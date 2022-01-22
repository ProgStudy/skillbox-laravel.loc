@component('mail::panel')
    @component('mail::table')
    <h1 class="text-center">Отчет сформирован</h1>
    <table>
        <thead>
            <tr>
                <th>Раздел</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $index => $item)
                <tr>
                    <td style="margin-left: 10px">{{$item[0]}}</td>
                    <td style="display:block; text-align:center">{{$item[1]}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endcomponent
@endcomponent