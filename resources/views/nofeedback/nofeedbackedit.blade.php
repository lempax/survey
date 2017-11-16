@extends('layouts.master')

@section('additional_styles')
<!-- Datepicker CSS -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<div class="box">
    <form method="POST" action="{{ asset('/nofeedback/create') }}" role="form">
        <input type="hidden" name="_method" value="PUT">
        <div class="box-header with-border">
            <h3 class="box-title">View No Feedback Case</h3>
        </div>

        <div class="box-body">
            <table class="table table-bordered">

                <tbody>
                    <tr>
                        <td>Date:</td>
                        <td name="date"><?php echo date("F j, Y (g:i a)", strtotime($temp->created_at)); ?></td>
                    </tr>
                    <tr>
                        <td>Team:</td>
                        <?php $team = \App\Department::where('departmentid', $temp->team)->first(); ?>
                        <td><input type="hidden" name="team" value="<?php echo $temp->team; ?>" size="30"/>{{ $team->name}}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Agent Name:</td>
                        <td> 
                            <?php $agent = \App\Employee::where('uid', $temp->agent)->first(); ?>
                            <input readonly type="text" name="agent" class="form-control" style="width: 150px;"  value="<?php echo $agent->name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Date of Case:</td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                              <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                              </div>
                            <input  readonly type="text" name="casedate" class="form-control" style="width: 110px;" value="<?php echo date('m/d/Y', strtotime($temp->casedate)) ?>">
                         </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">No. of calls:</td>
                        <td><input readonly  type="text" name="calls" class="form-control" style="width: 150px;" value="<?php echo $temp->calls ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">No. of emails:</td>
                        <td><input readonly  type="text" name="emails" class="form-control" style="width: 150px;" value="<?php echo $temp->emails ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Reason:</td>
                        <td>
                            <p><textarea name="reason" id="reason_editor"> <?php echo $temp->reason ?> </textarea></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Sup Action Plan:</td>
                        <td>
                            <textarea name="actionplan" id="plan_editor"> <?php echo $temp->actionplan ?> </textarea>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="<?php echo $temp->id ?>">
    </form>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $breakdown['name'] }}</h3>
        </div>
        <div class="box-body">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date Created</th>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                   @foreach($rows AS $row)
                   <?php $agent = \App\Employee::where('uid', $row->agent)->first(); ?>
                   <?php $team = \App\Department::where('departmentid', $row->team)->first(); ?>
                    <tr>
                        <td><a href="{{$row->id}}">{{ $row->id }}</a></td>
                        <td>{{ date("F j, Y", strtotime($row->created_at)) }}</td>
                        <td>{{ $team->name }}</td>
                        <td>{{ $agent->name }}</td>
                        <td>{{ $row->calls }}</td>
                        <td>{{ $row->emails }}</td>
                        <td>
                            <?php 
                                $date = new DateTime($row->casedate);
                                $week = $date->format("W");
                            ?>
                            Week {{$week}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('additional_scripts')
<!-- datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        CKEDITOR.config.toolbar = [
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']}
        ];
        CKEDITOR.config.readOnly = true;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.replace('reason_editor');
        CKEDITOR.replace('plan_editor');
        
    });
    
</script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>

@endsection
