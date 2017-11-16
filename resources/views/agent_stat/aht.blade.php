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
                    @foreach($aht_sum['data'] as $row)
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
                    @foreach($aht as $case)
                    
                    @if($m == 4)
                        <?php $login = 'april_login' ?>
                        <?php $aht_out = 'april_aht_out' ?>
                        <?php $in_out = 'april_in_out' ?>
                        <?php $aht_in = 'april_aht_in' ?>
                    @elseif($m == 6)
                        <?php $login = 'june_login' ?>
                        <?php $aht_out = 'june_aht_out' ?>
                        <?php $in_out = 'june_in_out' ?>
                        <?php $aht_in = 'june_aht_in' ?>
                    @elseif($m == 7)
                        <?php $login = 'july_login' ?>
                        <?php $aht_out = 'july_aht_out' ?>
                        <?php $in_out = 'july_in_out' ?>
                        <?php $aht_in = 'july_aht_in' ?>
                    @elseif($m == 9)
                        <?php $login = 'sept_login' ?>
                        <?php $aht_out = 'sept_aht_out' ?>
                        <?php $in_out = 'sept_in_out' ?>
                        <?php $aht_in = 'sept_aht_in' ?>
                    @else
                        <?php $login = strtolower(date('M', mktime(0, 0, 0, $m))).'_login' ?>
                        <?php $aht_out = strtolower(date('M', mktime(0, 0, 0, $m))).'_aht_out' ?>
                        <?php $in_out = strtolower(date('M', mktime(0, 0, 0, $m))).'_in_out' ?>
                        <?php $aht_in = strtolower(date('M', mktime(0, 0, 0, $m))).'_aht_in' ?>
                    @endif
                    <tr>
                        <td>{{ $case->team }}</td>
                        <td>{{ $case->$login }}</td>
                        <td>{{ $case->$aht_out }}</td>
                        <td>{{ $case->$in_out }}</td>
                        <td>{{ $case->$aht_in }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endfor
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