<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2>Device Data</h2>

<table>
    <thead>
    <tr>
        <td>
            <p>GUID</p>
            <h3>{{ $deviceData->guid }}</h3>
            <hr>
        </td>
        <td>
            <p>Device ID</p>
            <h3>{{ $deviceData->device_id }}</h3>
            <hr>
        </td>
        <td>
            <p>Device D Time</p>
            <h3>{{ $deviceData->device_d_time }}</h3>
            <hr>
        </td>
        <td>
            <p>User ID</p>
            <h3>{{ $deviceData->user_id }}</h3>
            <hr>
        </td>
    </tr>
    <tr>
        <th>Device Data</th>
    </tr>
    </thead>
    <tbody>
    @if (!is_null($deviceData->device_data))
        @foreach($deviceData->device_data as $key => $deviceData)
            <tr>
                <td>{{ $key }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>NO DEVICE DATA</td>
        </tr>
    @endif
    </tbody>
</table>

</body>
</html>

