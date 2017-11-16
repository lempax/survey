@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
@endsection

@section('content')

<style type="text/css">
    .textdiv{
        float: left; 
        width: 20%;
        padding-right: 15px;
    }

    .area{
        min-height: 300px;
    }

    .foot-area{
        float: right;
        margin-right: 15px;
    }

    .small-input{
        width: 80px;
        float: right;
        margin-top: 5px;
    }
</style>

<form name="myform" role="form" method="POST" action="store">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 80%; min-height: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ $form_title }}</h4>
                </div>
                <div class="modal-body" style="height: 480px;">
                    <h5>Team: <b>{{  Auth::user()->department->name }}</b></h5>
                    <h5 style="margin-bottom: 20px;">Supervisor: <b>{{ Auth::user()->superior->name }}</b></h5>

                    <div class="textdiv">
                        <label>Calls</label>
                        <textarea name="calls" class="form-control area" rows="3" placeholder="Enter case id ..." onkeyup="cnt(this, document.myform.calls_cnt);"></textarea>
                        <input type="text" name="calls_cnt" class="form-control small-input" placeholder="0" style="margin-top:0; border-top:0;" readonly />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="textdiv">
                        <label>Emails</label>
                        <textarea name="emails" class="form-control area" rows="3" placeholder="Enter case id..." onkeyup="cnt(this, document.myform.emails_cnt);"></textarea>
                        <input type="text" name="emails_cnt" class="form-control small-input" placeholder="0" style="margin-top:0; border-top:0;" readonly />
                    </div>
                    <div class="textdiv">
                        <label>Chats</label>
                        <textarea name="chats" class="form-control area" rows="3" placeholder="Enter case id..." onkeyup="cnt(this, document.myform.chats_cnt);"></textarea>
                        <input type="text" name="chats_cnt" class="form-control small-input" placeholder="0" style="margin-top:0; border-top:0;" readonly />
                    </div>
                    <div class="textdiv">
                        <label>Reached customer M2P</label>
                        <textarea name="reached" class="form-control area" rows="3" placeholder="Enter case id..." onkeyup="cnt(this, document.myform.reached_cnt);"></textarea>
                        <input type="text" name="reached_cnt" class="form-control small-input" placeholder="0" style="margin-top:0; border-top:0;" readonly />
                    </div>
                    <div class="textdiv">
                        <label>Forwarded to M2P</label>
                        <textarea name="forwarded" class="form-control area" rows="3" placeholder="Enter case id..." onkeyup="cnt(this, document.myform.forwarded_cnt);"></textarea>
                        <input type="text" name="forwarded_cnt" class="form-control small-input" placeholder="0" style="margin-top:0; border-top:0;" readonly />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">Close</button>
                    <button type="reset" name="reset" class="btn btn-warning"> Clear All</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="box">
    <div class="box-header">
        <h3 class="box-title"><button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal" style="width: 350px; margin-top: 5px; float: left;">Log Cases for the Day</button> 
            <button type="button" class="btn btn-success btn-sm" id="daterange" data-toggle="tooltip" title="Date range" style="float: left; margin-left: 5px; height: 34px; margin-top: 5px;">
                <i class="fa fa-calendar"></i>
            </button>
        </h3><span id="date_range_info" class="text-info" style="float: left; font-size: 120%; margin-left: 5px; margin-top: 5px;"></span>
    </div>
    <div class="box-body">

        <table id="table_breakdown" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    @foreach($breakdown['headers'] as $i => $head)
                    <th style='{{ $breakdown['headerStyle'][$i] }}}'>{{ $head }}</th>
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
<!-- /.box -->
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<script>
                            $(document).ready(function () {
                                $(".first").each(function () {
                                    $(this).keyup(function () {
                                        calculateSum();
                                    });
                                });

                            });

                            function calculateSum() {

                                var sum = 0;
                                $(".first").each(function () {
                                    if (!isNaN(this.value) && this.value.length != 0) {
                                        sum += parseFloat(this.value);
                                    }

                                });

                                $("#sum").html(sum.toFixed(2));
                            }

                            function cnt(usa_vks, x) {
                                var y = usa_vks.value;
                                var r = 0;
                                a = y.replace(/\s/g, ' ');
                                a = a.split(' ');
                                for (z = 0; z < a.length; z++) {
                                    if (a[z].length > 0)
                                        r++;
                                }
                                x.value = r;
                            }

                            $(function () {
                                $('#table_breakdown').DataTable();
                                $('#daterange').daterangepicker({
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
                                    //oTable.ajax.url(url).load();
                                    $('#date_range_info').html("<strong>[Date: &nbsp;" + start.format('MMMM DD, YYYY') + "</strong>&nbsp; - &nbsp;<strong>" + end.format('MMMM DD, YYYY') + "]</strong> <input type='hidden' name='date_from' value=" + start.format('YYYY-MM-DD') + "> <input type='hidden' name='date_to' value=" + end.format('YYYY-MM-DD') + ">");
                                });
                            });

</script>

@endsection