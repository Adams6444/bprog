<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            table > tr , th {
                    border: 1px solid black;
                    padding: 0.5rem;
                }
        </style>
    </head>
    <body class="antialiased" style="width: 100%">
        <div class="container" style="display: flex; justify-content: center; width: fit-content; flex-direction: column;">
            <table>
                <thead>
                    <tr>
                        <th>id</th><th>name</th><th>value</th>
                    </tr>
                </thead>
                </tbody>
                @foreach($task_1 as $row)
                    <tr>
                        <th>{{$row->id}}</th><th>{{$row->name}}</th><th>{{$row->value}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>id</th><th>termin</th><th>value</th>
                    </tr>
                </thead>
                </tbody>
                @foreach($task_2 as $key => $row)
                    <tr>
                        <th>{{$key}}</th><th>{{$row['date_start']}} - {{$row['date_stop']}} </th><th>{{ $row['wolny'] ?? $row['zejety'] }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
