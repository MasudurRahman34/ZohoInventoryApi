<?php

use App\Http\Controllers\Api\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::GET('/roles', [RolePermissionController::class, 'roleIndex'])->name('role.index');
Route::POST('/roles', [RolePermissionController::class, 'storeRoleWithPermission'])->name('store.role');
Route::POST('/roles-assign', [RolePermissionController::class, 'assignRole'])->name('assign.role');
Route::POST('/permissions', [RolePermissionController::class, 'storePermission'])->name('store.permission');
Route::GET('/permissions', [RolePermissionController::class, 'indexPermission'])->name('index.permission');
