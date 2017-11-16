@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<!-- Default box -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#create" aria-expanded="true">
                    Request Repair
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#repaired" aria-expanded="false">
                    View All Repaired Items
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#irreparable" aria-expanded="false">
                    View All Irreparable Items
                </a>
            </li>
    </ul>
    
    <div class="tab-content">
        <div id="create" class="tab-pane active">
            <form name="myform" role="form" method="POST" action="store">
     
            <div class="alert alert-info alert-dismissable" style="width: 450px; margin-left: 10px;" >
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below.
            </div>
                
            <div>
                @if($errors->any())
                    <div class="alert alert-danger" aria-hidden="true" style="width: 450px; margin-left: 10px;">
                        <p>Warning :</p>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                    @if(Session::has('flash_message'))
                    <div class="alert alert-success" aria-hidden="true" style="width: 450px; margin-left: 10px;">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
        
        <div class="box-body">
            <table class="table table-bordered" style="width: 800px">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>REPAIR REQUEST FORM</center></th>
                    <tr>
                        <th style="font-weight: bold; width: 300px;">Date</th>
                        <td><input type="hidden" name="date" class="form-control" value="<?php date('F d, Y')?>"><?php echo $date = date("F j, Y g:i A"); ?></td>
                    </tr>
                    
                    <tr>
                        <th style="width: 150px">Name </th>
                        <th><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</th>
                    </tr>
                    
                    <tr>
                        <th style="width: 150px">Department </th>
                        <th><input type="hidden" name="department" value="{{Auth::user()->department->name}}">{{ Auth::user()->department->name }}</th>
                    </tr>
                    
                    <tr style="display: none">
                        <th style="width: 150px">Status </th>
                        <th><input type="hidden" name="status" class="form-control" style="width:250px;" value="Irreparable"></th>
                    </tr>
                    
                    <tr style="display: none">
                        <th style="font-weight: bold; width: 160px;">Request ID </th>
                        <td style="margin-left: 15px;"><input type="text" style="width: 250px" name="request_id" class="form-control" value="<?php echo substr(number_format(time() * rand(), 0, '', ''), 0, 10); ?>"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            
            <div>
            <table class="table table-bordered" style="width: 800px" id="myTable">
                <tbody>
                    <tr>
                        <th colspan="4" style="text-align: center">DETAILS OF THE UNIT</th>
                    </tr>
                    
                    <tr>
                        <th style="text-align: center; width: 170px;">DESCRIPTION</th>
                        <th style="text-align: center">BRAND</th>
                        <th style="text-align: center">SERIAL</th>
                        <th style="text-align: center">DEFECT OF THE UNIT</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="description[]" style="width: 170px;" class="form-control"></td>
                        <td><input type="text" name="brand[]" style="width: 170px;" class="form-control"></td>
                        <td><input type="text" name="serial[]" style="width: 170px;" class="form-control"></td>
                        <td><input type="text" name="defect[]" style="width: 170px;" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
            </div>
                <div>
                    <button type="button" class="btn btn-block btn-info" style="width: 90px; float: left; margin-left: 10px; margin-right: 5px;" onclick="displayResult()">Add Row</button>
                    <button type="button" class="btn btn-block btn-info" style="width: 90px;" onclick="delete_row()">Delete Row</button>
                </div>
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
        
        <div id="repaired" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">Repaired Items</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
            </div>
            <div class="box-body">
                <table id="table_breakdownn" class="table table-bordered table-hover table-striped" style="width: 850px;">
                    <thead>
                        <tr>
                            @foreach($breakdown['headers'] as $i => $head)
                            <th style='{{ $breakdown['headerStyle'][$i] }}'><center>{{ $head }}</center></th>
                            @endforeach
                        </tr>
                    </thead>
                        <tbody>
                         @foreach($rows as $row)
                            <?php 
                                $user = \App\Employee::where('uid', $row->name)->first();
                                $name = DB::table('employees')->where('uid', $row->name)->first();
                            ?>
                         
                         <?php if($row->status=="Repaired"){         
                            
                            echo '<tr>';
                               echo '<td><center>'.$row-> request_id.'</center></td>';
                               echo '<td><center>'.date('F j,  Y', strtotime($row->created_at)).'</center></td>';
                               echo '<td><center>'.$user-> name.'</center></td>';
                               echo '<td><center>'.$row-> department.'</center></td>';
                               echo '<td><center>';
                               echo "<a href=edit/". $row-> id.'><span class="label label-info"> Edit </span></a>';
                               echo '</center></td>';
                            echo '</tr>';
                             
                         } ?>
                         @endforeach
                        </tbody>
                </table>
            </div>
        </div>
        
        <div id="irreparable" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">Irreparable Items</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            <div class="box-body">
                <table id="table_breakdown" class="table table-bordered table-hover table-striped" style="width: 850px;">
                    <thead>
                        <tr>
                            @foreach($breakdown['headers'] as $i => $head)
                            <th style='{{ $breakdown['headerStyle'][$i] }}'><center>{{ $head }}</center></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                         @foreach($rows as $row)
                            <?php 
                                $user = \App\Employee::where('uid', $row->name)->first();
                                $name = DB::table('employees')->where('uid', $row->name)->first();
                            ?>
                         
                         <?php if($row->status=="Irreparable"){         
                            
                            echo '<tr>';
                               echo '<td><center>'.$row-> request_id.'</center></td>';
                               echo '<td><center>'.date('F j,  Y', strtotime($row->created_at)).'</center></td>';
                               echo '<td><center>'.$user-> name.'</center></td>';
                               echo '<td><center>'.$row-> department.'</center></td>';
                               echo '<td><center>';
                               echo "<a href=edit/".$row-> id.'><span class="label label-info"> Edit </span></a>';
                               echo '</center></td>';
                            echo '</tr>';
                             
                         } ?>
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
            '<tr>\n\
                <td><input type="text" name="description[]" style="width: 170px;" class="form-control"></td>\n\
                <td><input type="text" name="brand[]" style="width: 170px;" class="form-control"></td>\n\
                <td><input type="text" name="serial[]" style="width: 170px;" class="form-control"></td>\n\
                <td><input type="text" name="defect[]" style="width: 170px;" class="form-control"></td>\n\
            </tr>' 
    }
    
    function delete_row() {
        var table = document.getElementById("myTable");
        var rowCount = table.rows.length - 1;
        
        if (rowCount === 2){
            alert("Cannot delete all rows!");
        } else {
            table.deleteRow(rowCount);
        }
    }
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
    $('#table_breakdownn').DataTable();
});
</script>
@endsection