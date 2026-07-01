<?php

use App\Containers\AppSection\Page\UI\WEB\Controllers\ShowGalleryPageController;
use Illuminate\Support\Facades\Route;

Route::get('/gallery/', ShowGalleryPageController::class)->name('gallery');
