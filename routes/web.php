<?php

use App\Http\Controllers\DeviceDataController;
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

Route::resource('device-data', DeviceDataController::class);
Route::get('emulator', [EmulatorController::class, 'index']);
//Route::get('emulate', [EmulatorController::class, 'emulate'])->name('emulate');
//Route::post('/upload-file', [EmulatorController::class, 'fileUpload'])->name('fileUpload');
Route::post('file-upload', [ EmulatorController::class, 'emulate' ])->name('emulate');
