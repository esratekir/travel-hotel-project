<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\FavoritesController;


Route::controller(UserController::class)->group(function () {
    Route::post('/user/register', 'register');
    Route::post('/user/login', 'login');
    Route::get('/user/{token}', 'token');
    Route::get('/user/profile/{token}', 'showUser');
    Route::put('/user/profile/update/{token}', 'UpdateUser');
    Route::post('/user/image/upload/{token}', 'storeImage');

    Route::get('/user/details/{id}', 'UserDetails');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/home/services', 'HomeServices');
    Route::get('/home/guides', 'HomeGuides');
    Route::get('/home/clients', 'HomeClients');
    Route::get('/activities', 'Activities');
    Route::get('/languages', 'Languages');
    Route::get('/countries', 'Countries');
    Route::get('/cities', 'Cities');

});

Route::controller(GuideController::class)->group(function () {
    Route::post('/guide/register', 'register');
    Route::post('/profile/image/upload/{token}', 'store');
    Route::post('/guide/image/upload/{token}', 'GuideImageUpload');
    Route::get('/guides', 'AllGuides');
    Route::get('/guide/details/{token}/{id}', 'showDetails');
    Route::get('/guide/profile/{token}', 'GetGuideProfile');
    Route::put('/guide/profile/update/{token}', 'GuideProfileUpdate');
    Route::delete('/guide/image/{token}/{id}', 'DeleteGuideImage');
});

Route::controller(TripController::class)->group(function() {
    Route::post('/create/user/trips/{token}', 'CreateTrip');
    Route::get('/user/trips/{token}', 'UserTrips');
    Route::delete('/delete/trip/{token}/{id}', 'DeleteTrip');
    Route::get('/view/trips/{token}', 'ViewTrip');
});

Route::controller(CommentsController::class)->group(function() {
    Route::get('/get/comments/{id}', 'GetComments');
    Route::post('/store/comments/{token}/{id}', 'StoreComments');
    Route::delete('/delete/comments/{token}/{id}', 'DeleteComments');
});

Route::controller(MessageController::class)->group(function() {
    Route::get('/my-messages/{token}', 'MyMessages');
    Route::get('/my-message/details/{token}/{id}', 'MessageDetails');
    Route::post('/send/message/{token}/{id}', 'SendMessage');
    Route::post('/report/user/{token}/{id}', 'ReportUser');
    Route::post('/message-read/{token}/{id}', 'MessageasRead');
    Route::delete('/delete/chat/{token}/{id}', 'DeleteChat');
});

Route::controller(ForgotPasswordController::class)->group(function() {
    Route::post('/forgot/password', 'SubmitForgotPassword');
    Route::get('/reset-password/{token}', 'ShowResetPassword');
    Route::post('/reset-password/{token}', 'SubmitResetPassword');
});

Route::controller(EmailVerificationController::class)->group(function() {
    Route::get('/verify/account/{token}', 'AccountVerification');
});

Route::controller(FavoritesController::class)->group(function() {
    Route::post('/add/favorites/{token}/{id}', 'AddFavorites');
    Route::get('/my/favorites/{token}', 'MyFavorites');
    Route::get('/my/favorites/{id}', 'MyFavoriteGuide');
    Route::delete('/delete/favorites/{token}/{id}', 'DeleteFavorites');
});

