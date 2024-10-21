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

Route::middleware(['auth:sanctum'])->group(function () {
    //users
    Route::get('/users', [UserController::class, 'index'])->middleware('permission:user-read');
    Route::get('/users/{id}', [UserController::class, 'getUser'])->middleware('permission:user-update');
    Route::post('/users', [UserController::class, 'create'])->middleware('permission:user-create');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('permission:user-update');
    Route::delete('/users/{id}', [UserController::class, 'delete'])->middleware('permission:user-delete');
    //roles
    Route::post('/roles', [RoleController::class, 'store'])->middleware('user-access:1');
    Route::get('/roles', [RoleController::class, 'index'])->middleware('user-access:1');
    //role->permissions
    Route::post('/role-permission', [RoleController::class, 'createRolePermission'])->middleware('user-access:1');
    Route::get('/permissions', [RoleController::class, 'getPermissions'])->middleware('user-access:1');
    //tasks
    Route::get('/tasks', [TaskController::class, 'index'])->middleware('permission:task-read');
    Route::post('/tasks', [TaskController::class, 'store'])->middleware('permission:task-create');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->middleware('permission:task-update');
    Route::delete('/tasks/{id}', [TaskController::class, 'delete'])->middleware('permission:task-delete');
});

// Route::middleware(['auth:sanctum', 'user-access:2'])->group(function () {
//     // Route::get('/users', [UserController::class, 'index']);
// });

// Route::middleware('auth:sanctum')->group(function(){
//     Route::get('/users', [UserController::class, 'index']);
// });
// Route::middleware(['auth:sanctum'])->group(function (){
//     Route::get('/users/{id}',[UserController::class, 'showUser']);
// });
