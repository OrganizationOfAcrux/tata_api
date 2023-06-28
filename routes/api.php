<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

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
Route::get('roles-list-pluck', [RoleController::class, 'rolesListPluck']);
Route::get('roles-list', [RoleController::class, 'rolesList']);
Route::resource('roles', RoleController::class);

Route::post('login', [AuthController::class, 'login']);
Route::post('forgetpassword', [AuthController::class, 'forgetPassword']);
Route::post('resetpassword', [AuthController::class, 'resetPassword']);
