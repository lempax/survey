<?php
     
     $q1= 0;
     $rq1 = 0;
    
    $totalq1 = 0;
    $totalq2 = 0;
    $totalq3 = 0;
    $totalq4 = 0;
    
    $totalrq1 = 0;
    $totalrq2 = 0;
    $totalrq3 = 0;
    $totalrq4 = 0;

 
?>


<table style="width:100%;" id="table1" class="table table-bordered table-striped" cellpadding="0">
                <tr>
                    <td></td>
                    <td colspan="8" style="text-align: center">Targets</td>
                    <td colspan="4" style="text-align: center">Results</td>
                    <td colspan="4" style="text-align: center">%Results</td>
                </tr>
                <tr>
                    <td >Agent Name</td>
                    <td class="quarter">Q1</td>
                    <td >Comments</td>
                    <td style="width:10px;">Q2</td>
                    <td >Comments</td>
                    <td style="width:10px;">Q3</td>
                    <td >Comments</td>
                    <td style="width:10px;">Q4</td>
                    <td> Comments</td>
                    <td>Q1</td>
                    <td>Q2</td>
                    <td>Q3</td>
                    <td>Q4</td>
                    <td>Q1%</td>
                    <td>Q2%</td>
                    <td>Q3%</td>
                    <td>Q4%</td>
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
                        @if($content[0][$i]['uid'] == $agent->uid)
                            <td>{{ $agent->lname.', '.$agent->fname }}</td>
                            <td class="q1 row{{$i}}">{{ $content[0][$i]['q1'] }}</td>
                            <?php 
                                if($content[0][$i]['q1'] >= 1)
                                {
                                    $q1 = $content[0][$i]['q1'];
                                }
                                $totalq1 = $totalq1 + $q1;
                            ?>
                            <td>{{ $content[0][$i]['q1comment'] }}</td>
                            
                            
                            <td class="q2 row{{$i}}">{{ $content[0][$i]['q2'] }}</td>
                            <?php 
                                if($content[0][$i]['q2'] >= 1)
                                {
                                    $q2 = $content[0][$i]['q2'];
                                }
                                $totalq2 = $totalq2 + $content[0][$i]['q2'];
                            ?>
                            <td>{{ $content[0][$i]['q2comment'] }}</td>
                            
                            
                            <td class="q3 row{{$i}}">{{ $content[0][$i]['q3'] }}</td>
                            <?php 
                                if($content[0][$i]['q3'] >= 1)
                                {
                                    $q3 = $content[0][$i]['q3'];
                                }
                                $totalq3 = $totalq3 + $content[0][$i]['q3'];
                            ?>
                            <td>{{ $content[0][$i]['q3comment'] }}</td>
                            
                            
                            <td class="q4 row{{$i}}">{{ $content[0][$i]['q4'] }}</td>
                            <?php 
                                if($content[0][$i]['q4'] >= 1)
                                {
                                    $q4 = $content[0][$i]['q4'];
                                }
                                $totalq4 = $totalq4 + $content[0][$i]['q4'];
                            ?>
                            <td>{{ $content[0][$i]['q4comment'] }}</td>
                            
                            
                            
                            <td class="rq1 row{{$i}}">{{ $content[0][$i]['rq1'] }}</td>
                            <?php 
                                if($content[0][$i]['rq1'] >= 1)
                                {
                                    $rq1 = $content[0][$i]['rq1'];
                                }
                                $totalrq1 = $totalrq1 + $rq1;
                            ?>
                            <td class="rq2 row{{$i}}">{{ $content[0][$i]['rq2'] }}</td>
                            <?php 
                                if($content[0][$i]['rq2'] >= 1)
                                {
                                    $rq2 = $content[0][$i]['rq2'];
                                }
                                $totalrq2 = $totalrq2 + $content[0][$i]['rq2'];
                            ?>
                            <td class="rq3 row{{$i}}">{{ $content[0][$i]['rq3'] }}</td>
                            <?php 
                                if($content[0][$i]['rq3'] >= 1)
                                {
                                    $rq3 = $content[0][$i]['rq3'];
                                }
                                $totalrq3 = $totalrq3 + $content[0][$i]['rq3'];
                            ?>
                            <td class="rq4 row{{$i}}">{{ $content[0][$i]['rq4'] }}</td>
                            <?php 
                                if($content[0][$i]['rq4'] >= 1)
                                {
                                    $rq4 = $content[0][$i]['rq4'];
                                }
                                $totalrq4 = $totalrq4 + $content[0][$i]['rq4'];
                            ?>
                            
                            
                            <?php
                                if($q1 != null && $rq1 != null){
                                $rq1p = round($rq1 / $q1 * 100, 2).'&';
                                }
                                $q1 = "";
                                $rq1 = "";
                            ?>
                            <td class="rq1p row{{$i}}">{{$rq1p}}</td>
                            <?php
                                $rq1p = "";
                                
                                if($q2 != null && $rq2 != null){
                                $rq2p = round($rq2 / $q2 * 100, 2).'%';
                                }
                                $q2 = "";
                                $rq2 = "";
                            ?>
                            <td class="rq2p row{{$i}}">{{$rq2p}}</td>
                            <?php
                                $rq2p = "";
                                
                                if($q3 != null && $rq3 != null){
                                $rq3p = round($rq3 / $q3 * 100, 2).'%';
                                }
                                $q3 = "";
                                $rq3 = "";
                            ?>
                            <td class="rq3p row{{$i}}">{{$rq3p}}</td>
                            <?php
                                $rq3p = "";
                                
                                if($q4 != null && $rq4 != null){
                                $rq4p = round($rq4 / $q4 * 100, 2).'%';
                                }
                                $q4 = "";
                                $rq4 = "";
                            ?>
                            <td class="rq4p row{{$i}}">{{$rq4p}}</td>
                        <?php
                            $rq4p = "";
                            $counter++;
                        ?>
                            
                        @else
                        @endif
                    @endfor
                    
                    
                    @if($counter == 0)
                        <td>{{ $agent->lname.', '.$agent->fname }}</td>
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
                    @endif
                </tr>
                @endforeach
                
                
                <?php 
                    $totalrq1p = $totalrq1 / $totalq1 * 100;
                    $totalrq2p = $totalrq2 / $totalq3 * 100;
                    $totalrq3p = $totalrq3 / $totalq3 * 100;
                    $totalrq4p = $totalrq4 / $totalq4 * 100;
                ?>
                
            
                <tr>
                    <td>Total</td>
                    <td colspan="2" style="text-align: center" id="tq1"> {{ $totalq1 }} </td>
                    <td colspan="2" style="text-align: center" id="tq2"> {{ $totalq2 }} </td>
                    <td colspan="2" style="text-align: center" id="tq3"> {{ $totalq3 }} </td>
                    <td colspan="2" style="text-align: center" id="tq4"> {{ $totalq4 }} </td>
                    <td id="trq1"> {{ $totalrq1 }} </td>
                    <td id="trq2"> {{ $totalrq2 }} </td>
                    <td id="trq3"> {{ $totalrq3 }} </td>
                    <td id="trq4"> {{ $totalrq4 }} </td>
                    <td id="trq1p"> {{round($totalrq1p, 2).'%' }} </td>
                    <td id="trq2p"> {{round($totalrq2p, 2).'%' }} </td>
                    <td id="trq3p"> {{round($totalrq3p, 2).'%' }} </td>
                    <td id="trq4p"> {{round($totalrq4p, 2).'%' }} </td>
                </tr>
            </table>