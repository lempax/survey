@extends('layouts.master')

@section('additional_styles')
<style type="text/css">
    .foot-area{
        float: right;

    }

    .td-center{
        text-align:center; 
        vertical-align: middle;
    }

    .td-left{
        text-align:left; 
        vertical-align: middle;
        font-weight: bold;
    }

    .first{
        width: 500px;
    }
</style>
@endsection

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')

<div class="box">
    <div class="box-body">
        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Create New Request</a></li>
            <li><a href="#tab_2" data-toggle="tab">View All Requests</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
        <table class="table table-bordered table-hover table-striped" style="margin-bottom: 10px; width: 70%;">
            <thead>
                <tr>
                    <th colspan="2">REQUEST FORM</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-left" style="vertical-align: middle;">Subject: </td>
                    <td><input type="text" class="first form-control" name=""></td>
                </tr>
                <tr>
                    <td class="td-left" style="vertical-align: middle;">Type: </td>
                    <td>
                        <select type="" name="" class="first form-control">
                            <option>Select Departments</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="td-left" style="vertical-align: middle;">Severity: </td>
                    <td>
                        <select type="" name="" class="first form-control">
                            <option>Select Priority</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="td-left" style="vertical-align: middle;">Message: </td>
                    <td><textarea id="ckeditor1"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;">
                        <button class="btn btn-warning" type="reset" name="reset"><i class="fa fa-eraser"></i> Clear All</button>
                        <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit Now</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('additional_scripts')
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

    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.replace('ckeditor1');
    CKEDITOR.replace('ckeditor2');
    CKEDITOR.instances.ckeditor1.setData(' ');
});
</script>
@endsection