<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PowerMeterController;
use App\Models\PowerData;
use App\Models\PowerMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/power-data', function (Request $request) {
    $validated = $request->validate([
        'power_meter_id' => 'required|exists:power_meters,id',
        'voltage' => 'required|numeric',
        'current' => 'required|numeric',
        'power' => 'required|numeric',
        'total_kwh' => 'required|numeric',
        'recorded_at' => 'required|date',
    ]);

    $powerData = PowerData::create($validated);

    return response()->json(['status' => 'success', 'data' => $powerData], 201);
});

Route::middleware(['auth:sanctum', 'active'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::get('/power-data/{power_meter_id}', function ($powerMeterId) {
        return PowerData::where('power_meter_id', $powerMeterId)
            ->orderBy('recorded_at', 'desc')
            ->limit(100)
            ->get();
    });

    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
        Route::apiResource('power-meters', PowerMeterController::class);
    });
});
