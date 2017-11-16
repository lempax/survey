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
    </div>
</div>
<div class="nav-tabs-custom" style="width: 100%;">
    <ul class="nav nav-tabs" style="width: 100%;">
        <li class="active"><a href="#tab_1" data-toggle="tab">Agent Stack Rank</a></li>
        <li><a href="#tab_2" data-toggle="tab">CRR/Quality/NPS</a></li>
        <li><a href="#tab_3" data-toggle="tab">Productivity</a></li>
        <li><a href="#tab_4" data-toggle="tab">SAS CR%</a></li>
        <li><a href="#tab_5" data-toggle="tab">Average Released per Team</a></li>
        <li><a href="#tab_6" data-toggle="tab">AHT</a></li>
        <li><a href="#chart" data-toggle="tab">Charts</a></li>
    </ul>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="tab_1" style="width: 100%;">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($sr['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_2" style="width: 100%;">
            <table id="table_breakdown2" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($cqn['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_3" style="width: 100%;">
            <table id="table_breakdown3" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($pr['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_4" style="width: 100%;">
            <table id="table_breakdown4" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($sas['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_5" style="width: 100%;">
            <table id="table_breakdown5" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rr['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_6" style="width: 100%;">
            <table id="table_breakdown6" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($aht['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
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
window.onload = function () {
 var calls = new CanvasJS.Chart("calls", {
            title:{
                    text: "CRR vs. Quality vs. NPS"
            },
            width:1200,
            theme: "theme2",
            animationEnabled: true,
            data: [
            {
                    type: "column",
                      dataPoints: [
                          <?php foreach($summary as $case){ ?>
                                    { label: "<?= $case->team ?>", y: <?= $case->cr ?> },

                          <?php } ?>
                           ]
                },
                
                {
                    type: "column",
                      dataPoints: [
                          <?php foreach($summary as $case){ ?>
                                    { label: "<?= $case->team ?>", y: <?= $case->q ?> },

                          <?php } ?>
                           ]
                },
                
                {
                    type: "column",
                      dataPoints: [
                          <?php foreach($summary as $case){ ?>
                                    { label: "<?= $case->team ?>", y: <?= $case->nps ?> },

                          <?php } ?>
                           ]
                }
            ]
    });
    calls.render();
    
    var prod = new CanvasJS.Chart("prod", {
            title:{
                    text: "Productivity vs. SAS"
            },
            width:1200,
            theme: "theme2",
            animationEnabled: true,
            data: [
            {
                type: "column",
                  dataPoints: [
                      <?php foreach($summary as $case){ ?>
                                { label: "<?= $case->team ?>", y: <?= $case->prod ?>, color: "#2F4F4F" },

                      <?php } ?>
                       ]
                },
                {
                type: "column",
                  dataPoints: [
                      <?php foreach($summary as $case){ ?>
                                { label: "<?= $case->team ?>", y: <?= $case->sas ?>, color: "#2E8B57" },

                      <?php } ?>
                       ]
                }
            ]
    });
    prod.render(); 
 }

$(function () {
$('#textHeader').text($('select[name=team_selection] option:selected').text());
$('#table_breakdown').DataTable();
$('#table_breakdown2').DataTable();
$('#table_breakdown3').DataTable();
$('#table_breakdown4').DataTable();
$('#table_breakdown5').DataTable();
$('#table_breakdown6').DataTable();
$('#table_breakdown7').DataTable();
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
});</script>
@endsection