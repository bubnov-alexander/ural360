<?php

use App\Containers\AppSection\Service\UI\WEB\Controllers\ShowServicesPageController;
use Illuminate\Support\Facades\Route;

Route::get('/service/', ShowServicesPageController::class)->name('services.index');
