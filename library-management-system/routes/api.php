<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


route::post('/register', [AuthController::class, 'register']);
route::post('', [AuthController::class, 'login']);
route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
//auth route
route::middleware('auth:sanctum')->group(function () {
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/active', [CategoryController::class, 'active']);
    Route::get('/category/inactive', [CategoryController::class, 'inactive']);
    Route::put('/category/{id}/{status}', [CategoryController::class, 'updateStatus']);
});
