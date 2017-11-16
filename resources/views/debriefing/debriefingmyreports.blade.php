@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/debriefing/store') }}" role="form">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">New Debriefing Report</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> You can click the <i>(SAVE AS DRAFT) </i> button, if you still want to edit your case later. Click <i>(SEND REPORT)</i> to immediately send your case as an email. 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-warning"></i><b> FAILED :</b>
                Please fill in all necessary input fields.
            </div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
            </div>
        @endif

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Created By: <font color="red">*</font></td>
                        <td><input type="hidden" name="name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Supervisor:</td>
                        <td><b>{{ Auth::user()->superior->name }}</b></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Type of Report: <font color="red">*</font></td>
                        <td>
                            <select name="reporttype"  class="form-control" style="width: 300px;">
                                <optgroup label="Select Type">
                                    <option>Debriefing Report</option>
                                    <option>Debriefing Report (Workpool Incharge)</option>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Category: <font color="red">*</font></td>
                        <td>
                            <select name="category"  class="form-control" style="width: 150px;">
                                <optgroup label="Select Category">
                                    <option>Normal</option>
                                    <option>Outage</option>
                                </optgroup>
                           </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Shift Schedule: <font color="red">*</font></td>
                        <td>
                            <select name="shift" class="form-control" style="width: 150px;">
                                <option>0100-1000</option>
                                <option>0200-1100</option>
                                <option>0500-1400</option>
                                <option>0600-1500</option>
                                <option>0700-1600</option>
                                <option>0800-1700</option>
                                <option>0900-1800</option>
                                <option>1000-1900</option>
                                <option>1100-2000</option>
                                <option>1200-2100</option>
                                <option>1300-2200</option>
                                <option>1330-2230</option>
                                <option>1400-2300</option>
                                <option>1500-2400</option>
                                <option>1600-0100</option>
                                <option>1700-0200</option>
                                <option>1800-0300</option>
                                <option>1900-0400</option>
                                <option>2000-0500</option>
                                <option>2100-0600</option>
                                <option>2200-0700</option>
                                <option>2230-0730</option>
                                <option>2300-0800</option>
                                <option>2400-0900</option>
                                <option>RES</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"> Content: <font color="red">*</font></td>
                        <td><textarea name="content" id="editor1" class="ckeditor"> </textarea></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>

        <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <input type="submit" name="save_myrep" class="btn btn-warning" value="Save As Draft">
                <input type="submit" name="send_myrep" class="btn btn-primary" value="Send Report">
            </div>
        </div>
    </div>
</form>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $breakdown['name'] }}</h3>
    </div>
    <div class="box-body">
        <?php $reports=0; ?>
        @foreach($all AS $myreports)
            <?php 
                if($myreports->name == Auth::user()->uid){
                    $reports++;
                }
            ?>
        @endforeach
        <table>
            <tr>
                <td><a href="{{ asset('/debriefing/create') }}"><u>View All Reports</u></a></td>
                <td style="width: 10px;"></td>
                <td><a href="{{ asset('/debriefing/myreports') }}"><u>Your Reports ({{ $reports }})</u></a></td>
            </tr>
        </table>
    </div>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
            <td>
                <form method="POST" action="{{ asset('/debriefing/searchdate') }}" role="form">
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
        <form method="POST" action="{{ asset('/debriefing/reports') }}" role="form">
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
        <div style="float:right;">
            <?php $status_cnt=0;?>
            @foreach($rows AS $row)
                <?php 
                    if($row->status == "Unsent"){$status_cnt++;}
                ?>
            @endforeach
            <font color="red"><b>You have {{ $status_cnt }} unsent <?= ($status_cnt == 1 ? 'report' : 'reports') ?>!</b></font>
        </div>
        <table id="table_breakdown" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    @foreach($breakdown['headers'] as $i => $head)
                    <th style='{{ $breakdown['headerStyle'][$i] }}'>{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rows AS $row)
               <?php
                if($row->status == 'Unsent')
                    $ref = "edit/$row->id";
                if($row->status == 'Sent')
                    $ref = "display/$row->id";
               ?>
                <?php $user = \App\Employee::where('uid', $row->name)->first();?>
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td><a href="{{$ref}}">{{ $row->reporttype }}</a></td>
                        <td>{{ $row->category }}</td>
                        <td>{{ date("F j, Y", strtotime($row->created_at)) }}</td>
                        <td>{{ $row->shift }}</td>
                        <td><center>
                            <?php if ($row->status=="Unsent")
                                    echo '<span class="label label-warning">Unsent</span>'; 
                                  else if ($row->status=="Sent")
                                    echo '<span class="label label-success">Sent</span>'; 
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
        CKEDITOR.replace('reason_editor');
        CKEDITOR.replace('plan_editor');
    });
    
</script>
@endsection


