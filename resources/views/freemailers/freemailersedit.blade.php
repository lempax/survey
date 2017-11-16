@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/freemailers/create') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">View Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please fill all the required fields below to create new case.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr style="vertical-align:middle;">
                        <td>Logged By: <font color="red">*</font></td>
                        <td><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Customer ID: <font color="red">*</font></td>
                        <td><input readonly type="text" class="form-control" name="customer_id" style="width: 200px;" value="<?php echo $temp->customer_id; ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Case ID: <font color="red">*</font></td>
                        <td><input readonly type="text" class="form-control" name="case_id" style="width: 200px;" value="<?php echo $temp->case_id; ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Medium <font color="red">*</font></td>
                        <td>
                            <input readonly type="text" class="form-control" name="case_id" style="width: 200px;" value="<?php echo $temp->medium; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Email Address <font color="red">*</font></td>
                        <td><input readonly type="text" class="form-control" name="email" style="width: 200px;" value="<?php echo $temp->email; ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Brief Description: <font color="red">*</font></td>
                        <td><textarea name="description" id="desc" class="ckeditor"><?php echo $temp->description; ?></textarea></td>
                        
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="<?php echo $temp->id; ?>">
        </div>

    </div>
</form>


@endsection

@section('additional_scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
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
        CKEDITOR.config.readOnly = true;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('desc');
    });
    
</script>
@endsection


