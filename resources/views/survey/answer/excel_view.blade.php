<table>
    <tr>
    @foreach($headers AS $header)
        <th>{{ $header }}</th>
    @endforeach
    </tr>
    @foreach($arr_values AS $_arr)
    <tr>
        <td>{{ $_arr['uid'] }}</td>
        <td>{{ $_arr['team'] }}</td>
        @foreach($_arr['answers'] AS $ans)
            <td>{{ $ans }}</td>
        @endforeach
        <?php $value = json_decode($_arr['optional_answers'])?>
         @foreach($value AS $key => $val)
         <?php $final = str_replace(array("\r\n", "/", "[", "]") , " " ,ucwords($val))?>
        <td>{{$final}}</td>
        @endforeach
    </tr>
    @endforeach
    
</table>