@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')

<div class="box">
    <div class="box-header" style="border-bottom: 3px solid #d2d6de;">
        <div class="col-sm-6">
            <form method="POST" id="search-form" class="form-inline" role="form">
                @if(in_array(Auth::user()->roles, ['MANAGER','SOM', 'SAS']))
                <div class="form-group">
                    <select class="form-control" aria-controls="teams" id="team_selection" name="team_selection">
                        <option value="all">All Teams</option>
                        @foreach($team_selection as $id => $team)
                        <option value="{{ $id }}" {{ $id == Request::get('deptid') ? 'selected' : '' }}>{{ $team }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <select class="form-control" aria-controls="weeks" id="week_selector" name="week_selection">
                        @for ($i = 1; $i <= date('W') - 0; $i++)
                        @if(Request::has('w'))
                        <option value="{{ $i }}" {{ $i == Request::get('w') ? 'selected' : '' }}>Week {{ $i }}</option>
                        @else
                        <option value="{{ $i }}" {{ $i == date('W') ? 'selected' : '' }}>Week {{ $i }}</option>
                        @endif
                        @endfor
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                    <i class="fa fa-calendar"></i>
                </button>
            </form>
        </div>
        <div class="col-sm-6">
            <div id="textHeader" class="text-right" style="font-size: 150%; font-weight: bold"></div>
        </div>
    </div>
</div>

<div class="nav-tabs-custom" style="width: 100%;">
    <ul class="nav nav-tabs" style="width: 100%;">
        <li class="active"><a href="#tab_1" data-toggle="tab">Listlocal</a></li>
        <li><a href="#tab_2" data-toggle="tab">DIFM</a></li>
        <li><a href="#tab_3" data-toggle="tab">Cloud Server</a></li>
        <li><a href="#tab_4" data-toggle="tab">Dedicated Server</a></li>
        <li><a href="#tab_5" data-toggle="tab">VPS</a></li>
        <li><a href="#tab_6" data-toggle="tab">Classic Hosting</a></li>
        <li><a href="#tab_7" data-toggle="tab">MyWebsite</a></li>
        <li><a href="#tab_8" data-toggle="tab">E-Mail</a></li>
        <li><a href="#tab_9" data-toggle="tab">E-Business</a></li>
        <li><a href="#tab_10" data-toggle="tab">Online Marketing</a></li>
        <li><a href="#tab_11" data-toggle="tab">Office</a></li>
        <li><a href="#tab_12" data-toggle="tab">Domains</a></li>
    </ul>
    <div class="tab-content" style="width: 100%;">
        <div class="tab-pane active" id="tab_1" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overviewContainer" style="height: 400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown['headers'] as $i => $head)
                                <th style='{{ $breakdown['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_2" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_difm" style="height: 400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_difm" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_difm['headers'] as $i => $head)
                                <th style='{{ $breakdown_difm['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_difm['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_3" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_cloud" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_cloud['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_cloud" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_cloud['headers'] as $i => $head)
                                <th style='{{ $breakdown_cloud['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_cloud['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_4" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_dedicated" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_dedicated['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_dedicated" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_dedicated['headers'] as $i => $head)
                                <th style='{{ $breakdown_dedicated['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_dedicated['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_5" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_vps" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_vps['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_vps" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_vps['headers'] as $i => $head)
                                <th style='{{ $breakdown_vps['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_vps['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_6" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_chosting" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_chosting['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_chosting" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_chosting['headers'] as $i => $head)
                                <th style='{{ $breakdown_chosting['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_chosting['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_7" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_mywebsite" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_mywebsite['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_mywebsite" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_mywebsite['headers'] as $i => $head)
                                <th style='{{ $breakdown_mywebsite['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_mywebsite['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_8" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_email" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_email['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_email" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_email['headers'] as $i => $head)
                                <th style='{{ $breakdown_email['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_email['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_9" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_ebusiness" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_ebusiness['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_ebusiness" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_ebusiness['headers'] as $i => $head)
                                <th style='{{ $breakdown_ebusiness['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_ebusiness['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_10" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_marketing" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_marketing['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_marketing" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_marketing['headers'] as $i => $head)
                                <th style='{{ $breakdown_marketing['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_marketing['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_11" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_office" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_office['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_office" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_office['headers'] as $i => $head)
                                <th style='{{ $breakdown_office['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_office['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane" id="tab_12" style="width: 100%;">
            <div class="box-body table-responsive" style="width: 100%;">
                <div id="overview_domain" style="height:400px; width: 100%;"></div>

                <div class="box-header" style="margin-top: 15px;">
                    <h3 class="box-title">{{ $breakdown_domain['name'] }}</h3>
                </div>
                <div class="box-body">
                    <table id="table_breakdown_domain" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown_domain['headers'] as $i => $head)
                                <th style='{{ $breakdown_domain['headerStyle'][$i] }}'>{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($breakdown_domain['data'] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset ("/canvasjs/canvasjs.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

<script>
        window.onload = function () {
        /** LISTLOCAL **/
        var overview = new CanvasJS.Chart("overviewContainer",
                {
                title: {
                text: "{{ $overview['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                        },
                        animationEnabled: true,
                        axisY: {
                        title: "{{ $overview['yLabel'] }}"
                        },
                        legend: {
                        verticalAlign: "bottom",
                                horizontalAlign: "center"
                        },
                        theme: "theme2",
                        data: [
                        {
                        click: function(e){
                        if (e.dataPoint.z !== 0) {
                        var queryParameters = {}, queryString = location.search.substring(1),
                                re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                while (m = re.exec(queryString)) {
                        queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                        }

// Add new parameters or update existing ones
                        queryParameters['deptid'] = 'deptid';
                                queryParameters['deptid'] = e.dataPoint.z;
                                location.search = $.param(queryParameters);
                        }
                        },
                                type: "column",
                                showInLegend: true,
                                legendMarkerColor: "grey",
                                legendText: "{{ $overview['xLabel'] }}",
                                dataPoints:
                                [
<?php foreach ($overview['data'] as $i => $data): ?>
                                    {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                ]
                        }
                        ]
                        });
                /** LISTLOCAL **/

                /** DIFM **/
                var overview_difm = new CanvasJS.Chart("overview_difm",
                        {
                        title: {
                        text: "{{ $overview_difm['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_difm['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_difm['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_difm['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_difm['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** DIFM **/


                /** CLOUD SERVER **/
                var overview_cloud = new CanvasJS.Chart("overview_cloud",
                        {
                        title: {
                        text: "{{ $overview_cloud['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_cloud['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_cloud['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_cloud['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_cloud['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** CLOUD SERVER **/


                /** DEDICATED SERVER **/
                var overview_dedicated = new CanvasJS.Chart("overview_dedicated",
                        {
                        title: {
                        text: "{{ $overview_dedicated['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_dedicated['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_dedicated['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_dedicated['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_dedicated['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** DEDICATED SERVER **/

                /** VPS **/
                var overview_vps = new CanvasJS.Chart("overview_vps",
                        {
                        title: {
                        text: "{{ $overview_vps['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_vps['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_vps['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_vps['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_vps['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** VPS **/

                /** CLASSIC HOSTING **/
                var overview_chosting = new CanvasJS.Chart("overview_chosting",
                        {
                        title: {
                        text: "{{ $overview_chosting['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_chosting['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_chosting['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_chosting['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_chosting['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** CLASSIC HOSTING **/

                /** MYWEBSITE **/
                var overview_mywebsite = new CanvasJS.Chart("overview_mywebsite",
                        {
                        title: {
                        text: "{{ $overview_mywebsite['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_mywebsite['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_mywebsite['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_mywebsite['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_mywebsite['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** MYWEBSITE **/

                /** EMAIL **/
                var overview_email = new CanvasJS.Chart("overview_email",
                        {
                        title: {
                        text: "{{ $overview_email['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_email['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_email['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_email['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_email['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** EMAIL **/

                /** EBUSINESS **/
                var overview_ebusiness = new CanvasJS.Chart("overview_ebusiness",
                        {
                        title: {
                        text: "{{ $overview_ebusiness['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_ebusiness['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_ebusiness['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_ebusiness['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_ebusiness['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** EBUSINESS **/

                /** ONLINE MARKETING **/
                var overview_marketing = new CanvasJS.Chart("overview_marketing",
                        {
                        title: {
                        text: "{{ $overview_marketing['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_marketing['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_marketing['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_marketing['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_marketing['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** ONLINE MARKETING **/

                /** OFFICE **/
                var overview_office = new CanvasJS.Chart("overview_office",
                        {
                        title: {
                        text: "{{ $overview_office['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_office['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_office['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_office['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_office['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** OFFICE **/

                /** DOMAIN **/
                var overview_domain = new CanvasJS.Chart("overview_domain",
                        {
                        title: {
                        text: "{{ $overview_domain['name'] . (Request::has('w') ? ' (Week ' . Request::get('w') . ')' : (Request::has('date_start') && Request::has('date_end') ? ' (' . Request::get('date_start') . ' ~ ' . Request::get('date_end') . ')' : ''))}}"
                                },
                                animationEnabled: true,
                                axisY: {
                                title: "{{ $overview_domain['yLabel'] }}"
                                },
                                legend: {
                                verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                },
                                theme: "theme2",
                                data: [
                                {
                                click: function(e){
                                if (e.dataPoint.z !== 0) {
                                var queryParameters = {}, queryString = location.search.substring(1),
                                        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
                                        while (m = re.exec(queryString)) {
                                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                                }

// Add new parameters or update existing ones
                                queryParameters['deptid'] = 'deptid';
                                        queryParameters['deptid'] = e.dataPoint.z;
                                        location.search = $.param(queryParameters);
                                }
                                },
                                        type: "column",
                                        showInLegend: true,
                                        legendMarkerColor: "grey",
                                        legendText: "{{ $overview_domain['xLabel'] }}",
                                        dataPoints:
                                        [
<?php foreach ($overview_domain['data'] as $i => $data): ?>
                                            {y: <?= $data['total'] ?>, z: <?= $data['deptid'] ?>, indexLabel: "<?= $data['total'] ?>", label: "<?= $data['label'] ?>"}<?= $i >= (count($overview_domain['data']) - 1) ? '' : ',' ?>
<?php endforeach; ?>
                                        ]
                                }
                                ]
                                });
                /** DOMAIN **/

                overview.render();
                overview_difm.render();
                overview_cloud.render();
                overview_dedicated.render();
                overview_vps.render();
                overview_chosting.render();
                overview_mywebsite.render();
                overview_email.render();
                overview_ebusiness.render();
                overview_marketing.render();
                overview_office.render();
                overview_domain.render();
                }


$(function () {
$('#textHeader').text($('select[name=team_selection] option:selected').text());
        $('#table_breakdown').DataTable();
        $('#table_breakdown_difm').DataTable();
        $('#table_breakdown_cloud').DataTable();
        $('#table_breakdown_dedicated').DataTable();
        $('#table_breakdown_vps').DataTable();
        $('#table_breakdown_chosting').DataTable();
        $('#table_breakdown_mywebsite').DataTable();
        $('#table_breakdown_email').DataTable();
        $('#table_breakdown_ebusiness').DataTable();
        $('#table_breakdown_marketing').DataTable();
        $('#table_breakdown_office').DataTable();
        $('#table_breakdown_domain').DataTable();

        });
        $("#week_selector").change(function() {
if ($('select[name=team_selection]').val() == 'all')
        window.location = "{{ url('/') . '/' . $perfurl }}?w=" + $(this).val();
        else
        window.location = "{{ url('/') . '/' . $perfurl }}?deptid=" + $('select[name=team_selection]').val() + "&w=" + $(this).val();
        });
        $("#team_selection").change(function() {
var queryParameters = {}, queryString = location.search.substring(1),
        re = /([^&=]+)=([^&]*)/g, m;
// Creates a map with the query string parameters
        while (m = re.exec(queryString)) {
queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
        }

// Add new parameters or update existing ones
queryParameters['deptid'] = 'deptid';
        queryParameters['deptid'] = $(this).val();
        location.search = $.param(queryParameters);
        });
        $('.daterange').daterangepicker({
ranges: {
'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Week': [moment().startOf('isoweek'), moment().endOf('isoweek')],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
},
        startDate: @if(Request::has('date_start')) moment('{{ Request::get('date_start') }}') @else moment().startOf('isoweek') @endif,
        endDate: @if(Request::has('date_end')) moment('{{ Request::get('date_end') }}') @else moment().endOf('isoweek') @endif
        }, function (start, end) {
if ($('select[name=team_selection]').val() == 'all') {
window.location = '{{ url("/") . "/" . $perfurl }}?date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
        } else
        window.location = "{{ url('/') . '/' . $perfurl }}?deptid=" + $('select[name=team_selection]').val() + '&date_start=' + start.format('YYYY-MM-DD') + '&date_end=' + end.format('YYYY-MM-DD');
        });
</script>
@endsection