<?php

use App\Containers\AppSection\Page\UI\WEB\Controllers\ShowContactsPageController;
use Illuminate\Support\Facades\Route;

Route::get('/contacts/', ShowContactsPageController::class)->name('contacts');
