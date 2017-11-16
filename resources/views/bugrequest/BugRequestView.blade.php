@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<!-- Default box -->
<form role="form" method="POST" action="store">
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">Create New Bug Request</h2></div><br>
            <div class="alert alert-info alert-dismissable" style="width: 450px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below to create new bug request
            </div>
        </div>
        <div class="box-body">
            <div>
                @if($errors->any())
                <div class="alert alert-danger" aria-hidden="true" style="width: 450px">
                    <p>Warning :</p>
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif
                @if(Session::has('flash_message'))
                <div class="alert alert-success" aria-hidden="true" style="width: 450px">
                    {{ Session::get('flash_message') }}
                </div>
                @endif
            </div>

            <table class="table table-bordered">
                <tbody>
                <th colspan="2" style="font-family: Verdana"><center>Create New Bug Request</center></th>
                
                <tr>
                    <th style="width: 150">Select Category: </th>
                    <td><div class="form-group">
                            <select class="form-control" name="category" style="width: 200px">
                                <option value="">Select Category</option>
                                <option value="MyWebsite">MyWebsite</option>
                                <option value="Webhosting">Webhosting</option>
                                <option value="E-Business">E-Business</option>
                                <option value="Contract Management">Contract Management</option>
                                <option value="Domain">Domain</option>
                                <option value="Control Panel">Control Panel</option>
                                <option value="Mail">Mail</option>
                            </select></div>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150">Subject: </th>
                    <td><input type="text" name="subject" style="width: 350px" class="form-control">
                        <label style="color: red">Format: [Bug Request][Application][Short Description of the issue][Case ID]</label>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150">Customer ID: </th>
                    <td><input type="text" name="customer_id" style="width: 200px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150">Contract ID: </th>
                    <td><input type="text" name="contract_id" style="width: 200px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150">Tech ID: </th>
                    <td><input type="text" name="tech_id" style="width: 350px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150">Domain/URL/Proj.ID: </th>
                    <td><input type="text" name="project_id" style="width: 350px" class="form-control"></td>
                </tr>
                <tr>
                    <th>Date of Occurrence: </th>
                    <td>
                        <div class="input-group date" data-provide="datepicker" style="width: 250px; float: left; ">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" name="date_occurrence" class="form-control pull-right"/>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th style="padding-top: 70px; width: 150px;">Description of the <br>encountered wrong <br>behaviour: </th>
                    <td>
                        <textarea id="ckeditor1" name="description"></textarea>
                    </td>
                </tr>
                <tr>
                    <th style="padding-top: 100px; width: 150px;">Solution Steps: </th>
                    <td>
                        <textarea id="ckeditor2" name="solution"></textarea>
                    </td>
                </tr>
                <tr>
                    <th style="padding-top: 70px; width: 150px;">Expected Behavior: </th>
                    <td>
                        <textarea id="ckeditor3" name="behavior"></textarea>
                    </td>
                </tr>

                <tr>
                    <th style="padding-top: 70px; width: 150px;">Step by step instruction to<br>reproduce the problem: </th>
                    <td>
                        <textarea id="ckeditor4" name="instruction"></textarea>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150px;">Attachments:</th>
                    <td>
                        <input type="file" name="files" id="files" class="form-group"/>
<!--                        <input type="button" id="uploader" value="Add files" class="button1" />-->
                        <div id="file_lists" style="margin: 0">
                            <ul id="lists">
                            </ul>
                        </div>
                        <div style="text-align: left; padding-top: 5px; font-size: 90%">
                            *Individual file sizes are limited up to <strong>15MB</strong> only.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150px;">Browser 1 (Type/Version):</th>
                    <td><input type="text" name="browser1" style="width: 350px" placeholder="Verification with Type/Version" class="form-control"></td>
                </tr>
                <!--<tr>-->
                    <th style="width: 150px;">Browser 2 (Type/Version):</th>
                    <td><input type="text" name="browser2" style="width: 350px" placeholder="Verification with Type/Version" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150px;">Operating System:</th>
                    <td><input type="text" name="os" style="width: 350px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150px;">Add CC Email Recipient:</th>
                    <input type="hidden" name="username" id="uid" />
                    <td>
                        <div class="form-group" style="width: 200px; margin-bottom: 1px;">     
                            <select class="form-control" id="recipient" name="recipient">
                                   <?php $subordinates = Auth::user()->subordinates(); ?>
                                   @foreach ($subordinates AS $subordinate)
                                    <option value="{{ $subordinate->uid }}">{{ $subordinate->name }}</option>
                                    @endforeach
                            </select>  
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td><input type="hidden" name="loggedby" value="{{Auth::user()->uid}}"></td>
                </tr>
                <tr style="display: none">
                    <th style="width: 150px;">Status</th>
                    <td><select class="form-control" name="status" style="width: 200px">
                            <option value="Open">Open</option>
                        </select></td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="box-footer" >
            <div class="foot-area" style="float: right;">
                <button class="btn btn-warning" type="submit" name="save"><i class="fa fa-save"></i> Save As Draft</button>
                <button class="btn btn-primary" type="submit" name="send"><i class="fa fa-send"></i> Submit Now</button>
            </div>
        </div> 
    </div> 
</form>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $breakdown['name'] }}</h3>
    </div>

    <table>
        <tr>
            <td style="width: 885px;"></td>
            <td>
                <form action="filter_date" method="POST" role="form">
                    <tr>
                        <td><div class="input-group date" data-provide="datepicker" style="width: 207px; float: right;">
                            <div class="input-group-addon">
                                From:
                            </div>
                            <input type="text" name="date_from" placeholder="Date From" class="form-control pull-right"/>
                        </div></td>
                        <td><div class="input-group date" data-provide="datepicker" style="width: 207px; float: left; ">
                            <div class="input-group-addon">
                                To:
                            </div>
                            <input type="text" name="date_to" placeholder="Date To" class="form-control pull-right"/>
                        </div></td>
                        <td><div>
                            <span class="input-group-btn">
                                <button class="btn btn-info btn-flat" type="submit"><i class="fa fa-search"></i> Search</button>
                            </span>
                        </div></td>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </tr>
                </form>
            </td>
        </tr>
    </table>

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
                <?php $user = \App\Employee::where('uid', $row->loggedby)->first();?>
                <tr>
                    <td><center><a href="edit/{{$row-> id}}">{{ $row->subject }}</center></td>
                    <td><center>{{ $row->category }}</center></td>
                    <td><center>{{ $user->name }}</center></td>
                    <td><center>{{ date('F j, Y g:i A', strtotime($row->created_at)) }}</center></td>
                    <td><center>
                        <?php
                            if ($row->status == "Open")
                                echo '<span class="label label-primary"> Open </span>';
                            else if ($row->status == "Ticket Created")
                                echo '<span class="label label-info">Ticket Created</span>';
                            else if ($row->status == "Resolved")
                                echo '<span class="label label-success">Resolved</span>';
                        ?>
                    </center></td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
    CKEDITOR.instances.ckeditor1.setData(' ');
    CKEDITOR.instances.ckeditor2.setData(' ');
    CKEDITOR.instances.ckeditor3.setData(' ');
    CKEDITOR.instances.ckeditor4.setData(' ');
});
</script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>
<script>
    $(document).ready(function () {
        $("#status").change(function () {
            var select = document.getElementById("status").value;
            if (select !== "")
                window.location = "sort_category/" + select;
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#status_bug").change(function () {
            var select = document.getElementById("status_bug").value;
            if (select !== "")
                window.location = 'http://localhost/mis-ews/public/bugrequest/sort_status/' + select;
        });
    });
</script>

@endsection