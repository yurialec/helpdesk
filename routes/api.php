<?php

use App\Http\Controllers\Api\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/helpdesk', function (Request $request) {
    return 'IT WORKS!';
});

Route::prefix('helpdesk')->group(function () {
    Route::post('/first-contact', [ChatController::class, 'firstContact']);
    Route::post('/chat/{protocol}', [ChatController::class, 'sendMessage']);
});