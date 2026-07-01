<?php

use App\Containers\AppSection\Faq\UI\WEB\Controllers\ShowQuestionsPageController;
use Illuminate\Support\Facades\Route;

Route::get('/questions/', ShowQuestionsPageController::class)->name('questions');
