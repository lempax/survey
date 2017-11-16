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
    </div>
</div>
@endsection