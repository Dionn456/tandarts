<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\TreatmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Models\Room;

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
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{userId}', [UserController::class, 'getUser']);
    Route::delete('users/{userId}', [UserController::class, 'destroy']);
    Route::post('users/{userId}', [UserController::class, 'updateUser']);

    Route::get('roles', [RoleController::class, 'index']);

    Route::get('treatments', [TreatmentController::class, 'index']);
    Route::get('treatments/analytics/{user_id}', [TreatmentController::class, 'analytics']);

    Route::post('review', [ReviewController::class, 'store']);
    Route::get('reviews', [ReviewController::class, 'index']);

    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::post('appointment', [AppointmentController::class, 'store']);
    Route::delete('appointment/{appointmentId}', [AppointmentController::class, 'destroy']);
    Route::get('appointment/{appointmentId}', [AppointmentController::class, 'getAppointment']);

    Route::post('appointment/{appointment}/invoice', [AppointmentController::class, 'invoice']);


    Route::post('room', [RoomController::class, 'store']);
    Route::get('rooms', [RoomController::class, 'index']);
    Route::delete('room/{roomId}', [RoomController::class, 'destroy']);
    Route::get('room/{roomId}', [RoomController::class, 'getRoom']);
    Route::post('room/{roomId}', [RoomController::class, 'updateRoom']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('guest/users', [UserController::class, 'guestIndex']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});
