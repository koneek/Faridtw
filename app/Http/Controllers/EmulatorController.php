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
            'file' => 'required|mimes:log,txt',
        ]);

        $fileName = $request->file->getClientOriginalName();
        $filePath = 'uploads/' . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($request->file));

        $method = $request->get('method');

        $device_data = [];
        $handle = fopen("storage/" . $filePath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if ($method==='data') {
                    if (str_contains($line, 'Integrals')) {
                        break;
                    }
                    $device_data[] = preg_split('/\s+/', $line);
                } else {
                    $device_data[] =  $line;
                }
            }
            fclose($handle);
        }

        $data = [];

        $data['GUID'] = $request->get('guid');
        $data['DeviceID'] = $request->get('device_id');
        $data['DeviceDTime'] = $request->get('device_d_time');
        $data['DeviceData'] = $device_data;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost/api/' . $method,
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

        return $response;
    }
}
