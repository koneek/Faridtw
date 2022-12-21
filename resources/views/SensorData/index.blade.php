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
                <h2>Данны датчиков</h2>
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
                <h3>Фильтр</h3>

                <form action="{{ route('sensor-data.index') }}">
                    <label for="guid">Device id:</label><br>
                    <input type="text" id="device_id" name="device_id"><br><br>

                    <label for="sensor_id">Cycle ID:</label><br>
                    <input type="text" id="cycle_id" name="cycle_id"><br><br>

                    <label for="sensor_id">Row ID:</label><br>
                    <input type="text" id="row_id" name="row_id"><br><br>

                    <label for="sensor_d_time">Date Time:</label><br>
                    <input type="text" id="date_time" name="date_time"><br><br>

                    <input type="submit" value="Submit">
                </form>

                <h3>List</h3>

                <table>
                    <tr>
                        <th>Device ID</th>
                        <th>Cycle ID</th>
                        <th>Row ID</th>
                        <th>Date Time</th>
                        <th>Удалено</th>
                        <th>Действия</th>
                    </tr>
                    @foreach($sensorData as $item)
                        <tr>
                            <td>{{ $item->device_id }}</td>
                            <td>{{ $item->cycle_id }}</td>
                            <td>{{ $item->row_id }}</td>
                            <td>{{ $item->date_time }}</td>
                            <td>
                                @if (is_null($item->deleted_at))
                                    Нет
                                @else
                                    Да
                                @endif
                            </td>
                            <td><a target="_blank" href="/sensor-data/{{$item->id}}">{{ "данные" }}</a>
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

