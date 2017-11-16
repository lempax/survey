@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ url('billingoutbound/update/'.$id.' ') }}" role="form">
<!--    <input type="hidden" name="_method" value="PUT">-->
    
    <div class="box">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">View Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please input case remarks. </b>
        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Logged By:</td>
                        <td><input readonly type="text" class="form-control" name="user" value="<?php echo $temp->user; ?>" style="width: 200px;" ></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Customer ID: </td>
                        <td><input readonly type="text" class="form-control" name="custid" value="<?php echo $temp->custid; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Contract ID: </td>
                        <td><input readonly type="text" class="form-control" name="contractid" value="<?php echo $temp->contractid; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Case ID: </td>
                        <td><input readonly type="text" class="form-control" name="caseid" value="<?php echo $temp->caseid; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Notes: </td>
                        <td><input readonly type="text" class="form-control" name="notes" value="<?php echo $temp->notes; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Date Submitted :</td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input readonly type="text" class="form-control" name="date" style="width: 150px;" value="<?php echo date('Y-m-d H:i:s', strtotime($temp->date)) ?>">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Remarks: </td>
                        <td><textarea name="remarks" class="ckeditor"> <?php echo $temp->remarks; ?></textarea></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Timestamp: </td>
                        <td>
                          <div class="input-group date" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input readonly type="text" class="form-control" name="timestamp" style="width: 150px;" value="<?php echo date('Y-m-d H:i:s') ?>">
                          </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="<?php echo $temp->id; ?>">
        <div class="box-footer">
            <div class="foot-area" style="float: right;">
            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-update"></i> Update Now</button>
            </div>
        </div>
             </div>
    </div>
</form>
   </div>
    </div>
@endsection

@section('additional_scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
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
        CKEDITOR.config.readOnly = false;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('remarks');
        $(document).ready(function()
    {

    });
    });
    
</script>
@endsection


