<table width="700">
    <thead>
        <tr>
            @foreach($data AS $breakdown)
                @foreach($breakdown['headers'] as $i => $head)
                <th style='{{ $breakdown['headerStyle'][$i] }} text-align: center; background-color: #3C8DBC; color: #fff; font-weight: normal;'>{{ $head }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data AS $breakdown)
            @foreach($breakdown['data'] as $_row)
            <tr>
                @foreach($_row as $_cell)
                <td width="20" style="text-align: center;"><?php echo $_cell ?></td>
                @endforeach
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>