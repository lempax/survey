@extends('layouts.master')

@section('content')


<div class="box box-success box-solid">
    <div class="box-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>1&1 Survey Management System<br>Employee Name: {{ $agent->name }}</th>
                    <th><span class="pull-right">Date: {{ date("F j, Y", strtotime($time_answered)) }} <br>Time: {{ date("g:i a", strtotime($time_answered)) }}</span></th>
                </tr>
            </thead>
            <tbody>
                @for($x = 0; $x < count($exam_answers); $x++)
                <tr>
                    <td colspan="2" style="padding: 20px;">
                        <div><b>Q:</b> <span style="word-wrap: break-word;">{{ $exam_answers[$x]['title'] }}</span></div>
                        <div><b>A:</b>
                            @if($exam_answers[$x]['title'] == 'Please name 2 premium features for mail.com')
                            {!! str_replace(array("\/", '\r\n'), ", " ,ucwords($exam_answers[$x]['answer'])) !!}
                            @else 
                            {{ $exam_answers[$x]['answer'] }}

                            <?php
                            //'Training','Permission','Others'
                            ?>
                            @if($exam_answers[$x]['optional_answer'])
                            <?php
                            $value = json_decode($exam_answers[$x]['optional_answer']);
                            $value2 = $exam_answers[$x]['answer'];
                          //  foreach ($value2 AS $key => $val) {
                             $fin_value = explode(",", $value2);  
                            
                             $arr = array();
                             foreach ($fin_value as $check_val){
                                 
                                 array_push($arr, $check_val);
                             }
                                // {!!  $val != "" || $val !=NULL ? str_replace( ,ucwords($val)) : '' !!}
                          //  }
                            ?>  
                            @foreach($value AS $key => $val)
                            <div><b>{{ $val != "" || $val !=NULL ? $arr[$key].':' : '' }} </b>
                                {!!  $val != "" || $val !=NULL ? str_replace(array("\r\n","/","[", "]"), "* " ,ucwords($val)) : '' !!}
                               
                            </div>
                            @endforeach

                            @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection