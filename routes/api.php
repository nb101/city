<?php

use App\Http\Controllers\Api\CityAnswersController;
use App\Http\Controllers\Api\CityQuestionsController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('questions', CityQuestionsController::class)->name('api.cities.questions');
Route::get('answers', CityAnswersController::class)->name('api.cities.answers');
