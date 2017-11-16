
<?php
    //not inbcluded in team
    $nit = array("UK Offshore Support Team 02", "UK Offshore Support Team 01", "Customer Service Offshore US 02",
        "Customer Service Offshore US 01", "UK Training Team", "Cebu Sales After Support - UK", "Special Task Cebu - UK",
        "Customer Service Offshore UK");
    
    $totalq1 = 0;
    $totalq2 = 0;
    $totalq3 = 0;
    $totalq4 = 0;
    
    $totalrq1 = 0;
    $totalrq2 = 0;
    $totalrq3 = 0;
    $totalrq4 = 0;

 
?>


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
           <td class="quarter">Q1</td>
           <td class="quarter">Q2</td>
           <td class="quarter">Q3</td>
           <td class="quarter">Q4</td>
           <td class="quarter">Q1</td>
           <td class="quarter">Q2</td>
           <td class="quarter">Q3</td>
           <td class="quarter">Q4</td>
           <td class="quarter">%Q1</td>
           <td class="quarter">%Q2</td>
           <td class="quarter">%Q3</td>
           <td class="quarter">%Q4</td>
        </tr>
    </thead>
    <tbody id ="tformbody">
        @foreach($teams as $team)
        @if(in_array($team->name, $nit))

        @else
        <tr>

            <td>{{ $team->name }}</td>
            <td class="q1">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[1] }}
                    <?php 
                        $totalq1 = $totalq1 + $content[1];
                        break;
                    ?>
                @endif
            @endforeach
            </td>
            <td class="q2">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[2] }}
                    <?php 
                        $totalq2 = $totalq2 + $content[2];                    
                        break;
                    ?>
                @endif
            @endforeach
            </td>
            <td class="q3">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[3] }}
                    <?php 
                        $totalq3 = $totalq3 + $content[3];
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="q4">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[4] }}
                    <?php
                        $totalq4 = $totalq4 + $content[4]; 
                        break;
                    ?>
                @endif
            @endforeach  
            </td>
            <td class="rq1">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[5] }}
                    <?php 
                        $totalrq1 = $totalrq1 + $content[5];
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="rq2">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[6] }}
                    <?php 
                        $totalrq2 = $totalrq2 + $content[6];
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="rq3">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[7] }}
                    <?php 
                        $totalrq3 = $totalrq3 + $content[7];
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="rq4">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[8] }}
                    <?php 
                        $totalrq4 = $totalrq4 + $content[8];
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="rq1p">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[9] }}
                    <?php 
                        break;
                    ?>
                @endif
            @endforeach    
            </td>
            <td class="rq2p">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[10] }}
                    <?php 
                        break;
                    ?>
                @endif
            @endforeach  
            </td>
            <td class="rq3p">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[11] }}
                    <?php 
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
            <td class="rq4p">
            @foreach($teamReports as $teamReport)
                @if($teamReport[0]->created_by == $team->admin)
                    <?php 
                        $content = json_decode($teamReport[0]->content, true);
                    ?>
                    {{ $content[12] }} 
                    <?php 
                        break;
                    ?>
                @endif
            @endforeach   
            </td>
        </tr>
        @endif
        @endforeach
     
        <?php 
        if($totalq1 != 0)
        {
            $totalrq1p = $totalrq1 / $totalq1 * 100;
        }
        else
        {
            $totalrq1p = 0;
        }
        if($totalq2 != 0)
        {
            $totalrq2p = $totalrq2 / $totalq3 * 100;
        }
        else
        {
            $totalrq2p = 0;
        }
        if($totalq3 != 0)
        {
            $totalrq3p = $totalrq3 / $totalq3 * 100;
        }
        else
        {
            $totalrq3p = 0;
        }
        if($totalrq4 != 0)
        {
            $totalrq4p = $totalrq4 / $totalq4 * 100;
        }
        else
        {
            $totalrq4p = 0;
        }
    
         ?>
       
        <tr>
            <td>Total </td>
            <td style="text-align: center" id="tq1"> {{$totalq1 }} </td>
            <td style="text-align: center" id="tq2"> {{$totalq2 }} </td>
            <td style="text-align: center" id="tq3"> {{$totalq3 }} </td>
            <td style="text-align: center" id="tq4"> {{$totalq4 }} </td>
            <td id="trq1"> {{$totalrq1 }} </td>
            <td id="trq2"> {{$totalrq2 }} </td>
            <td id="trq3"> {{$totalrq3 }} </td>
            <td id="trq4"> {{$totalrq4 }} </td>
            <td id="trq1p"> {{round($totalrq1p, 2).'%' }} </td>
            <td id="trq2p"> {{round($totalrq2p, 2).'%' }} </td>
            <td id="trq3p"> {{round($totalrq3p, 2).'%' }} </td>
            <td id="trq4p"> {{round($totalrq4p, 2).'%' }} </td>
           
        </tr>
    </tbody>
</table>
 
