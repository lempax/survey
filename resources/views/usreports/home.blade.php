@extends('layouts.master')

@section('additional_styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script type="text/javascript" src="{{ asset ("/canvasjs/canvasjs.min.js") }}"></script>
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">

<style>
    .legend { list-style: none; }
    .legend li { float: left; margin-right: 10px; }
    .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; }
    .legend .superawesome { background-color: #4f81bc; }
    .legend .awesome { background-color: #9bbb58; }
    .legend .kindaawesome { background-color: #c0504e; }
    .legend .prod { background-color: #2F4F4F; }
    .legend .sas { background-color: #2E8B57; }
</style>

@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header" style="border-bottom: 3px solid #d2d6de;">
        <div class="col-left">
            <form method="POST" id="search-form" class="form-inline" role="form">
                <div class="form-group">
                    <select class="form-control" aria-controls="weeks" id="week_selector" name="week_selection" style="width: 150px;">
                        <option>Select Team</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                    <i class="fa fa-calendar"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<div class="nav-tabs-custom" style="width: 100%;">
    <ul class="nav nav-tabs" style="width: 100%;">
        <li class="active"><a href="#tab_1" data-toggle="tab">No Feedback Returns</a></li>
        <li><a href="#tab_2" data-toggle="tab">SAS Low Performers</a></li>
        <li><a href="#tab_3" data-toggle="tab">Release Rate</a></li>
        <li><a href="#tab_4" data-toggle="tab">Absenteeism Report</a></li>
        <li><a href="#tab_5" data-toggle="tab">Agent Sanctions</a></li>
        <li><a href="#tab_6" data-toggle="tab">IDC-BBB Report</a></li>
        <li><a href="#chart" data-toggle="tab">Charts</a></li>
    </ul>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="tab_1" style="width: 100%;">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team #</th>
                        <th>Agent (Last Name, First Name)</th>
                        <th>Numbers of Cases Processed (Calls & Emails)</th>
                        <th>Explanation</th>
                        <th>Supervisor's Action Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Abad, Dohn Rose</td>
                        <td>40 calls, 20 emails</td>
                        <td>This is only a test</td>
                        <td>This is only a test</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Luayon, Alrey</td>
                        <td>50 calls, 60 emails</td>
                        <td>This is only a test</td>
                        <td>This is only a test</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_2" style="width: 100%;">
            <table id="table_breakdown2" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team #</th>
                        <th>Agents (Last Name, First Name)</th>
                        <th>Total Calls of the Week</th>
                        <th>No. of Upsells for the week</th>
                        <th>Explanation</th>
                        <th>Supervisor's Action Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Abad, Dohn Rose</td>
                        <td>40</td>
                        <td>5</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Luayon, Alrey</td>
                        <td>60</td>
                        <td>6</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_3" style="width: 100%;">
            <table id="table_breakdown3" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team #</th>
                        <th>Agents (Last Name, First Name)</th>
                        <th>Release Rate</th>
                        <th>Explanation</th>
                        <th>Supervisor's Action Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Abad, Dohn Rose</td>
                        <td>30%</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Luayon, Alrey</td>
                        <td>20%</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_4" style="width: 100%;">
            <table id="table_breakdown4" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team #</th>
                        <th>Agents (Last Name, First Name)</th>
                        <th>Number of Absences</th>
                        <th>Date (Month, Day, Year) and Type of Absence</th>
                        <th>Reason</th>
                        <th>Supervisor's Action Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Abad, Dohn Rose</td>
                        <td>3</td>
                        <td>June 14, 2017 - VL<br>
                            June 18, 2017 - SL<br>
                            June 25, 2017 - VL
                        </td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Luayon, Alrey</td>
                        <td>4</td>
                        <td>June 14, 2017 - VL
                        </td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_5" style="width: 100%;">
            <table id="table_breakdown5" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th rowspan="2">Team</th>
                        <th rowspan="2">Agent</th>
                        <th colspan="4" class="text-center">Performance Related (Quality Measures)</th>
                        <th colspan="4" class="text-center">Attendance Related</th>
                        <th colspan="4" class="text-center">Behavior Related</th>
                    </tr>
                    <tr>
                        <th>Violations</th>
                        <th>Latest Sanctions</th>
                        <th>Served (M,D,Y)</th>
                        <th>Reset (M,D,Y)</th>
                        <th>Violations</th>
                        <th>Latest Sanctions</th>
                        <th>Served (M,D,Y)</th>
                        <th>Reset (M,D,Y)</th>
                        <th>Violations</th>
                        <th>Latest Sanctions</th>
                        <th>Served (M,D,Y)</th>
                        <th>Reset (M,D,Y)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Luayon, Alrey</td>
                        <td>AWOL</td>
                        <td>VW</td>
                        <td>May 14, 2017</td>
                        <td>June 14, 2017</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Abad, Dohn Rose</td>
                        <td>AWOL</td>
                        <td>VW</td>
                        <td>May 01, 2017</td>
                        <td>June 01, 2017</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_6" style="width: 100%;">
            <table id="table_breakdown6" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team #</th>
                        <th>Date Received (Month, Day, Year)</th>
                        <th>Case ID</th>
                        <th>Situation/Concern/Issue</th>
                        <th>Agent's Action Plan</th>
                        <th>Supervisor's Action Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>June 14, 2017</td>
                        <td>12345676</td>
                        <td>tets</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>June 06, 2017</td>
                        <td>45646456</td>
                        <td>tess</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="chart" style="width: 100%;">
            <div style="border: 1px solid #eee;  padding: 10px 15px 10px 0px; width: 370px; height: 60px;">
                <ul class="legend">
                    <li><span class="superawesome"></span> CRR</li>
                    <li><span class="awesome"></span> Quality</li>
                    <li><span class="kindaawesome"></span> NPS</li>
                    <li><span class="prod"></span> Production</li>
                    <li><span class="sas"></span> SAS</li>
                </ul>
            </div>

            <div class="box-body">
                <div id="calls" style="height: 400px;"></div>
            </div>
            <div class="box-body">
                <div id="prod" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

<script>
$(function () {
    $('#table_breakdown').DataTable();
    $('#table_breakdown2').DataTable();
    $('#table_breakdown3').DataTable();
    $('#table_breakdown4').DataTable();
    $('#table_breakdown5').DataTable();
    $('#table_breakdown6').DataTable();
});
</script>
@endsection