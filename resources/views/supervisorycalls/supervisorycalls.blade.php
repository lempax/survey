@extends('layouts.master')
@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">

@endsection

@section('content')
<div class="box">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @if(Auth::user()->roles == "SUPERVISOR" || (Auth::user()->roles == "AGENT" && in_array(Auth::user()->username, array("sduapa", "gcondeno"))))
            <li class="active"><a href="#tab1" data-toggle="tab">Create new case</a></li>
            <li class=""><a href="#tab2" data-toggle="tab">Supervisory Calls</a></li>
            @else
            <li class="active"><a href="#tab2" data-toggle="tab">Supervisory Calls</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <?php $uid = Auth::user()->uid; ?>
            <div class="tab-pane <?= Auth::user()->roles == "SUPERVISOR" || (Auth::user()->roles == "AGENT" && in_array(Auth::user()->username, array("sduapa", "gcondeno"))) ? 'active' : '' ?>" id="tab1">
                <form  method="POST" action="{{ asset('/supervisorycalls/add') }}" role="form">
                    <div class="box-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered" style="width: 500px;">
                            <tbody>
                                <tr>
                                    <td style="vertical-align:middle; font-weight: bold;">Case Number:</td>
                                    <td><input class="form-control" type="text" name="case_number" style="width:350px;" required></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:middle; font-weight: bold;">Supervisor: </td>
                                    <td><input type="text" name="" style="width: 350px;" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                        <input type="hidden" name="agent_name" value="{{ Auth::user()->uid }}"></td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:middle; font-weight: bold;">Team: </td>
                                    <td>
                                        <?php $sup_dept = DB::table('departments')->where('admin', Auth::user()->uid)->first(); ?>
                                        @if($sup_dept == TRUE)
                                        <input class="form-control" type="text" value="{{ $sup_dept->name }}" name="" style="width: 350px;" readonly>
                                        <input class="form-control" type="hidden" value="{{ $sup_dept->departmentid }}" name="team" style="width: 350px;">
                                        @else
                                            @if(Auth::user()->username == 'gcondeno')
                                            <input class="form-control" type="text" value="US Technical Support Team 03" name="" style="width: 350px;" readonly>
                                            <input class="form-control" type="hidden" value="21205560" name="team" style="width: 350px;">
                                            @elseif(Auth::user()->username == 'sduapa')
                                            <input class="form-control" type="text" value="US Technical Support Team 01" name="" style="width: 350px;" readonly>
                                            <input class="form-control" type="hidden" value="21205558" name="team" style="width: 350px;">
                                            @endif
                                        @endif

                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:middle; font-weight: bold;">Date of Case:</td>
                                    <td>
                                        <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                            <div class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </div>
                                            <input type="text" class="form-control" name="case_date" style="width: 150px;" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle; font-weight: bold;">Date Tracked:</td>
                                    <td><?php echo date("F j, Y - l"); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><button class="btn btn-primary" type="submit" style="width: 100px; float: right; margin-right: 23px;"> <i class="fa fa-send-o"></i> Submit </button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br>
                </form>
            </div>

            <div class="tab-pane <?= Auth::user()->roles != "SUPERVISOR" && !in_array(Auth::user()->username, array("sduapa", "gcondeno")) ? 'active' : '' ?>" id="tab2">
                <table id="supCalls" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            @foreach($breakdown['headers'] as $i => $head)
                            <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($rows AS $row)
                        <?php
                        $dept = DB::table('departments')->where('departmentid', $row->team)->first();
                        $agent = DB::table('employees')->where('uid', $row->agent_name)->first();
                        ?>
                        <tr>
                            <td style="vertical-align:middle;">{{ date("F j, Y", strtotime($row->case_date)) }}</td>
                            @if(Auth::user()->uid == $row->agent_name)
                            <td style="vertical-align:middle; width: 15%;"><a href="view/{{ $row->id }}"><u>{{ $row->case_number }}</u></a></td>
                            @else
                            <td style="vertical-align:middle; width: 15%;">{{ $row->case_number }}</td>
                            @endif

                            <td style="vertical-align:middle;">{{ $agent->fname }} {{ $agent->lname }}</td>
                            <td style="vertical-align:middle;">{{ $dept->name }}</td>
                            <td style="vertical-align:middle;">{{ date("F j, Y", strtotime($row->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
    @section('additional_scripts')
    <!--<script src="{{ asset("/bower_components/admin-lte/plugins/jQuery/jQuery-1.8.3.min.js") }}"></script>-->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
    <script src="{{ asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
    <script>

$("#team").on('change', function () {
    var selItem = $(this).val();
    $.ajax({url: "{{ url('/supervisorycalls/getagent') }}" + '/' + selItem, success: function (result) {
            $("#agent").html(result);
        }});
});

    </script>

    <script type="text/javascript">
        $(function () {
            $('#supCalls').DataTable();
        });
    </script>
    @endsection