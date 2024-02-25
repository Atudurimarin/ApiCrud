<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Models\Article;
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

//Route::post('/articles', [ArticleController::class, 'store'])->name('api.v1.articles.store');
//Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('api.v1.articles.show');
//Route::get('/articles', [ArticleController::class, 'index'])->name('api.v1.articles.index');

/*
Route::middleware('auth:sanctum')->group( function(){ 
    Route::apiResource('articles', ArticleController::class)->except('index')->names('api.v1.articles');
    // SE APLICA MIDDLEWARE AL GRUPO MENOS INDEX               ^^
});

Route::get('articles', [ArticleController::class, 'index'])->name('api.v1.articles.index');
 // EVITA QUE SE APLIQUE EL MIDDLEWARE */

 Route::apiResource('articles', ArticleController::class)->names('api.v1.articles');

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('logout', [AuthController::class, 'logout'])->name('logout');
