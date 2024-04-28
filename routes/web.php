<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DonationController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('admin')->group(function() {
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/dashboard', function() {
            return view('admin.dashboard.index');
        });

        Route::get('/donatur', [DonaturController::class, 'index'])->name('admin.donatur.index');
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
        
        Route::get('/donation',[DonationController::class, 'index'])->name('admin.donation.index');
        Route::get('/donation/filter', [DonationController::class, 'filter'])->name('admin.donation.filter');

        Route::resource('/category', CategoryController::class, ['as' => 'admin']);
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);
        Route::resource('/campaign', CampaignController::class, ['as' => 'admin']);
    });
});
