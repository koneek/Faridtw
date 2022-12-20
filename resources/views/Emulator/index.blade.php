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
                <h2>Emulate Send Data</h2>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/device-data" class="dropdown-item">Device data</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="">
                <form action="{{ route('emulate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row"><label class="col-sm-2 col-form-label">Method</label>
                        <div class="col-sm-10">
                            <select class="form-control m-b" name="method">
                                <option>Power</option>
                                <option>Data</option>
                                <option>Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">GUID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="guid" name="guid">
                        </div>
                    </div>
                    <button id="generateUUID" onclick="event.preventDefault(); generateUUID();">Generate UUID</button>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">DeviceID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="device_id">
                        </div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">DeviceDTime</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="device_d_time">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="file" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <br>
                    <br>
                    <br>
                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white btn-sm" type="submit">Cancel</button>
                            <button type="submit" class="btn btn-success">Send Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function generateUUID() {
        var d = new Date().getTime();//Timestamp
        var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
        document.getElementById('guid').value = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16;//random number between 0 and 16
            if(d > 0){//Use timestamp until depleted
                r = (d + r)%16 | 0;
                d = Math.floor(d/16);
            } else {//Use microseconds since page-load if supported
                r = (d2 + r)%16 | 0;
                d2 = Math.floor(d2/16);
            }
            return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    }

    generateUUID()
</script>
</body>
</html>

