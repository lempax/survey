<table>
    <tr>
    @foreach($headers AS $header)
        @if($header == "Question1")
            <th style="background-color: #eee; text-align: center;" colspan="3">{{ $header }}</th>
        @else
            <th style="background-color: #eee; text-align: center;">{{ $header }}</th>
        @endif
    @endforeach
<!--    <th style="background-color:#eee; text-align: center;" colspan="3">Question1 Essay</th>-->
    </tr>
    <tr>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">&nbsp;</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">&nbsp;</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">Training</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">Access/Permission</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">Others</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">&nbsp;</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">&nbsp;</td>
        <td style="background-color: #eee; font-weight: bold; text-align: center;">&nbsp;</td>
    </tr>
    @foreach($arr_values AS $_arr)
    <tr>
        <td>{{ $_arr['uid'] }}</td>
        <td>{{ $_arr['team'] }}</td>
        @foreach($_arr['answers'] AS $key => $ans)
             @if($key == 0)
                <?php $value = explode(',', $ans); ?>
                @foreach($_arr['optional_answers'] AS $opt)
                @if($opt != NULL)
                <?php $val = json_decode($opt); ?>
                    @foreach($val AS $_val)
                        <td>{{ str_replace(array("/"), "", str_replace(array("[", "]"), "", str_replace(array('\r\n'), "," ,$_val))) }}</td>
                    @endforeach
                @endif
                @endforeach
            @else
                <td>{{ str_replace(array("/"), "", str_replace(array("[", "]"), "", str_replace(array('\r\n'), "," ,$ans))) }}</td>
           @endif
        @endforeach

       
    </tr>
    @endforeach
</table>