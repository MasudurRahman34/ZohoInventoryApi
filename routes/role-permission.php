<?php

use App\Http\Controllers\Api\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::GET('/roles', [RolePermissionController::class, 'indexRole'])->name('roles.index');
Route::GET('/roles/{roleId}', [RolePermissionController::class, 'showRole'])->name('roles.show');
Route::POST('/roles', [RolePermissionController::class, 'storeRoleWithPermissions'])->name('store.roles-with-permissions');
Route::PUT('/roles/{roleId}', [RolePermissionController::class, 'updateRoleWithPermissions'])->name('update.roles-with-permissions');

Route::POST('/assign-role', [RolePermissionController::class, 'assignRole'])->name('assign.roles');

Route::POST('/permissions', [RolePermissionController::class, 'storePermission'])->name('store.permissions');
Route::GET('/permissions', [RolePermissionController::class, 'indexPermission'])->name('index.permissions');

Route::POST('/permissions-group', [RolePermissionController::class, 'storePermissionGroup'])->name('store.permissions-group');
Route::GET('/permissions-group', [RolePermissionController::class, 'indexPermissionGroup'])->name('store.permissions-group');
