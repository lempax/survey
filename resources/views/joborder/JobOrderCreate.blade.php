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
                    Create New Jobs
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#view" aria-expanded="false">
                    View Job Listings
                </a>
            </li>
    </ul>
    <div class="tab-content">
        <div id="create" class="tab-pane active">
        <form role="form" method="POST" action="store" enctype="multipart/form-data">
            <div>
                <div class="box-header with-border">
                    <div><h2 class="box-title" style="font-size: 20px;">Create New Order</h2></div><br>
                    <div class="alert alert-info alert-dismissable"  style="width: 500px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        This page will let you create new Job Order for your desired project. 
                    </div>
                </div>
                <div class="box-body">
                    <div>
                        @if($errors->any())
                        <div class="alert alert-danger" aria-hidden="true" style="width: 500px;">
                            <p>Warning :</p>
                            @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif
                        @if(Session::has('flash_message'))
                        <div class="alert alert-success" aria-hidden="true" style="width: 500px;">
                            {{ Session::get('flash_message') }}
                        </div>
                        @endif
                    </div>

                    <table class="table table-bordered" style="width:850px;">
                        <tbody>
                        <th colspan="2" style="font-family: Verdana"><center>Create Job Order</center></th>

                        <tr style="display: none">
                            <th style="width: 150px">Logged By: </th>
                            <td><input type="hidden" name="created_by" class="form-control" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                        </tr>

                        <tr>
                            <th style="width: 150px">Title: </th>
                            <td><input type="text" name="title" style="width: 300px" class="form-control"></td>
                        </tr>
                        <tr>
                            <th style="width: 150px">Type: </th>
                            <td><select class="form-control" name="type" style="width: 250px">
                                    <option value=" ">Select Job Type</option>
                                    <option value="isdev">IS Development</option>
                                    <option value="itserv">IT Services</option>
                                    <option value="misc">Miscellaneous</option>
                            </select></td>
                        </tr>
                        <tr>
                            <th style="width: 150px">Severity: </th>
                            <td><select class="form-control" name="priority" style="width: 250px">
                                    <option value=" ">Select Job Priority</option>
                                    <option value="minor">Minor</option>
                                    <option value="major">Major</option>
                                    <option value="critical">Critical</option>
                            </select></td>
                        </tr>
                        <tr>
                            <th style="width: 150px">Description: </th>
                            <td><textarea id="ckeditor" name="description"></textarea></td>
                        </tr>
                        <tr>
                            <th style="width: 150px;">Attachments: </th>
                            <td><input type="file" name="attachments" id="attachments">
                            <div style="font-size: 90%">
                                * Individual file sizes are limited up to <strong>15MB</strong> only.
                            </div></td>
                        </tr>
                        <tr style="display:none">
                            <th style="width: 150px;">Status: </th>
                            <td><input type="text" name="status" value="pending"></td>
                        </tr>
                        <tr style="display:none">
                            <th>TID:</th>
                            <td><input type="hidden" name="tid" value="<?php echo substr(number_format(time() * rand(), 0, '', ''), 0, 10); ?>"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="box-footer">
                        <div class="foot-area" style="float: right; margin-right: 280px;">
                            <button class="btn btn-primary" type="submit" name="send"><i class="fa fa-floppy-o"></i>&nbsp; Create Job</button>
                        </div>
                    </div> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                </div>
            </div> 
        </form>
        </div>
        
        <div id="view" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
                <h5> Shows all the Job Orders/Listings created by each department. </h5>
            </div>
            
            <div class="box-body">     
                <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            @foreach($breakdown['headers'] as $i => $head)
                            <th style='{{ $breakdown['headerStyle'][$i] }}'><center>{{ $head }}</center></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <?php $user = \App\Employee::where('uid', $row->created_by)->first();
                              $itemName = \App\ItemInventory::where('id', $row ->item_id)->first();
                        ?>
                        <tr>
                            <td><center><a href="view/{{$row->id}}">{{ $row-> title }}</center></td>
                            <td><center>
                                <?php
                                    if ($row->type == "isdev")
                                        echo 'IS Developer';
                                    else if ($row->type == "itserv")
                                        echo 'IT Services';
                                    else if ($row->type == "misc")
                                        echo 'Miscellaneous';
                                ?>
                            </center></td>
                            <td><center>{{ $user-> name }}</center></td>
                            <td><center>
                                <?php
                                    if ($row->priority == "minor")
                                        echo '<span style="color:gold; font-weight: bold;">MINOR</span>';
                                    else if ($row->priority == "major")
                                        echo '<span style="color:salmon; font-weight: bold">MAJOR</span>';
                                    else if ($row->priority == "critical")
                                        echo '<span style="color:red; font-weight: bold;">CRITICAL</span>';
                                ?>
                            </center></td>
                            <td><center>{{ date('F j,  Y', strtotime($row->created_at)) }}</center></td>
                            <td><center>
                                <?php 
                                    if($row->status == "pending") echo 'Pending';
                                    else if ($row->status == "approved") echo 'Approved';
                                    else if ($row->status == "disapproved") echo 'Dispproved';
                                    else if ($row->status == "assigned") echo 'Assigned';
                                    else if ($row->status == "ongoing") echo 'In Progress';
                                    else if ($row->status == "closed") echo 'Closed';
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
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
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

@endsection