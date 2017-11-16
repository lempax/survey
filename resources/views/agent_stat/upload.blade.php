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
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <table class="table table-bordered table-hover table-striped" style="margin: 10px 10px 10px 10px; width: 600px;">
                <thead>
                    <tr>
                        <th style="text-transform: uppercase; letter-spacing: 2px;" colspan="3">Uload Excel File for Agent Statistics</th>
                    </tr>
                </thead>
                <tbody>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_sr') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Agent Stack Rank</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_cqn') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>CRR | Quality | NPS</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_prod') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Agent Productivity</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_sas') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Agent SAS</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_rel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Agent Released Rate</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('agentstat/submit_aht') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>AHT</td>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                        </td>
                        <td><button class="btn btn-block btn-primary btn-sm">Import File</button></td>
                    </tr>
                </form>
                </tbody>
            </table><br>

        </div>
    </div>
</div>
@endsection


@section('additional_scripts')
@endsection