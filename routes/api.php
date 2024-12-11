<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('login',[\App\Http\Controllers\AuthController::class, 'login'])->name('login');

        Route::post('logout',[\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    });

    Route::apiResource('employee',\App\Http\Controllers\API\EmployeeController::class);
    Route::patch('employee/{employee}/status',[\App\Http\Controllers\API\EmployeeController::class,'updateStatus'])->name('employee.status');
    Route::apiResource('user',\App\Http\Controllers\API\UserController::class);
    Route::patch('user/{user}/status', [\App\Http\Controllers\API\UserController::class, 'updateStatus'])->name('user.status');

})->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

