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

<h2>Cycle</h2>

<table>
    <thead>
    <tr>
        <td>
            <p>Number</p>
            <h3>{{ $cycle->number }}</h3>
            <hr>
        </td>
        <td>
            <p>Started at</p>
            <h3>{{ $cycle->started_at }}</h3>
            <hr>
        </td>
        <td>
            <p>Ended at</p>
            <h3>{{ $cycle->ended_at }}</h3>
            <hr>
        </td>
        <td>
            <p>Duration</p>
            <h3>{{ $cycle->duration }}</h3>
            <hr>
        </td>
        <td>
            <p>Status</p>
            <h3>{{ $cycle->status }}</h3>
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="5">Stages</td>
    </tr>
    <tr>
        <th>Name</th>
        <th>Started at</th>
        <th>Ended at</th>
    </tr>
    </thead>
    <tbody>
    @if (count($cycle->stages))
        @foreach($cycle->stages as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->started_at }}</td>
                <td>{{ $item->ended_at }}</td>
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

