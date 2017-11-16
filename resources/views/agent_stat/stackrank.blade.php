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
        <li class="active"><a href="#tab_1" data-toggle="tab">Summary</a></li>
        <li><a href="#tab_9" data-toggle="tab">Ranking</a></li>
        <li><a href="#tab_2" data-toggle="tab">CRR% </a></li>
        <li><a href="#tab_3" data-toggle="tab">Quality</a></li>
        <li><a href="#tab_4" data-toggle="tab">NPS</a></li>
        <li><a href="#tab_5" data-toggle="tab">Productivity</a></li>
        <li><a href="#tab_6" data-toggle="tab">SAS CR</a></li>
        <li><a href="#tab_7" data-toggle="tab">Released Time</a></li>
        <li><a href="#tab_8" data-toggle="tab">AHT Inbound</a></li>            
    </ul>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="tab_1" style="width: 100%;">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    @if($type == 'sr')
                    <tr>
                        <th colspan='2'></th>
                        <th colspan='2' style='text-align: center;'>CRR%</th>
                        <th colspan='2' style='text-align: center;'>QUALITY</th>
                        <th colspan='2' style='text-align: center;'>NPS</th>
                        <th colspan='2' style='text-align: center;'>PRODUCTIVITY</th>
                        <th colspan='2' style='text-align: center;'>SAS CR</th>
                        <th colspan='2' style='text-align: center;'>RELEASED</th>
                        <th colspan='2' style='text-align: center;'>AHT</th>
                        <th></th>
                    </tr>
                    @endif
                    <tr>
                        @foreach($sr['headers'] as $i => $head)
                        <th style='{{ $sr['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($sr['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_2" style="width: 100%;">
            <table id="table_breakdown2" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th colspan="2">
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
                <th colspan="2"></th>
                </tr>
                <tr>
                    <th>Employee</th>
                    <th>Team</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th class="crr">CRR</th>
                    <th class="feed">FEED</th>
                    <th>Ave</th>
                    <th>Rank</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($cr as $case)
                    <tr>
                        <td>{{ $case->agent }}</td>
                        <td>{{ $case->team }}</td>
                        <td class="crr">{{ $case->jan_cr }}</td>
                        <td class="feed">{{ $case->jan_feed }}</td>
                        <td class="crr">{{ $case->feb_cr }}</td>
                        <td class="feed">{{ $case->feb_feed }}</td>
                        <td class="crr">{{ $case->mar_cr }}</td>
                        <td class="feed">{{ $case->mar_feed }}</td>
                        <td class="crr">{{ $case->april_cr }}</td>
                        <td class="feed">{{ $case->april_feed }}</td>
                        <td class="crr">{{ $case->may_cr }}</td>
                        <td class="feed">{{ $case->may_feed }}</td>
                        <td class="crr">{{ $case->june_cr }}</td>
                        <td class="feed">{{ $case->june_feed }}</td>
                        <td class="crr">{{ $case->july_cr }}</td>
                        <td class="feed">{{ $case->july_feed }}</td>
                        <td class="crr">{{ $case->aug_cr }}</td>
                        <td class="feed">{{ $case->aug_feed }}</td>
                        <td class="crr">{{ $case->sept_cr }}</td>
                        <td class="feed">{{ $case->sept_feed }}</td>
                        <td class="crr">{{ $case->oct_cr }} </td>
                        <td class="feed">{{ $case->oct_feed }}</td>
                        <td class="crr">{{ $case->nov_cr }}</td>
                        <td class="feed">{{ $case->nov_feed }}</td>
                        <td class="crr">{{ $case->dec_cr }}</td>
                        <td class="feed">{{ $case->dec_feed }}</td>
                        <td>{{ $case->ave_cr }}</td>
                        <td>{{ $case->rank_cr }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_3" style="width: 100%;">
            <table id="table_breakdown3" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($q['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_4" style="width: 100%;">
            <table id="table_breakdown4" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                       @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($nps['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_5" style="width: 100%;">
            <table id="table_breakdown5" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($prod['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_6" style="width: 100%;">
            <table id="table_breakdown6" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($sas['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="tab_7" style="width: 100%;">
            <table id="table_breakdown7" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rel['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_8" style="width: 100%;">
            <table id="table_breakdown8" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($q['headers'] as $i => $head)
                        <th style='{{ $q['headerStyle'][$i] }}'>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($aht['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="tab-pane" id="tab_9" style="width: 100%;">
            <table id="table_breakdown9" class="table table-bordered table-hover table-striped" style="width: 500px;">
                <thead>
                    <tr>
                        <th style="text-align: center">Rank</th>
                        <th style="text-align: center">Employee</th>
                        <th style="text-align: center">Team</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overall['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td style="text-align: center"><?= $cell ?></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
$('#table_breakdown2').DataTable();
$('#table_breakdown3').DataTable();
$('#table_breakdown4').DataTable();
$('#table_breakdown5').DataTable();
$('#table_breakdown6').DataTable();
$('#table_breakdown7').DataTable();
$('#table_breakdown8').DataTable();
$('#table_breakdown9').DataTable();
});

</script>
@endsection