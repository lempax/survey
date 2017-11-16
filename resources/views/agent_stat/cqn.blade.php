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
                        <th>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-gear"> </i>&nbsp;&nbsp; Show Hide Columns</button>
                        <ul id="filter_list" class="dropdown-menu" role="menu" style="height: auto; max-height: 250px; overflow-x: hidden;">
                            <li>
                                <a class="checkbox" data-value=" tabIndex="-1">
                                    <input type="checkbox" name="feed" class="feed_btn" checked="" /> <label class="feedback">Feedback</label>
                                    <input type="checkbox" name="crr" class="crr_btn" style="display: none;"/> <label class="cr"> CRR%</label>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </th>
                @for ($m = 1; $m <= 12; $m++)
                <th class="feed" style="text-transform: uppercase;"> {{ date('M', mktime(0, 0, 0, $m)) }} </th>
                <th class="crr" style="text-transform: uppercase;"> {{ date('M', mktime(0, 0, 0, $m)) }} </th>
                @endfor
                </tr>
                <tr>
                    <th>Team</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                    <th class="crr">CRR</th>
                    <th class="feed">NPS</th>
                </tr>
                </thead>
                <tbody>
                     @foreach($cqn as $case)
                     <tr>
                        <td>{{ $case->team }}</td>
                        <td class="crr">{{ $case->jan_crr }}</td>
                        <td class="feed">{{ $case->jan_nps }}</td>
                        <td class="crr">{{ $case->feb_crr }}</td>
                        <td class="feed">{{ $case->feb_nps }}</td>
                        <td class="crr">{{ $case->mar_crr }}</td>
                        <td class="feed">{{ $case->mar_nps }}</td>
                        <td class="crr">{{ $case->april_crr }}</td>
                        <td class="feed">{{ $case->april_nps }}</td>
                        <td class="crr">{{ $case->may_crr }}</td>
                        <td class="feed">{{ $case->may_nps }}</td>
                        <td class="crr">{{ $case->june_crr }}</td>
                        <td class="feed">{{ $case->june_nps }}</td>
                        <td class="crr">{{ $case->july_crr }}</td>
                        <td class="feed">{{ $case->july_nps }}</td>
                        <td class="crr">{{ $case->aug_crr }}</td>
                        <td class="feed">{{ $case->aug_nps }}</td>
                        <td class="crr">{{ $case->sept_crr }}</td>
                        <td class="feed">{{ $case->sept_nps }}</td>
                        <td class="crr">{{ $case->oct_crr }} </td>
                        <td class="feed">{{ $case->oct_nps }}</td>
                        <td class="crr">{{ $case->nov_crr }}</td>
                        <td class="feed">{{ $case->nov_nps }}</td>
                        <td class="crr">{{ $case->dec_crr }}</td>
                        <td class="feed">{{ $case->dec_nps }}</td>
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
                    @foreach($cqn as $case)
                    
                    @if($m == 4)
                        <?php $feed = 'april_feed' ?>
                        <?php $q = 'april_q' ?>
                        <?php $fcr = 'april_fcr' ?>
                        <?php $crr = 'april_crr' ?>
                        <?php $nps = 'april_nps' ?>
                    @elseif($m == 6)
                        <?php $feed = 'june_feed' ?>
                        <?php $q = 'june_q' ?>
                        <?php $fcr = 'june_fcr' ?>
                        <?php $crr = 'june_crr' ?>
                        <?php $nps = 'june_nps' ?>
                    @elseif($m == 7)
                        <?php $feed = 'july_feed' ?>
                        <?php $q = 'july_q' ?>
                        <?php $fcr = 'july_fcr' ?>
                        <?php $crr = 'july_crr' ?>
                        <?php $nps = 'july_nps' ?>
                    @elseif($m == 9)
                        <?php $feed = 'sept_feed' ?>
                        <?php $q = 'sept_q' ?>
                        <?php $fcr = 'sept_fcr' ?>
                        <?php $crr = 'sept_crr' ?>
                        <?php $nps = 'sept_nps' ?>
                    @else
                        <?php $feed = strtolower(date('M', mktime(0, 0, 0, $m))).'_feed' ?>
                        <?php $q = strtolower(date('M', mktime(0, 0, 0, $m))).'_q' ?>
                        <?php $fcr = strtolower(date('M', mktime(0, 0, 0, $m))).'_fcr' ?>
                        <?php $crr = strtolower(date('M', mktime(0, 0, 0, $m))).'_crr' ?>
                        <?php $nps = strtolower(date('M', mktime(0, 0, 0, $m))).'_nps' ?>
                    @endif
                    <tr>
                        <td>{{ $case->team }}</td>
                        <td>{{ $case->$feed }}</td>
                        <td>{{ $case->$q }}</td>
                        <td>{{ $case->$fcr }}</td>
                        <td>{{ $case->$crr }}</td>
                        <td>{{ $case->$nps }}</td>
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
                <div id="feed" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="crr" style="height: 400px;"></div>
            </div>
            <div class="box-body">
                <div id="fcr" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="q" style="height: 400px;"></div>
            </div>

            <div class="box-body">
                <div id="nps" style="height: 400px;"></div>
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
     CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                "#2F4F4F",
                "#008080",
                "#2E8B57",
                "#3CB371",
                "#90EE90"                
                ]);

     
     var crr = new CanvasJS.Chart("crr", {
		title:{
			text: "CRR Overview"
		},
                width:1200,
                theme: "theme2",
                colorSet: "greenShades",
                animationEnabled: true,
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "doughnut",
                          dataPoints: [
                              <?php foreach($cqn as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_crr, 0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	crr.render();
        
        var feed = new CanvasJS.Chart("feed", {
		title:{
			text: "Feedback Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet: "greenShades",
                animationEnabled: true,
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
                          dataPoints: [
                              <?php foreach($cqn as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_feed, 0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	feed.render();
        
        var nps = new CanvasJS.Chart("nps", {
		title:{
			text: "NPS Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet: "greenShades",
                animationEnabled: true,
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
                          dataPoints: [
                              <?php foreach($cqn as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_nps, 0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	nps.render();
        
        var q = new CanvasJS.Chart("q", {
		title:{
			text: "Quality Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet: "greenShades",
                animationEnabled: true,
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
                          dataPoints: [
                              <?php foreach($cqn as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_q, 0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	q.render();
        
        var fcr = new CanvasJS.Chart("fcr", {
		title:{
			text: "First Contact Resolution Overview"
		},
                theme: "theme2",
                width:1200,
                colorSet: "greenShades",
                animationEnabled: true,
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
                          dataPoints: [
                              <?php foreach($cqn as $case){ ?>
                                        { label: "<?= $case->team ?>", y: <?= substr($case->jan_fcr, 0, -1) ?> },
                                        
                              <?php } ?>
                               ]
                    }
		]
	});
	fcr.render();
 }

$(function () {
    var $feedchk = $(".feed_btn");
    var $crrchk = $(".crr_btn");

    $feedchk.click(function () {
        $('.feed').show();
        $('.crr').hide();
        $('.crr_btn').show();
        $('.feed_btn').hide();
        $('.feedback').hide();
        $('.cr').show();
    });

    $crrchk.click(function () {
        $('.crr').show();
        $('.feed').hide();
        $('.feed_btn').show();
        $('.crr_btn').hide();
        $('.feedback').show();
        $('.cr').hide();
    });

    $('.feed_btn').removeAttr('checked');
    $('.feed').toggle();
    $('.cr').hide();
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