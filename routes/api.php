<?php

use Illuminate\Support\Facades\Route;

// Index
Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to GemaShuu API',
    ], 200);
})->middleware('auth.client.jwt');

// Auth Route
require_once __DIR__ . '/api/auth.php';

// Another Routes
require_once __DIR__ . '/api/games.php';

