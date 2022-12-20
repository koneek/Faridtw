<?php

use App\Http\Controllers\CycleController;
use App\Http\Controllers\DeviceDataController;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\EmulatorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('cycles', CycleController::class);
Route::resource('device-data', DeviceDataController::class);
Route::resource('sensor-data', SensorDataController::class);

Route::get('emulator', [EmulatorController::class, 'index']);
Route::post('file-upload', [ EmulatorController::class, 'emulate' ])->name('emulate');

