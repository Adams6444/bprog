<style>
    table > tr , th {
            border: 1px solid black;
            padding: 0.5rem;
        }
</style>

<table>
    <thead>
        <tr>
            <th>name</th><th>basic price</th><th>discount</th>
        </tr>
    </thead>
    </tbody>
    @foreach($task_4 as $row)
        <tr>
            <th>{{$row->name}}</th>
            @foreach ($row->getPrices as $index => $price)
            <th>
                @if ($index === 0 && count($row->getPrices) > 1)
                    <s>{{ $price->value }}</s>
                @else
                    {{ $price->value }}
                @endif
            </th>
        @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
