<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::get('logout', function () {
    Session::flush();
    return 'logout successfuly';
});


Route::resource('users', UserController::class);

Route::resource('books', BookController::class);


Route::get('roles-list', [RoleController::class, 'rolesList']);
Route::resource('roles', RoleController::class);

Route::post('login', [AuthController::class, 'login']);
Route::post('forgetpassword', [AuthController::class, 'forgetPassword']);
Route::post('resetpassword', [AuthController::class, 'resetPassword']);


Route::get('libraries/total', [LibraryController::class, 'getTotalBook']);
Route::post('libraries/assigne', [LibraryController::class, 'assignBookToUser']);
Route::get('libraries/students/{search}', [LibraryController::class, 'search']);
Route::get('libraries/search-subject', [LibraryController::class, 'searchSubject']);
Route::get('libraries/index', [LibraryController::class, 'index']);
Route::delete('libraries/{library}', [LibraryController::class, 'destroy']);
Route::get('libraries/history', [LibraryController::class, 'history']);
