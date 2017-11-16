@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/freemailers/store') }}" role="form">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Create New Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Please fill all the required fields below to create new case.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-warning">&nbsp;</i><b> FAILED.</b>
                Please fill in all necessary input fields.
            </div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success" aria-hidden="true"  style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
            </div>
        @endif

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr style="vertical-align:middle;">
                        <td>Logged By: <font color="red">*</font></td>
                        <td><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Customer ID: <font color="red">*</font></td>
                        <td><input type="text" class="form-control" name="customer_id" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Case ID: <font color="red">*</font></td>
                        <td><input type="text" class="form-control" name="case_id" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Medium <font color="red">*</font></td>
                        <td>
                            <select name="medium" class="form-control" style="width: 200px;">
                                <option>Select medium</option>
                                <option>Telephone</option>
                                <option>Email</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Email Address <font color="red">*</font></td>
                        <td><input type="text" class="form-control" name="email" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Brief Description: <font color="red">*</font></td>
                        <td><textarea name="description" id="desc" class="ckeditor"> </textarea></td>
                        
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

        <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
    </div>
</form>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">{{ $breakdown['name'] }}</h1> 
        <br><i> Displays all cases created by the Mail.com team. </i>
    </div>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
            <td>
                <form method="POST" action="{{ asset('/freemailers/search') }}" role="form">
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
        <form method="POST" action="{{ asset('/freemailers/sort') }}" role="form">
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
                                echo '<a href="edit/'.$row->id.'">'.$row->case_id.'</a>'; 
                            else { echo $row->case_id; }
                         ?>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $row->customer_id }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->medium }}</td>
                        <td>{{date("F j, Y", strtotime($row->created_at)) }}</td>
                        <td>{{ $row->description }}</td>
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
        CKEDITOR.replace('desc');
    });
    
</script>
@endsection
