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
                    @foreach($sast['data'] as $row)
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
                    @foreach($sass as $case)
                    
                    @if($m == 4)
                        <?php $sas = 'april_sas' ?>
                        <?php $calls = 'april_calls' ?>
                        <?php $cr = 'april_cr' ?>
                    @elseif($m == 6)
                        <?php $sas = 'june_sas' ?>
                        <?php $calls = 'june_calls' ?>
                        <?php $cr = 'june_cr' ?>
                    @elseif($m == 7)
                        <?php $sas = 'july_sas' ?>
                        <?php $calls = 'july_calls' ?>
                        <?php $cr = 'july_cr' ?>
                    @elseif($m == 9)
                        <?php $sas = 'sept_sas' ?>
                        <?php $calls = 'sept_calls' ?>
                        <?php $cr = 'sept_cr' ?>
                    @else
                        <?php $sas = strtolower(date('M', mktime(0, 0, 0, $m))).'_sas' ?>
                        <?php $calls = strtolower(date('M', mktime(0, 0, 0, $m))).'_calls' ?>
                        <?php $cr = strtolower(date('M', mktime(0, 0, 0, $m))).'_cr' ?>
                    @endif
                    <tr>
                        <td>{{ $case->team }}</td>
                        <td>{{ $case->$sas }}</td>
                        <td>{{ $case->$calls }}</td>
                        <td>{{ $case->$cr }}</td>
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
                <div id="total" style="height: 400px;"></div>
            </div>
            
            <div class="box-body">
                <div id="sas" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="calls" style="height: 400px;"></div>
            </div>
            <div class="box-body">
                <div id="cr" style="height: 400px;"></div>
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
    CanvasJS.addColorSet("customColorSet1",
     [//colorSet Array
     "#4661EE",
     "#EC5657",
     "#1BCDD1",
     "#8FAABB",
     "#B08BEB",
     "#3EA0DD",
     "#F5A52A",
     "#23BFAA",
     "#FAA586",
     "#EB8CC6",
    ]); 
    var total = new CanvasJS.Chart("total", {
		title:{
			text: "SAS vs. Calls vs. CR%"
		},
                width:1200,
                theme: "theme2",
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_sas ?> },
                                        
                              <?php } ?>
                               ]
                    },
                    
                    {
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_calls ?> },
                                        
                              <?php } ?>
                               ]
                    },
                    
                    {
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_cr,  0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	total.render();
    
     var sas = new CanvasJS.Chart("sas", {
		title:{
			text: "SAS Overview"
		},
                width:1200,
                theme: "theme2",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_sas ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	sas.render();
        
        var calls = new CanvasJS.Chart("calls", {
		title:{
			text: "Calls Overview"
		},
                theme: "theme2",
                width:1200,
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_calls ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	calls.render();
        
        var cr = new CanvasJS.Chart("cr", {
		title:{
			text: "CR% Overview"
		},
                theme: "theme2",
                width:1200,
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($sass as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_cr,  0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	cr.render();
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