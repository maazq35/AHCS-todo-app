<?php

use Illuminate\Support\Facades\Route;



Route::get('/', [App\Http\Controllers\TodoController::class, 'index']);
