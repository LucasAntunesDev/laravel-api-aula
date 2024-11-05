<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PeopleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'OK'
    ]);
});

Route::prefix('people')->group(function () {
    Route::get('list', [PeopleController::class, 'list']);

    Route::post('store', [PeopleController::class, 'store']);

    Route::post('storeInterest', [PeopleController::class, 'storeInterest']);
});

Route::prefix('user')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register']);
});
