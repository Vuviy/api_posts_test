<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/posts/{id?}', [PostController::class, 'get']);

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::post('/logout',[AuthController::class,'logout'])
    ->middleware(['auth:sanctum', 'ability:admin,user']);


Route::middleware(['auth:sanctum', 'ability:admin,user'])->group( function () {
    Route::get('/posts/user/{author_id}/{id?}', [PostController::class, 'getForAuthor']);

   Route::post('/posts/create', [PostController::class, 'create']);
   Route::post('/posts/update/{id}', [PostController::class, 'update']);
   Route::post('/posts/delete/{id}', [PostController::class, 'delete']);
   Route::post('/posts/publish/{id}', [PostController::class, 'publish']);

    Route::post('/comment/create', [CommentController::class, 'create']);

    Route::get('/user', [UserController::class, 'get']);
});


Route::middleware(['auth:sanctum', 'ability:admin'])->group( function () {
   Route::post('/comment/delete/{id}', [CommentController::class, 'delete']);
   Route::post('/user/ban/{id}', [UserController::class, 'banUser']);
});

