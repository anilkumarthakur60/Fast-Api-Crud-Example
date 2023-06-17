<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(TagController::class)
    ->prefix('tags')
    ->group($route = function () {
        Route::get('', 'index');
        Route::post('', 'store');
        Route::post('delete', 'delete');
        Route::post('restore-all-trashed', 'restoreAllTrashed');
        Route::post('force-delete-trashed', 'forceDeleteTrashed');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::put('{id}/status-change/{column}', 'changeStatusOtherColumn'); //specific columns change value from 0 to 1 and vice versa
        Route::put('{id}/status-change', 'changeStatus');//default status column from 0 to 1 and vice versa
        Route::put('{id}/restore-trash', 'restoreTrashed');
        Route::delete('{id}', 'destroy');
    });

Route::controller(PostController::class)
    ->prefix('posts')
    ->group(function () use ($route) {
        $route();
    });
Route::controller(CategoryController::class)
    ->prefix('categories')
    ->group(function () use ($route) {
        $route();
    });

Route::controller(AdminController::class)
    ->prefix('auth')
    ->middleware(['auth:admin-api', 'scope:adminApi'])
    ->group(function () {
        Route::post(uri: 'logout', action: 'logout');
        Route::get('detail', 'detail');
        Route::get('refresh-token', 'refreshToken');
    });
Route::controller(AdminController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post(uri: 'login', action: 'login');
        Route::post(uri: 'register', action: 'register');
        Route::post(uri: 'forget-password', action: 'passwordReset');
        Route::post(uri: 'reset-password', action: 'resetPassword');
    });


Route::apiResource('medias', MediaController::class);
