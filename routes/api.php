<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;

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
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum', 'user-access:1'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/role-permission', [RoleController::class, 'createRolePermission']);
    Route::get('/permissions', [RoleController::class, 'getPermissions']);
});

Route::middleware(['auth:sanctum', 'user-access:2'])->group(function () {
    // Route::get('/users', [UserController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks', [TaskController::class, 'index']);
});

// Route::middleware('auth:sanctum')->group(function(){
//     Route::get('/users', [UserController::class, 'index']);
// });
// Route::middleware(['auth:sanctum'])->group(function (){
//     Route::get('/users/{id}',[UserController::class, 'showUser']);
// });
