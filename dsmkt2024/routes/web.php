<?php

use App\Http\Controllers\Admin\AutosController;
use App\Http\Controllers\Admin\ConsentionController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::middleware('admin')->group(function () {
    Route::prefix('menu')->name('menu.')->middleware(['auth', 'verified'])->group(function () {
        Route::get('/concessions', [ConsentionController::class, 'index'])->name('concessions');
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::get('/structure', [MenuController::class, 'index'])->name('structure');
        Route::get('/autos', [AutosController::class, 'index'])->name('autos');
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');

        Route::get('/files', function () {
            return view('admin.files.index');
        })->name('files');

        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::get('/edit/{menuItem}', [MenuController::class, 'edit'])->name('edit');
        Route::post('/toggle-status/{menuItem}', [MenuController::class, 'toggleStatus'])->name('toggleStatus');

        Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::get('/get-menu-items', [MenuController::class, 'getMenuItems']);
        Route::get('/get-menu-items-with-files', [MenuController::class, 'getMenuItemsWithFiles']);

        Route::patch('/menu-items/{menuItem}', [MenuController::class, 'update'])->name('menu-items.update');
        Route::post('/menu-items/update-order', [MenuItemController::class, 'updateOrder'])->name('menu-items.update-order');
        Route::post('/update-tree-structure', [MenuItemController::class, 'updateTreeStructure'])->name('menu.update-tree-structure');
        Route::post('/menu-items/update-type', [MenuItemController::class, 'updateType'])->name('menu-items.update-type');
        Route::get('/menu-items/{id}/has-sub-items', [MenuItemController::class, 'hasSubItems'])->name('menu-items.has-sub-items');
        Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');

        Route::get('/files/create', [FileController::class, 'create'])->name('files.create');
        Route::post('/files/store', [FileController::class, 'store'])->name('files.store');
        Route::get('/file/edit/{file}', [FileController::class, 'edit'])->name('file.edit');
        Route::patch('/files/{file}', [FileController::class, 'update'])->name('file.update');
        Route::get('/files/delete/{id}', 'FileController@deleteFile')->name('files.delete');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
