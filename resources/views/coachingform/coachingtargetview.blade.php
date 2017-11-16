@extends ('layouts.master')
@section('additional_styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<!-- Pace style -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/pace/pace.min.css") }}">

<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
<style>
    .quarter{
        width: 40px;
        border: none;
        background: transparent;
    }
    
    .comment{
        width: 100%;
        border: none;
        background: transparent;
    }
    
    table td, th{
        text-align: center;
        border:1px solid #ccc !important;
    }
</style>
@endsection


@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="box">
    <div class="box-body">
            <table style="width:100%;" id="table1" class="table table-bordered table-striped" cellpadding="0">
                <tr>
                    <td></td>
                    <td colspan="8" style="text-align: center"><b>Targets</td>
                    <td colspan="4" style="text-align: center"><b>Results</td>
                    <td colspan="4" style="text-align: center"><b>%Results</td>
                </tr>
                <tr>
                    <td><b>Agent Name</td>
                    <td class="quarter"><b>Q1</td>
                    <td><b>Comments</td>
                    <td style="width:10px;"><b>Q2</td>
                    <td><b>Comments</td>
                    <td style="width:10px;"><b>Q3</td>
                    <td><b>Comments</td>
                    <td style="width:10px;"><b>Q4</td>
                    <td><b>Comments</td>
                    <td><b>Q1</td>
                    <td><b>Q2</td>
                    <td><b>Q3</td>
                    <td><b>Q4</td>
                    <td><b>Q1%</td>
                    <td><b>Q2%</td>
                    <td><b>Q3%</td>
                    <td><b>Q4%</td>
                </tr>
                <?php
                    $counter = 0;
                    $count = count($content[0]);
                    $i = 0;
                    $aCount= count($agents);
                ?>
                @foreach($agents as $agent)
                <tr>
                    @for($i=0;$i<$aCount;$i++)
                        @if(isset($content[0][$i]))
                            @if($content[0][$i]['uid'] == $agent->uid)
                                <td>{{ $agent->lname.', '.$agent->fname }}</td>
                                <td class="q1 row{{$i}}">{{ $content[0][$i]['q1'] }}</td>
                                <td>{{ $content[0][$i]['q1comment'] }}</td>
                                <td class="q2 row{{$i}}">{{ $content[0][$i]['q2'] }}</td>
                                <td>{{ $content[0][$i]['q2comment'] }}</td>
                                <td class="q3 row{{$i}}">{{ $content[0][$i]['q3'] }}</td>
                                <td>{{ $content[0][$i]['q3comment'] }}</td>
                                <td class="q4 row{{$i}}">{{ $content[0][$i]['q4'] }}</td>
                                <td>{{ $content[0][$i]['q4comment'] }}</td>
                                <td class="rq1 row{{$i}}">{{ $content[0][$i]['rq1'] }}</td>
                                <td class="rq2 row{{$i}}">{{ $content[0][$i]['rq2'] }}</td>
                                <td class="rq3 row{{$i}}">{{ $content[0][$i]['rq3'] }}</td>
                                <td class="rq4 row{{$i}}">{{ $content[0][$i]['rq4'] }}</td>
                                <td class="rq1p row{{$i}}"></td>
                                <td class="rq2p row{{$i}}"></td>
                                <td class="rq3p row{{$i}}"></td>
                                <td class="rq4p row{{$i}}"></td>
                                <?php
                                    $counter++;
                                ?>
                            @else
                            @endif
                        @endif
                    @endfor
                </tr>
                @endforeach
                @foreach($nAgents as $newAgent)
                <tr>
                    <td>{{ $newAgent->lname.', '.$newAgent->fname }}</td>
                    <td class="q1 row{{$i}}"></td>
                    <td ></td>
                    <td class="q1 row{{$i}}"></td>
                    <td></td>
                    <td class="q1 row{{$i}}"></td>
                    <td></td>
                    <td class="q1 row{{$i}}"></td>
                    <td></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                    <td class="q1 row{{$i}}"></td>
                </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td colspan="2" style="text-align: center" id="tq1"></td>
                    <td colspan="2" style="text-align: center" id="tq2"></td>
                    <td colspan="2" style="text-align: center" id="tq3"></td>
                    <td colspan="2" style="text-align: center" id="tq4"></td>
                    <td id="trq1"></td>
                    <td id="trq2"></td>
                    <td id="trq3"></td>
                    <td id="trq4"></td>
                    <td id="trq1p"></td>
                    <td id="trq2p"></td>
                    <td id="trq3p"></td>
                    <td id="trq4p"></td>
                </tr>
            </table>
            <br>
            <button type="button" id="edit" class="btn bg-blue"><i class="fa fa-edit"></i> Edit</button>
            <button type="button" id="generate" class="btn bg-green"><i class="fa fa-file-excel-o"></i> Generate in Excel</button>
            <button type="button" id="close" class="btn bg-red"><i class="fa fa-close"></i> Close</button>
    </div>
</div>

@endsection

@section ('additional_scripts')
<!-- DataTables -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<!-- SlimScroll -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<!-- FastClick -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
<!-- PACE -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/pace/pace.min.js") }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

<script>
$(document).ready(function(){
    $("#close").on("click", function() {
        window.location = '../coachingtarget';
    });
    
    $("#edit").on("click", function() {
        window.location = '../coachingtarget/edit/'+<?php echo $report->id; ?>;
    });
    $('#generate').on('click', function(){
            window.location = 'generateteam/'+<?php echo $report->id; ?>;
        });
    
    var sumq1 = 0;
       $('.q1').each(function(){
           if($(this).text())
           {
            sumq1 += parseInt($(this).text());
           }
       });
       $('#tq1').text(sumq1);
       
       var sumq2 = 0;
       $('.q2').each(function(){
           if($(this).text())
           {
            sumq2 += parseInt($(this).text());
           }
       });
       $('#tq2').text(sumq2);
       
       var sumq3 = 0;
       $('.q3').each(function(){
           if($(this).text())
           {
            sumq3 += parseInt($(this).text());
           }
       });
       $('#tq3').text(sumq3);
       
       var sumq4 = 0;
       $('.q4').each(function(){
           if($(this).text())
           {
            sumq4 += parseInt($(this).text());
           }
       });
       $('#tq4').text(sumq4);
       
        var sumrq1 = 0;
       $('.rq1').each(function(){
           if($(this).text())
           {
            sumrq1 += parseInt($(this).text());
           }
       });
       $('#trq1').text(sumrq1);
       
       var sumrq2 = 0;
       $('.rq2').each(function(){
           if($(this).text())
           {
            sumrq2 += parseInt($(this).text());
           }
       });
       $('#trq2').text(sumrq2);
       
       var sumrq3 = 0;
       $('.rq3').each(function(){
           if($(this).text())
           {
            sumrq3 += parseInt($(this).text());
           }
       });
       $('#trq3').text(sumrq3);
       
       var sumrq4 = 0;
       $('.rq4').each(function(){
           if($(this).text())
           {
            sumrq4 += parseInt($(this).text());
           }
       });
       $('#trq4').text(sumrq4);
       
       var counter = 0;
       $('.rq1p').each(function()
       {
            var result = parseInt($('.rq1.row'+counter).text());
            var target = parseInt($('.q1.row'+counter).text());
            var percentage = (result / target).toFixed(2) * 100;
            if(typeof percentage === "number" && percentage >= 1)
            {
                $('.rq1p.row' +counter+ '').text(percentage+'%');
            }
            counter++;
       });
       
       var counter = 0;
       $('.rq2p').each(function()
       {
            var result = parseInt($('.rq2.row'+counter).text());
            var target = parseInt($('.q2.row'+counter).text());
            var percentage = (result / target).toFixed(2) * 100;
            if(typeof percentage === "number" && percentage >= 1)
            {
                $('.rq2p.row' +counter+ '').text(percentage+'%');
            }
            counter++;
       });
       
       var counter = 0;
       $('.rq3p').each(function()
       {
            var result = parseInt($('.rq3.row'+counter).text());
            var target = parseInt($('.q3.row'+counter).text());
            var percentage = (result / target).toFixed(2) * 100;
            if(typeof percentage === "number" && percentage >= 1)
            {
                $('.rq3p.row' +counter+ '').text(percentage+'%');
            }
            counter++;
       });
       
       var counter = 0;
       $('.rq4p').each(function()
       {
            var result = parseInt($('.rq4.row'+counter).text());
            var target = parseInt($('.q4.row'+counter).text());
            var percentage = (result / target).toFixed(2) * 100;
            if(typeof percentage === "number" && percentage >= 1)
            {
                $('.rq4p.row' +counter+ '').text(percentage+'%');
            }
            counter++;
       });
       
       var trq1 = parseInt($('#trq1').text());
            var tq1 = parseInt($('#tq1').text());
            var trq1p = ((parseFloat(trq1)/parseFloat(tq1)) * 100).toFixed(2);
            
            var trq2 = parseInt($('#trq2').text());
            var tq2 = parseInt($('#tq2').text());
            var trq2p = ((parseFloat(trq2)/parseFloat(tq2)) * 100).toFixed(2);
            
            var trq3 = parseInt($('#trq3').text());
            var tq3 = parseInt($('#tq3').text());
            var trq3p = ((parseFloat(trq3)/parseFloat(tq3)) * 100).toFixed(2);
            
            var trq4 = parseInt($('#trq4').text());
            var tq4 = parseInt($('#tq4').text());
            var trq4p = ((parseFloat(trq4)/parseFloat(tq4)) * 100).toFixed(2);
            
            if(!isNaN(trq1p) && trq1p > 0)
            {
                $('#trq1p').text(trq1p+"%");
            }
            if(!isNaN(trq2p) && trq2p > 0)
            {
                $('#trq2p').text(trq2p+"%");
            }
            if(!isNaN(trq3p) && trq3p > 0)
            {
                $('#trq3p').text(trq3p+"%");
            }
            if(!isNaN(trq4p) && trq4p > 0)
            {
                $('#trq4p').text(trq4p+"%");
            }
});

</script>
@endsection