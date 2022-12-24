<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Просмотр цикла</title>

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
                                <h2>Просмотр цикла</h2>
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
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Number</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->number }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Device ID</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->device_id }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Начало</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->started_at }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Завершение</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->ended_at }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Продолжительность</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->duration }}</h4></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="ibox ">
                                            <div class="ibox-title"><h5>Статус</h5></div>
                                            <div class="ibox-content"><h4
                                                    class="no-margins">{{ $cycle->status }}</h4></div>
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
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                            id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"
                                            role="grid">
                                            <thead>
                                            <tr>
                                                <th class="sorting" style="width: 15px;">Номер</th>
                                                <th class="sorting" style="width: 159.187px;">Название</th>
                                                <th class="sorting" style="width: 159.187px;">Начало</th>
                                                <th class="sorting" style="width: 159.187px;">Завершение</th>
                                                <th class="sorting" style="width: 159.187px;">События</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($cycle->stages))
                                                @foreach($cycle->stages as $item)
                                                    <tr>
                                                        <td>{{ $item->number }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->started_at }}</td>
                                                        <td>{{ $item->ended_at }}</td>
                                                        <td>
                                                            @foreach($item->data as $it)
                                                                {{ $it }}<br>
                                                            @endforeach
                                                        </td>
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
