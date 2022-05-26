<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChatController;
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
    return view('login.login');
});
Route::get('/login', function () {
    return view('login.login');
});
Route::post('handle-login',[LoginController::class, 'store'])->name('login');
Route::post('/post-chat', [ChatController::class, 'create']);
Route::get('/chat',[ChatController::class, 'index'] )->middleware('check');
Route::post('/get-user', [LoginController::class, 'show']);
