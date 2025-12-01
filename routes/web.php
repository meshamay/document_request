<?php

use App\Http\Controllers\UserDocumentRequestController;
use App\Http\Controllers\AdminDocumentRequestController;
use App\Http\Controllers\AdminReportsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - No Authentication Required
|--------------------------------------------------------------------------
*/

// Redirect root to user page
Route::get('/', function () {
    return redirect()->route('user.document-requests.index');
});

// User Routes - Document Requests
Route::get('/user/document-requests', [UserDocumentRequestController::class, 'index'])
    ->name('user.document-requests.index');
Route::post('/user/document-requests', [UserDocumentRequestController::class, 'store'])
    ->name('user.document-requests.store');

// Admin Routes - Document Requests
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/document-requests', [AdminDocumentRequestController::class, 'index'])
        ->name('document-requests.index');
    Route::get('/document-requests/{id}', [AdminDocumentRequestController::class, 'show'])
        ->name('document-requests.show');
    Route::put('/document-requests/{id}', [AdminDocumentRequestController::class, 'update'])
        ->name('document-requests.update');
    Route::delete('/document-requests/{id}', [AdminDocumentRequestController::class, 'destroy'])
        ->name('document-requests.destroy');
    
    // Reports & Analytics
    Route::get('/reports', [AdminReportsController::class, 'index'])
        ->name('reports');
});
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function () {
     Route::resource('document-requests', \App\Http\Controllers\AdminDocumentRequestController::class);
});
