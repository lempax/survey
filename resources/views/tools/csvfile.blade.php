@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $breakdown['name'] }}</h3>
    </div>
    <form method="POST" role="form" action="{{ asset('cases/generate') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
            <div style="padding-bottom: 10px; margin-bottom: 10px;">
                <button type="button" class="btn btn-primary btn-sm" id="daterange" data-toggle="tooltip" title="Date range" style="float: left; margin-left: 5px; height: 34px;">
                    <i class="fa fa-calendar"></i>
                </button>
                <input type="submit" name="generate" class="btn btn-block btn-success" style="width: 200px; float: left; margin-left: 5px;" value="Generate CSV File">
                <span id="date_range_info" class="text-info" style="float: left; font-size: 120%; margin-left: 5px; margin-top: 5px;"></span>
            </div><br>
            </form>
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }} text-align: center;'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($breakdown['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td style="text-align: center;"><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
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