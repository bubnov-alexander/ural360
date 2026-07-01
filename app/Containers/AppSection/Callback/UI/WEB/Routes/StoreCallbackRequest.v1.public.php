<?php

use App\Containers\AppSection\Callback\UI\WEB\Controllers\StoreCallbackRequestController;
use Illuminate\Support\Facades\Route;

Route::post('/callback/', StoreCallbackRequestController::class)->name('callback.store');
