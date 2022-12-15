<?php

namespace App\Http\Controllers;

use App\Models\DeviceData;
use App\Http\Requests\StoreDeviceDataRequest;
use App\Http\Requests\UpdateDeviceDataRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DeviceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $query = DeviceData::query();

        $data = $request->all();

        if (isset($data['guid'])) {
            $query->where('guid', $data['guid']);
        }
        if (isset($data['device_id'])) {
            $query->where('device_id', $request->get('device_id'));
        }
        if (isset($data['device_d_time'])) {
            $query->where('device_d_time', $request->get('device_d_time'));
        }
        if (isset($data['user_id'])) {
            $query->where('user_id', $request->get('user_id'));
        }
        if (isset($data['type'])) {
            $query->where('type', $request->get('type'));
        }

        return view("DeviceData.index", ["deviceData" => $query->get()]);
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
        return view("DeviceData.show", ["deviceData" => DeviceData::find($id)->makeVisible(['device_data'])]);
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
