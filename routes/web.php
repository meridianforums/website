<?php

use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToggleProjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('privacy-policy',function (){
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('home');

Route::get('/account', [App\Http\Controllers\UserAccountController::class, 'index'])
    ->name('account')
    ->middleware(['verified', 'auth']);

Route::post('/account', [App\Http\Controllers\UserAccountController::class, 'update'])
    ->name('account.update')
    ->middleware(['verified', 'auth']);

Route::namespace('projects')->name('projects.')->prefix('account/projects')->group(function () {
    Route::middleware(['verified', 'auth'])->group(function () {

        Route::get('/', [ProjectController::class, 'index'])->name('index');

        Route::get('/details/{project}', [ProjectController::class, 'show'])->name('show');

        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');

        Route::get('/modify/{project}', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');

        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');

        Route::post('/toggle/{project}', [ToggleProjectController::class, '__invoke'])->name('toggle');
    });
});

Route::get('/admin/stats', [StatisticsController::class, '__invoke'])
    ->name('admin.stats')
    ->middleware(['verified', 'auth']);
