@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')

<!-- Default box --> 
<form role="form" method="POST" action="{{ asset('/msas/show') }}">
    <input type="hidden" name="_method" value="PUT"/>
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">View Pending Concern</h2></div><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Form cannot be edited.
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
                <input type="hidden" name="id" value="<?php echo $data1->id; ?>"/>
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>View Case</center></th>
                    <tr>
                        <th style="width: 200px">Employee Name : &nbsp;<font style="color:red;">*</font></th>
                        <td><input type="hidden" name="emp_name" value="<?php echo $data1->emp_name; ?>">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px">Customer ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input readonly class="form-control" type="text" name="custID" style="width: 150px;" value="<?php echo $data1->custID; ?>"></input></td>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 200px">Case ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input readonly class="form-control" type="text" name="caseID" style="width: 150px;" value="<?php echo $data1->caseID; ?>"></input></td>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 200px">Contract ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input readonly class="form-control" type="text" name="contractID" style="width: 150px;" value="<?php echo $data1->contractID; ?>"></input></td>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 100px;">Product Cycle : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div class="form-group" style="width: 150px">
                                <input readonly type="text" name="product_cycle" class="form-control" value="<?php echo $data1->product_cycle; ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 200px">Date of Upsells : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div style="width: 150px;">
                                <input readonly type="text" name="date_upsells" class="form-control pull-right" value="<?php echo date('m/d/Y', strtotime($data1->date_upsells)); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 200px">Date of Order : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div style="width: 150px;">
                                <input readonly type="text" name="order_date" class="form-control pull-right" value="<?php echo date('m/d/Y', strtotime($data1->order_date)); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-top: 110px; width: 150px;">Notes : &nbsp;<font style="color:red;">*</th>
                        <td>
                            <textarea readonly id="ckeditor1" name="notes"><?php echo $data1->notes; ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>
</form>

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
            CKEDITOR.config.readOnly = true;
            CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
            CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
            CKEDITOR.replace('ckeditor1');
            CKEDITOR.replace('ckeditor2');
            CKEDITOR.instances.ckeditor1.setData(' ');
            });
</script>
@endsection