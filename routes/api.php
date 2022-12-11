<?php

use App\Http\Controllers\API\DeviceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/power', [DeviceController::class, 'power'])->name('power');
Route::post('/mode', [DeviceController::class, 'mode'])->name('mode');
Route::post('/data', [DeviceController::class, 'data'])->name('data');

Route::delete('/data/{guid}', [DeviceController::class, 'delete'])->name('delete');
Route::get('/firmwares/{deviceID}', [DeviceController::class, 'firmwares'])->name('firmwares');
Route::post('/status', [DeviceController::class, 'status'])->name('status');
Route::get('/firmware/{id}', [DeviceController::class, 'firmware'])->name('firmware');
