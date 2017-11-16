@extends('layouts.master')

@section('content')
<div class="box">
    <?php $userId = Auth::user()->uid; ?>  
    <div class="box-body"><br></div>
    <div class="box-footer">
        <a href="{{ asset('/materialrequests/create') }}"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Back to Material Requests</u></font></a>
    </div>
    <div class="box-body">
        <div style="padding: 5px; border: 1px solid; border-color: #a0a0a0; text-align: center; width: 900px;">
            <strong style="font-size: 11pt;">
                1&1 INTERNET (PHILIPPINES), INC.
                <br>
                Material Requisition Form
            </strong><br>
            Version:  2 08.12.2016
        </div>
    </div><br>
    <div style="float: right; margin-right: 200px; width: 200px; text-align: center;" class="box-body">
        <b><?php
            if($rows->status == 'pending') echo 'PENDING';
            if($rows->status == 'approved') echo 'APPROVED';
            if($rows->status == 'disapproved') echo 'DISAPPROVED';
            ?></b>
    </div>
    <div class="box-body">
        Date: <b><?php echo date("F j, Y", strtotime($rows->created_at)); ?></b><br><br>
        With your approval, may I request for the purchase of the following item/s to be used by <b>{{ $rows->department }}</b>.<br><br>
        <form method="POST" action="{{ asset('/materialrequests/update') }}" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="{{$rows->id}}" name="id">
            <input type="hidden" value="{{$rows->reasons}}" name="reasons">
            <input type="hidden" value="{{$rows->requested_by}}" name="requested_by">
            <input type="hidden" value="{{$rows->department}}" name="department">
            <input type="hidden" value="{{$rows->next_approval}}" name="next_approval">
            <input type="hidden" value="{{$rows->dept_head}}" name="dept_head">
            <input type="hidden" value="{{$rows->sga_admin}}" name="sga_admin">
            <input type="hidden" value="{{$rows->sga_manager}}" name="sga_manager">
            
            <table class="table table-bordered" style="width: 900px; ">
                <thead>
                    <th><center>Item Description</center></th>
                    <th><center>Quantity</center></th>
                    <th><center>Unit Cost</center></th>
                    <th><center>Total Amount</center></th>
                    <th><center>Availability</center></th>
                </thead>
                <tbody  id="myTable">
                    <?php 
                    $total=0; 
                    $contents = json_decode($rows->contents); 
                    if($rows->status == 'pending'){
                        if($userId == '21225273' || $userId == '21464812'){
                            foreach($contents as $content){
                                print '<tr>';
                                    print '<td style="width: 350px;"><input type="text" readonly class="form-control" name="description[]" value="'.$content->description.'"></td>';
                                    print '<td><input type="text" readonly id="qty" class="form-control" name="quantity[]" value="'.$content->quantity.'"></td>';
                                    print '<td><input type="text" id="cost" class="form-control" name="unit_cost[]" value="'.number_format((float)$content->unit_cost, 2).'"></td>';
                                    print '<td><input type="text" id="total" class="form-control" name="total_amount[]" value="'.$content->total_amount.'"></td>';
                                    echo '<td>';
                                                echo '<select type="text" style="font-size: 9px; padding: 1px;" class="form-control" name="availability[]" value="'.$content->availability.'">';
                                                     if($content->availability != "") {echo '<option value="'.$content->availability.'">'.$content->availability.'</option>';}
                                                     if($content->availability != "NEED TO PURCHASE") {echo '<option value="NEED TO PURCHASE">NEED TO PURCHASE</option>';}
                                                     if($content->availability != "ON STOCK") {echo '<option value="ON STOCK">ON STOCK</option>';}
                                                     if($content->availability != "INVALID") {echo '<option value="INVALID">INVALID</option>';}
                                                echo '</select>
                                           </td>';
                                echo '</tr>';
                                $total += $content->total_amount;
                            }
                        }else{
                            foreach($contents as $content){
                                print '<tr>';
                                print '<td style="width: 400px;"><input type="text" readonly class="form-control" name="description[]" value="'.$content->description.'"></td>';
                                print '<td><input type="text" readonly id="qty" class="form-control" name="quantity[]" value="'.$content->quantity.'"></td>';
                                print '<td><input type="text" readonly id="cost" class="form-control" name="unit_cost[]" value="'.number_format((float)$content->unit_cost, 2).'"></td>';
                                print '<td><input type="text" readonly id="total" class="form-control" name="total_amount[]" value="'.number_format((float)$content->total_amount, 2).'"></td>';
                                print '<td>'.$content->availability.'</td>';
                                print '</tr>';
                                $total += $content->total_amount;
                            }
                        }
                    }else{
                        foreach($contents as $content){
                            print '<tr>';
                            print '<td style="width: 400px;"><input type="text" readonly class="form-control" name="description[]" value="'.$content->description.'"></td>';
                            print '<td><input type="text" readonly id="qty" class="form-control" name="quantity[]" value="'.$content->quantity.'"></td>';
                            print '<td><input type="text" readonly id="cost" class="form-control" name="unit_cost[]" value="'.number_format((float)$content->unit_cost, 2).'"></td>';
                            print '<td><input type="text" readonly id="total" class="form-control" name="total_amount[]" value="'.number_format((float)$content->total_amount, 2).'"></td>';
                            print '<td>'.$content->availability.'</td>';
                            print '</tr>';
                            $total += $content->total_amount;
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="3" style="text-align: right;"> TOTAL AMOUNT </th>
                        <td><input type="text" class="form-control" id="totalamt" value="<?php echo number_format($total, 2); ?>"></td>
                        <td style="text-align: center">
                            <?php if($rows->status == 'pending'){
                                if($userId == '21225273' || $userId == '21464812'){
                                    echo '<button type="submit" name="update" onClick="successPop()" class="btn btn-primary">Update Form</button>';
                                }
                            }?>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: right;"> UPDATE DETAILS </th>
                        <td colspan="2" style="color: #a0a0a0 ">
                             <i><?php 
                                if($rows->quoted_by!=' '){
                                    $name = App\Employee::where('uid', $rows->quoted_by)->first();
                                    echo $name->fname.' '.$name->lname;
                                    echo '<br>';
                                    echo date("F j, Y - g:i A", $rows->date_quoted); 
                                }
                                ?></i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <strong>JUSTIFICATION:</strong>
            <br>
            <?php echo $rows->reasons; ?>
            </form>
            <br><br>
            <div class="box-body" style="width: 765px; border: 1px solid;  border-color: #a0a0a0;">
                <table style="width: 750px; text-align: center;">
                    <tbody>
                        <tr>
                            <td style="padding: 5px; background: ">
                                Prepared by:
                                <br><br>
                                <?php
                                    $rqstr = App\Employee::where('uid', $rows->requested_by)->first();
                                    echo $rqstr->fname.' '.$rqstr->lname;
                                ?>
                                <hr>
                                Signature Over Printed Name
                            </td>
                            <td style="padding: 5px;">
                                Reviewed by:
                                <br><br>
                                <?php
                                    if($rows->sga_admin != ""){
                                    $review = App\Employee::where('uid', $rows->sga_admin)->first();
                                    echo $review->fname.' '.$review->lname;}
                                ?>
                                <hr>
                                Signature Over Printed Name
                            </td>
                            <td style="padding: 5px;">
                                Recommended by:
                                <br><br>
                                <?php
                                    if($rows->dept_head != ""){
                                    $recommend = App\Employee::where('uid', $rows->dept_head)->first();
                                    echo $recommend->fname.' '.$recommend->lname;}
                                ?>
                                <hr>
                                Signature Over Printed Name
                            </td>
                            <td style="padding: 5px;">
                                Approved by:
                                <br><br>
                                <?php
                                    if($rows->sga_manager != ""){
                                    $approve = App\Employee::where('uid', $rows->sga_manager)->first();
                                    echo $approve->fname.' '.$approve->lname;}
                                ?>
                                <hr>
                                Signature Over Printed Name
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
       <br>
        <div class="box-body" style="width: 765px; border: 1px solid; border-color: #e4e4e4;">
            <form method="POST" action="{{ asset('/materialrequests/process') }}" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$rows->id}}" name="id">
                <input type="hidden" value="{{$rows->contents}}" name="contents">
                <input type="hidden" value="{{$rows->quoted_by}}" name="quoted_by">
                <input type="hidden" value="{{$rows->date_quoted}}" name="date_quoted">
                <input type="hidden" value="{{$rows->reasons}}" name="reasons">
                <input type="hidden" value="{{$rows->requested_by}}" name="requested_by">
                <input type="hidden" value="{{$rows->department}}" name="department">
                <input type="hidden" value="{{$rows->next_approval}}" name="next_approval">
                <input type="hidden" value="{{$rows->dept_head}}" name="dept_head">
                <input type="hidden" value="{{$rows->sga_admin}}" name="sga_admin">
                <input type="hidden" value="{{$rows->sga_manager}}" name="sga_manager">
            <fieldset>    
                <legend>Action:</legend>
                @if($rows->status == 'pending')
                <!-- LEVEL 1-->
                    @if($rows->next_approval == 1 && $userId == '21225273')
                        <select name="status" class="form form-control" style="width: 200px;" id="status" onChange="statusChange();">
                            <option>Select Action</option>
                            <option>Approved</option>
                            <option>Disapprove</option>
                        </select>
                    @elseif($rows->next_approval == 1 && $userId == '21464812')
                        <select name="status" class="form form-control" style="width: 200px;" id="status" onChange="statusChange();">
                            <option>Select Action</option>
                            <option>Approved</option>
                            <option>Disapprove</option>
                        </select>
                    @elseif($rows->next_approval == 3 && $userId == '21203272')
                            <select name="status" class="form form-control" style="width: 200px;" id="status" onChange="statusChange();">
                                <option>Select Action</option>
                                <option>Approved</option>
                                <option>Disapprove</option>
                            </select>
                    @endif
                <!-- LEVEL 2 -->
                    <?php $manager = DB::table('employees')->where('roles', 'manager')->get();
                    foreach($manager as $mgr) { ?>
                        @if($mgr->uid == $userId && $rows->next_approval == 2)
                            <select name="status" class="form form-control" style="width: 200px;" id="status" onChange="statusChange();">
                                <option>Select Action</option>
                                <option>Approved</option>
                                <option>Disapprove</option>
                            </select>
                        @endif
                    <?php } ?>
                    <div id="statusChange"></div>
                @endif
            </fieldset>
            </form>  
            
            @if($rows->status == 'pending')
                <div id="addbutton" style="float: right; display: inline;"><button class="btn btn-primary" name="edit_item" onClick="addRemarks()">Add Remarks <i class="fa fa-caret-down"></i></button></div> 
                <div id="removebutton" style="float: right; display: none;"><button class="btn btn-primary" name="edit_item" onClick="addRemarks()">Add Remarks <i class="fa fa-caret-up"></i></button></div> 
                <form method="POST" action="{{ asset('/materialrequests/addremarks') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" value="{{$rows->id}}" name="id">
                    <div id="checkbox" style="display: none;">
                        &nbsp;&nbsp;&nbsp;
                        <input id="private" type="checkbox" name="visibility" value="1">&nbsp;Set as confidentiality
                    </div>
                    <br>
                    <div id="add_remarks" style="display: none; width: 700px;">
                        <br>
                        <textarea name="remarks" class="form-control" style="width: 720px;" placeholder="State your remarks/reasons here."></textarea><br>
                        <div style="float: right;"><button type="submit" class="btn btn-primary">Submit</button></div>
                    </div>
                </form>
            @else
                <div id="addbutton" style="float: left; display: inline;"><button class="btn btn-primary" onClick="addRemarks()">Add Remarks <i class="fa fa-caret-down"></i></button></div> 
                <div id="removebutton" style="float: left; display: none;"><button class="btn btn-primary" onClick="addRemarks()">Add Remarks <i class="fa fa-caret-up"></i></button></div> 
                <form method="POST" action="{{ asset('/materialrequests/addremarks') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" value="{{$rows->id}}" name="id">
                    <div id="checkbox" style="display: none;">
                        &nbsp;&nbsp;&nbsp;
                        <input id="private" type="checkbox" name="visibility" value="1">&nbsp;Set as confidentiality
                    </div>
                    <br>
                    <div id="add_remarks" style="display: none; width: 700px;">
                        <br>
                        <textarea name="remarks" class="form-control" style="width: 720px;" placeholder="State your remarks/reasons here."></textarea><br>
                        <div style="float: right;"><button type="submit" class="btn btn-primary">Submit</button></div>
                    </div>
                </form>
            @endif
        </div>
        <div class="box-body">
            <?php
                $remarks = DB::table('mr_forms_remarks')->where('mr_id', $rows->id)->get();     
                foreach($remarks as $remark){
                    $name = DB::table('employees')->where('uid', $remark->changed_by)->first();
                    if($remark->visibility == 0){ ?>
                      <br><table class="table table-bordered" style="width: 755px; ">
                            <tr style="background:#cbdaef">
                                <td><?php echo $name->fname.' '.$name->lname ?><span style="float:right;"><?php echo date("F j, Y - g:i a", strtotime($remark->created_at)); ?></span></td>
                            </tr>
                            <tr style="background:#e9eff8">
                                <td>{{ $remark->remarks }}</td>
                            </tr>
                      </table>
                <?php    } 
                }
            ?>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script type="text/javascript">
    function addRemarks() {
        $('#add_remarks').toggle();
        $('#checkbox').toggle();
        $('#addbutton').toggle();
        $('#removebutton').toggle();
    }
</script>
<script type="text/javascript">
    var inputQty = document.getElementById('qty'),
    inputCost = document.getElementById('cost'),
    inputTtlAmt = document.getElementById('totalamt'),
    inputTotal = document.getElementById('total');

    inputCost.onchange = function() {
       total.value = inputQty.value * inputCost.value;
    };
</script>
<script>
    function successPop() {
        alert("Update success!");
    }
</script>
<script>
    function statusChange() {
        var $id = document.getElementById("status");
        
        switch($id.value){
            case "Disapprove":
                document.getElementById("statusChange").innerHTML = 
                    '<br><textarea name="remarks" class="form-control" style="width: 700px;" placeholder="State your reasons here."></textarea>\n\
                     <br><button type="submit" class="btn btn-primary">Submit</button><br><br>';
                break;
            case "Approved":
                document.getElementById("statusChange").innerHTML = 
                    '<br><button type="submit" class="btn btn-primary">Submit</button><br><br>';
                break;
            case "Select Action":
                document.getElementById("statusChange").innerHTML = '';
                break;
        }
        
    }
</script>
@endsection