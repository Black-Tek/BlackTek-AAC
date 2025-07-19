<?php

use App\Http\Controllers\News\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NewsController::class, 'index'])->name('home');

Route::get('news', [NewsController::class, 'index'])->name('news.index');

Route::get('news/{news}', [NewsController::class, 'show'])
    ->name('news.show')
    ->where('news', '[0-9]+');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
