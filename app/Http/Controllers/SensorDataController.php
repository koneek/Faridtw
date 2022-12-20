<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = SensorData::query();

        return view("SensorData.index", ["sensorData" => $query->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param int
     * @return View
     */
    public function show($id)
    {
        return view("SensorData.show", ["sensorData" => SensorData::find($id)->makeVisible(['sensor_data'])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SensorData $sensorData
     * @return \Illuminate\Http\Response
     */
    public function destroy(SensorData $sensorData)
    {
        //
    }
}
