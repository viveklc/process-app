<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\CityApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use App\Http\Controllers\Api\V1\UserProfilePhotoApiController;
use App\Http\Controllers\Api\V1\ChapterApiController;
use App\Http\Controllers\Api\V1\CourseApiController;
use App\Http\Controllers\Api\V1\PageApiController;
use App\Http\Controllers\Api\V1\LevelApiController;
use App\Http\Controllers\Api\V1\BookApiController;
use App\Http\Controllers\Api\V1\SubjectApiController;

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    // Customer Send and verify OTP API
    Route::post('/send-otp', [
        AuthApiController::class, 'sendOtp'
    ])->name('send-otp');

    Route::post('/verify-otp', [
        AuthApiController::class, 'verifyOtp'
    ])->name('verify-otp');


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('user/get', [UserApiController::class, 'show']);
        Route::put('user/update', [UserApiController::class, 'update']);
        Route::apiResource('user-profile-photos', UserProfilePhotoApiController::class)->only('index', 'store', 'destroy');

        Route::apiResource('cities', CityApiController::class)->only('index');

        Route::apiResource('courses', CourseApiController::class);
        Route::apiResource('levels', LevelApiController::class)->only('index', 'show');
        Route::apiResource('subjects', SubjectApiController::class)->only('index', 'show');
        Route::apiResource('books', BookApiController::class)->only('index', 'show');
        Route::apiResource('chapters', ChapterApiController::class);
        Route::apiResource('pages', PageApiController::class);
    });
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
