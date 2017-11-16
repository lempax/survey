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
    #table td
    {
        padding: 0px !important;
    }
    input
    {
        height: 100% !important;
        width: 100% !important; 
        outline:none !important;
        text-align: center !important;
        padding: 0 !important;
    }
    .quarter{
        width: 40px;
        border: none;
        background: transparent;
        padding: 0 !important;
    }
    
    .comment{
        width: 100%;
        border: none;
        background: transparent;
        padding: 0 !important;
    }
    
    table td, th{
        text-align: center;
        border:1px solid #ccc !important;
        padding: 0 ;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button 
    { 
    -webkit-appearance: none; 
    margin: 0; 
    }
</style>

@endsection


@section ('content')
<meta name ="csrf-token" content = "{{ csrf_token() }}"/>
<div class="box">
    <div class="box-body">
        @if(isset($supId))
        <form action="../createtarget/addtargetforsup" method="POST">
            {{ csrf_field() }}
            <input type="text" name="supId" value="{{ $supId }}" hidden>
        @else
        <form action="../coachingtarget/createtarget/addtarget" method="POST">
            {{ csrf_field() }}
        @endif
            <table style="width:100%;" id="table1" class="table table-hover table-striped" cellpadding="0">
                <tr>
                    <th></th>
                    <th colspan="8" class="text-center">Targets</th>
                    <th colspan="4" class="text-center">Results</th>
                    <th colspan="4" class="text-center">%Results</th>
                </tr>
                <tr>
                    <th style="width: 15%;">Employee</th>
                    <th>Q1</th>
                    <th>Comments</th>
                    <th>Q2</th>
                    <th>Comments</th>
                    <th>Q3</th>
                    <th>Comments</th>
                    <th>Q4</th>
                    <th> Comments</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                    <th>Q1%</th>
                    <th>Q2%</th>
                    <th>Q3%</th>
                    <th>Q4%</th>
                </tr>
                <?php
                    $counter = 0;
                    $rowCounter = 0;
                ?>
                @foreach($agents as $agent)
                <tr>
                    <td class="text-left">{{ $agent->lname.', '.$agent->fname }}<input type="text" hidden name="content[{{$counter}}][uid]" value="{{$agent->uid}}"></td>
                    <td><input type="number" name="content[{{$counter}}][q1]" class="quarter q1 row{{$rowCounter}}"></td>
                    <td><input type="text" name="content[{{$counter}}][q1comment]" class="comment"></td>
                    <td><input type="number" name="content[{{$counter}}][q2]" class="quarter q2 row{{$rowCounter}}"></td>
                    <td><input type="text" name="content[{{$counter}}][q2comment]" class="comment"></td>
                    <td><input type="number" name="content[{{$counter}}][q3]" class="quarter q3 row{{$rowCounter}}"></td>
                    <td><input type="text" name="content[{{$counter}}][q3comment]" class="comment"></td>
                    <td><input type="number" name="content[{{$counter}}][q4]" class="quarter q4 row{{$rowCounter}}"></td>
                    <td><input type="text" name="content[{{$counter}}][q4comment]" class="comment"></td>
                    <td><input type="number" name="content[{{$counter}}][rq1]" class="quarter rq1 row{{$rowCounter}}"></td>
                    <td><input type="number" name="content[{{$counter}}][rq2]" class="quarter rq2 row{{$rowCounter}}"></td>
                    <td><input type="number" name="content[{{$counter}}][rq3]" class="quarter rq3 row{{$rowCounter}}"></td>
                    <td><input type="number" name="content[{{$counter}}][rq4]" class="quarter rq4 row{{$rowCounter}}"></td>
                    <td><input type="text" class="quarter rq1p row{{$rowCounter}}" disabled></td>
                    <td><input type="text" class="quarter rq2p row{{$rowCounter}}" disabled></td>
                    <td><input type="text" class="quarter rq3p row{{$rowCounter}}" disabled></td>
                    <td><input type="text" class="quarter rq4p row{{$rowCounter}}" disabled></td>
                </tr>
                <?php
                    $counter++;
                    $rowCounter++;
                ?>
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
                <input type='text' id="totalq1" name="totalq1" value="" hidden>
                <input type='text' id="totalq2" name="totalq2" value="" hidden>
                <input type='text' id="totalq3" name="totalq3" value="" hidden>
                <input type='text' id="totalq4" name="totalq4" value="" hidden>
                <input type='text' id="totalrq1" name="totalrq1" value="" hidden>
                <input type='text' id="totalrq2" name="totalrq2" value="" hidden>
                <input type='text' id="totalrq3" name="totalrq3" value="" hidden>
                <input type='text' id="totalrq4" name="totalrq4" value="" hidden>
                <input type='text' id="totalrq1p" name="totalrq1p" value="" hidden>
                <input type='text' id="totalrq2p" name="totalrq2p" value="" hidden>
                <input type='text' id="totalrq3p" name="totalrq3p" value="" hidden>
                <input type='text' id="totalrq4p" name="totalrq4p" value="" hidden>
            </table>
            <br>
            <button type="submit" class="btn btn-block btn-primary">Create Report</button>
        </form>
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
    $('input[type=number]').on('input', function(){
        
       if($(this).val() >= 1)
       {
            var sumq1 = 0;
            $('.q1').each(function(){
                if($(this).val())
                {
                 sumq1 += parseInt($(this).val());
                }
            });
            $('#tq1').text(sumq1);
            $("#totalq1").val(sumq1);

            var sumq2 = 0;
            $('.q2').each(function(){
                if($(this).val())
                {
                 sumq2 += parseInt($(this).val());
                }
            });
            $('#tq2').text(sumq2);
            $("#totalq2").val(sumq2);

            var sumq3 = 0;
            $('.q3').each(function(){
                if($(this).val())
                {
                 sumq3 += parseInt($(this).val());
                }
            });
            $('#tq3').text(sumq3);
            $("#totalq3").val(sumq3);

            var sumq4 = 0;
            $('.q4').each(function(){
                if($(this).val())
                {
                 sumq4 += parseInt($(this).val());
                }
            });
            $('#tq4').text(sumq4);
            $("#totalq4").val(sumq4);

             var sumrq1 = 0;
            $('.rq1').each(function(){
                if($(this).val())
                {
                 sumrq1 += parseInt($(this).val());
                }
            });
            $('#trq1').text(sumrq1);
            $("#totalrq1").val(sumrq1);

            var sumrq2 = 0;
            $('.rq2').each(function(){
                if($(this).val())
                {
                 sumrq2 += parseInt($(this).val());
                }
            });
            $('#trq2').text(sumrq2);
            $("#totalrq2").val(sumrq2);

            var sumrq3 = 0;
            $('.rq3').each(function(){
                if($(this).val())
                {
                 sumrq3 += parseInt($(this).val());
                }
            });
            $('#trq3').text(sumrq3);
            $("#totalrq3").val(sumrq3);

            var sumrq4 = 0;
            $('.rq4').each(function(){
                if($(this).val())
                {
                 sumrq4 += parseInt($(this).val());
                }
            });
            $('#trq4').text(sumrq4);
            $("#totalrq4").val(sumrq4);

            var counter = 0;
            $('.rq1p').each(function()
            {
                 var result = parseInt($('.rq1.row'+counter).val());
                 var target = parseInt($('.q1.row'+counter).val());
                 var percentage = (result / target).toFixed(2) * 100;
                 if(typeof percentage === "number" && percentage >= 1)
                 {
                     $('.rq1p.row' +counter+ '').val(percentage+'%');
                 }
                 counter++;
            });

            var counter = 0;
            $('.rq2p').each(function()
            {
                 var result = parseInt($('.rq2.row'+counter).val());
                 var target = parseInt($('.q2.row'+counter).val());
                 var percentage = (result / target).toFixed(2) * 100;
                 if(typeof percentage === "number" && percentage >= 1)
                 {
                     $('.rq2p.row' +counter+ '').val(percentage+'%');
                 }
                 counter++;
            });

            var counter = 0;
            $('.rq3p').each(function()
            {
                 var result = parseInt($('.rq3.row'+counter).val());
                 var target = parseInt($('.q3.row'+counter).val());
                 var percentage = (result / target).toFixed(2) * 100;
                 if(typeof percentage === "number" && percentage >= 1)
                 {
                     $('.rq3p.row' +counter+ '').val(percentage+'%');
                 }
                 counter++;
            });

            var counter = 0;
            $('.rq4p').each(function()
            {
                 var result = parseInt($('.rq4.row'+counter).val());
                 var target = parseInt($('.q4.row'+counter).val());
                 var percentage = (result / target).toFixed(2) * 100;
                 if(typeof percentage === "number" && percentage >= 1)
                 {
                     $('.rq4p.row' +counter+ '').val(percentage+'%');
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
            $('#trq1p').text(trq1p+'%');
            $('#totalrq1p').val(trq1p+'%');
        }
        else
        {
            $('#totalrq1p').val('');
        }
        if(!isNaN(trq2p) && trq2p > 0)
        {
            $('#trq2p').text(trq2p+'%');
            $('#totalrq2p').val(trq2p+'%');
        }
        else
        {
            $('#totalrq2p').val('');
        }
        if(!isNaN(trq3p) && trq3p > 0)
        {
            $('#trq3p').text(trq3p+'%');
            $('#totalrq3p').val(trq3p+'%');
        }
        else
        {
            $('#totalrq3p').val('');
        }
        if(!isNaN(trq4p) && trq4p > 0)
        {
            $('#trq4p').text(trq4p+'%');
            $('#totalrq4p').val(trq4p+'%');
        }
        else
        {
            $('#totalrq4p').val('');
        }
        
        }
        else
        {
            $(this).val('');
        }
    });
</script>
@endsection