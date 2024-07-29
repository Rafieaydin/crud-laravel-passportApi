<?php

use App\Http\Middleware\HandleFormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', ['App\Http\Controllers\AuthController','register']);
Route::post('login', ['App\Http\Controllers\AuthController','login']);

Route::middleware(['auth:api',HandleFormData::class])->group(function(){
    Route::get('/post', ['App\Http\Controllers\PostController','index']);
    Route::post('/post', ['App\Http\Controllers\PostController','store']);
    Route::get('/post/{post}', ['App\Http\Controllers\PostController','show']);
    Route::patch('/post/{id}/update', ['App\Http\Controllers\PostController','updates']);
    Route::delete('/post/{id}/delete', ['App\Http\Controllers\PostController','destroy']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
