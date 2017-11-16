@extends('layouts.master')

@section('additional_styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script type="text/javascript" src="{{ asset ("/canvasjs/canvasjs.min.js") }}"></script>
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6">
                    <form method="POST" id="search-form" class="form-inline" role="form">
                        @if(in_array(Auth::user()->roles, ['MANAGER','SOM']))
                        <div class="form-group">
                            <select class="form-control" aria-controls="teams" id="team_selection" name="team_selection">
                                <option value="all">All Teams</option>
                                @foreach($team_selection as $id => $team)
                                <option value="{{ $id }}" {{ $id == Request::get('deptid') ? 'selected' : '' }}>{{ $team }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <select class="form-control" aria-controls="weeks" id="week_selector" name="week_selection">
                                @for ($i = 1; $i <= date('W') - 0; $i++)
                                @if(Request::has('w'))
                                <option value="{{ $i }}" {{ $i == Request::get('w') ? 'selected' : '' }}>Week {{ $i }}</option>
                                @else
                                <option value="{{ $i }}" {{ $i == date('W') ? 'selected' : '' }}>Week {{ $i }}</option>
                                @endif
                                @endfor
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div id="textHeader" class="text-right" style="font-size: 150%; font-weight: bold"></div>
                </div>
            </div>
            <div class="box-body">
                <div id="overviewContainer" style="height: 400px; width: 100%;"></div>
            </div>
        </div>

        @if(isset($breakdown))
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
            </div>
            <div class="box-body">
                <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            @foreach($breakdown['headers'] as $i => $head)
                            <th style='{{ $breakdown['headerStyle'][$i] }}}'>{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($breakdown['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @if(isset($overview_table))
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $overview_table['name'] }}</h3>
            </div>
            <div class="box-body">
                <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            @foreach($overview_table['headers'] as $i => $head)
                            <th style='{{ $overview_table['headerStyle'][$i] }}}'>{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($overview_table['data'] as $row)
                        <tr>
                            @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    <!-- /.box -->
</div>
</div>
@endsection


@section('additional_scripts')
<!-- DataTables -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<!-- SlimScroll -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<!-- FastClick -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script>
window.onload = function () {
var overview = new CanvasJS.Chart("overviewContainer",
{
title: {
text: "{{ $overview['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
},
        animationEnabled: true,
        axisY: {
        title: "{{ $overview['yLabel'] }}"
        },
        legend: {
        verticalAlign: "bottom",
                horizontalAlign: "center"
        },
        theme: "theme2",
        data: [
        {
        click: function(e){
        if (e.dataPoint.z !== 0) {
        var queryParameters = {}, queryString = location.search.substring(1),
                re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
        while (m = re.exec(queryString)) {
        queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
        }

// Add new parameters or update existing ones
        queryParameters['deptid'] = 'deptid';
        queryParameters['deptid'] = e.dataPoint.z;
        location.search = $.param(queryParameters);
        }
        },
                type: "column",
                showInLegend: true,
                legendMarkerColor: "grey",
                legendText: "{{ $overview['xLabel'] }}",
                dataPoints: [
<?php foreach ($overview['data'] as $i => $data): ?>
                    {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                ]
        }
        ]
});
overview.render();
}
$(function () {
$('#textHeader').text($('select[name=team_selection] option:selected').text());
$('#table_breakdown').DataTable();
});
$("#week_selector").change(function() {
if ($('select[name=team_selection]').val() == 'all')
        window.location = "{{ url('/') . '/' . $perfurl }}?w=" + $(this).val();
else
        window.location = "{{ url('/') . '/' . $perfurl }}?deptid=" + $('select[name=team_selection]').val() + "&w=" + $(this).val();
});
$("#team_selection").change(function() {
var queryParameters = {}, queryString = location.search.substring(1),
        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
while (m = re.exec(queryString)) {
queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
}

// Add new parameters or update existing ones
queryParameters['deptid'] = 'deptid';
queryParameters['deptid'] = $(this).val();
location.search = $.param(queryParameters);
});
$('.daterange').daterangepicker({
ranges: {
'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Week': [moment().startOf('isoweek'), moment().endOf('isoweek')],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: @if(Request::has('date_start')) moment('{{ Request::get('date_start') }}') @else moment().startOf('isoweek') @endif,
        endDate: @if(Request::has('date_end')) moment('{{ Request::get('date_end') }}') @else moment().endOf('isoweek') @endif
}, function (start, end) {
if ($('select[name=team_selection]').val() == 'all') {
window.location = '{{ url("/") . "/" . $perfurl }}?date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
} else
        window.location = "{{ url('/') . '/' . $perfurl }}?deptid=" + $('select[name=team_selection]').val() + '&date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
});
</script>
@endsection