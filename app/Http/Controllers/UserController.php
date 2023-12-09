<?php

namespace App\Http\Controllers;

use App\Events\UserEvent;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\Comment;
use App\Models\User;
use App\Models\Follow;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Packages\Threads\App\Models\Thread;

class UserController extends Controller
{
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
        // if (auth()->check()) {
        //     return view('questions', ['questions' => auth()->user()->feedQuestions()->latest()->paginate(4)]);
        // } else {

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

        $user = User::where('username', $incomingFields['loginusername'])->first();


        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            if (auth()->user()->checkIsBan()) {
                auth()->logout();
                return redirect('signin')->with('failure', 'Your account is banned. Please contact administrator.');
            }

            $request->session()->regenerate();
            return view('questions', ['questions' => auth()->user()->feedQuestions()->latest()->paginate(4)]);
        } else {
            return redirect('signin')->with('failure', 'Invalid login');
        }
    }

    public function register(Request $request) {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:1', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:2']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('questions', ['questions' => auth()->user()->feedQuestions()->latest()->paginate(4)]);
    }

    private function getSharedData($user) {
        $currentlyFollowing = 0;

        if (auth()->check()) {
            $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
        }

        View::share('sharedData', ['currentlyFollowing' => $currentlyFollowing, 'avatar' => $user->avatar, 'username' => $user->username, 'questionCount' => $user->questions()->count()]);
    }

    public function showProfile(User $user) {
        $this->getSharedData($user);
        return view('profile-pages', [
            'questions' => $user->questions()->latest()->get(),
            'followers' => $user->followers()->latest()->get(),
            'following' => $user->following()->latest()->get(),
            'followersCount' => $user->followers()->count(),
            'followingCount' => $user->following()->count(),
       ]);
    }

    // public function profileFollowers(User $user) {
    //     $currentlyFollowing = 0;

    //     if (auth()->check()) {
    //         $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
    //     }

    //     return view('profile-followers', ['currentlyFollowing' => $currentlyFollowing, 'avatar' => $user->avatar, 'username' => $user->username, 'questions' => $user->questions()->latest()->get(), 'questionCount' => $user->questions()->count()]);
    // }

    // public function profileFollowing(User $user) {
    //     $currentlyFollowing = 0;

    //     if (auth()->check()) {
    //         $currentlyFollowing = Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->count();
    //     }

    //     return view('profile-following', ['currentlyFollowing' => $currentlyFollowing, 'avatar' => $user->avatar, 'username' => $user->username, 'questions' => $user->questions()->latest()->get(), 'questionCount' => $user->questions()->count()]);
    // }
}
