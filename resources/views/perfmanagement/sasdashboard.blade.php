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
                <h3>{{ $dash_data['total'] }}</h3>
                <p>Total SAS</p>
            </div>
            <div class="icon">
                <i class="fa fa-bar-chart"></i>
            </div>
            <a href="{{ url('sas/dashboard') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $dash_data['featured'] }}</h3>
                <p>Featured Products</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ url('sas/featured') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $dash_data['gross'] }}<sup style="font-size: 20px"></sup></h3>

                <p>Gross Products</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('sas/gross') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $dash_data['tariff'] }}</h3>

                <p>Tariff Change</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{ url('sas/tariff') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                    @if(in_array(Auth::user()->roles, ['MANAGER','SOM','SUPERVISOR', 'SAS']))
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
                                @if(in_array(Auth::user()->roles, ['MANAGER','SOM', 'SAS']))
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
                <table id="agent_stats" class="table table-hover table-bordered row-border order-column" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>All UK Teams</th>
                            <th><span data-toggle="tooltip" title="Total DIFM Cases">DIFM</span></th>
                            <th><span data-toggle="tooltip" title="Total Listlocal Cases">Listlocal</span></th>
                            <th><span data-toggle="tooltip" title="Total Cloud Server Cases">Cloud</span></th>
                            <th><span data-toggle="tooltip" title="Total Dedicated Server Cases">Dedicated</span></th>
                            <th><span data-toggle="tooltip" title="Total VPS Cases">VPS</span></th>
                            <th><span data-toggle="tooltip" title="Total Classic Hosting Cases">Classic Hosting</span></th>
                            <th><span data-toggle="tooltip" title="Total MyWebsite Cases">MyWebsite</span></th>
                            <th><span data-toggle="tooltip" title="Total Email Cases">E-Mail</span></th>
                            <th><span data-toggle="tooltip" title="Total E-Business Cases">E-Business</span></th>
                            <th><span data-toggle="tooltip" title="Total Online Marketing Cases">Online Marketing</span></th>
                            <th><span data-toggle="tooltip" title="Total Office Cases">Office</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">Domain</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">Total</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">GO +</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">FO +</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">Sales</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">Calls</span></th>
                            <th><span data-toggle="tooltip" title="Total Domain Cases">CR %</span></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>DIFM</th>
                            <th>Listlocal</th>
                            <th>Cloud Server</th>
                            <th>Dedicated Server</th>
                            <th>Virtual Server</th>
                            <th>Classic Hosting</th>
                            <th>MyWebsite</th>
                            <th>E-Mail</th>
                            <th>E-Business</th>
                            <th>Online Marketing</th>
                            <th>Office</th>
                            <th>Domain</th>
                            <th>All</th>
                            <th>Go</th>
                            <th>Fo</th>
                            <th>Sales</th>
                            <th>Calls</th>
                            <th>Cr</th>
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
            "url": '{{ url("sas/overallweekly")  }}',
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

            var sum_cols = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
            var difm, listlocal, cloud, dedicated, virtual, hosting, mywebsite, email, ebusiness, marketing, office, domain, all, go, fo, sales, calls, cr;

            $.each(sum_cols, function (index, value) {
                total = api
                        .column(value)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                switch (value) {
                    case 1:
                        difm = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 2:
                        listlocal = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 3:
                        cloud = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 4:
                        dedicated = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 5:
                        virtual = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 6:
                        hosting = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 7:
                        mywebsite = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 8:
                        email = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 9:
                        ebusiness = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 10:
                        marketing = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 11:
                        office = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 12:
                        domain = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 13:
                        all = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 14:
                        go = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 15:
                        fo = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 16:
                        sales = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 17:
                        calls = total;
                        $(api.column(value).footer()).html(total);
                        break;
                    case 18:
                        cr = total.toFixed(2);
                        $(api.column(value).footer()).html(total.toFixed(2) + ' %');
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
        var url = '{{ url("sas/overallweekly")  }}' + '?date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
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
        var url = '{{ url("sas/overallweekly")  }}?week_selection=' + $(this).val();
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