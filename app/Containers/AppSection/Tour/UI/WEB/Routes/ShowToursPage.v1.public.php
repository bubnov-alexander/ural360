<?php

use App\Containers\AppSection\Tour\UI\WEB\Controllers\ShowTourPageController;
use App\Containers\AppSection\Tour\UI\WEB\Controllers\ShowToursPageController;
use Illuminate\Support\Facades\Route;

Route::get('/routes/', ShowToursPageController::class)->name('tours.index');
Route::get('/routes/{slug}/', ShowTourPageController::class)->name('tours.show');
Route::redirect('/shop/', '/routes/', 301);
Route::redirect('/product/{slug}/', '/routes/{slug}/', 301);
