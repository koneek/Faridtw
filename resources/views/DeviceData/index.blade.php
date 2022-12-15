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

<h2>Filter</h2>

<form action="{{ route('device-data.index') }}">
    <label for="guid">GUID:</label><br><br>
    <input type="text" id="guid" name="guid"><br><br>
    <label for="device_id">Device ID:</label><br><br>
    <input type="text" id="device_id" name="device_id"><br><br>
    <label for="device_d_time">Device D Time:</label><br><br>
    <input type="text" id="device_d_time" name="device_d_time"><br><br>
    <label for="user_id">User ID:</label><br><br>
    <input type="text" id="user_id" name="user_id"><br><br>
    <input type="submit" value="Submit">
</form>

<h2>Device Data</h2>

<table>
    <tr>
        <th>GUID</th>
        <th>Device ID</th>
        <th>Device D Time</th>
        <th>User ID</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
    @foreach($deviceData as $item)
        <tr>
            <td>{{ $item->guid }}</td>
            <td>{{ $item->device_id }}</td>
            <td>{{ $item->device_d_time }}</td>
            <td>{{ $item->user_id }}</td>
            <td>
                @if (is_null($item->deleted_at))
                    Yes
                @else
                    No
                @endif
            </td>
            <td><a target="_blank" href="/device-data/{{$item->id}}">{{ "device data" }}</a>
            </td>
        </tr>
    @endforeach
</table>

</body>
</html>

