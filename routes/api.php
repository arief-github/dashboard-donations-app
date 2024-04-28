<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SliderController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API Category
 */
 Route::get('/categories',[CategoryController::class, 'index']);
 Route::get('/category/{slug}',[CategoryController::class, 'show']);
 Route::get('/category-home',[CategoryController::class, 'categoryHome']);

/**
 * API Donation
 */
Route::get('/campaign', [CampaignController::class, 'index']);
Route::get('/campaign/{slug}', [CampaignController::class, 'show']);

 /**
  * API Slider
  */
  Route::get('/sliders', [SliderController::class, 'index']);