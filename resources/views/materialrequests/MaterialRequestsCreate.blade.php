@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<div class="box">
    <div class="nav-tabs-custom">
        <?php 
        $userId = Auth::user()->uid; 
        $count=0;
            foreach($pending AS $p){
                if($userId == '21225273' || $userId == '21464812'){
                            if($p->status == 'pending')  $count++;
                }elseif($userId == '21203272'){
                    if($p->next_approval == 3){
                        if($p->status == 'pending')  $count++;
                    }
                }else{
                    $manager = DB::table('employees')->where('roles', 'manager')->get();
                    $temp=0;
                    foreach($manager as $mgr){ 
                        if($mgr->uid == $userId){
                            $temp=1;
                            if($p->next_approval == 2){
                                    if($p->status == 'pending') $count++;
                            }
                        } 
                    }
                    if($temp!=1){
                        if($p->requested_by == $userId){
                            if($p->status == 'pending')  $count++;
                        }
                    }
                }
            }
        ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Material Request Form</a></li>
            <li class=""><a href="#tab2" data-toggle="tab">Pending Requests (<font color="red">{{ $count }}</font>)</a></li>
            <li class=""><a href="#tab3" data-toggle="tab">Show All Requests</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
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
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissable" aria-hidden="true"  style="text-align: center; margin-left: 10px; width: 400px;">
                        <i class="fa fa-warning">&nbsp;</i>{{ Session::get('error_message') }}
                    </div>
                @endif
                <div class="box-body" style="padding: 5px; border: 1px solid; border-color: #a0a0a0; text-align: center; width: 800px;">
                    <strong style="font-size: 11pt;">
                        1&1 INTERNET (PHILIPPINES), INC.
                        <br>
                        Material Requisition Form
                    </strong><br>
                    Version:  2 08.12.2016
                </div><br>
                Date: <b><?php echo date("F j, Y"); ?></b><br><br>
                With your approval, may I request for the purchase of the following item/s to be used by <b>{{ Auth::user()->department->name }}</b>.<br><br>
                <form method="POST" action="{{ asset('/materialrequests/store') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-bordered" style="width: 800px;">
                        <thead>
                            <tr>
                                <th><center>Item Description</center></th>
                                <th><center>Quantity</center></th>
                                <th><center>Unit Cost</center></th>
                                <th><center>Total Amount</center></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <tr>
                                <td style="width: 400px;"><input type="text" class="form-control" name="description[]" required></td>
                                <td><input type="text" class="form-control" name="quantity[]" required></td>
                                @if($userId == '21225273')
                                    <td><input type="text" class="form-control" name="unit_cost[]"></td>
                                    <td><input type="text" class="form-control" name="total_amount[]"></td>
                                @elseif($userId == '21464812')
                                    <td><input type="text" class="form-control" name="unit_cost[]"></td>
                                    <td><input type="text" class="form-control" name="total_amount[]"></td>
                                @else
                                    <td><input type="text" readonly class="form-control" name="unit_cost[]"></td>
                                    <td><input type="text" readonly class="form-control" name="total_amount[]"></td>
                                @endif
                                <td style="width: 60px;"></td>
                            </tr>
                        </tbody>
                    </table>
                    &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="button" value="Add Item" onclick="addItem();">
                    <br><br>
                    <strong>JUSTIFICATION</strong>
                    (Please indicate clearly reasons for request)
                    <br><br>
                    <textarea class="form-control" name="reasons" style="height:100px; width:700px;"></textarea>
                    <br>
                    <div class="box-footer">
                        <div class="foot-area">
                            <button type="submit" name="add" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="tab2">
                 <form method="POST" action="{{ asset('/materialrequests/sort') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body" style="float: left;">
                        <select name="category" class="form-control" style="width: 150px;">
                            <option>All</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Denied</option>
                        </select>
                    </div>
                    <div class="box-body">
                        <button class="btn btn-primary"  style="float:left;">View Requests</button>
                    </div>
                </form>
                <div class="box-body">
                    <table id="pending_requests" class="table table-bordered">
                        <thead>
                            @foreach($breakdown['headers'] as $i => $head)
                                <th style="{{ $breakdown['headerStyle'][$i] }}"><center>{{ $head }}</center></th>
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach($pending AS $p)
                            <?php $requestedby = \App\Employee::where('uid', $p->requested_by)->first();?>
                            <!-- IF MMAGDADARO or AMERELOS-->
                            @if($userId == '21225273' || $userId == '21464812')
                                
                                <tr>
                                    <td><center><a href="edit/{{$p->id}}">{{ $p->id }}</a></center></td>
                                    <td><center>{{ $requestedby->name }}</center></td>
                                    <td><center>{{ $p->department }}</center></td>
                                    <td><center>{{ date("F j, Y", strtotime($p->created_at)) }}</center></td>
                                    <td>
                                        <center>
                                        <?php echo '<span class="label label-warning">Pending</span>';  ?>
                                        </center>
                                    </td>
                                </tr>
                                
                            <!-- IF JAY-->
                            @elseif($userId == '21203272')
                                @if($p->next_approval == 3)
                                    <tr>
                                        <td><center><a href="edit/{{$p->id}}">{{ $p->id }}</a></center></td>
                                        <td><center>{{ $requestedby->name }}</center></td>
                                        <td><center>{{ $p->department }}</center></td>
                                        <td><center>{{ date("F j, Y", strtotime($p->created_at)) }}</center></td>
                                        <td>
                                            <center>
                                            <?php echo '<span class="label label-warning">Pending</span>'; ?>
                                            </center>
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <!-- IF DEPARTMENT HEADS-->
                                <?php $manager = DB::table('employees')->where('roles', 'manager')->get();
                                $temp=0;
                                foreach($manager as $mgr){ ?>
                                    @if($mgr->uid == $userId)
                                        <?php $temp=1; ?>
                                        @if($p->next_approval == 2)
                                            
                                                <tr>
                                                    <td><center><a href="edit/{{$p->id}}">{{ $p->id }}</a></center></td>
                                                    <td><center>{{ $requestedby->name }}</center></td>
                                                    <td><center>{{ $p->department }}</center></td>
                                                    <td><center>{{ date("F j, Y", strtotime($p->created_at)) }}</center></td>
                                                    <td>
                                                        <center>
                                                        <?php echo '<span class="label label-warning">Pending</span>'; ?>
                                                        </center>
                                                    </td>
                                                </tr>
                                        @endif
                                    @endif
                                <?php } 
                                if($temp!=1){ ?>
                                    @if($p->requested_by == $userId)
                                    <tr>
                                        <td><center><a href="edit/{{$p->id}}">{{ $p->id }}</a></center></td>
                                        <td><center>{{ $requestedby->name }}</center></td>
                                        <td><center>{{ $p->department }}</center></td>
                                        <td><center>{{ date("F j, Y", strtotime($p->created_at)) }}</center></td>
                                        <td>
                                            <center>
                                            <?php if($p->status=="pending")
                                                    echo '<span class="label label-warning">Pending</span>'; 
                                                else if ($p->status=="approved")
                                                    echo '<span class="label label-success">Approved</span>'; 
                                                else if ($p->status=="disapproved")
                                                    echo '<span class="label label-default">Disapproved</span>'; 
                                              ?>
                                            </center>
                                        </td>
                                    </tr>
                                    @endif
                                <?php } ?>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <form method="POST" action="{{ asset('/materialrequests/sort') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body" style="float: left;">
                        <select name="category" class="form-control" style="width: 150px;">
                            <option>All</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Denied</option>
                        </select>
                    </div>
                    <div class="box-body">
                        <button class="btn btn-primary"  style="float:left;">View Requests</button>
                    </div>
                </form>
                <div class="box-body">
                    <table id="all_requests" class="table table-bordered">
                        <thead>
                            @foreach($breakdown['headers'] as $i => $head)
                                <th style="{{ $breakdown['headerStyle'][$i] }}"><center>{{ $head }}</center></th>
                            @endforeach
                        </thead>
                        <tbody>
                            @foreach($rows AS $row)
                            <?php $requestedby = \App\Employee::where('uid', $row->requested_by)->first();?>
                            <!--IF MMAGDADARO or AMERELOS or JAY -->
                            @if($userId == '21225273' || $userId == '21464812' || $userId == '21203272')
                                <tr>
                                    <td><center><a href="edit/{{$row->id}}">{{ $row->id }}</a></center></td>
                                    <td><center>{{ $requestedby->name }}</center></td>
                                    <td><center>{{ $row->department }}</center></td>
                                    <td><center>{{ date("F j, Y", strtotime($row->created_at)) }}</center></td>
                                    <td>
                                        <center>
                                        <?php if($row->status=="pending")
                                                echo '<span class="label label-warning">Pending</span>'; 
                                            else if ($row->status=="approved")
                                            echo '<span class="label label-success">Approved</span>'; 
                                          else if ($row->status=="disapproved")
                                            echo '<span class="label label-default">Disapproved</span>'; 
                                        ?>
                                        </center>
                                    </td>
                                </tr>
                            @else
                                <?php $manager = DB::table('employees')->where('roles', 'manager')->get();
                                $temp=0;
                                foreach($manager as $mgr){ ?>
                                    @if($mgr->uid == $userId)
                                        <?php $temp=1; ?>
                                        <tr>
                                            <td><center><a href="edit/{{$row->id}}">{{ $row->id }}</a></center></td>
                                            <td><center>{{ $requestedby->name }}</center></td>
                                            <td><center>{{ $row->department }}</center></td>
                                            <td><center>{{ date("F j, Y", strtotime($row->created_at)) }}</center></td>
                                            <td>
                                                <center>
                                                <?php if($row->status=="pending")
                                                        echo '<span class="label label-warning">Pending</span>'; 
                                                    else if ($row->status=="approved")
                                                    echo '<span class="label label-success">Approved</span>'; 
                                                  else if ($row->status=="disapproved")
                                                    echo '<span class="label label-default">Disapproved</span>'; 
                                                ?>
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                <?php } 
                                if($temp!=1){ ?>
                                @if($row->requested_by == $userId)
                                <tr>
                                    <td><center><a href="edit/{{$row->id}}">{{ $row->id }}</a></center></td>
                                    <td><center>{{ $requestedby->name }}</center></td>
                                    <td><center>{{ $row->department }}</center></td>
                                    <td><center>{{ date("F j, Y", strtotime($row->created_at)) }}</center></td>
                                    <td>
                                        <center>
                                        <?php if($row->status=="pending")
                                                    echo '<span class="label label-warning">Pending</span>'; 
                                              else if ($row->status=="approved")
                                                    echo '<span class="label label-success">Approved</span>'; 
                                              else if ($row->status=="disapproved")
                                                    echo '<span class="label label-default">Disapproved</span>'; 
                                        ?>
                                        </center>
                                    </td>
                                </tr>
                                @endif
                            
                                <?php } ?>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript">
    $(function () {
        $('#pending_requests').DataTable();  
        $('#all_requests').DataTable();  
    });
</script>
<script type="text/javascript">
    var table = document.getElementById("myTable");
    var x = '';
    var div = 'contain';

    function addItem() {
        for(x = 0; x <= (table.rows.length) - 1; x++){
            temp_status = status + x;
            temp_div = div + x;
        }   
        document.getElementById("myTable").insertRow(-1).innerHTML = 
            '<tr>\n\
                <td style="width: 400px;"><input type="text" class="form-control" name="description[] required"></td>\n\
                <td><input type="text" class="form-control" style="" name="quantity[] required"></td>\n\
                @if($userId == '21225273' || $userId == '21464812')\n\
                <td><input type="text" class="form-control" name="unit_cost[]"></td>\n\
                <td><input type="text" class="form-control" name="total_amount[]"></td>\n\
                @else\n\
                <td><input type="text" readonly class="form-control" name="unit_cost[]"></td>\n\
                <td><input type="text" readonly class="form-control" name="total_amount[]"></td>\n\
                @endif\n\
                <td style="vertical-align:middle; text-align:center;"><i class="fa fa-fw fa-close fa-lg" onclick="deleteItem();"></i></td>\n\
            </tr>';
    }
    function deleteItem() {
        document.getElementById("myTable").deleteRow(-1);
    }
</script>
@endsection
