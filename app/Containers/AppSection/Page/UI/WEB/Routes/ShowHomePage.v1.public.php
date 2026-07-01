<?php

use App\Containers\AppSection\Page\UI\WEB\Controllers\ShowHomePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowHomePageController::class)->name('home');
