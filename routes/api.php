<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/recipe',[RecipeController::class,'store']);
Route::post('/recipe/upload',[RecipeController::class,'upload']);
Route::patch('/recipe/{recipe}',[RecipeController::class,'update']);
Route::get('/recipes',[RecipeController::class,'index']);
Route::get('/recipe/{id}',[RecipeController::class,'show']);
Route::delete('/recipe/{id}',[RecipeController::class,'destory']);

Route::get('/category',[CategoryController::class,'index']);

