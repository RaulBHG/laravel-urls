<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('healthcheck', function (Request $request) {
    return response()->json(['status' => 'ok']);
});
