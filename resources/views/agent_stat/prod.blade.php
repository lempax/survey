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
                    @foreach($prods as $case)
                    
                    @if($m == 4)
                        <?php $diff = 'april_diff' ?>
                        <?php $email = 'april_email' ?>
                        <?php $sse = 'april_sse' ?>
                        <?php $calls = 'april_calls' ?>
                        <?php $prod = 'april_prod' ?>
                    @elseif($m == 6)
                        <?php $diff = 'june_diff' ?>
                        <?php $email = 'june_email' ?>
                        <?php $sse = 'june_sse' ?>
                        <?php $calls = 'june_calls' ?>
                        <?php $prod = 'june_prod' ?>
                    @elseif($m == 7)
                        <?php $diff = 'july_diff' ?>
                        <?php $email = 'july_email' ?>
                        <?php $sse = 'july_sse' ?>
                        <?php $calls = 'july_calls' ?>
                        <?php $prod = 'july_prod' ?>
                    @elseif($m == 9)
                        <?php $diff = 'sept_diff' ?>
                        <?php $email = 'sept_email' ?>
                        <?php $sse = 'sept_sse' ?>
                        <?php $calls = 'sept_calls' ?>
                        <?php $prod = 'sept_prod' ?>
                    @else
                        <?php $diff = strtolower(date('M', mktime(0, 0, 0, $m))).'_diff' ?>
                        <?php $email = strtolower(date('M', mktime(0, 0, 0, $m))).'_email' ?>
                        <?php $sse = strtolower(date('M', mktime(0, 0, 0, $m))).'_sse' ?>
                        <?php $calls = strtolower(date('M', mktime(0, 0, 0, $m))).'_calls' ?>
                        <?php $prod = strtolower(date('M', mktime(0, 0, 0, $m))).'_prod' ?>
                    @endif
                    <tr>
                        <td>{{ $case->team }}</td>
                        <td>{{ $case->$diff }}</td>
                        <td>{{ $case->$email }}</td>
                        <td>{{ $case->$sse }}</td>
                        <td>{{ $case->$calls }}</td>
                        <td>{{ $case->$prod }}</td>
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
                <div id="call_diff" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="email" style="height: 400px;"></div>
            </div>
            <div class="box-body">
                <div id="sse" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="call" style="height: 400px;"></div>
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
     var call_diff = new CanvasJS.Chart("call_diff", {
		title:{
			text: "Call Difference Overview"
		},
                width:1200,
                theme: "theme2",
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($prods as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_diff ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	call_diff.render();
        
        var email = new CanvasJS.Chart("email", {
		title:{
			text: "Emails Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($prods as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_email ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	email.render();
        
        var sse = new CanvasJS.Chart("sse", {
		title:{
			text: "SSE Calls Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($prods as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_sse ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	sse.render();
        
        var call = new CanvasJS.Chart("call", {
		title:{
			text: "Calls Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($prods as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_calls ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	call.render();
        
        var prod = new CanvasJS.Chart("prod", {
		title:{
			text: "Productivity Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet:  "customColorSet1",
                animationEnabled: true,
		data: [
		{
			type: "column",
                          dataPoints: [
                              <?php foreach($prods as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= $case->jan_prod ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	prod.render();
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