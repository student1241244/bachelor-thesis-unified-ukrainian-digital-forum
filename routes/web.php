<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QAController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WarningController;
use App\Http\Controllers\PasscodeController;
use App\Http\Controllers\QuestionDetailsController;
use App\Http\Controllers\SecuritySettingController;
use App\Http\Controllers\PasscodeFeaturesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin-dashboard', function () {
    return "You admin";
})->middleware('can:visitAdminPages');

Route::get('/admin/settings', [SettingController::class, "show"])->name('admin.settings');
Route::post('/admin/settings', [SettingController::class, "update"])->name('admin.settings.update');
Route::get('/admin/settings-security', [SecuritySettingController::class, "show"])->name('admin.settings-security');
Route::post('/admin/toggle-maintenance', [SecuritySettingController::class, "toggleMaintenance"])->name('admin.toggleMaintenance');
Route::post('/admin/settings/update-backup-frequency', [SecuritySettingController::class, "updateBackupFrequency"])->name('admin.settings.updateBackupFrequency');


// Main routes
Route::get('/qa-home', function () {
    return view('qa-home');
});

Route::get('/passcode', [PasscodeController::class, "passcodeHome"])->name('passcode.passcode-home');
Route::get('/buy-passcode', [PasscodeController::class, "createCheckoutSession"])->name('passcode.checkout');
Route::get('/passcode/success', [PasscodeController::class, "success"])->name('passcode.success');
Route::get('/passcode/cancel', [PasscodeController::class, "cancel"])->name('passcode.cancel');
Route::post('/passcode-activate', [PasscodeController::class, 'passcodeActivate'])->name('passcode.activate');
Route::stripeWebhooks('stripe-webhook');

Route::get('/warnings/{id}/delete', [WarningController::class, "destroy"])->name('warnings.destroy');

Route::post('/reports', [ReportController::class, "store"])->name('reports.store');
Route::put('/reports/clean', [ReportController::class, "clean"])->name('reports.clean');

Route::get('/threads', [ThreadController::class, "index"])->name('threads.index');
Route::get('/threads-home', [ThreadController::class, "showThreadsHome"])->name('threads.home');
Route::get('/threads-add', [ThreadController::class, "create"])->name('threads.create');
Route::post('/threads', [ThreadController::class, "store"])->name('threads.store');
Route::post('/threads-{id}/add-comment', [ThreadController::class, "addComment"])->name('threads.add_comment');
Route::get('/threads-{id}', [ThreadController::class, "show"])->name('threads.show');
Route::get('/threads/{categoryId}', [ThreadController::class, "showByCategory"])->name('threads.showByCategory');


Route::get('/home', [UserController::class, "showHomepage"]);
Route::get('/', [UserController::class, "showHomepage"]);

// User routes
Route::post('/login', [UserController::class, "login"])->middleware('guest');
Route::post('/register', [UserController::class, "register"])->middleware('guest');

Route::post('/logout', [UserController::class, "logout"])->middleware('auth');
Route::get('/profile-settings', [UserController::class, "showProfileSettings"])->middleware('auth');
Route::post('/profile-settings', [UserController::class, "updateProfileSettings"])->middleware('auth');
Route::get('/favourites/{user:username}', [UserController::class, "showFavourites"])->middleware('auth');

Route::get('/signin', function () {
    return view('signin', ['title' => 'Signin']);
})->name('login')->middleware('guest');
Route::get('/signup', function () {
    return view('signup', ['title' => 'Signup']);
})->middleware(['guest', 'checkRegistrationEnabled']);

// Q&A routes
Route::get('/questions/{categoryId}', [QAController::class, "showQuestions"]);
Route::get('/ask-question', [QAController::class, "show"])->middleware(['auth', 'checkContentCreationEnabled']);;
Route::post('/create-question', [QAController::class, "createNewQuestion"])->middleware('auth');
Route::get('/question-details/{question}', [QAController::class, "showSingleQuestion"]);
Route::delete('/question-details/{question}', [QAController::class, "deleteQuestion"])->middleware('can:delete,question');
Route::get('/question-details/{question}/edit', [QAController::class, "showEditQuestionForm"])->middleware('can:delete,question');
Route::put('/question-details/{question}', [QAController::class, "editQuestion"])->middleware('can:delete,question');

Route::post('/questions/post-answer/{question_id}', [QAController::class, "postAnswer"])->name('questions.post_answer')->middleware('auth');
Route::post('/questions/update-answer/{id}', [QAController::class, "updateAnswer"])->name('questions.update_answer')->middleware('auth');
Route::get('/questions/delete-answer/{id}', [QAController::class, "deleteAnswer"])->name('questions.delete_answer')->middleware('auth');
Route::get('/questions/get-answer/{id}', [QAController::class, "getAnswer"])->name('questions.get_answer')->middleware('auth');
Route::get('/questions/bookmark/{id}', [QAController::class, "bookmark"])->name('questions.bookmark');

Route::get('/search/{query}', [QAController::class, "search"]);

//Question details
//Comment routes
Route::post('/question-details/{question}/create-comment', [CommentController::class, "createComment"])->middleware('auth');
Route::post('/question-details/{id}/vote', [QuestionDetailsController::class, 'voteQuestion'])->middleware('auth')->name('questions.vote');
Route::post('/question-details/{id}/{idAnswer}/vote', [QuestionDetailsController::class, 'voteAnswer'])->middleware('auth')->name('questions.answers.vote');


//Profile routes
Route::get('/profile/{user:username}', [UserController::class, "showProfile"]);

//Follow routes
Route::post('/follow/{user:username}', [FollowController::class, "followUser"])->middleware('auth');
Route::post('/unfollow/{user:username}', [FollowController::class, "unfollowUser"])->middleware('auth');
// Route::post('/profile/{user:username}/followers', [FollowController::class, "profileFollowers"])->middleware('auth');
// Route::post('/profile/{user:username}/following', [FollowController::class, "profileFollowing"])->middleware('auth');

Route::post('/switch-theme', [PasscodeFeaturesController::class, 'switchTheme']);

//General routes
Route::get('/about', [GeneralController::class, "showAbout"]);
Route::get('/privacy-policy', [GeneralController::class, "showPrivacyPolicy"]);
Route::get('/content-policy', [GeneralController::class, "showContentPolicy"]);
Route::get('/cookie-policy', [GeneralController::class, "showCookiePolicy"]);
Route::get('/contact', [GeneralController::class, "showContact"]);
Route::get('/support', [GeneralController::class, "showSupport"]);