<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Запросы</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/app.css">

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
</head>
<body>
<div class="row">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    @include('menu')
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h2>Запросы</h2>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                    </ul>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content" style="">
                                <form id="emulate_form" action="{{ route('device-data.index') }}" method="GET"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">GUID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="guid" name="guid">
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Device
                                            ID</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" id="device_id" name="device_id">
                                                <option selected disabled hidden>Выбрать аппарат</option>
                                                @foreach($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Device D
                                            Time</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="device_d_time">
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">User ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="user_id">
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Тип</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" id="type" name="type">
                                                <option selected disabled hidden>Выбрать тип</option>
                                                <option value="log">Log</option>
                                                <option value="sensor">Sensor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <button type="submit" class="btn btn-success" style="float: right;">Фильтровать</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5></h5>
                            </div>
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                            role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting" style="width: 159.187px;">GUID</th>
                                                <th class="sorting" style="width: 159.187px;">Device ID</th>
                                                <th class="sorting" style="width: 159.187px;">Device D Time</th>
                                                <th class="sorting" style="width: 159.187px;">User ID</th>
                                                <th class="sorting" style="width: 159.187px;">Тип</th>
                                                <th class="sorting" style="width: 159.187px;">Дата и время запроса</th>
                                                <th class="sorting" style="width: 159.187px;">IP</th>
                                                <th class="sorting" style="width: 159.187px;">Удалено</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($deviceData as $item)
                                                <tr>
                                                    <td><a target="_blank" href="/device-data/{{$item->id}}">{{ $item->guid }}</a></td>
                                                    <td>{{ $item->device_id }}</td>
                                                    <td>{{ $item->device_d_time }}</td>
                                                    <td>{{ $item->user_id }}</td>
                                                    <td>{{ $item->type }}</td>
                                                    <td>{{ $item->request_time }}</td>
                                                    <td>{{ $item->ip }}</td>
                                                    <td>{{ $item->deleted_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
