@extends('layouts.master')

@section('additional_styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<!-- Pace style -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/pace/pace.min.css") }}">
<style>
    table tbody tr td:first-child {
        text-align: left;
    }
    td.highlight {
        background-color: whitesmoke !important;
    }
    table.dataTable.order-column tbody tr > .sorting_1,
    table.dataTable.order-column tbody tr > .sorting_2,
    table.dataTable.order-column tbody tr > .sorting_3, table.dataTable.display tbody tr > .sorting_1,
    table.dataTable.display tbody tr > .sorting_2,
    table.dataTable.display tbody tr > .sorting_3 {
        background-color: #f9f9f9;
    }
    table.dataTable.order-column tbody tr.selected > .sorting_1,
    table.dataTable.order-column tbody tr.selected > .sorting_2,
    table.dataTable.order-column tbody tr.selected > .sorting_3, table.dataTable.display tbody tr.selected > .sorting_1,
    table.dataTable.display tbody tr.selected > .sorting_2,
    table.dataTable.display tbody tr.selected > .sorting_3 {
        background-color: #acbad4;
    }
    table.dataTable.display tbody tr.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd > .sorting_1 {
        background-color: #f1f1f1;
    }
    table.dataTable.display tbody tr.odd > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd > .sorting_2 {
        background-color: #f3f3f3;
    }
    table.dataTable.display tbody tr.odd > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd > .sorting_3 {
        background-color: whitesmoke;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_1 {
        background-color: #a6b3cd;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_2 {
        background-color: #a7b5ce;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_3 {
        background-color: #a9b6d0;
    }
    table.dataTable.display tbody tr.even > .sorting_1, table.dataTable.order-column.stripe tbody tr.even > .sorting_1 {
        background-color: #f9f9f9;
    }
    table.dataTable.display tbody tr.even > .sorting_2, table.dataTable.order-column.stripe tbody tr.even > .sorting_2 {
        background-color: #fbfbfb;
    }
    table.dataTable.display tbody tr.even > .sorting_3, table.dataTable.order-column.stripe tbody tr.even > .sorting_3 {
        background-color: #fdfdfd;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_1 {
        background-color: #acbad4;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_2 {
        background-color: #adbbd6;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_3 {
        background-color: #afbdd8;
    }
    table.dataTable.display tbody tr:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1 {
        background-color: #eaeaea;
    }
    table.dataTable.display tbody tr:hover > .sorting_2, table.dataTable.order-column.hover tbody tr:hover > .sorting_2 {
        background-color: #ebebeb;
    }
    table.dataTable.display tbody tr:hover > .sorting_3, table.dataTable.order-column.hover tbody tr:hover > .sorting_3 {
        background-color: #eeeeee;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_1 {
        background-color: #a1aec7;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_2 {
        background-color: #a2afc8;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_3 {
        background-color: #a4b2cb;
    }
</style>
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $dash_data['calls'] }}</h3>
                <p>Productivity (Calls)</p>
            </div>
            <div class="icon">
                <i class="fa fa-phone"></i>
            </div>
            <a href="{{ url('productivity') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $dash_data['emails'] }}</h3>
                <p>Productivity (Emails)</p>
            </div>
            <div class="icon">
                <i class="fa fa-envelope"></i>
            </div>
            <a href="{{ url('productivity') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $dash_data['crr'] }}<sup style="font-size: 20px">%</sup></h3>

                <p>CRR Rating</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('feedbacks') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $dash_data['sas'] }}</h3>

                <p>SAS Upsells</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{ url('sasupsells') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Team Overview</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    @if(in_array(Auth::user()->roles, ['MANAGER','SOM','SUPERVISOR']))
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul id="filter_list" class="dropdown-menu" role="menu" style="height: auto; max-height: 250px; overflow-x: hidden;">
                            @foreach($filter_selection as $id => $name)
                            <li>
                                <a class="checkbox" data-value="{{ $id }}" tabIndex="-1">
                                    <label>
                                        <input type="checkbox" {{ !in_array($id, $filter_list) ? 'checked' : '' }}>
                                        {{ $name }}
                                    </label>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-8">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                @if(in_array(Auth::user()->roles, ['MANAGER','SOM']))
                                <div class="form-group">
                                    <select class="form-control" aria-controls="teams" id="team_selection" name="team_selection">
                                        <option value="all">All Teams</option>
                                        @foreach($name_selection as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <select class="form-control" aria-controls="weeks" id="week_selection" name="week_selection">
                                        @for ($i = 1; $i <= date('W') - 0; $i++)
                                        <option value="{{ $i }}" {{ $i == date('W') ? 'selected' : '' }}>Week {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                                    <i class="fa fa-calendar"></i>
                                </button>
                                <span id="date_range_info" class="text-info" style="font-size: 120%"></span>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <div id="textHeader" class="text-right" style="font-size: 150%"></div>
                        </div>
                    </div>
                </div>
                <table id="agent_stats" class="table table-hover table-bordered row-border order-column">
                    <thead>
                        <tr>
                            @if(in_array(Auth::user()->roles, ['MANAGER','SOM']))
                            <th rowspan="2" id="headName">Teams</th>
                            @else
                            <th rowspan="2" id="headName">Agents</th>
                            @endif
                            <th colspan="3">Productivity</th>
                            <th colspan="2">Blacklist</th>
                            <th colspan="3">CRR Rating</th>
                            <th colspan="2">SAS Rating</th>
                            <th colspan="3">Cosmocom</th>
                        </tr>
                        <tr>
                            <th>Calls</th>
                            <th>Emails</th>
                            <th><span data-toggle="tooltip" title="Total number of SSE Cases">Cases</span></th>
                            <th><span data-toggle="tooltip" title="Blacklisted cases">BL</span></th>
                            <th><span data-toggle="tooltip" title="Blacklist percentage">%</span></th>
                            <th><span data-toggle="tooltip" title="Feedback Returns">Ret.</span></th>
                            <th><span data-toggle="tooltip" title="Request Solved (Yes CRR)">Yes</span></th>
                            <th><span data-toggle="tooltip" title="CRR Percentage">%</span></th>
                            <th><span data-toggle="tooltip" title="Total number of Sales">Sales</span></th>
                            <th><span data-toggle="tooltip" title="SAS Conversion Rate">CR %</span></th>
                            <th><span data-toggle="tooltip" title="Cosmocom Release Rate">Rel.%</span></th>
                            <th><span data-toggle="tooltip" title="Total Cosmocom Time (hours)">Total</span></th>
                            <th><span data-toggle="tooltip" title="Average Cosmocom Time (hours)">AVG</span></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Total / Average: </th>
                            <th>Calls</th>
                            <th>Emails</th>
                            <th>Bl</th>
                            <th>Bl</th>
                            <th>Blacklist</th>
                            <th>Returns</th>
                            <th>CRR%</th>
                            <th>CRR%</th>
                            <th>Sales</th>
                            <th>Sales CR</th>
                            <th>Release</th>
                            <th>Cosmo</th>
                            <th>Cosmo</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection


@section('additional_scripts')
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
$(document).ajaxStart(function () {
    Pace.restart();
});
$(function () {
    var oTable = $('#agent_stats').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": '{{ url("/overallweekly")  }}',
            "data": function (d) {
                d.team_selection = $('select[name=team_selection]').val();
            }
        },
        "fnDrawCallback": function () {
            if ($('select[name=team_selection]').val() === 'all') {
                $('#headName').text('Team');
                $('#textHeader').text('All Teams');
            } else {
                $('#headName').text('Name');
                $('#textHeader').text($('select[name=team_selection] option:selected').text());
                //alert(oTable.fnGetData());
            }
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
            };

            var sum_cols = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            var calls, emails, cases, bl_count, bl_rate, returns, yes_count, sales;

            $.each(sum_cols, function (index, value) {
                total = api
                        .column(value)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                switch (value) {
                    case 1:
                        calls = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 2:
                        emails = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 3:
                        cases = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 4:
                        bl_count = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 5:
                        bl_rate = ((bl_count / cases) * 100).toFixed(2);
                        $(api.column(value).footer()).html(bl_rate + '%');
                        break;
                    case 6:
                        returns = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 7:
                        yes_count = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 8:
                        crr = ((yes_count / returns) * 100).toFixed(2);
                        $(api.column(value).footer()).html(crr + '%');
                        break;
                    case 9:
                        sales = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 10:
                        cr = ((sales / calls) * 100).toFixed(2);
                        $(api.column(value).footer()).html(cr + '%');
                        break;
                    default:
                        $(api.column(value).footer()).html(total);
                        break;
                }
            });
        }
    });

    $('.daterange').daterangepicker({
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Week': [moment().startOf('isoweek'), moment().endOf('isoweek')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().startOf('isoweek'),
        endDate: moment().endOf('isoweek')
    }, function (start, end) {
        var url = '{{ url("/overallweekly")  }}' + '?date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
        oTable.ajax.url(url).load();
        $('#date_range_info').html("Date: &nbsp; <strong>" + start.format('MMMM DD, YYYY') + "</strong>&nbsp; - &nbsp;<strong>" + end.format('MMMM DD, YYYY') + "</strong>");
    });

    $('#agent_stats tbody')
            .on('mouseenter', 'td', function () {
                var colIdx = oTable.cell(this).index().column;

                $(oTable.cells().nodes()).removeClass('highlight');
                $(oTable.column(colIdx).nodes()).addClass('highlight');
            })
            .on('mouseout', 'td', function () {
                $(oTable.cells().nodes()).removeClass('highlight');
            });

    $('#week_selection').change(function (e) {
        var url = '{{ url("/overallweekly")  }}?week_selection=' + $(this).val();
        oTable.ajax.url(url).load();
        $('#date_range_info').html("<strong>Calendar Week " + $(this).val() + "</strong>");
        e.preventDefault();
    });

    $('#team_selection').change(function (e) {
        oTable.ajax.reload();
        e.preventDefault();
    });

    var options = {!! json_encode($filter_list) !!};

    $('#filter_list a').on('click', function (event) {

        $_token = "{{ csrf_token() }}";

        var $target = $(event.currentTarget),
                val = $target.attr('data-value'),
                $inp = $target.find('input'),
                idx;

        if ((idx = options.indexOf(val)) > -1) {
            options.splice(idx, 1);
            setTimeout(function () {
                $inp.prop('checked', true)
            }, 0);
        } else {
            options.push(val);
            setTimeout(function () {
                $inp.prop('checked', false)
            }, 0);
        }

        $(event.target).blur();

        console.log(options);
        $.post('{{ url("/usersettings")  }}', {type: 'filtered_list', entries: options, _token: $_token})
                .done(function (data) {
                    oTable.ajax.reload();
                    //alert(data.entries);
                });
        return false;
    });
});
</script>
@endsection