<?php

use App\Http\Controllers\UserDocumentRequestController;
use App\Http\Controllers\AdminDocumentRequestController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.document-requests.index');
        }
        return redirect()->route('user.document-requests.index');
    }
    return redirect()->route('login');
})->name('home');

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/document-requests', [UserDocumentRequestController::class, 'index'])
        ->name('user.document-requests.index');
    Route::post('/user/document-requests', [UserDocumentRequestController::class, 'store'])
        ->name('user.document-requests.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/document-requests', [AdminDocumentRequestController::class, 'index'])
        ->name('document-requests.index');
    Route::get('/document-requests/{id}', [AdminDocumentRequestController::class, 'show'])
        ->name('document-requests.show');
    Route::put('/document-requests/{id}', [AdminDocumentRequestController::class, 'update'])
        ->name('document-requests.update');
    Route::delete('/document-requests/{id}', [AdminDocumentRequestController::class, 'destroy'])
        ->name('document-requests.destroy');
    
    Route::get('/profile', [AdminProfileController::class, 'index'])
        ->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])
        ->name('profile.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
