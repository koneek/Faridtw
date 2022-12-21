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

<h2>Данные датчиков</h2>

<table>
    <thead>
    <tr>
        <td>
            <p>Device ID</p>
            <h3>{{ $sensorData->device_id }}</h3>
            <hr>
        </td>
        <td>
            <p>Cycle ID</p>
            <h3>{{ $sensorData->cycle_id }}</h3>
            <hr>
        </td>
        <td>
            <p>Row ID</p>
            <h3>{{ $sensorData->row_id }}</h3>
            <hr>
        </td>
        <td>
            <p>Date Time</p>
            <h3>{{ $sensorData->date_time }}</h3>
            <hr>
        </td>
    </tr>
    <tr>
        <th colspan="2">Данные датчиков</th>
    </tr>
    </thead>
    <tbody>
    @if (!is_null($sensorData->row_data))
        @foreach($sensorData->row_data as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>Нет данных</td>
        </tr>
    @endif
    </tbody>
</table>

</body>
</html>

