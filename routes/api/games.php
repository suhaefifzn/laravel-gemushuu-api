<?php

use App\Http\Controllers\GameController;

Route::controller(GameController::class)->group(function () {
    Route::prefix('games')->group(function () {
        Route::get('', 'getAll');
        Route::get('/{game:slug}', 'getOne');
        Route::post('', 'add');
        Route::put('/{game:slug}', 'update');
        Route::delete('/{game:slug}', 'delete');
    });
});
