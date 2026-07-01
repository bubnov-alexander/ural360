<?php

use App\Containers\AppSection\Page\UI\WEB\Controllers\ShowAboutPageController;
use Illuminate\Support\Facades\Route;

Route::get('/about/', ShowAboutPageController::class)->name('about');
