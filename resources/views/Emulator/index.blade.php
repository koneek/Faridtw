<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Эмулятор запросов в сервис мониторинга</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link rel="stylesheet" href="css/app.css">

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
                                <h2>Эмулятор запросов в сервис мониторинга</h2>
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
                                <form id="emulate_form" action="{{ route('emulate') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Команда</label>
                                        <div class="col-sm-10">
                                            <select class="form-control m-b" id="method" name="method" onchange="methodChanged()">
                                                <option selected disabled hidden>Выбрать команду</option>
                                                <option value="data">Data - данные от датчиков</option>
                                                <option value="status">Status -  данные о циклах</option>
                                                <option value="power">Power - данные о питании</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">GUID</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="guid" name="guid">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-outline-warning btn-block" id="generate_guid" onclick="event.preventDefault(); generateguid()">Сгенерировать GUID</button>
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">DeviceID</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="device_id" name="device_id">
{{--                                            <select class="form-control m-b" id="device_id" name="device_id">--}}
{{--                                                <option selected disabled hidden>Выбрать аппарат</option>--}}
{{--                                                @foreach($devices as $device)--}}
{{--                                                    <option value="{{ $device->id }}">{{ $device->id }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
                                        </div>
                                    </div>
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">DeviceDTime</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="device_d_time" value="2022-12-20 18:37:29">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="row" id="file_mode">
                                        <div class="col-md-6">
                                            <label class="btn btn-primary">
                                                <i class="fa fa-image"></i> Выбрать файл<input type="file" id="file" name="file" class="form-control" style="display: none;" accept=".txt,.log"/>
                                            </label>
                                            <div id="selected_file"></div>
                                        </div>
                                    </div>
                                    <div class="row" id="power_mode" style="display: none;">
                                        <div class="col-md-2">
                                            <select class="form-control m-b" id="power" name="power">
                                                <option selected disabled hidden>Выбрать команду</option>
                                                <option value="off">Off</option>
                                                <option value="on">On</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button type="submit" class="btn btn-success">Отправить</button>
                                        </div>
                                    </div>

                                    <div class="ibox ">
                                        <div class="ibox-title">
                                            <h5>Ответ от сервера:</h5>
                                        </div>
                                        <div id="response_code" class="ibox-content"></div>
                                        <div id="response_message" class="ibox-content"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function generateguid() {
        var d = new Date().getTime();//Timestamp
        var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now() * 1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
        document.getElementById('guid').value = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16;//random number between 0 and 16
            if (d > 0) {//Use timestamp until depleted
                r = (d + r) % 16 | 0;
                d = Math.floor(d / 16);
            } else {//Use microseconds since page-load if supported
                r = (d2 + r) % 16 | 0;
                d2 = Math.floor(d2 / 16);
            }
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    }

    generateguid()

    function methodChanged() {
        let method = document.getElementById("method").value;
        let fileType = method === "status" ? ".log" : ".txt"
        document.getElementById("file").setAttribute('accept', fileType);

        $("#file_mode").css("display", method === "power" ? "none" : "")
        $("#power_mode").css("display", method === "power" ? "" : "none")
    }

    $("#emulate_form").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $("#emulate_form").attr("action"),
            // data: new FormData(this),
            // cache: false,
            // contentType: 'multipart/form-data',
            // processData: false,
            data: new FormData( this ),
            processData: false,
            contentType: false,
            // data: $("#emulate_form").serialize(),
            //or your custom data either as object {foo: "bar", ...} or foo=bar&...
            success: function (data, textStatus, xhr) {
                $("#response_code").text('Код: '+xhr.status)
                $("#response_message").text('Сообщение: '+data)
            },
            error: function(error, textStatus, xhr){
                $("#response_code").text('Код: '+error.status)
                $("#response_message").text('Сообщение: '+xhr)
            }
        });
    });

    document.getElementById("file").onchange = function () {
        $("#selected_file").text(this.value.replace(/^.*[\\\/]/, ''))
    };
</script>
</body>
</html>
