<?php

use App\Http\Controllers\Api\V1\CalculateController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('calculate', CalculateController::class);
});
