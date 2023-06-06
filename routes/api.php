<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

Route::controller(PostController::class)
    ->prefix('posts')
    ->group(callback:  function () {
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

Route::controller(TagController::class)
    ->prefix('tags')
    ->group(function () {
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

Route::controller(\App\Http\Controllers\CategoryController::class)
    ->prefix('tags')
    ->group(function () {
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
