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
        width: 70px;
        border: none;
        background: transparent;
        padding:0 !important;
    }
    .padding-top
    {
        padding-top: .6% !important;
    }
    .text-center
    {
        text-align: center;
    }
    .comment{
        width: 100%;
        border: none;
        background: transparent;
        padding: 0 !important;
    }
    
    table td, th{
        text-align: left;
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

<?php
    //not inbcluded in team
    $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
        "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
        "Customer Service Offshore UK");
?>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <form id="teamForm" action="" method="post">
                    {{ csrf_field() }}
                <select id="agentForm" class="form-control" name="agentForm">
                    <option value="none" class="w" selected disabled hidden>Select Team</option>
                    @foreach ($teams as $team)
                        @if(in_array($team->name, $nit))
                
                        @else
                        <option value="{{ $team->gid }}" class="w">{{ $team->name }}</option>
                        @endif
                    @endforeach
                </select>
                </form>
            </div>
        </div>
        <table id="teamTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td></td>
                    <td colspan="4" style="text-align: center"><b>Targets</b></td>
                    <td colspan="4" style="text-align: center"><b>Results</b></td>
                    <td colspan="4" style="text-align: center"><b>%Results</b></td>
                </tr>
               <tr>
                   <td>Team Name</td>
                   <td class="quarter padding-top text-center">Q1</td>
                   <td class="quarter padding-top text-center">Q2</td>
                   <td class="quarter padding-top text-center">Q3</td>
                   <td class="quarter padding-top text-center">Q4</td>
                   <td class="quarter padding-top text-center">Q1</td>
                   <td class="quarter padding-top text-center">Q2</td>
                   <td class="quarter padding-top text-center">Q3</td>
                   <td class="quarter padding-top text-center">Q4</td>
                   <td class="quarter padding-top text-center">%Q1</td>
                   <td class="quarter padding-top text-center">%Q2</td>
                   <td class="quarter padding-top text-center">%Q3</td>
                   <td class="quarter padding-top text-center">%Q4</td>
                </tr>
            </thead>
            <tbody id ="tformbody">
                <?php
                    $teamSameAdmin = "";
                    $check = 0;
                ?>
                @foreach($teams as $team)
                @if(in_array($team->name, $nit))
                
                @else
                <tr>
                    <?php
                        $teamSameAdmin = $team->name;
                    ?>
                    @foreach($teams as $team2)
                        @if($team->name != $team2->name)
                            @if($team->admin == $team2->admin)
                                <?php 
                                    $teamSameAdmin .= " & ".$team2->name;
                                    array_push($nit, $team2->name);
                                    $check = 1;
                                ?>
                            @endif
                        @endif
                    @endforeach
                    
                    @if($check == 0)
                    <td>{{ $team->name }}</td>
                    @else
                    <td>{{ $teamSameAdmin }}</td>
                    <?php $check = 0; ?>
                    <?php $teamSameAdmin = ""; ?>
                    @endif
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[1] }}" class="quarter q1" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[2] }}" class="quarter q2" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[3] }}" class="quarter q3" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[4] }}" class="quarter q4" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach  
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[5] }}" class="quarter rq1" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[6] }}" class="quarter rq2" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[7] }}" class="quarter rq3" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[8] }}" class="quarter rq4" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[9] }}" class="quarter rq1p" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach    
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[10] }}" class="quarter rq2p" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach  
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[11] }}" class="quarter rq3p" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                    <td>
                    @foreach($teamReports as $teamReport)
                        @if($teamReport[0]->created_by == $team->admin)
                            <?php 
                                $content = json_decode($teamReport[0]->content, true);
                            ?>
                            <input type="text" value="{{ $content[12] }}" class="quarter rq4p" disabled>
                            <?php 
                                break;
                            ?>
                        @endif
                    @endforeach   
                    </td>
                </tr>
                @endif
                @endforeach
                <tr>
                    <td>Total</td>
                    <td style="text-align: center" id="tq1"></td>
                    <td style="text-align: center" id="tq2"></td>
                    <td style="text-align: center" id="tq3"></td>
                    <td style="text-align: center" id="tq4"></td>
                    <td style="text-align: center" id="trq1"></td>
                    <td style="text-align: center" id="trq2"></td>
                    <td style="text-align: center" id="trq3"></td>
                    <td style="text-align: center" id="trq4"></td>
                    <td style="text-align: center" id="trq1p"></td>
                    <td style="text-align: center" id="trq2p"></td>
                    <td style="text-align: center" id="trq3p"></td>
                    <td style="text-align: center" id="trq4p"></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" class="btn bg-green-gradient btn-sm" id="generate"><i class="fa fa-file-excel-o"></i> Generate in Excel</button>

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
    
    
    $(function () 
    {
        $("#teamTable").DataTable
        ({
            "lengthChange": false,
            "ordering":false,
            "searching":false,
            "paging":false
        });

        
    });
    $(document).ready(function(){
        
        $('#agentForm').on('change', function(){
            $('#teamForm').submit();
        });
        
        $('#generate').on('click', function(){
            window.location = 'coachingtarget/generate';
        });
        
        var sumq1 = 0;
        $('.q1').each(function(){
            if($(this).val())
            {
             sumq1 += parseInt($(this).val());
            }
        });
        $('#tq1').text(sumq1);
        
        var sumq2 = 0;
            $('.q2').each(function(){
                if($(this).val())
                {
                 sumq2 += parseInt($(this).val());
                 console.log(sumq2);
                }
            });
        $('#tq2').text(sumq2);
        
        var sumq3 = 0;
        $('.q3').each(function(){
           if($(this).val())
           {
            sumq3 += parseInt($(this).val());
           }
       });
       $('#tq3').text(sumq3);
       
       var sumq4 = 0;
       $('.q4').each(function(){
           if($(this).val())
           {
            sumq4 += parseInt($(this).val());
           }
       });
       $('#tq4').text(sumq4);
       
        var sumrq1 = 0;
       $('.rq1').each(function(){
           if($(this).val())
           {
            sumrq1 += parseInt($(this).val());
           }
       });
       $('#trq1').text(sumrq1);
       
        var sumrq2 = 0;
       $('.rq2').each(function(){
           if($(this).val())
           {
            sumrq2 += parseInt($(this).val());
           }
       });
       $('#trq2').text(sumrq2);
       
        var sumrq3 = 0;
       $('.rq3').each(function(){
           if($(this).val())
           {
            sumrq3 += parseInt($(this).val());
           }
       });
       $('#trq3').text(sumrq3);
       
        var sumrq4 = 0;
       $('.rq4').each(function(){
           if($(this).val())
           {
            sumrq4 += parseInt($(this).val());
           }
       });
       $('#trq4').text(sumrq4);
       
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
        }
        if(!isNaN(trq2p) && trq2p > 0)
        {
            $('#trq2p').text(trq2p+'%');
        }
        if(!isNaN(trq3p) && trq3p > 0)
        {
            $('#trq3p').text(trq3p+'%');
        }
        if(!isNaN(trq4p) && trq4p > 0)
        {
            $('#trq4p').text(trq4p+'%');
        }
       
       $('#totalrq1p').val(trq1p+'%');
       $('#totalrq2p').val(trq2p+'%');
       $('#totalrq3p').val(trq3p+'%');
       $('#totalrq4p').val(trq4p+'%');
    });
    
    
</script>
@endsection