<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
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
    return redirect('/admin/dashboard');
});

Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});

Route::prefix('/admin')->middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['permission:dashboard_access'])->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::prefix('master')->group(function () {

        Route::middleware(['permission:master_categories_access'])->group(function () {
            Route::get('/categories', [CategoriesController::class, 'index'])->name('master.categories.index');
        });
    });


    Route::middleware(['permission:users_access'])->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware(['permission:groups_access'])->prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('groups.index');
        Route::post('/store', [GroupController::class, 'store'])->name('groups.store');
        Route::put('/update/{group}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/destroy/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    });

    Route::middleware(['permission:roles_access'])->prefix('roles')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexRoles'])->name('roles.index');
        Route::post('/store', [RolePermissionController::class, 'storeRole'])->name('roles.store');
        Route::put('/update/{role}', [RolePermissionController::class, 'updateRole'])->name('cms.roles.update');
        Route::delete('/destroy/{id}', [RolePermissionController::class, 'destroyRole'])->name('cms.roles.destroy');
        Route::get('/{role}/permissions', [RolePermissionController::class, 'getRolePermissions'])->name('cms.roles.permissions');
    });

    Route::middleware(['permission:permissions_access'])->prefix('permissions')->group(function () {
        Route::get('/', [RolePermissionController::class, 'indexPermissions'])->name('permissions.index');
        Route::post('/store', [RolePermissionController::class, 'storePermission'])->name('permissions.store');
        Route::put('/update/{permission}', [RolePermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/destroy/{id}', [RolePermissionController::class, 'destroyPermission'])->name('permissions.destroy');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__ . '/auth.php';
