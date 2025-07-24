<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CompanyController;
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
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [RegisteredUserController::class, 'login']);
// Route::post('/logout', [RegisteredUserController::class, 'logout']);
// No "ensure.company" middleware on /companies
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'logout']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::post('/companies/{company}/switch', [CompanyController::class, 'switch']);

 
    Route::middleware('company_selected')->group(function () {
        Route::get('/dashboard', fn () => response()->json(['message' => 'Welcome']));
        Route::get('/companies', [CompanyController::class, 'index']);
        Route::put('/companies/{company}', [CompanyController::class, 'update']);
        Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
    });
});
