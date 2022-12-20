<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use App\Http\Requests\StoreDeviceDataRequest;
use App\Http\Requests\UpdateDeviceDataRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = Cycle::query();

        return view("Cycle.index", ["cycles" => $query->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDeviceDataRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeviceDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int
     * @return View
     */
    public function show($id)
    {
        return view("Cycle.show", ["cycle" => Cycle::find($id)->load('stages')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DeviceData $deviceData
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceData $deviceData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDeviceDataRequest $request
     * @param \App\Models\DeviceData $deviceData
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceDataRequest $request, DeviceData $deviceData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DeviceData $deviceData
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceData $deviceData)
    {
        //
    }
}
