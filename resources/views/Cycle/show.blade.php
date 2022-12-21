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

<h2>Цикл</h2>

<table>
    <thead>
    <tr>
        <td>
            <p>Номер</p>
            <h3>{{ $cycle->number }}</h3>
            <hr>
        </td>
        <td>
            <p>Начало</p>
            <h3>{{ $cycle->started_at }}</h3>
            <hr>
        </td>
        <td>
            <p>Завершение</p>
            <h3>{{ $cycle->ended_at }}</h3>
            <hr>
        </td>
        <td>
            <p>Продолжительность</p>
            <h3>{{ $cycle->duration }}</h3>
            <hr>
        </td>
        <td>
            <p>Статус</p>
            <h3>{{ $cycle->status }}</h3>
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="5">Стадии</td>
    </tr>
    <tr>
        <th>Название</th>
        <th>Начало</th>
        <th>Завершение</th>
        <th>События</th>
    </tr>
    </thead>
    <tbody>
    @if (count($cycle->stages))
        @foreach($cycle->stages as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->started_at }}</td>
                <td>{{ $item->ended_at }}</td>
                <td>{{ implode(PHP_EOL, $item->data) }}</td>
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

