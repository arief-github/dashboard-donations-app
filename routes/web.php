<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;

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
    });
});
