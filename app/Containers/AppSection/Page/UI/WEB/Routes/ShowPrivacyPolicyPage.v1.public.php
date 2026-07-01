<?php

use App\Containers\AppSection\Page\UI\WEB\Controllers\ShowPrivacyPolicyPageController;
use Illuminate\Support\Facades\Route;

Route::get('/privacy-policy/', ShowPrivacyPolicyPageController::class)->name('privacy-policy');
