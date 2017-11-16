@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')

<style type="text/css">
    .textdiv{
        float: left; 
        width: 20%;
        padding-right: 15px;
    }

    .area{
        min-height: 300px;
    }

    .foot-area{
        float: right;
        margin-right: 15px;
    }

    .small-input{
        width: 80px;
        float: right;
        margin-top: 5px;
    }
</style>

<div class="box">
    <div class="box-header">
        <form method="POST" role="form" action="{{ asset('sas/generate') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(in_array(Auth::user()->roles, ['MANAGER','SOM', 'SAS']))
            <div class="form-group">
                <select class="form-control" aria-controls="teams" id="team_selection" name="team_selection" style="width: 200px; float: left;"> 
                    <option value="all">All Teams</option>
                    @foreach($team_selection as $id => $team)
                    <option value="{{ $id }}" {{ $id == Request::get('deptid') ? 'selected' : '' }}>{{ $team }}</option>
                    @endforeach
                </select>
                <select class="form-control" aria-controls="weeks" id="week_selector" name="week_selection" style="width: 100px; float: left; margin-left: 5px;">
                    @for ($i = 1; $i <= date('W') - 0; $i++)
                    @if(Request::has('w'))
                    <option value="{{ $i }}" {{ $i == Request::get('w') ? 'selected' : '' }}>Week {{ $i }}</option>
                    @else
                    <option value="{{ $i }}" {{ $i == date('W') ? 'selected' : '' }}>Week {{ $i }}</option>
                    @endif
                    @endfor
                </select>
                <button type="button" class="btn btn-primary btn-sm" id="daterange" data-toggle="tooltip" title="Date range" style="float: left; margin-left: 5px; height: 34px;">
                    <i class="fa fa-calendar"></i>
                </button>
                <span id="date_range_info" class="text-info" style="float: left; font-size: 120%; margin-left: 5px; margin-top: 5px;"></span>
            </div>
            @endif
            <br>
            </div>
            <div class="box-body">
                <table id="table_breakdown" class="table table-bordered table-hover table-striped" style='width: 40%; margin-left: 0;'>
                    <thead>
                        <tr>
                            <th>Select Type of Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="fo_go" style="margin-right: 7px;" id="optionsRadios1"> FO vs. GO
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="sas_breakdown" style="margin-right: 7px;" id="optionsRadios1"> FO, GO, TC Breakdown
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> Sales Agent Cebu
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> SAS Focus Product
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> SAS Week on Week
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> Featured Products
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> Gross Products
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="radio">
                                    <label style="font-weight: bold;">
                                        <input type="radio" name="type" value="domain" style="margin-right: 7px;" id="optionsRadios1"> Tariff Change
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" name="generate" class="btn btn-block btn-success" style="width: 200px; float: left; margin-top: 10px;" value="Generate">
                </form>
            </div>
    </div>
    <!-- /.box -->
    @endsection

    @section('additional_scripts')
    <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
    <script>
$(function () {
    //$('#table_breakdown').DataTable();
    $('#daterange').daterangepicker({
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Week': [moment().startOf('isoweek'), moment().endOf('isoweek')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().startOf('isoweek'),
        endDate: moment().endOf('isoweek')
    }, function (start, end) {
        var url = '{{ url("/overallweekly")  }}' + '?date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
        //oTable.ajax.url(url).load();
        $('#date_range_info').html("<strong>[Date: &nbsp;" + start.format('MMMM DD, YYYY') + "</strong>&nbsp; - &nbsp;<strong>" + end.format('MMMM DD, YYYY') + "]</strong> <input type='hidden' name='date_from' value=" + start.format('YYYY-MM-DD') + "> <input type='hidden' name='date_to' value=" + end.format('YYYY-MM-DD') + ">");
    });
});
    </script>

    @endsection