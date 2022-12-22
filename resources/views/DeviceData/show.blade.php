<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Просмотр запроса</title>

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
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>GUID</h5></div>
                                            <div class="ibox-content"><h4 class="no-margins">{{ $deviceData->guid }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Device ID</h5></div>
                                            <div class="ibox-content"><h4 class="no-margins">{{ $deviceData->device_id }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Device D Time</h5></div>
                                            <div class="ibox-content"><h4 class="no-margins">{{ $deviceData->device_d_time }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>User ID</h5></div>
                                            <div class="ibox-content"><h4 class="no-margins">{{ $deviceData->user_id}}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Type</h5></div>
                                            <div class="ibox-content"><h4 class="no-margins">{{ $deviceData->type }}</h4></div>
                                        </div>
                                    </div>
                                </div>
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
                                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                        role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting" style="width: 159.187px;">Device Data</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (!is_null($deviceData->device_data))
                                                @foreach($deviceData->device_data as $item)
                                                    <tr>
                                                        <td>{{ is_array($item) ? json_encode($item) : $item }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>NO DEVICE DATA</td>
                                                </tr>
                                            @endif
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
