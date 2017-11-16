@extends('layouts.master')

@section('additional_styles')
<style type="text/css">
    .foot-area{
        float: right;

    }
</style>
@endsection

@section('content')

<form name="myform" role="form" method="POST" action="masterreport/store">
    <div class="box">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover table-striped" style="margin-bottom: 10px;">
                <thead>
                    <tr>
                        <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px;" colspan="5">US WEBHOSTING AVAILABILITY</th>
                    </tr>
                    <tr>
                        <th style="text-align:left; vertical-align: middle;">Group</th>
                        <th style="text-align:center; vertical-align: middle;">Offered</th>
                        <th style="text-align:center; vertical-align: middle;">Handled</th>
                        <th style="text-align:center; vertical-align: middle;">Overflow In</th>
                        <th style="text-align:center; vertical-align: middle;">Overflow Out</th>
                    </tr>
                </thead>
                <tbody>
                    @for($x = 0; $x < count($pilot); $x++)
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">{{ $pilot[$x] }}</td>
                        <td><input type="text" class="first form-control" name="offered[]" value="{{ $offered[$x] }}"> </td>
                        <td><input type="text" class="second form-control" name="handled[]" value="{{ $handled[$x] }}"> </td>
                        <td><input type="text" class="third form-control" name="overflow_in[]" value="{{ $overflow_in[$x] }}"> </td>
                        <td><input type="text" class="fourth form-control" name="overflow_out[]" value="{{ $overflow_out[$x] }}"> </td>
                    </tr>
                    @endfor
                    @for($x = 0; $x < count($sum_offered); $x++)
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">Total</td>
                        <td><input type="text" name="sum_offered[]" class="form-control" placeholder="0" readonly id="sum_offered" value="{{ $sum_offered[$x] }}"></td>
                        <td><input type="text" name="sum_handled[]" class="form-control" placeholder="0" readonly id="sum_handled" value="{{ $sum_handled[$x] }}" /></td>
                        <td><input type="text" name="sum_over_in[]" class="form-control" placeholder="0" readonly id="sum_over_in" value="{{ $sum_over_in[$x] }}" /></td>
                        <td><input type="text" name="sum_over_out[]" class="form-control" placeholder="0" readonly id="sum_over_out" value="{{ $sum_over_out[$x] }}"/> </td>
                    </tr>
                    @endfor
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
                        @for($x = 0; $x < count($expected); $x++)
                        <td><input type="text" class="sixth form-control" name="expected[]" value="{{ $expected[$x] }}"> </td>
                        @endfor
                        @for($x = 0; $x < count($sum_expected); $x++)
                        <td><input type="text" name="sum_expected[]" class="form-control" placeholder="0" readonly id="sum_expected" value="{{ $sum_expected[$x] }}"/> </td>
                        @endfor
                    </tr>
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">Planned Leave</td>
                        @for($x = 0; $x < count($planned); $x++)
                        <td><input type="text" class="seventh form-control" name="planned[]" value="{{ $planned[$x] }}"> </td>
                        @endfor
                        @for($x = 0; $x < count($sum_planned); $x++)
                        <td><input type="text" name="sum_planned[]" class="form-control" placeholder="0" readonly id="sum_planned" value="{{ $sum_planned[$x] }}" /> </td>
                        @endfor
                    </tr>
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">Unplanned Leave</td>
                        @for($x = 0; $x < count($unplanned); $x++)
                        <td><input type="text" class="eight form-control" name="unplanned[]" value="{{ $unplanned[$x] }}"> </td>
                        @endfor
                        @for($x = 0; $x < count($sum_unplanned); $x++)
                        <td><input type="text" name="sum_unplanned[]" class="form-control" placeholder="0" readonly id="sum_unplanned" value="{{ $sum_unplanned[$x] }}" /> </td>
                        @endfor
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
                    @for($x = 0; $x < count($emails); $x++)
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">{{ $workpool[$x] }}<input type="hidden" name="workpool[]" value="{{ $workpool[$x] }}"></td>
                        <td><input type="text" class="fifth form-control" name="emails[]" value="{{ $emails[$x] }}"> </td>
                    </tr>
                    @endfor
                    <tr>
                        @for($x = 0; $x < count($sum_emails); $x++)
                        <td style="text-align:left; width: 100px; font-weight: bold;">Total</td>
                        <td><input type="text" name="sum_emails[]" class="form-control" placeholder="0" readonly id="sum_emails" value="{{ $sum_emails[$x] }}"/></td>
                        @endfor
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
                    @for($x = 0; $x < count($products); $x++)
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">{{ ucfirst($products[$x]) }} <input type="hidden" name="products[]" value="difm" value="{{ $products[$x] }}"></td>
                        <td><input type="text" class="form-control" name="upsells[]" value="{{ $upsells[$x] }}"> </td>
                    </tr>
                    @endfor
                </tbody>
            </table>

            <table class="table table-bordered table-hover table-striped" style="width: 33%; float: left;">
                <thead>
                    <tr>
                        <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;">File input</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="file" id="exampleInputFile">
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
                    @for($x = 0; $x < count($group); $x++)
                    <tr>
                        <td style="text-align:left; width: 100px; font-weight: bold;">{{ $group[$x] }}<input type="hidden" name="group[]" value="{{ $group[$x] }}"></td>
                        <td><input type="text" class="form-control" name="sas_cnt[]" value="{{ $sas_cnt[$x] }}"> </td>
                    </tr>
                    @endfor
                </tbody>
            </table>

        </div>

        <!-- /.box-body -->
        <div class="box-footer">
            <div class="form-group">
                <label>Highlights</label>
                <textarea id="editor1" name="highlights" class="form-control area" rows="3" placeholder="Enter text here ...">{{ $highlights }}</textarea>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label style="margin-top: 30px;">Lowlights</label>
                <textarea id="editor2" name="lowlights" class="form-control area" rows="3" placeholder="Enter text here...">{{ $lowlights }}</textarea>
            </div>
<!--            <div class="foot-area">
                <button type="reset" name="reset" class="btn btn-warning"><i class="fa fa-eraser"></i> Clear All</button>
                <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit Now</button>
            </div>-->
        </div>
</form>
<!-- /.box-footer-->
</div>
    
    
@endsection

@section('additional_scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

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