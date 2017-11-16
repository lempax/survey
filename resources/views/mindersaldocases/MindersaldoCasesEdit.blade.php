@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/mct/update') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">View Mindersaldo Cases</h3>
        </div>
        <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Form cannot be edited.
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
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>View Case</center></th>
                    <tr>
                        <th width="230px">Logged By :</td>
                        <td><input type="hidden" name="emp_name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th>Customer ID : <font color="red"> *</font></td>
                        <td><input type="text" class="form-control" name="customer_id" value="<?php echo $data1->customer_id; ?>" style="width: 150px;" readonly></td>
                    </tr>
                    <tr>
                        <th>Contract ID : <font color="red"> *</font></td>
                        <td><input type="text" class="form-control" name="contract_id" value="<?php echo $data1->contract_id; ?>" style="width: 150px;" readonly></td>
                    </tr>
                    <tr>
                        <th>Date of Last Credit Card Update :<font color="red"> *</font></td>
                        <td>
                            <div style="width: 150px;">
                                <input readonly type="text" name="date_updated" class="form-control pull-right" value="<?php echo date('m/d/Y', strtotime($data1->date_updated)); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Date of Mindersaldo Lock : <font color="red"> *</font></td>
                        <td>
                            <div style="width: 150px;">
                                <input readonly type="text" name="date_mindersaldo_lock" class="form-control pull-right" value="<?php echo date('m/d/Y', strtotime($data1->date_mindersaldo_lock)); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">Sure they want to upgrade? <font color="red"> *</font></td>
                        <td>
                            <div style="width: 150px">
                                <input readonly type="text" name="confirm" class="form-control" value="<?php echo $data1->confirm; ?>">
                            </div>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="<?php echo $data1->id; ?>">
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


