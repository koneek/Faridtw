<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class EmulatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view("Emulator.index");
    }

    public function emulate(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlxs,xlx,docx,doc,csv,txt,png,gif,jpg,jpeg|max:2048',
        ]);

        $fileName = $request->file->getClientOriginalName();
        $filePath = 'uploads/' . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($request->file));

        $device_data = [];
        $handle = fopen("storage/" . $filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $device_data[] = $line;
            }
            fclose($handle);
        }

        $method = $request->get('method');

        $data = [];

        $data['GUID'] = $request->get('guid');
        $data['DeviceID'] = $request->get('device_id');
        $data['DeviceDTime'] = $request->get('device_d_time');
        $data['DeviceData'] = $device_data;


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://mtk-mon.loc/api/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        dd($method, $data);

        dd(123);
        dd($x);
        dd($request->all());

        return view("Emulator.index");
    }
}
