<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);
    Route::post('settings/config', [ProfileController::class, 'updateConfig']);
    Route::get('settings/get-config', [ProfileController::class, 'getConfig']);
    Route::patch('settings/profile', [ProfileController::class, 'updateProfile']);
    Route::patch('settings/password', [PasswordController::class, 'update']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');    

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
    
    
});
Route::get('/get-topics', [TopicController::class, 'getTopics']);

Route::post('/get-questions', [QuestionsController::class, 'getQuestions']);
Route::post('/get-question', [QuestionsController::class, 'getQuestion']);
Route::post('/get-my-questions', [QuestionsController::class, 'getMyQuestions']);
Route::get('/get-limit', [QuestionsController::class, 'getLimit']);
Route::post('/post-question', [QuestionsController::class, 'postQuestion']);
Route::post('/like', [QuestionsController::class, 'like']);
Route::post('/dislike', [QuestionsController::class, 'dislike']);

Route::post('/get-answers', [AnswerController::class, 'getAnswers']);
Route::post('/post-answer', [AnswerController::class, 'postAnswer']);
Route::post('/like-answer', [AnswerController::class, 'like']);
Route::post('/dislike-answer', [AnswerController::class, 'dislike']);

Route::post('/get-notifications', [NotificationController::class, 'getNotification']);
Route::post('/get-user-notifications', [NotificationController::class, 'getUserNotification']);
Route::post('/read-notifications', [NotificationController::class, 'readNotification']);