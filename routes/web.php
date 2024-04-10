<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SliderController;

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

        Route::resource('/category', CategoryController::class, ['as' => 'admin']);
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);
    });
});
