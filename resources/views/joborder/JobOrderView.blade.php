@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<!-- Default box -->
<div class="box" >
<?php $userId = Auth::user()->uid; 
    $members = DB::table('employees')->where('departmentid', '=', '21238070')->get();   
?>  
    <div>
        <div class="box-header with-border">
            <div class="alert alert-info alert-dismissable" style="width:550px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Here you can view the details of the selected Job Order and have it updated.
            </div>
            <div class="box-footer">
                <a href="{{ asset('/joborder/create') }}"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Back to Job Order Lists</u></font></a>
            </div>
        </div>
        <div class="box-body" >
            <div class="instr" style="overflow: hidden; padding-bottom: 20px">
                <input type="hidden" value="{{$temp->id}}" name="id">
                <div class="col-left">
                <div class="box-body" style="float: left; margin-left: 30px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                    <fieldset style="min-height: 100px; min-width: 600px; ">
                        <legend><strong>Details</strong></legend>
                        <div style="float: left; color: #999999; ">
                            Title: <?php echo '<span class="white-text" style="margin-left: 26px;"><font color="black">'.$temp->title.'</font></span>'; ?> <br/>
                            Type: <?php 
                                if($temp->type == "isdev")
                                    echo '<span class="white-text" style="margin-left: 23px;"><font color="black">IS Development</font></span>'; 
                                else if ($temp->type == "itserv")
                                    echo '<span class="white-text" style="margin-left: 23px;"><font color="black">IT Services</font></span>';
                                else if ($temp->type == "misc")
                                    echo '<span class="white-text" style="margin-left: 23px;"><font color="black">Miscellaneous</font></span>'; 
                                ?><br/>
                            Priority: <?php 
                                if($temp->priority == "minor")
                                    echo '<span style="color:gold; font-weight: bold; margin-left: 9px;">MINOR</span>'; 
                                else if ($temp->priority == "major")
                                    echo '<span style="color:salmon; font-weight: bold; margin-left: 9px;">MAJOR</span>';
                                else if ($temp->priority == "critical")
                                    echo '<span style="color:red; font-weight: bold; margin-left: 9px;">CRITICAL</span>'; 
                                ?><br/>
                            Status: <?php 
                                if($temp->status == "pending")
                                    echo '<span style="margin-left: 15px;"><font color="black">Pending</font></span>'; 
                                else if ($temp->status == "approved")
                                    echo '<span style="margin-left: 15px;"><font color="black">Approved</font></span>'; 
                                else if ($temp->status == "disapproved")
                                     echo '<span style="margin-left: 15px;"><font color="black">Disapproved</font></span>';
                                else if ($temp->status == "assigned")
                                     echo '<span style="margin-left: 15px;"><font color="black">Assigned</font></span>';
                                else if ($temp->status == "ongoing")
                                     echo '<span style="margin-left: 15px;"><font color="black">In Progress</font></span>';
                                else if ($temp->status == "closed")
                                     echo '<span style="margin-left: 15px;"><font color="black">Closed</font></span>';
                               ?><br/>
                        </div>
                    </fieldset>
                    </div>
                    
                    <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                        <fieldset style="min-height: 100px; min-width: 400px; max-width: 400px;">
                            <legend><strong>People</strong></legend>
                            <div style="color: #999999; ">
                                Requested by:<?php $user = \App\Employee::where('uid', $temp->created_by)->first();?>
                                <span style="float: right;"><font color="black"><?php echo $user->name ?></font></span>
                                <br>Assigned to: <?php $assigned = \App\Employee::where('uid', $temp->assigned_to)->first();
                                if($temp->assigned_to != ''){
                                    echo '<span style="float: right;"><font color="black">'.$assigned->name.'</font></span>';
                                } ?>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                        <fieldset style="min-height: 100px; max-height: 200px; min-width: 400px; max-width: 400px;">
                            <legend><strong>Dates</strong></legend>
                            <div style=" color: #999999; ">
                                Created: <span style="float: right; margin-left:170px;"><font color="black"><?php echo date('F j,  Y - g:i A', strtotime($temp->created_at)) ?></font></span> <br>
                                Updated: <?php echo '<span style="float: right; margin-left:150px;"><font color="black">'.date('F j,  Y - g:i A', strtotime($temp->updated_at)). '</span></font>';?> <br>
                                Started: <?php if($temp->status == 'ongoing' || $temp->status == 'closed') echo '<span style="float: right; margin-left:150px;"><font color="black">'.date('F j,  Y - g:i A', strtotime($prog->created_at)).'</span></font>' ;?><br>
                                Due: <?php if($temp->status == 'closed') echo '<span style="float: right; margin-left:150px;"><font color="black">'.date('F j,  Y', strtotime($prog->date_due)).'</span></font>' ;?><br>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="box-body" style="float: left; margin-left: 30px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                        <fieldset style="min-height: 100px; min-width: 600px; max-width: 600px; ">
                        <legend><strong>Description</strong></legend>
                        <?php echo $temp->description ?>
                        </fieldset>
                    </div>
                    
                    
                    <!----- if pending ----->
                    <?php if($temp->status == "pending"){
                        if($userId == $temp->created_by){?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                                <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend><strong>Actions</strong></legend>
                                    <div style="float: left;">
                                        <legend style="font-size: 15px;">Additional Files</legend>
                                        <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                        <input type="file" name="attachments[]" id="attachments" multiple>
                                        <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                        <div style="font-size: 90%">
                                        * Individual file sizes are limited up to <strong>15MB</strong> only.
                                        </div>
                                    </div>
                                </fieldset>
                                </form>
                            </div>
                            
                        <?php   
                        }else if($userId == '21205462'){?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend><strong>Actions</strong></legend>
                                
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                    
                                <fieldset style="min-height: 100px; min-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Needs Approval</legend>
                                    <span style="font-size: 12px;">This option will allow you to Approve or Disapprove this Job Order before it <br> can be processed:<br> </span>
                                        <select class="form-control" name="status" id="status" style="width: 250px; margin-top: 15px;">
                                            <option value=" "> </option>
                                         <option value="approved">Approved Request</option>
                                        <option value="disapproved">Invalid/Disapproved Request</option>
                                        </select>
                                <textarea name="dreason" id="reason" placeholder="[state your reasons here]" class="form-control" style="width: 250px; height: 80px; margin-top: 25px; display: none;"></textarea></br>
                                <button type="submit" name="submit" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Submit</button>
                                </fieldset>
                                </form>   
                            </div>
                            <br>
                            
                            <form method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$temp->id}}" name="id">
                            <input type="hidden" value="{{$temp->type}}" name="type">
                            <input type="hidden" value="{{$temp->priority}}" name="priority">
                            <input type="hidden" value="{{$temp->title}}" name="title">
                            <input type="hidden" value="{{$temp->description}}" name="description">
                            <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                            <input type="hidden" value="{{$temp->status}}" name="status">
                            <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                            <input type="hidden" value="{{$temp->tid}}" name="tid">
                            <div style="float: left;">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                        <div style="font-size: 90%">
                                        * Individual file sizes are limited up to <strong>15MB</strong> only.
                                        </div>
                                </fieldset>
                            </div>
                            </form>
                            </fieldset>
                            </div>
                        <!----- if approved ----->
                     <?php   }
                    }else if($temp->status == 'approved'){ 
                        if($userId == $temp->created_by){ ?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend><strong>Actions</strong></legend>
                                    <div style="float: left;">
                                    <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">    
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                     <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                     <div style="font-size: 90%">
                                     * Individual file sizes are limited up to <strong>15MB</strong> only.
                                     </div>
                                     </form>
                                    </div>
                                </fieldset>
                            </div>
                        <?php    
                        }else if($userId == '21205462'){ ?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                            <legend><strong>Actions</strong></legend>
                            
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Assign Job Order</legend>
                                    <span style="font-size: 12px;">The following option allows you to assign or re-assign a particular IT/IS staff <br> which will handle this Job Order: </span>
                                        <input type="hidden" name="status" value="assigned">
                                        <select class="form-control" name="assigned_to" style="width: 250px; margin-top: 15px;">
                                               <?php $members = DB::table('employees')->where('departmentid','=', '21238070')->get(); ?>
                                                <option value=" "> </option>
                                                @foreach ($members AS $member)
                                                <option name="assigned_to" value="{{ $member->uid }}">{{ $member->fname }} {{ $member->lname}}</option>
                                                @endforeach
                                        </select>
                                    <br><button type="submit" name="send" style="width: 79px;"><i class="fa fa-send-o"></i>&nbsp; Assign</button>
                                </fieldset>
                                </form>
                            </div><br>
                            
                            <div style="float: left;">
                                <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" onclick="displayResult()">
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    * Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                </fieldset>
                                </form>    
                           </div>
                            </fieldset>
                            </div>
                        <!----- if assigned ----->
                     <?php    }
                    }else if($temp->status == 'assigned'){ 
                        if($userId == $temp->created_by){ ?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend><strong>Actions</strong></legend>
                                    <div style="float: left;">
                                    <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" enctype="multipart/form-data">    
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" style="color: transparent">
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    *Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                    </form>
                                    </div>
                                </fieldset>
                            </div>
                            
                         <?php   
                        }else if($userId == '21205462'){?>
                            <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend><strong>Actions</strong></legend>
                        
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Assign Job Order</legend>
                                    <span style="font-size: 12px;">The following option allows you to assign or re-assign a particular IT/IS staff <br> which will handle this Job Order: </span>

                                    <select class="form-control" name="assigned_to" value="{{ $temp->assigned_to }}" style="width: 250px; margin-top: 15px;">
                                            <?php $members = DB::table('employees')->where('departmentid','=', '21238070')->get(); ?>
                                            <?php $assign = \App\Employee::where('uid', $temp->assigned_to)->first(); ?>
                                            <option value="{{ $temp->assigned_to }}" selected>{{ $assign->fname }} {{ $assign->lname}}</option>
                                            @foreach($members AS $member)
                                                <?= ($member->uid == $temp->assigned_to ? '' : '<option value="'.$member->uid.'">'.$member->fname. ' ' .$member->lname.'</option>') ?>
                                            @endforeach
                                            
                                    </select>
                                    <br><button type="submit" name="send" style="width: 79px;"><i class="fa fa-send-o"></i>&nbsp; Assign</button>
                                </fieldset>
                                </form>    
                            </div><br>
                            
                            <div style="float: left;">
                                <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    * Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                </fieldset>
                                </form>    
                            </div>
                            </fieldset>
                           </div>
                        <!----if user = assigned to---->
                    <?php }else if($userId == $temp->assigned_to){?>
                         <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend><strong>Actions</strong></legend>
                        
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Change Status</legend>
                                    <span style="font-size: 12px;">The following option allows you to change the status whether the job order is <br>in progress or not</span>

                                    <select class="form-control" name="status" id="status" style="width: 250px; margin-top: 15px;">
                                         <option value=" "> </option>
                                         <option value="ongoing">In Progress</option>
                                    </select>
                                 
                                    <br><button type="submit" name="send" style="width: 90px;"><i class="fa fa-send-o"></i>&nbsp; Submit</button>
                                </fieldset>
                                </form>    
                            </div><br>
                            
                            <div style="float: left;">
                                <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    * Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                </fieldset>
                                </form>    
                            </div>
                            </fieldset>
                           </div>
                        <!----if ongoing status----->
                   <?php }
               }else if($temp->status == 'ongoing'){ 
                   if($userId == $temp->created_by){ ?>
                        <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend><strong>Actions</strong></legend>
                                                    
                            <div style="float: left;">
                                <form role="form" method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    * Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                </fieldset>
                                </form>    
                            </div>
                            </fieldset>
                           </div>
                  <?php }else if($userId == '21205462'){?>
                       <div class="box-body" style="float: right; margin-right: 40px; margin-bottom: 30px; border: 1px solid; border-color: #e4e4e4;">
                            <fieldset style="min-height: 100px; min-width: 400px;">
                                <legend><strong>Actions</strong></legend>
                                
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                
                                <fieldset style="min-height: 100px; max-height: 300px; min-width: 400px;  max-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Update Status</legend>
                                    <span style="font-size: 12px;">Below you have the option to <i>Close</i> this Job Order opt to change the due date <br> or deadline: </span>

                                    <select class="form-control" id="status" name="status" style="width: 250px; margin-top: 15px;">
                                        <option name="status" value=""> </option>
                                        <option name="status" value="closed">Close Job Order</option>
                                        <option name="status" value="set_date" id="set_date">Set Due Date</option>
                                    </select><br>
                                    
                                    <div class="input-group date" data-provide="datepicker" name="_deadline" id="deadline" style="width: 250px; float: left; display: none; margin-right: 100px; margin-bottom: 10px;">
                                        <div class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </div>
                                        <input type="text" name="deadline" class="form-control pull-right"/>
                                    </div>
                                    
                                    <button type="submit" name="send" style="width: 90px;"><i class="fa fa-send-o"></i>&nbsp; Update</button>
                                </fieldset>
                                </form>
                            </div><br>    
                        
                            <div style="float: left;">
                                <form method="POST" action="{{ asset('/joborder/status') }}" role="form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" value="{{$temp->id}}" name="id">
                                    <input type="hidden" value="{{$temp->type}}" name="type">
                                    <input type="hidden" value="{{$temp->priority}}" name="priority">
                                    <input type="hidden" value="{{$temp->title}}" name="title">
                                    <input type="hidden" value="{{$temp->description}}" name="description">
                                    <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                    <input type="hidden" value="{{$temp->status}}" name="status">
                                    <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                    <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                    <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px; margin-bottom: 30px;">
                                    <legend style="font-size: 15px;">Assign Job Order</legend>
                                    <span style="font-size: 12px;">The following option allows you to assign or re-assign a particular IT/IS staff <br> which will handle this Job Order: </span>

                                    <select class="form-control" name="assigned_to" value="{{ $temp->assigned_to }}" style="width: 250px; margin-top: 15px;">
                                            <?php $members = DB::table('employees')->where('departmentid','=', '21238070')->get(); ?>
                                            <?php $assign = \App\Employee::where('uid', $temp->assigned_to)->first(); ?>
                                            <option value="{{ $temp->assigned_to }}" selected>{{ $assign->fname }} {{ $assign->lname}}</option>
                                            @foreach($members AS $member)
                                                <?= ($member->uid == $temp->assigned_to ? '' : '<option value="'.$member->uid.'">'.$member->fname. ' ' .$member->lname.'</option>') ?>
                                            @endforeach
                                            
                                    </select>
                                    <br><button type="submit" name="send" style="width: 79px;"><i class="fa fa-send-o"></i>&nbsp; Assign</button>
                                </fieldset>
                                </form>    
                                
                            </div><br><br>
                            
                            <div style="float: left;"> 
                                <form method="POST" action="{{ asset('/joborder/upload') }}" id="upload" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$temp->id}}" name="id">
                                <input type="hidden" value="{{$temp->type}}" name="type">
                                <input type="hidden" value="{{$temp->priority}}" name="priority">
                                <input type="hidden" value="{{$temp->title}}" name="title">
                                <input type="hidden" value="{{$temp->description}}" name="description">
                                <input type="hidden" value="{{$temp->attachments}}" name="attachments">
                                <input type="hidden" value="{{$temp->status}}" name="status">
                                <input type="hidden" value="{{$temp->created_by}}" name="created_by">
                                <input type="hidden" value="{{$temp->assigned_to}}" name="assigned_to">
                                <input type="hidden" value="{{$temp->tid}}" name="tid">
                                <fieldset style="min-height: 100px; min-width: 400px;">
                                    <legend style="font-size: 15px;">Additional Files</legend>
                                    <span style="font-size: 12px;">This will allow you to upload additional files as attachment for this Job Order: </span>
                                    <input type="file" name="attachments[]" id="attachments" multiple>
                                    <button type="submit" name="send" style="width: 79px;"><i class="fa fa-floppy-o"></i>&nbsp; Attach</button>
                                    <div style="font-size: 90%">
                                    * Individual file sizes are limited up to <strong>15MB</strong> only.
                                    </div>
                                </fieldset>
                                </form>    
                            </div>
                            </fieldset>
                           </div>
                <?php  }
            } ?>
                        
                      
                    <div class="box-body" style="float: left; margin-left: 30px; border: 1px solid; border-color: #e4e4e4;">
                        <fieldset style="min-height: 100px; max-height: 100px; min-width: 600px; max-width: 600px; ">
                            <legend><strong>Attachments</strong></legend>
                                
                                <?php 
                                    if($temp->attachments != ' '){
                                    $file = json_decode($temp->attachments); ?>
                                
                                    @foreach($file as $_test)
                                        <span class="fa fa-fw fa-asterisk" style="margin-right: 5px;"></span>
                                        <a href="{{ asset('/joborder/download/'.$_test->attachments.'') }}"><?php echo $_test->attachments ?></a><br>
                                    @endforeach  
                                    <?php } ?>
                        </fieldset>
                    </div>   
                                      
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>   
        </div>   
    </div> 
    
    <div>
        <ul class="nav nav-tabs"> 
            <li style="margin-left: 30px;" class="active">
                <a data-toggle="tab" href="#comment" aria-expanded="true">
                    Comments
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#history" aria-expanded="false">
                    History
                </a>
            </li>
        </ul>
        
        <div class="tab-content">
            <div id="comment" style="margin-left: 30px;" class="tab-pane active">
                    <?php
                        $comments = DB::table('job_order_comments')->where('id', $temp->id)->get();     
                        foreach($comments as $comment){
                            $name = DB::table('employees')->where('uid', $comment->uid)->first();
                            if($comment->private == 0){ ?>
                              <br><table class="table table-bordered" style="width: 755px; margin-bottom: 5px;">
                                    <tr style="background:#cbdaef">
                                        <td><?php echo $name->fname.' '.$name->lname ?><span style="float:right;"><?php echo date("F j, Y - g:i a", strtotime($comment->created_at)); ?></span></td>
                                    </tr>
                                    <tr style="background:#e9eff8">
                                        <td>{{ $comment->comment }}</td>
                                    </tr>
                              </table>
                        <?php    } 
                        }
                    ?>
                <br>              
                <div id="addbutton" style="float: left; display: inline;"><button class="btn btn-primary" onClick="addComment()">Add Comment <i class="fa fa-caret-down"></i></button></div> 
                <div id="removebutton" style="float: left; display: none;"><button class="btn btn-primary" onClick="addComment()">Add Comment <i class="fa fa-caret-up"></i></button></div> 
                    <form method="POST" action="{{ asset('/joborder/comment') }}" role="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" value="{{ $temp->id }}" name="id">
                        <input type="hidden" name="uid" class="form-control" value="{{Auth::user()->uid}}">
                        <input type="hidden" name="status" class="form-control" value="added">
                        <br>
                        <div id="add_comment" style="display: none; width: 700px;">
                            <br>
                            <textarea name="comment" class="form-control" style="width: 720px;" placeholder="State your comment here."></textarea><br>
                            <div><button type="submit" class="btn btn-primary">Submit</button>&nbsp;&nbsp;&nbsp;
                                 <input id="private" type="checkbox" name="private" value="1">&nbsp;Private comment
                            </div>    
                        </div>
            </div>
            
            <div id="history" style="margin-left: 30px;" class="tab-pane">
                <div class="box-body">
                    <fieldset class="collapsible">
                            @foreach($histories AS $history)
                            <?php $name = DB::table('employees')->where('uid', $history->uid)->first(); 
                                  $assign = \App\Employee::where('uid', $temp->assigned_to)->first(); 
                                  $due = \App\JobOrderInProgress::where('assignee', $temp->assigned_to)->first(); ?>
                            <table class="table table-bordered" style="width: 755px;"><tr style="background:#e9eff8">
                            <tr><i class="fa fa-paperclip"></i>&nbsp;&nbsp;
                                <?php  
                                if($history->details == 'Assigned to'){
                                    echo '['.date('F j, Y h:i A',strtotime($history->created_at)).'] '.$name->fname.' '.$name->lname.' - '.'<span style="font-weight: bold">'.$history->details. ' ' .$assign->name.'</span>';
                                }elseif($history->details == 'Due date set on'){
                                    echo '['.date('F j, Y h:i A',strtotime($history->created_at)).'] '.$name->fname.' '.$name->lname.' - '.'<span style="font-weight: bold">'.$history->details. ' ' .date('F j,  Y', strtotime($due->date_due)).'</span>';
                                }elseif($history->details == 'New files attached'){
                                    echo '['.date('F j, Y h:i A',strtotime($history->created_at)).'] '.$name->fname.' '.$name->lname.' - '.'<span style="font-weight: bold">'.$history->details. ' ' .$_test->attachments.'</span>';
                                }else{
                                    echo '['.date('F j, Y h:i A',strtotime($history->created_at)).'] '.$name->fname.' '.$name->lname.' - '.'<span style="font-weight: bold">'.$history->details. '</span>'; 
                                }?>
                            </tr>    
                            </table>
                            @endforeach
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box-footer">
        
    </div>
</div>
@endsection

@section('additional_scripts')
<script type="text/javascript">
    function addComment() {
        $('#add_comment').toggle();
        $('#addbutton').toggle();
        $('#removebutton').toggle();
    }
</script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>  
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>
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
    CKEDITOR.replace('ckeditor');
    CKEDITOR.instances.ckeditor1.setData(' ');
});
</script>
<script type="text/javascript">
    $('#status').change(function() {
            if ($(this).val() === 'disapproved') {
                $('#reason').show();
                $('#reason').select();
            } else {
                $('#reason').val('');
                $('#reason').hide();
            }
        });
</script>
 <script>
     $('#status').change(function() {
            if ($(this).val() === 'set_date') {
                $('#deadline').show();
                $('#deadline').select();
            } else {
                $('#deadline').val('');
                $('#deadline').hide();
            }
        });
</script>
<script>
var date = new Date();
date.setDate(date.getDate()-0);

$('#deadline').datepicker({ 
    startDate: date
});
</script>

@endsection