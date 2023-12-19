<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Question;
use App\Events\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Packages\Threads\App\Models\Thread;
use App\Http\Requests\Profile\UpdateRequest;

class UserController extends Controller
{
    protected function sendFailedLoginResponse($username)
    {
        Log::channel('authlog')->info('Failed login attempt', [
            'username' => $username,
            'ip' => request()->ip(),
        ]);
    }

    public function updateProfileSettings(UpdateRequest $request) {
        $user = auth()->user();

        $data = $request->only(['email', 'password']);

        if ($request->file('avatar')) {
            $filename = $user->id . '-' . uniqid() . '.jpg';
            $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
            Storage::put('public/avatars/' . $filename, $imgData);
            $oldAvatar = $user->avatar;
            $data['avatar'] = $filename;

            if ($oldAvatar != "/fallback-avatar.jpg") {
                Storage::delete(str_replace("/storage/", "public/", $oldAvatar));
            }

        }
        $user->update($data);

        return response()->json([
            'avatar' => $user->avatar,
            'message' => 'Your profile has been updated successfully',
        ]);
    }

    public function showProfileSettings() {
        $user = auth()->user();
        return view('profile-settings', get_defined_vars());
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

    public function showHomepage() {
        $userCount = Cache::remember('userCount', 20, function() {
            return user::count();
        });

        $questionCount = Cache::remember('postCount', 20, function() {
            return Question::count();
        });

        $answerCount = Cache::remember('answerCount', 20, function() {
            return Comment::count();
        });

        $threadCount = Cache::remember('threadCount', 20, function() {
            return Thread::count();
        });

        $threadCommentCount = Cache::remember('threadCommentCount', 20, function() {
            return \Packages\Threads\App\Models\Comment::count();
        });

        return view('home', get_defined_vars());
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            if (auth()->user()->checkIsBan()) {
                auth()->logout();

                return redirect('signin')->with('failure', 'Your account is banned. Please contact administrator.');
            }
            $request->session()->regenerate();
            return view('qa-home');
        } else {
            $this->sendFailedLoginResponse($incomingFields['loginusername']);

            return redirect('signin')->with('failure', 'Invalid login');
        }
    }

    public function register(Request $request) {
        if (Setting::where('setting_name', 'user_registration_enabled')->value('setting_status')) {
            $incomingFields = $request->validate([
                'username' => ['required', 'min:1', 'max:20', Rule::unique('users', 'username')],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => ['required', 'min:2']
            ]);
            $incomingFields['password'] = bcrypt($incomingFields['password']);
            $user = User::create($incomingFields);
            auth()->login($user);

            return view('/qa-home', get_defined_vars());
        } else {
            Log::info('ERROR. User registration disabled.');
        }
    }

    private function getSharedData($user) {
        $currentlyFollowing = auth()->check() ? Follow::where('user_id', auth()->id())->where('followeduser', $user->id)->count() : 0;
        $questionsCount = $user->questions()->count();
        $commentsCount = $user->comments()->count();
        $totalAnswerUpvotes = $user->comments->sum('votes_count'); // Ensure 'votes_count' is the correct column name in your Comment model
    
        View::share('sharedData', [
            'avatar' => $user->avatar,
            'username' => $user->username,
            'questionCount' => $questionsCount,
            'bonus_points' => $user->bonus_points,
            'answerCount' => $commentsCount,
            'answerUpvotes' => $totalAnswerUpvotes,
            'currentlyFollowing' => $currentlyFollowing
        ]);
    }
    

    public function showProfile(User $user) {
        $this->getSharedData($user);
        $bonus = 1;
        return view('profile', [
            'questions' => $user->questions()->latest()->get(),
            'followers' => $user->followers()->latest()->get(),
            'following' => $user->following()->latest()->get(),
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
            'bonus_points' => $bonus,
       ]);
    }

    public function showFavourites(User $user) {
        $favourites = $user->bookmarkQuestions()->latest()->paginate(4);
        return view('/favourites', ['favourites' => $favourites, 'title' => 'Favourites']);
    }
}