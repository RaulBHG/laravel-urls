<?php

use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\V1\Infrastructure\Middlewares\BearerTokenMiddleware;

Route::prefix('v1')->middleware(BearerTokenMiddleware::class)->group(function () {
	Route::post('short-urls', [UrlController::class, 'shortUrl']);
});

Route::get('healthcheck', function (Request $request) {
	return response()->json(['status' => 'ok']);
});
