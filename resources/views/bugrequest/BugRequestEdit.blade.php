@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<!-- Default box -->
<div class="box">
<form role="form" method="POST" action="{{ asset('/bugrequest/update') }}">
     <input type="hidden" name="_method" value="PUT">
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">Update Bug Request</h2></div><br>
            <div class="alert alert-info alert-dismissable" style="width: 450px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below to update bug request
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
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>Update Bug Requests</center></th>
                    <tr>
                        <input type="hidden" name="id" value="<?php echo $bq->id ?>">
                        <th style="width: 150">Select Category: </th>
                        <td><div class="form-group">
                                <select class="form-control" name="category" value="<?php echo $bq->category ?>" style="width: 200px">
                                        <option <?php if ($bq->category == '' ) echo 'selected'; ?> value="">Select Category</option>
                                        <option <?php if ($bq->category == 'MyWebsite' ) echo 'selected'; ?> value="MyWebsite">MyWebsite</option>
                                        <option <?php if ($bq->category == 'Webhosting' ) echo 'selected'; ?> value="Webhosting">Webhosting</option>
                                        <option <?php if ($bq->category == 'E-Business' ) echo 'selected'; ?> value="E-Business">E-Business</option>
                                        <option <?php if ($bq->category == 'Contract Management' ) echo 'selected'; ?> value="Contract Management">Contract Management</option>
                                        <option <?php if ($bq->category == 'Domain' ) echo 'selected'; ?> value="Domain">Domain</option>
                                        <option <?php if ($bq->category == 'Control Panel' ) echo 'selected'; ?> value="Control Panel">Control Panel</option>
                                        <option <?php if ($bq->category == 'Mail' ) echo 'selected'; ?> value="Mail">Mail</option>
                                </select></div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150">Subject: </th>
                        <td><input type="text" name="subject" value="<?php echo $bq->subject ?>" style="width: 350px" class="form-control">
                        <label style="color: red">Format: [Bug Request][Application][Short Description of the issue][Case ID]</label>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150">Customer ID: </th>
                        <td><input type="text" name="customer_id" value="<?php echo $bq->customer_id ?>" style="width: 200px" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150">Contract ID: </th>
                        <td><input type="text" name="contract_id" value="<?php echo $bq->contract_id ?>" style="width: 200px" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150">Tech ID: </th>
                        <td><input type="text" name="tech_id" value="<?php echo $bq->tech_id ?>" style="width: 350px" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150">Domain/URL/Proj.ID: </th>
                        <td><input type="text" name="project_id" value="<?php echo $bq->project_id ?>" style="width: 350px" class="form-control"></td>
                    </tr>
                    <tr>
                        <th>Date of Occurrence: </th>
                        <td>
                            <div class="input-group date" data-provide="datepicker" style="width: 250px; float: left; ">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" name="date_occurrence" value="<?php echo date('m/d/Y', strtotime($bq->date_occurrence)) ?>" class="form-control pull-right"/>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th style="padding-top: 70px; width: 150px;">Description of the <br>encountered wrong <br>behaviour: </th>
                        <td>
                            <textarea id="ckeditor1" name="description"><?php echo $bq->description; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-top: 100px; width: 150px;">Solution Steps: </th>
                        <td>
                            <textarea id="ckeditor2" name="solution"><?php echo $bq->solution; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-top: 70px; width: 150px;">Expected Behavior: </th>
                        <td>
                            <textarea id="ckeditor3" name="behavior"><?php echo $bq->behavior; ?></textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th style="padding-top: 70px; width: 150px;">Step by step instruction to<br>reproduce the problem: </th>
                        <td>
                            <textarea id="ckeditor4" name="instruction"><?php echo $bq->instruction; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Attachments:</th>
                        <td>
                            <a ><?php echo $bq->files; ?></a>
                            
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Browser 1 (Type/Version):</th>
                        <td><input type="text" name="browser1" value="<?php echo $bq->browser1 ?>" style="width: 350px" placeholder="Verification with Type/Version" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Browser 2 (Type/Version):</th>
                        <td><input type="text" name="browser2" value="<?php echo $bq->browser2 ?>" style="width: 350px" placeholder="Verification with Type/Version" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Operating System:</th>
                        <td><input type="text" name="os" value="<?php echo $bq->os ?>" style="width: 350px" class="form-control"></td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Add CC Email Recipient:</th>
                        <td>
                          <div class="form-group" style="width: 250px;" >
                                <select class="form-control" name="recipient" value="<?php echo $bq->recipient ?>">
                                 
                                     <?php $recipient = \App\Employee::where('uid', $bq->recipient)->first(); ?>
                                     <option value="{{ $bq->recipient }}" selected>{{ $recipient->name }}</option>
                                <?php $subordinates = Auth::user()->subordinates(); ?>
                                @foreach($subordinates AS $subordinate)
                                    <?= ($subordinate->uid == $bq->recipient ? '' : '<option value="'.$subordinate->uid.'">'.$subordinate->name.'</option>') ?>
                                @endforeach
                                 </optgroup>
                                </select>
                          </div>
                        </td>
                    </tr>
                    <input type="hidden" name="loggedby" value="{{Auth::user()->uid}}">
                    <tr>
                        <th style="width: 150px;">Status</th>
                        <td><select class="form-control" name="status" value="<?php echo $bq->status ?>" style="width: 200px">
                            <option <?php if ($bq->status == 'Open' ) echo 'selected'; ?> value="Open">Open</option>
                            <option <?php if ($bq->status == 'Resolved' ) echo 'selected'; ?> value="Resolved">Resolved</option>
                            <option <?php if ($bq->status == 'Ticket Created' ) echo 'selected'; ?> value="Ticket Created">Ticket Created</option>
                         </select></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
        </div>
        <div class="box-footer" >
            <div class="foot-area" style="float: right;">
                <button class="btn btn-warning" type="submit" name="save"><i class="fa fa-save"></i> Save Update</button>
                <button class="btn btn-primary" type="submit" name="send"><i class="fa fa-edit"></i> Update Now</button>
            </div>
        </div> 
    </div> 
</form>
</div>
<div class="box">
    <div class="box-header">
        <div><h3 class="box-title">{{ $breakdown['name'] }} Comments </h3></div><br>
        
        <div style="display: block">
            @foreach($all as $row)
                    <?php $user = \App\Employee::where('uid', $row->username)->first();?>
            <table>     
                <thead>
                    <th style="border: 2px solid #F4F4F4; font-family: Helvetica,Arial,sans-serif; font-weight: bold; font-size: 14px; color: #333; padding: 6px 6px 6px 6px; width: 1150px; background-color: #F9F9F9; text-align: left;">    
                       <label style='float: left; margin-left: 5px;'>{{  $user->name }} </label>
                       <label style='float: right; margin-right: 5px;'>{{ date('F j, Y g:i A', strtotime($row->created_at)) }}</label>
                </thead>    
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="output" style="width:1150px" value="{{ $row->message }}" id="output" readonly></td>
                    </tr>
                </tbody>
            </table><br>
             @endforeach
        </div>
        
        <form method="POST" action="{{ asset('/bugrequest/comment/'.$bq->id) }}" role="form" >

            <input type="hidden" name="request_id" value="{{ $trans_id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
            
            <div class="commentBox" id="commentBox" style="display: none; width: 1140px; float:left; margin: 10px;">
                <label style="font-style: italic;">Write Comment</label><br>
                <textarea id="commentmsg" class="form-control" style="width: 1100px; height: 150px;" name="commentmsg"></textarea><br>
                <input type="submit" name="add" value="Add" class="form-group" /> 
                <input id="cancel_btn" type="button" onclick="yourFunction();" value="Cancel" class="form-group" /><br>
            </div>
            <?php if ($bq->status == 'Open' ){
                echo '<div>'; 
                echo  '<button type="button" id="comment"  class="btn btn-info" name="comment"><i class="fa fa-comment-o"></i> Add Comment</button>';
                echo  '</div>';
            }?>
        </form>
    </div>
 </div> 
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
            CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
            CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
            CKEDITOR.replace('ckeditor1');
            CKEDITOR.replace('ckeditor2');
            CKEDITOR.replace('ckeditor3');
            CKEDITOR.replace('ckeditor4');
        });
</script>

<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#comment').click(function () {
            $('.commentBox').show();
            $(this).hide();
        });
        $('#cancel_btn').click(function () {
            $('.commentBox').hide();
            $('#comment').show();
        });
    });
</script>
<script>
function yourFunction(){
     document.getElementById('commentmsg').value = "";
};
</script>
@endsection