@extends('layouts.master')

@section('additional_styles')
<!-- datepicker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<form method="POST" action="store" role="form">

<div class="box">

    <div class="box-header with-border">
        <h3 class="box-title">Create New Case</h3>
    </div>
    <div class="alert alert-info alert-dismissable"> 
        <b>Note:</b> Displays all cases with no Feedback.
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
    </div>
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
            <i class="fa fa-warning">&nbsp;</i><b> FAILED.</b>
            Please fill in all necessary input fields.  
        </div>
    @endif 
    @if(Session::has('flash_message'))
        <div class="alert alert-success" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
            <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
        </div>
    @endif

    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Date:</td>
                    <td name="date"><?php echo date("F j, Y - l"); ?></td>
                </tr>
                <tr>
                    <td>Team:</td>
                    <td> <input type="hidden" name="team" value="{{ Auth::user()->department->departmentid}}" size="30">{{ Auth::user()->department->name}}</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">Agent Name:</td>
                    <td> 
                         <select name="agent" class="form-control" style="width: 200px;">
                             <optgroup label="{{ Auth::user()->department->name}}">
                                <?php $subordinates = Auth::user()->subordinates(); ?>
                                @foreach($subordinates AS $subordinate)
                                <option value="{{ $subordinate->uid }}" selected>{{ $subordinate->name }}</option>
                                @endforeach
                             </optgroup>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">Date of Case:</td>
                    <td>
                      <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                          <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                          </div>
                        <input type="text" name="casedate"class="form-control" style="width: 110px;">
                     </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">No. of calls:</td>
                    <td><input type="text" name="calls" class="form-control" style="width: 150px;"></td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">No. of emails:</td>
                    <td><input type="text" name="emails" class="form-control" style="width: 150px;"></td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">Reason:</td>
                    <td>
                        <textarea name="reason" id="editor 1" class="ckeditor" cols='80' rows='10' name="editor1"> </textarea>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;">Sup Action Plan:</td>
                    <td>
                        <textarea name="actionplan" id="editor 1" class="ckeditor" cols='80' rows='10' name="editor1"> </textarea>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    <div class="box-footer">
        <div class="foot-area" style="float: right;">
            <button class="btn btn-warning" type="reset" name="reset" onclick="document.getElementById['reason'].value = ''; document.getElementById['actionplan'].value = '';"><i class="fa fa-eraser"></i> Clear All</button>
            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit Now</button>
        </div>
    </div>
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
                        <td><a href="edit/{{$row->id}}">{{ $row->id }}</a></td>
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
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript">
    $(function () {
        $('#table_breakdown').DataTable();
         CKEDITOR.config.toolbar = [
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']}
        ];
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('reason_editor');
        CKEDITOR.replace('plan_editor');
    });
    
</script>
@endsection

    