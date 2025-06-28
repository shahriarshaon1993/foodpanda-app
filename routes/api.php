<?php

use App\Http\Controllers\Api\V1\AuthenticatedApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthenticatedApiController::class, 'getUser']);
});
