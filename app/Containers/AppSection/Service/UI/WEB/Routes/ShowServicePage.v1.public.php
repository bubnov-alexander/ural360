<?php

use App\Containers\AppSection\Service\UI\WEB\Controllers\ShowServicePageController;
use Illuminate\Support\Facades\Route;

Route::get('/service/{slug}/', ShowServicePageController::class)->name('services.show');
