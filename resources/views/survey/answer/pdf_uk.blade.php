<center>
    <table>
        <tr>
            <th colspan="2"><center><img src="/var/www/mis-ews/public/attachments/survey/{{ $image }}" style="width: 220px;"></center></th>
        </tr>
        <tr>
            <th colspan="2" style="padding-bottom: 20px;"><center>1&1 Survey Management System</center></th>
        </tr>
        <tr>
            <th style="padding: 20px;">Employee Name: {{ $agent->name }}</th>
            <th style="padding: 20px;"><span style="float:right">Date: {{ date("F j, Y", strtotime($time_answered)) }} &nbsp; &nbsp;Time: {{ date("g:i a", strtotime($time_answered)) }}</span></th>
        </tr>
            <tbody>
                @for($x = 0; $x < count($exam_answers); $x++)
                <tr>
                    <td colspan="2" style="padding: 20px;">
                        <div><b>Q:</b> <span style="word-wrap: break-word;">{{ $exam_answers[$x]['title'] }}</span></div>
                        <div><b>A:</b>
                                {!! str_replace(array("/", '\r\n', '[', ']'), "" ,ucwords($exam_answers[$x]['answer'])) !!}
                            </div>
                        @if($exam_answers[$x]['optional_answer'])
                        <?php $value = json_decode($exam_answers[$x]['optional_answer']); 
                              $arr = array('Training', 'Access/Permissions', 'Others');
                        ?>
                        @foreach($value AS $key => $val)
                            <div><b>{{ $val != "" || $val !=NULL ? $arr[$key].':' : '' }} </b>
                                {!!  $val != "" || $val !=NULL ? str_replace(array("/", '\r\n', '[', ']'), "" ,ucwords($val)) : '' !!}
                            </div>
                        @endforeach
                        
                        @endif
                    </td>
                </tr>
                @endfor
            </tbody>
    </table>
</center>
