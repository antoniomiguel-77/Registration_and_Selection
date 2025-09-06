<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


/**User Routes */
Route::controller(UserController::class)->prefix("user")->group(function () {
    route::post("store", "store")->name("store.user");
    route::get("find", "show")->name("show.user")->middleware('auth:sanctum');
    route::post("delete", "destroy")->name("delete.user")->middleware('auth:sanctum');
});
