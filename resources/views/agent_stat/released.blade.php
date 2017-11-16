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

<div class="nav-tabs-custom" style="width: 100%;">
    <ul class="nav nav-tabs" style="width: 100%;">
        <li class="active"><a href="#tab_0" data-toggle="tab">Summary</a></li>
        <li><a href="#chart" data-toggle="tab">Charts</a></li>
        @for ($m = 1; $m <= 12; $m++)
        <li><a href="#tab_{{ $m }}" data-toggle="tab" style="text-transform: uppercase;"> {{ date('M', mktime(0, 0, 0, $m)) }} </a></li>
        @endfor
    </ul>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="tab_0" style="width: 100%;">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Team</th>
                        @for ($m = 1; $m <= 12; $m++)
                        <th class="crr" style="text-transform: uppercase;"> {{ date('M', mktime(0, 0, 0, $m)) }} </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($rr_sum['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @for ($m = 1; $m <= 12; $m++)
        <div class="tab-pane" id="tab_{{ $m }}" style="width: 100%;">
            <table id="table_breakdown{{ $m }}" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($header['headers'] as $i => $head)
                        <th style='{{ $header['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rr as $case)
                    
                    @if($m == 4)
                        <?php $total = 'april_total' ?>
                        <?php $calls = 'april_calls' ?>
                        <?php $ave = 'april_ave' ?>
                    @elseif($m == 6)
                        <?php $total = 'june_total' ?>
                        <?php $calls = 'june_calls' ?>
                        <?php $ave = 'june_ave' ?>
                    @elseif($m == 7)
                        <?php $total = 'july_total' ?>
                        <?php $calls = 'july_calls' ?>
                        <?php $ave = 'july_ave' ?>
                    @elseif($m == 9)
                        <?php $total = 'sept_total' ?>
                        <?php $calls = 'sept_calls' ?>
                        <?php $ave = 'sept_ave' ?>
                    @else
                        <?php $total = strtolower(date('M', mktime(0, 0, 0, $m))).'_total' ?>
                        <?php $calls = strtolower(date('M', mktime(0, 0, 0, $m))).'_calls' ?>
                        <?php $ave = strtolower(date('M', mktime(0, 0, 0, $m))).'_ave' ?>
                    @endif
                    <tr>
                        <td>{{ $case->team }}</td>
                        <td>{{ $case->$total }}</td>
                        <td>{{ $case->$calls }}</td>
                        <td>{{ $case->$ave }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endfor
        <div class="tab-pane" id="chart" style="width: 100%;">
             <select class="form-control" style="width: 200px; ">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ date('m', mktime(0, 0, 0, $m)) }}">{{ date('F', mktime(0, 0, 0, $m)) }}</option>
            @endfor
            </select>

            <div class="box-body">
                <div id="calls" style="height: 400px;"></div>
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
                    text: "Calls Overview"
            },
            width:1200,
            theme: "theme2",
            animationEnabled: true,
            data: [
            {
                    type: "column",
                      dataPoints: [
                          <?php foreach($rr as $case){ ?>
                                    { label: "<?= $case->team ?>", y: <?= $case->jan_calls ?> },

                          <?php } ?>
                           ]
                }
            ]
    });
    calls.render(); 
 }
$(function () {
    $('#table_breakdown').DataTable();
    $('#table_breakdown1').DataTable();
    $('#table_breakdown2').DataTable();
    $('#table_breakdown3').DataTable();
    $('#table_breakdown4').DataTable();
    $('#table_breakdown5').DataTable();
    $('#table_breakdown6').DataTable();
    $('#table_breakdown7').DataTable();
    $('#table_breakdown8').DataTable();
    $('#table_breakdown9').DataTable();
    $('#table_breakdown10').DataTable();
    $('#table_breakdown11').DataTable();
    $('#table_breakdown12').DataTable();
});

</script>
@endsection