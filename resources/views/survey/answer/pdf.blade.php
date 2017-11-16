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
            @for($x = 0; $x < count($exam_answers); $x++)
            <tr>
                <td colspan="2" style="padding: 20px;">
                    <div><b>Q:</b> <span style="word-wrap: break-word;">{{ $exam_answers[$x]['title'] }}</span></div>
                    <div><b>A:</b>
                        @if($exam_answers[$x]['title'] == 'Please name 2 premium features for mail.com')
                        {{ str_replace(array("\/", '\r\n'), ", " ,ucwords($exam_answers[$x]['answer'])) }}
                        @else 
                        {{ $exam_answers[$x]['answer'] }}
                        @endif
                    </div>
                </td>
            </tr>
            @endfor
    </table>
</center>
