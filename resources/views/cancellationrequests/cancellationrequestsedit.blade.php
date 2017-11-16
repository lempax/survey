@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/cancellationrequests/create') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">View Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please fill up all required fields with (<font color="red">*</font>)
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Logged By:</td>
                        <td><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Supervisor: </td>
                        <td><b>{{ Auth::user()->superior->name }}</b></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Customer ID: </td>
                        <td><input readonly type="text" class="form-control" name="customer_id" value="<?php echo $temp->customer_id; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Contract ID: </td>
                        <td><input readonly type="text" class="form-control" name="contract_id" value="<?php echo $temp->contract_id; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Product ID: </td>
                        <td><input readonly type="text" class="form-control" name="product_id" value="<?php echo $temp->product_id; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Email Address: </td>
                        <td><input readonly type="text" class="form-control" name="email" value="<?php echo $temp->email; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Date of Cancellation Request:</td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input readonly type="text" class="form-control" name="cancellation_date" style="width: 150px;" value="<?php echo date('m/d/Y', strtotime($temp->cancellation_date)) ?>">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Cancellation Effective Date: </td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input readonly type="text" class="form-control" name="effective_date" style="width: 150px;" value="<?php echo date('m/d/Y', strtotime($temp->effective_date)) ?>">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Type of Cancellation: </td>
                        <td>
                            <input readonly type="text" class="form-control" name="email" value="<?php echo $temp->type; ?>" style="width: 200px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Cancellation Reason: </td>
                        <td><textarea name="reason" id="reason" class="ckeditor"><?php echo $temp->reason; ?></textarea></td>
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
        CKEDITOR.config.readOnly = true;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('reason');
    });
    
</script>
@endsection


