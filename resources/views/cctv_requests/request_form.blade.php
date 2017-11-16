@extends('layouts.master')

@section('additional_styles')
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ('/bower_components/admin-lte/plugins/datepicker/datepicker3.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ('/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
@endsection

@section('content')
<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">Request for CCTV Footage</h2></div><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Please fill all the required fields below to create new pending concern.
            </div>
        </div>
        <div class="box-body">
            <div>
                @if($errors->any())
                    <div class="alert alert-danger" aria-hidden="true">
                        <p>Warning :</p>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success" aria-hidden="true">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
            <table class="table table-bordered">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>New Request</center></th>
                    <tr>
                        <th style="width: 170px">Employee Name : &nbsp;<font style="color:red;">*</font></th>
                        <td><input type="hidden" name="emp_name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 170px">Coverage : &nbsp;<font style="color:red;">*</font>
                            <br/>(From - To)
                        </th>
                        <td>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservationtime">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 170px">Reason/Purpose : &nbsp;<font style="color:red;">*</font></th>
                        <td><textarea id="ckeditor1" name="concern"></textarea></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            <div class="foot-area" style="float: right;">
                <button class="btn btn-warning" type="reset" name="reset"><i class="fa fa-eraser"></i> Clear All</button>
                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit Now</button>
            </div>
        </div> 
    </div> 
</div>
@endsection

@section('additional_scripts')
<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset ('/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset ('/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready( function() {

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    
    CKEDITOR.config.toolbar = [
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']}
    ];
    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.replace('ckeditor1');
    CKEDITOR.replace('ckeditor2');
    CKEDITOR.instances.ckeditor1.setData(' ');
});
</script>
@endsection