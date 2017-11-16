@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<style type="text/css">
    .foot-area{
        float: right;

    }

    .td-center{
        text-align:center; 
        vertical-align: middle;
    }

    .td-left{
        text-align:left; 
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<!--<div class="col-md-6" style="width: 100%;">-->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Create New Report</a></li>
            <li><a href="#tab_2" data-toggle="tab">View All Reports</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box-body table-responsive">
                    <form name="myform" role="form" method="POST" action="{{ asset('masterreport/store') }}">
                        <table class="table table-bordered table-hover table-striped" style="margin-bottom: 10px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px;" colspan="5">US WEBHOSTING AVAILABILITY</th>
                                </tr>
                                <tr>
                                    <th class="td-left">Group</th>
                                    <th class="td-center">Offered</th>
                                    <th class="td-center">Handled</th>
                                    <th class="td-center">Overflow In</th>
                                    <th class="td-center">Overflow Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pilots as $pilot)
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">{{ $pilot->pilot }} <input type="hidden" name="pilot[]" value="{{ $pilot->pilot }}"</td>
                                    <td><input type="text" class="first form-control" name="offered[]"> </td>
                                    <td><input type="text" class="second form-control" name="handled[]"> </td>
                                    <td><input type="text" class="third form-control" name="overflow_in[]"> </td>
                                    <td><input type="text" class="fourth form-control" name="overflow_out[]"> </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">Total</td>
                                    <td><input type="text" name="sum_offered[]" class="form-control" placeholder="0" readonly id="sum_offered"></td>
                                    <td><input type="text" name="sum_handled[]" class="form-control" placeholder="0" readonly id="sum_handled" /></td>
                                    <td><input type="text" name="sum_over_in[]" class="form-control" placeholder="0" readonly id="sum_over_in" /></td>
                                    <td><input type="text" name="sum_over_out[]" class="form-control" placeholder="0" readonly id="sum_over_out" /> </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" style="margin-bottom: 10px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;" colspan="14">Absenteeism</th>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">Head Count</th>
                                    @foreach($teams as $team)
                                    <th style="text-align:center;">{{ $team->shortName }} <input type="hidden" name="deptid[]" value="{{ $team->departmentid }}"></th>
                                    @endforeach
                                    <th style="text-align: center;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left; width: 140px; font-weight: bold;">Expected On Shift</td>
                                    @foreach($teams as $team)
                                    <td><input type="text" class="sixth form-control" name="expected[]"> </td>
                                    @endforeach
                                    <td><input type="text" name="sum_expected[]" class="form-control" placeholder="0" readonly id="sum_expected" /> </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">Planned Leave</td>
                                    @foreach($teams as $team)
                                    <td><input type="text" class="seventh form-control" name="planned[]"> </td>
                                    @endforeach
                                    <td><input type="text" name="sum_planned[]" class="form-control" placeholder="0" readonly id="sum_planned" /> </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">Unplanned Leave</td>
                                    @foreach($teams as $team)
                                    <td><input type="text" class="eight form-control" name="unplanned[]"> </td>
                                    @endforeach
                                    <td><input type="text" name="sum_unplanned[]" class="form-control" placeholder="0" readonly id="sum_unplanned" /> </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" style="float: left; width: 30%; margin-bottom: 10px; margin-right: 10px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;" colspan="4">Emails</th>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">Group</th>
                                    <th style="text-align:center;">No. of Emails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workpools as $workpool)
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">{{ $workpool->workpool }}<input type="hidden" name="workpool[]" value="{{ $workpool->workpool }}"></td>
                                    <td><input type="text" class="fifth form-control" name="emails[]"> </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">Total</td>
                                    <td><input type="text" name="sum_emails[]" class="form-control" placeholder="0" readonly id="sum_emails" /></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" style="width: 35%; float: left; margin-right: 10px; margin-bottom: 10px;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;" colspan="4">Focused Products</th>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">Product</th>
                                    <th style="text-align:center;">No. of Successful Upsell</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">New DIFM <input type="hidden" name="products[]" value="difm"></td>
                                    <td><input type="text" class="form-control" name="upsells[]"> </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">Listlocal <input type="hidden" name="products[]" value="listlocal"></td>
                                    <td><input type="text" class="form-control" name="upsells[]"> </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" style="width: 33%; float: left;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;">File Upload</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="file" name="file" id="exampleInputFile">
                                        <p class="help-block">Example block-level help text here.</p></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover table-striped" style="width: 35%; float: left;">
                            <thead>
                                <tr>
                                    <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;" colspan="4">Sales After Support</th>
                                </tr>
                                <tr>
                                    <th style="text-align:left;">Group</th>
                                    <th style="text-align:center;">SAS Upsells</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:left; width: 100px; font-weight: bold;">SAS<input type="hidden" name="group[]" value="sas"></td>
                                    <td><input type="text" class="form-control" name="sas_cnt[]"> </td>
                                </tr>
                            </tbody>
                        </table>
                </div>

                <div class="box-footer">
                    <div class="form-group">
                        <label>Highlights</label>
                        <textarea id="editor1" name="highlights" class="form-control area" rows="3" placeholder="Enter text here ..."></textarea>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label style="margin-top: 30px;">Lowlights</label>
                        <textarea id="editor2" name="lowlights" class="form-control area" rows="3" placeholder="Enter text here..."></textarea>
                    </div>
                    <div class="foot-area">
                        <button type="reset" name="reset" class="btn btn-warning"><i class="fa fa-eraser"></i> Clear All</button>
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit Now</button>
                    </div>
                </div>
                </form>

            </div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <div class="box-header">
                    <h3 class="box-title">{{ $breakdown['name'] }}</h3>
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
                                <td><?= $cell ?></td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
<!--</div> nav-tabs-custom -->

@endsection

@section('additional_scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>

<script type="text/javascript">
$(function () {
    CKEDITOR.config.toolbar = [
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']}
    ];
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
});


$(document).ready(function () {
    $(".first").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".second").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".third").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".fourth").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".fifth").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".sixth").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".seventh").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
    $(".eight").each(function () {
        $(this).keyup(function () {
            calculateSum();
        });
    });
});

function calculateSum() {
    var sum_first = 0;
    var sum_second = 0;
    var sum_third = 0;
    var sum_fourth = 0;
    var sum_fifth = 0;
    var sum_sixth = 0;
    var sum_seventh = 0;
    var sum_eight = 0;
    $(".first").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_first += parseFloat(this.value);
        }

    });
    $(".second").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_second += parseFloat(this.value);
        }

    });
    $(".third").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_third += parseFloat(this.value);
        }

    });
    $(".fourth").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_fourth += parseFloat(this.value);
        }

    });
    $(".fifth").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_fifth += parseFloat(this.value);
        }

    });
    $(".sixth").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_sixth += parseFloat(this.value);
        }

    });
    $(".seventh").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_seventh += parseFloat(this.value);
        }

    });
    $(".eight").each(function () {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum_eight += parseFloat(this.value);
        }

    });
    document.getElementById('sum_offered').value = sum_first;
    document.getElementById('sum_handled').value = sum_second;
    document.getElementById('sum_over_in').value = sum_third;
    document.getElementById('sum_over_out').value = sum_fourth;
    document.getElementById('sum_emails').value = sum_fifth;
    document.getElementById('sum_expected').value = sum_sixth;
    document.getElementById('sum_planned').value = sum_seventh;
    document.getElementById('sum_unplanned').value = sum_eight;
}
</script>
@endsection