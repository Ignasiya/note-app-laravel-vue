<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {

    // Профиль пользователя
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Заметки пользователя
    Route::prefix('/note')->group(function () {
        Route::post('/', [NoteController::class, 'store'])->name('note.create');
        Route::get('/{note}', [NoteController::class, 'view'])->name('note.view');
        Route::put('/{note}', [NoteController::class, 'update'])->name('note.update');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('note.destroy');
    });

});

require __DIR__.'/auth.php';
