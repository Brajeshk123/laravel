<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGeneratorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view dashboard')
        ->name('dashboard');

    Route::get('users', [UserController::class, 'index'])
        ->middleware('permission:view users')
        ->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])
        ->middleware('permission:create users')
        ->name('users.create');
    Route::post('users', [UserController::class, 'store'])
        ->middleware('permission:create users')
        ->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:edit users')
        ->name('users.edit');
    Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])
        ->middleware('permission:edit users')
        ->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:delete users')
        ->name('users.destroy');

    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('permission:view roles')
        ->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])
        ->middleware('permission:create roles')
        ->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('permission:create roles')
        ->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])
        ->middleware('permission:edit roles')
        ->name('roles.edit');
    Route::match(['put', 'patch'], 'roles/{role}', [RoleController::class, 'update'])
        ->middleware('permission:edit roles')
        ->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('permission:delete roles')
        ->name('roles.destroy');

    Route::get('roles/{role}/permissions', [RolePermissionController::class, 'edit'])
        ->middleware('permission:edit roles')
        ->name('roles.permissions.edit');
    Route::post('roles/{role}/permissions', [RolePermissionController::class, 'update'])
        ->middleware('permission:edit roles')
        ->name('roles.permissions.update');

    Route::get('permissions', [PermissionController::class, 'index'])
        ->middleware('permission:view permissions')
        ->name('permissions.index');

    Route::get('/permission-generator', [PermissionGeneratorController::class, 'index'])
        ->middleware('permission:create permissions')
        ->name('permission-generator.index');
    Route::post('/permission-generator', [PermissionGeneratorController::class, 'store'])
        ->middleware('permission:create permissions')
        ->name('permission-generator.store');

    Route::get('categories/trash', [CategoryController::class, 'trash'])
        ->middleware('permission:delete categories|restore categories|force delete categories')
        ->name('categories.trash');
    Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])
        ->middleware('permission:restore categories')
        ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
        ->middleware('permission:force delete categories')
        ->name('categories.force-delete');
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('contents', [ContentController::class, 'index'])
        ->middleware('permission:view contents')
        ->name('contents.index');
    Route::get('contents/create', [ContentController::class, 'create'])
        ->middleware('permission:create contents')
        ->name('contents.create');
    Route::post('contents', [ContentController::class, 'store'])
        ->middleware('permission:create contents')
        ->name('contents.store');
    Route::get('contents/{content}/edit', [ContentController::class, 'edit'])
        ->middleware('permission:edit contents')
        ->name('contents.edit');
    Route::match(['put', 'patch'], 'contents/{content}', [ContentController::class, 'update'])
        ->middleware('permission:edit contents')
        ->name('contents.update');
    Route::delete('contents/{content}', [ContentController::class, 'destroy'])
        ->middleware('permission:delete contents')
        ->name('contents.destroy');
    Route::get('tags', [TagController::class, 'index'])
        ->middleware('permission:view tags')
        ->name('tags.index');
    Route::get('tags/create', [TagController::class, 'create'])
        ->middleware('permission:create tags')
        ->name('tags.create');
    Route::post('tags', [TagController::class, 'store'])
        ->middleware('permission:create tags')
        ->name('tags.store');
    Route::get('tags/{tag}/edit', [TagController::class, 'edit'])
        ->middleware('permission:edit tags')
        ->name('tags.edit');
    Route::match(['put', 'patch'], 'tags/{tag}', [TagController::class, 'update'])
        ->middleware('permission:edit tags')
        ->name('tags.update');
    Route::delete('tags/{tag}', [TagController::class, 'destroy'])
        ->middleware('permission:delete tags')
        ->name('tags.destroy');
    Route::get('menus', [MenuController::class, 'index'])
        ->middleware('permission:view menus')
        ->name('menus.index');
    Route::get('menus/create', [MenuController::class, 'create'])
        ->middleware('permission:create menus')
        ->name('menus.create');
    Route::post('menus', [MenuController::class, 'store'])
        ->middleware('permission:create menus')
        ->name('menus.store');
    Route::post('menus/{menu}/items', [MenuItemController::class, 'store'])
        ->middleware('permission:edit menus')
        ->name('menus.items.store');
    Route::match(['put', 'patch'], 'menus/{menu}/items/{item}', [MenuItemController::class, 'update'])
        ->middleware('permission:edit menus')
        ->name('menus.items.update');
    Route::delete('menus/{menu}/items/{item}', [MenuItemController::class, 'destroy'])
        ->middleware('permission:edit menus')
        ->name('menus.items.destroy');
    Route::get('menus/{menu}', [MenuController::class, 'show'])
        ->middleware('permission:view menus')
        ->name('menus.show');
    Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])
        ->middleware('permission:edit menus')
        ->name('menus.edit');
    Route::match(['put', 'patch'], 'menus/{menu}', [MenuController::class, 'update'])
        ->middleware('permission:edit menus')
        ->name('menus.update');
    Route::delete('menus/{menu}', [MenuController::class, 'destroy'])
        ->middleware('permission:delete menus')
        ->name('menus.destroy');

    Route::get('media', [MediaController::class, 'index'])
        ->middleware('permission:view media')
        ->name('media.index');
    Route::get('media/create', [MediaController::class, 'create'])
        ->middleware('permission:create media')
        ->name('media.create');
    Route::post('media', [MediaController::class, 'store'])
        ->middleware('permission:create media')
        ->name('media.store');
    Route::get('media/{medium}/edit', [MediaController::class, 'edit'])
        ->middleware('permission:edit media')
        ->name('media.edit');
    Route::match(['put', 'patch'], 'media/{medium}', [MediaController::class, 'update'])
        ->middleware('permission:edit media')
        ->name('media.update');
    Route::delete('media/{medium}', [MediaController::class, 'destroy'])
        ->middleware('permission:delete media')
        ->name('media.destroy');
    Route::get('/settings', [SettingController::class, 'index'])
        ->middleware('permission:manage settings')
        ->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])
        ->middleware('permission:manage settings')
        ->name('settings.update');
});
