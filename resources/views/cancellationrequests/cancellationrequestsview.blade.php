@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{asset('/cancellationrequests/store')}}" role="form">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Log Cancellation Cases</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please fill up all required fields with (<font color="red">*</font>)
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
                        <td><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Supervisor: </td>
                        <td><b>{{ Auth::user()->superior->name }}</b></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Customer ID: </td>
                        <td><input type="text" class="form-control" name="customer_id" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Contract ID: </td>
                        <td><input type="text" class="form-control" name="contract_id" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Product ID: </td>
                        <td><input type="text" class="form-control" name="product_id" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Email Address: </td>
                        <td><input type="text" class="form-control" name="email" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Date of Cancellation Request:</td>
                        <td>
                          <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input type="text" class="form-control" name="cancellation_date" style="width: 150px;">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Cancellation Effective Date: </td>
                        <td>
                          <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input type="text" class="form-control" name="effective_date" style="width: 150px;">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Type of Cancellation: </td>
                        <td>
                            <select name="type" class="form-control" style="width: 200px;">
                                <option>Select Reason</option>
                                <option>Before Renewal</option>
                                <option>After Renewal</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Cancellation Reason: </td>
                        <td><textarea name="reason" id="reason" class="ckeditor"> </textarea></td>
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
        <h1 class="box-title">{{ $breakdown['name'] }}</h1> 
    </div>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
            <td>
                <form method="POST" action="{{ asset('/cancellationrequests/search') }}" role="form">
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
        <form method="POST" action="{{ asset('/cancellationrequests/sort') }}" role="form">
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
               <?php $user = \App\Employee::where('uid', $row->name)->first();?>
                    <tr>
                        <td>
                         <?php 
                            if($row->name ==  Auth::user()->uid)
                                echo '<a href="edit/'.$row->id.'">'.$user->name.'</a>'; 
                            else { echo $user->name; }
                         ?>
                        </td>
                        <td>{{ $row->customer_id }}</td>
                        <td>{{ $row->contract_id }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->product_id }}</td>
                        <td>{{date("F j, Y", strtotime($row->cancellation_date)) }}</td>
                        <td>{{date("F j, Y", strtotime($row->effective_date)) }}</td>
                        <td>{{ $row->type }}</td>
                        <td>{{ $row->reason }}</td>
                    </tr>
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
        CKEDITOR.replace('reason');
    });
    
</script>
@endsection


