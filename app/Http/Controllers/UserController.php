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

    public function updateProfileSettings(Request $request) {
        $user = auth()->user();
    
        $data = [];
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'required',
                    'confirmed',
                    'min:6', // Minimum of 6 characters
                    'regex:/[a-z]/',      // At least one lowercase letter
                    'regex:/[A-Z]/',      // At least one uppercase letter
                    'regex:/[0-9]/',      // At least one number
                    'regex:/[@$!%*#?&]/', // At least one special character
                ]
            ]);
            $data['password'] = bcrypt($request->input('password'));
        }
    
        if ($request->file('avatar')) {
            $filename = $user->id . '-' . uniqid() . '.jpg';
            $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
            Storage::put('public/avatars/' . $filename, $imgData);
            $oldAvatar = $user->avatar;
            $data['avatar'] = $filename;
    
            if ($oldAvatar && $oldAvatar != "/fallback-avatar.jpg") {
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
        $userCount = Cache::remember('userCount', 60, function() {
            return user::count();
        });

        $questionCount = Cache::remember('postCount', 60, function() {
            return Question::count();
        });

        $answerCount = Cache::remember('answerCount', 60, function() {
            return Comment::count();
        });

        $threadCount = Cache::remember('threadCount', 60, function() {
            return Thread::count();
        });

        $threadCommentCount = Cache::remember('threadCommentCount', 60, function() {
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
                'username' => [
                    'required',
                    'alpha_num', // Alphanumeric characters
                    'min:5',     // Minimum of 5 characters
                    'max:15',    // Maximum of 15 characters
                    Rule::unique('users', 'username') // Unique in users table
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users', 'email')
                ],
                'password' => [
                    'required',
                    'min:6', // Minimum of 6 characters
                    'regex:/[a-z]/',      // At least one lowercase letter
                    'regex:/[A-Z]/',      // At least one uppercase letter
                    'regex:/[0-9]/',      // At least one number
                    'regex:/[@$!%*#?&]/', // At least one special character
                ]
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
        $questionsCount = $user->questions()->count();
        $commentsCount = $user->comments()->count();
        $totalAnswerUpvotes = $user->comments->sum('votes_count');
    
        View::share('sharedData', [
            'avatar' => $user->avatar,
            'username' => $user->username,
            'questionCount' => $questionsCount,
            'bonus_points' => $user->bonus_points,
            'answerCount' => $commentsCount,
            'answerUpvotes' => $totalAnswerUpvotes
        ]);
    }
    

    public function showProfile(User $user) {
        $this->getSharedData($user);
        $bonus = 1;
        return view('profile', [
            'questions' => $user->questions()->latest()->get(),
            'bonus_points' => $bonus,
       ]);
    }

    public function showFavourites(User $user) {
        $favourites = $user->bookmarkQuestions()->latest()->paginate(4);
        return view('/favourites', ['favourites' => $favourites, 'title' => 'Favourites']);
    }
}