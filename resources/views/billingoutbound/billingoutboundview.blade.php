@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{asset('billingoutbound/store')}}" role="form">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Billing Outbound Tracking Tool</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            
            <b>Note:</b> * Default session timeout is two (2) hours. </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; *  Please fill up all required fields with (<font color="red">*</font>)
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-warning">&nbsp;</i><b> FAILED.</b>
                Please fill in all necessary input fields.
            </div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success alert-dismissable" aria-hidden="true"  style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
            </div> 
        @endif

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Logged By:</td>
                        <td><input type="hidden" value="{{Auth::user()->name}}"><input type="hidden" name="user" value="{{Auth::user()->username}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Customer ID: </td>
                        <td><input type="text" class="form-control" name="custid" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Contract ID: </td>
                        <td><input type="text" class="form-control" name="contractid" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Case ID: </td>
                        <td><input type="text" class="form-control" name="caseid" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Notes: </td>
                        <td><textarea name="notes" id="notes" class="ckeditor"> </textarea></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Date Submitted:</td>
                        <td><input type="text" class="form-control" name="date"  style="width: 200px;" value="<?php echo date("Y-m-d H:i:s") ?>"  ></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

        <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <button class="btn btn-warning" type="reset" name="reset"><i class="fa fa-eraser"></i> Clear All</button>
            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit Now</button>
            </div>
        </div>
    </div>
</form>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">{{ $breakdown['name'] }}</h1></br></br>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Displays all cases created by the team. </b>
        </div>
        
    </div>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
            <td>
                <form method="POST" action="{{ asset('billingoutbound/search') }}" role="form">
                    <div class="input-group date" data-provide="datepicker" style="width: 150px; float: left;">
                          <div class="input-group-addon">
                            From:
                          </div>
                          <input type="text" name="date_from" class="form-control" style="width: 100px;" placeholder="Pick a date">
                     </div>
                    <div style="float: left;">&nbsp;&nbsp;</div>
                    <div class="input-group date" data-provide="datepicker" style="width: 150px; float: left;">
                          <div class="input-group-addon">
                            To:
                          </div>
                          <input type="text" name="date_to" class="form-control" style="width: 100px;" placeholder="Pick a date">
                     </div>
                    <div style="float: left;">
                        <button class="btn btn-info btn-flat" type="submit"><i class="fa fa-search"></i> Search</button>
                    </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </td>
            </tr>
        </table>
    </div>
    <div class="box-body">
<!--        <b>[ Date: <font color="blue">{{date("F j, Y")}} </font>]</b>
        <br><br>-->
        <form method="POST" action="{{ asset('billingoutbound/sort') }}" role="form">
            <table>
                <tr>
                    <td><input type="submit" name="today" class="btn btn-primary" value="Today"></td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="weekly" class="btn btn-primary" value="Weekly"></td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="monthly" class="btn btn-primary" value="Monthly"></td>
                    <td>&nbsp;<input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
                    <td><input type="submit" name="all" class="btn btn-primary" value="View All"></td>
                </tr>
            </table>
        <br><br>
        </form>
        <table id="table_breakdown" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    @foreach($breakdown['headers'] as $i => $head)
                    <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
               @foreach($rows AS $row)
               <?php $_user = \App\Employee::where('username', $row->user)->first(); ?>
               @if(isset($_user))
               
                    <tr>
                        <td><a href="edit/{{ $row->id }}">{{ $_user->name }}</a></td>
                        <td>{{ $row->custid }}</td>
                        <td>{{ $row->contractid }}</td>
                        <td>{{ $row->caseid }}</td>
                        <td>{{ $row->notes }}</td>
                        <td>{{date("F j, Y", strtotime($row->date)) }}</td>
                        <td>{{ $row->remarks }}</td>
                        <td>{{date("F j, Y", strtotime($row->timestamp)) }}</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
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
        CKEDITOR.replace('notes');
    });
    
</script>
@endsection


