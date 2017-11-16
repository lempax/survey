@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<!-- Default box -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#create" aria-expanded="true">
                    Create New Case
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#cases" aria-expanded="false">
                    View All Reports
                </a>
            </li>
    </ul>
    <div class="tab-content">
            <div id="create" class="tab-pane active">
                <form name="myform" role="form" method="POST" action="storemailtophone">
     
        
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below to create new case.
            </div>
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
            <table class="table table-bordered" style="width: 500px">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>CW03 - MEDIUM CHANGE (MAIL TO PHONE)</center></th>
                    
                    <tr>
                        <th style="width: 150">Logged By: </th>
                        <th><input type="hidden" name="loggedby" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</th>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 160px;">Date: </td>
                        <td name="date_created"><?php echo $date = date("F j, Y"); ?></td>
                    </tr>
                    <tr>
                        <th style="width: 170px;">Employee Name:<span style="color: red; font-weight: bold">*</span></th>
                        <td>
                            <div class="form-group" style="width: 250px; float: left; margin-left: 13px; margin-bottom: 1px;">     
                                <select class="form-control" name="employee_name">
                                    <optgroup label="{{  Auth::user()->department->name }}">
                                       <?php $subordinates = Auth::user()->subordinates() ?>
                                       @foreach ($subordinates AS $subordinate)
                                        <option value="{{ $subordinate->uid }}">{{ $subordinate->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>                  
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="table table-bordered" style="width: 500px" id="myTable">
                <tbody>
                    <th style="width:10px"><i class="fa fa-fw fa-plus-circle fa-lg" onclick="displayResult()"></i></th>
                    <th style="font-family: Verdana; width:120px"><center>Case ID</center></th>
                    <th style="font-family: Verdana"><center>Case CRR</center></th>
                    <th style="width: 40px"> </th>
                    <tr>
                        <td colspan="2" style="width: 170px"><input class="form-control" type="text" name="case_id[]" style="width: 150px; margin-bottom: 1px;"></input> </td>
                        <td><center><div class="form-group" style="width: 250px; margin-bottom: 1px;" id="case_status0" >
                                <select class="form-control" name="case_crr[]" id="case_status0" onChange="assign()">
<!--                                        <option value="">Select Status</option>-->
                                        <option value="No Survey">No Survey</option>
                                        <option value="No Feedback Returns">No Feedback Returns</option>
                                        <option value="None-Voice Mail">None-Voice Mail</option>
                                        <option value="Reached - 0% CRR">Reached - 0% CRR </option>
                                </select>
                             </div></center>
                        </td>
                        <th><i class="fa fa-fw fa-minus-circle fa-lg" onclick="delete_row()" style="vertical-align: middle"></i></th>
                    </tr>
                </tbody>
            </table>
            <br>
                    <table class="table table-bordered" style="width: 900px">
                        <tbody>
                        <tr>
                        <td style="font-weight: bold; width: 170px;">Date of Case: </td>
                        <td>
                            <div class="input-group date" data-provide="datepicker" style="width: 250px; float: left; margin-left: 13px; ">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" name="date_ofcase" class="form-control pull-right"/>
                            </div>
                        </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 170px;">Customer Reached?</td>
                            <td style="float: left; margin-left: 13px;">
                                <input type='radio' name="customer_reached" value='YES' id="chkYes"/> YES<br>
                                <input type='radio' name="customer_reached" value='NO' id="chkNo"/> NO
                            </td>
                        </tr>
                        
                        <tr id="trReason" style="display: none">
                            <td style="font-weight: bold; width: 230px;">Reason:</td>
                            <td style="width: 1000px">
                                <textarea class="form-control" name="reason" id="ckreason" style="width: 1200px;" /></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; width: 170px; margin-bottom: 1px;">Status: </td>
                            <td><center><div class="form-group" style="width: 250px; float:left; margin-left: 10px; margin-bottom: 1px;">
                                    <select class="form-control" name="status">
                                            <option value="Resolved">Resolved</option>
                                            <option value="Unresolved">Unresolved</option>
                                    </select>
                                 </div></center>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
       <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <button type="submit" name="save" class="btn btn-warning"><i class="fa fa-save"></i> Save As Draft</button>
                <button type="submit" name="send" class="btn btn-primary"><i class="fa fa-send"></i> Submit Now</button>
            </div>
        </div>
</form>
            </div>
        <div id="cases" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            
            <div class="box-body">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }}}'><center>{{ $head }}</center></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <?php 
                        $user = \App\Employee::where('uid', $row->loggedby)->first(); $count=0;
                        $employee = DB::table('employees')->where('uid', $row->employee_name)->first();
                    ?>
                    <tr>
                        <td><center><a href="edit/{{$row-> id}}">{{ $row-> id}}</a></center></td>
                        <td><center>{{ date('F j,  Y', strtotime($row->created_at)) }}</center></td>
                        <td><center><?php echo $employee->fname.' '.$employee->lname ?></center></td>
                        <td><center>{{ date('F j, Y', strtotime($row->date_ofcase)) }}</center></td>
                        <td><center>{{ $row-> customer_reached}}</center></td>
                        <td><center>
                            <?php if ($row->status=="Unresolved")
                                    echo '<span class="label label-warning">Unresolved</span>'; 
                                  else if ($row->status=="Resolved")
                                    echo '<span class="label label-success">Resolved</span>'; 
                            ?>
                        </center></td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="../../plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    var table = document.getElementById("myTable");
    var status = 'case_status';
    var x = '';
    var div = 'contain';

    function displayResult() {
        for(x = 0; x <= (table.rows.length) - 1; x++){
            temp_status = status + x;
            temp_div = div + x;
        }   
        document.getElementById("myTable").insertRow(-1).innerHTML = 
            '<td colspan="2" style="width:170px">\n\
            <input type="text" name="case_id[]" class="form-control" style="width: 150px; margin-bottom: 1px;"></input></td>\n\
            <td><select type="text" class="form-control" name="case_crr[]" style="width:250px; float:left; margin-left: 10px;" id="'+ 
            temp_status +'" onChange="assign()"><option value="No Survey">No Survey</option><option value="No Feedback Returns">No Feedback Returns</option><option value="None-Voice Mail">None-Voice Mail</option><option value="Reached - 0% CRR">Reached - 0% CRR</option></select></td><td style="text-align: center;"><i class="fa fa-fw fa-minus-circle fa-lg" onclick="delete_row()"></i></td>';
    }
    
    function delete_row() {
        document.getElementById("myTable").deleteRow(-1);
    }
    
    function assign(){
        for(x = 0; x <= (table.row.length) - 1; x++){
            temp_status = status + x;
            temp_div = div + x;
            if (document.getElementById(temp_status).value === "input") {
                document.getElementById(temp_div).style.display = 'block';
                document.getElementById(temp_status).style.display = 'none';
            } else {
                document.getElementById(temp_div).style.display = 'none';
            }
        }
    }
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("input[name='customer_reached']").click(function () {
            if ($("#chkNo").is(":checked")) {
                $("#trReason").show();
            } else {
                $("#trReason").hide();
            }
        });
    });
</script>
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
            CKEDITOR.replace('ckreason');
            CKEDITOR.instances.ckreason.setData(' ');
        });
</script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>
@endsection