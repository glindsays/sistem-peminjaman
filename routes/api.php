<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    
    // URL-nya akan menjadi: GET /api/v1/campus/calendar
//     Route::get('/campus/calendar', [CampusCalendarController::class, 'getCalendarJson']);
    
// });
