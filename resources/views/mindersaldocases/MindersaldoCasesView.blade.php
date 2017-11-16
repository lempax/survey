@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{asset('/mct/store')}}" role="form">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Case</h3>
        </div>
        <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> All fields are required. Don't leave anything empty.
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
                    <th colspan="2" style="font-family: Verdana"><center>Add New Case</center></th>
                    <tr>
                        <th width="230px">Logged By :</td>
                        <td><input type="hidden" name="emp_name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">SSE Customer ID : <font color="red"> *</font> </td>
                        <td><input type="text" class="form-control" name="customer_id" style="width: 150px;"></td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">Contract ID : <font color="red"> *</font> </td>
                        <td><input type="text" class="form-control" name="contract_id" style="width: 150px;"></td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">Date of Last Credit Card Update : <font color="red"> *</font> </td>
                        <td>
                          <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input type="text" class="form-control" name="date_updated" style="width: 150px;">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">Date of Mindersaldo Lock : <font color="red"> *</font> </td>
                        <td>
                          <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                          <input type="text" class="form-control" name="date_mindersaldo_lock" style="width: 150px;">
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;">Sure they want to upgrade ? <font color="red"> *</font> </td>
                        <td>
                            <div class="form-group" style="width: 150px">
                                <select class="form-control" name="confirm">
                                    <optgroup label="Select Answer">
                                        <option>Yes</option>
                                        <option>No</option>
                                    </optgroup>
                                </select>
                             </div>
                        </td>
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
    <label style="padding-left: 10px; font-size:16px;"><?php echo "Date : " .date("F j, Y"); ?></label>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
            <td>
                <form method="POST" action="{{ asset('/mct/search') }}" role="form">
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
        <form method="POST" action="{{ asset('/mct/sort') }}" role="form">
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
                    <th style="{{ $breakdown['headerStyle'][$i] }}"><center>{{ $head }}</center></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
               @foreach($rows AS $row)
               <?php $user = \App\Employee::where('uid', $row->emp_name)->first();?>
                    <tr>
                        <td><center>
                         <?php 
                            if($row->emp_name ==  Auth::user()->uid)
                                echo '<a href="edit/'.$row->id.'">'.$user->name.'</a>'; 
                            else { echo $user->name; }
                         ?>
                        </center></td>
                        <td><center>{{ $row->customer_id }}</center></td>
                        <td><center>{{ $row->contract_id }}</center></td>
                        <td><center>{{ date("F j, Y H:i:s", strtotime($row->created_at)) }}</center></td>
                    </center></tr>
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


