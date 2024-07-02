<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KenegerianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->group(function () {
//     Route::get('me', [AuthController::class, 'me']);
//     Route::post('logout', [AuthController::class, 'logout']);
// });

Route::get('data-kenegerian',[KenegerianController::class,'index'])->name('data.kenegerian');