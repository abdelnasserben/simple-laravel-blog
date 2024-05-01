<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::prefix('/blog')->name('blog.')->controller(BlogController::class)->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/new', 'create')->name('create')->middleware('auth');
    Route::post('/new', 'store');
    Route::get('/{post}/edit', 'edit')->name('edit')->middleware('auth');
    Route::patch('/{post}/edit', 'update')->middleware('auth');
    Route::get('/{slug}-{post}', 'show')
        ->where([
            'post' => '[0-9]+',
            'slug' => '[0-0a-z\-]+'
        ])->name('show');
});
