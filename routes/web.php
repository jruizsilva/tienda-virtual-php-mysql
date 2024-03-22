<?php

use App\Controllers\DashboardController;
use App\Controllers\AuthController;
use App\Controllers\PermissionsController;
use App\Controllers\RoleController;
use App\Controllers\UserController;
use Lib\Route;

Route::get('/', [DashboardController::class, 'dashboardPage']);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage']);

// Roles
Route::get('/roles', [RoleController::class, 'rolesPage']);
Route::get('/roles/all', [RoleController::class, 'all']);
Route::post('/roles/insert', [RoleController::class, 'insert']);
Route::post('/roles/update', [RoleController::class, 'update']);
Route::post('/roles/delete/:id', [RoleController::class, 'delete']);
Route::get('/roles/find/:id', [RoleController::class, 'find']);
Route::get('/roles/allSelectOptions', [RoleController::class, 'allSelectOptions']);

// Permissions
Route::get('/permissions/all/roles/:id', [PermissionsController::class, 'allByRoleId']);
Route::post('/permissions/update/roles/:id', [PermissionsController::class, 'updateByRoleId']);

// Users
Route::get('/users', [UserController::class, 'usersPage']);
Route::post('/users/insert', [UserController::class, 'insert']);
Route::get('/users/all', [UserController::class, 'all']);
Route::get('/users/find/:id', [UserController::class, 'find']);
Route::post('/users/update', [UserController::class, 'update']);
Route::post('/users/delete/:id', [UserController::class, 'delete']);

// Auth
Route::get('/login', [AuthController::class, 'loginPage']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/change-password/:email/:token', [AuthController::class, 'changePasswordPage']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/auth/change-password', [AuthController::class, 'changePassword']);

Route::dispatch();
