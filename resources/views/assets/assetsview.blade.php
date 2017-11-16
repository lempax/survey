@extends('layouts.master')

@section('content')
<div class="box">
    <br>
    <div class="box-header">
        <a href="{{ asset('/assets/new') }}"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Back to Issuance Form</u></font></a>
    </div>
    @if(Session::has('error_message'))
        <div class="modal" id="alert" role="dialog" aria-hidden="true" style=" display:inline; padding-top: 180px;">
            <div class="modal-content" style="text-align:center; margin:auto; width:350px; height: 80px; padding: 10px; background: red">               
                <div style="float:right;">
                    <span class="close" type="button" onClick="hideAlert();"><i class="fa fa-times-circle"></i></span>
                </div><br>
                <font style="color: white; font-size: 16px; font-weight: bold;">
                {{ Session::get('error_message') }}</font>   
            </div>
        </div>
    @endif
    <div class="box-body">
        <div style="padding: 5px; border: 1px solid; border-color: #a0a0a0; text-align: center;">
            <strong style="font-size: 11pt;">
                1&1 INTERNET (PHILIPPINES), INC.
                <br>
                Assets Requisition Form
            </strong><br>
        </div><br>
        <div> <b>DATE:</b> <u> <?php echo date('F j, Y'); ?> </u></div>
        <div style="float: right; padding-right:30px;">
            <b>STATUS:</b>
            <?php 
                if($rows->status=="pending")
                    echo '<span class="label label-warning">Pending</span>'; 
                else if ($rows->status=="approved")
                    echo '<span class="label label-success">Approved</span>'; 
                else if ($rows->status=="disapproved")
                    echo '<span class="label label-default">Disapproved</span>'; 
            ?>
        </div>
        <div>
            <br>
            <?php $to = DB::table('employees')->where('uid', $rows->issued_to)->first(); ?>
            <p>With your approval, the following items are to be issued to <u>{{$to->fname}} {{$to->lname}}</u>.</p>
        </div>
    </div><br>
    <div class="box-body">
        <table class="table table-bordered" style="width: 900px;">
            <thead>
                <tr>
                    @foreach($breakdown['headers'] as $i => $head)
                    <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody> 
                <?php
                    $issue = DB::table('assets_issuance_item')->where('issued_id', $rows->issued_id)->get();
                foreach($issue AS $row) {
                    $item = DB::table('assets_items')->where('id', $row->item_id)->first();
                ?>
                
                <tr>
                    <td><input type="text" readonly class="form form-control" value="{{ $item->category }}"></td>
                    <td><input type="text" readonly class="form form-control" value="{{ $item->name }}"></td>
                    <td><input type="text" readonly class="form form-control" value="{{ $row->serial }}"></td>
                    <td><input type="text" readonly class="form form-control" name="quantity" value="{{ $row->quantity }}"></td>
                </tr>  
                <?php } ?>
            </tbody>
        </table>
    </div><br>
    <div class="box-body">
        <b>JUSTIFICATION</b><br>
        {{ $rows->purpose }}
    </div>
    <div class="box-body" style="border: 1px solid; width: 700px; margin-left: 10px;">
        <table style="width: 700px;">
            <tr>
                <td style="width:50%;text-align: center;">
                    Prepared by:
                    <br><br>
                    <?php
                        $by = App\Employee::where('uid', $rows->issued_by)->first();
                        echo $by->fname.' '.$by->lname;
                    ?>
                    <br>_______________________________<br>
                    Signature Over Printed Name
                </td>
                <td style="text-align: center;">
                    Accepted by:
                    <br><br>
                    <?php
                    if($rows->approved_by != ""){
                        $by = App\Employee::where('uid', $rows->approved_by)->first();
                        echo $by->fname.' '.$by->lname;
                    }
                    ?>
                    <br>_______________________________<br>
                    Signature Over Printed Name
                </td>
            </tr>
        </table>
    </div>
    <br>
    
    <div class="box-body">
        <form method="POST" action="{{ asset('/assets/action') }}" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="issued_id" value="{{$rows->issued_id}}">
            <?php
                $emp = DB::table('employees')->where('uid', $rows->issued_by)->first();
                $dept = DB::table('departments')->where('departmentid', $emp->departmentid)->first();
            ?> 
            
            @foreach($items AS $item)
                <input type="hidden" name="id[]" value="{{ $item->item_id }}">
                <input type="hidden" name="quantity[]" value="{{ $item->quantity }}">
            @endforeach
            
            <select class="form form-control" name="action" id="action" style="width: 200px; float: left;" onChange="actionToggle();">
                <option>Select Action</option>
                @if($rows->status == 'pending')
                <?php
                    if(Auth::user()->uid == $dept->admin){
                        echo '<option value="approved">Approve</option><option value="disapproved">Disapprove</option>';
                    }elseif(Auth::user()->uid == $rows->issued_by){
                        echo '<option value="accepted">Accept in Behalf of Receiver</option>';
                    }
                ?>
                @endif
                <option value="add_remark">Add Remarks</option>
            </select>
            <button class="btn btn-primary" type="submit">Submit</button><br><br>
            <div id="actionChange">
                <div id="remark" style="display:none"><textarea name="remark" class="form-control" style="width: 700px;" placeholder="State your remarks/reasons here."></textarea></div>
            </div>
            <div class="modal" id="modal" role="dialog" aria-hidden="true" style=" display:none;">
                <div class="modal-content" style="background:#ffffff; width:350px; height:250px; margin:auto; margin-top: 50px;">
                    <div class="modal-header" style="height: 45px;">
                        <button class="close" type="button" onClick="hideModal();"> <i class="fa fa-close"></i> </button>
                    </div>
                    <div class="modal-body" style="margin-left: 40px;">
                        <b>Please enter your profile password: <font color="red"> *</font></b>
                        <input type="password" name="password" class="form form-control" style="width: 150px;">                        
                    </div>
                    <div style="float: right; margin-right: 60px;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
   
    <div class="nav-tabs-custom" style="padding-left: 20px;">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Comments</a></li>
        </ul>
    </div>
    <div class="box-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <?php $comments = DB::table('assets_remarks')->where('remarks_id', $rows->issued_id)->get(); ?>
                @foreach($comments AS $comment)
                <table class="table table-bordered" style="width:800px;">
                    <tr>
                        <td style="background-color: #f5f5f5;">
                            <?php $by = DB::table('employees')->where('uid', $comment->remarks_by)->first(); ?>
                            <div style="float: left;"><b>{{$by->fname}} {{$by->lname}}</b></div>
                            <div style="float: right;"><i>{{ date('F j, Y', strtotime($comment->created_at)) }}</i></div>
                        </td>
                    </tr>
                    <tr>
                        <td>{{$comment->remarks}}</td>
                    </tr>
                </table>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    function actionToggle() {
        var $id = document.getElementById("action");
        
        switch($id.value){
            case "add_remark":
                displayRemark();
                break;
            case "Select Action":
            case "approved":
            case "disapproved":    
                hideRemark();
                break;
            case "accepted": 
                displayModal();
                hideRemark();
                break;
        }
    }
    
    function hideModal(){
        document.getElementById('modal').style.display = "none";
    }
    
    function displayModal(){
        document.getElementById('modal').style.display = "inline";
    }
    
    function displayRemark(){
        document.getElementById('remark').style.display = "block";
    }
    
    function hideRemark(){
        document.getElementById('remark').style.display = "none";
    }
    
    function hideAlert(){
        document.getElementById('alert').style.display = "none";
    }
</script>
@endsection