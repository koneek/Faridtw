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

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>Device Data</h2>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        @include('menu')
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="">
                <h3>Filter</h3>

                <form action="{{ route('cycles.index') }}">
                    <label for="guid">GUID:</label><br>
                    <input type="text" id="guid" name="guid"><br><br>

                    <label for="device_id">Device ID:</label><br>
                    <input type="text" id="device_id" name="device_id"><br><br>

                    <label for="device_d_time">Device D Time:</label><br>
                    <input type="text" id="device_d_time" name="device_d_time"><br><br>

                    <label for="user_id">User ID:</label><br>
                    <input type="text" id="user_id" name="user_id"><br><br>

                    <select class="form-control m-b" name="type">
                        <option value="log">Log</option>
                        <option value="sensor">Sensor</option>
                    </select><br><br>

                    <input type="submit" value="Submit">
                </form>

                <h3>List</h3>

                <table>
                    <tr>
                        <th>Number</th>
                        <th>Started at</th>
                        <th>Ended at</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Deleted</th>
                        <th>Actions</th>
                    </tr>
                    @foreach($cycles as $item)
                        <tr>
                            <td>{{ $item->number }}</td>
                            <td>{{ $item->started_at }}</td>
                            <td>{{ $item->ended_at }}</td>
                            <td>{{ $item->duration }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @if (is_null($item->deleted_at))
                                    No
                                @else
                                    Yes
                                @endif
                            </td>
                            <td><a target="_blank" href="/cycles/{{$item->id}}">stages</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>

