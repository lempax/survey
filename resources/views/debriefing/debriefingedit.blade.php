@extends('layouts.master')

@section('content')

<form method="POST" action="{{ asset('/debriefing/update') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Edit Saved Debriefing Report</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> You can click the <i>(SAVE AS DRAFT) </i> button, if you still want to edit your case later. Click <i>(SEND REPORT)</i> to immediately send your case as an email. 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissable" aria-hidden="true"  style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-warning"></i><b> FAILED :</b>
                Please fill in all necessary input fields.
            </div>
        @endif
        @if(Session::has('flash_message'))
            <div class="alert alert-success" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
            </div>
        @endif

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Created By: <font color="red">*</font></td>
                        <td><input type="hidden" name="name" value="<?php echo $temp->name; ?>">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Supervisor:</td>
                        <td><b>{{ Auth::user()->superior->name }}</b></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Type of Report: <font color="red">*</font></td>
                        <td>
                            <select name="reporttype" value="<?php echo $temp->reporttype; ?>" class="form-control" style="width: 300px;">
                                <optgroup label="Select Type">
                                 <option><?php echo $temp->reporttype; ?></option>
                                 <?= ($temp->reporttype == "Debriefing Report" ? '<option>Debriefing Report (Workpool Incharge)</option>' : '<option>Debriefing Report</option>') ?>
                                </optgroup>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Category: <font color="red">*</font></td>
                        <td>
                            <select name="category" value="<?php echo $temp->category; ?>" class="form-control" style="width: 150px;">
                                <optgroup label="Select Category">
                                 <option><?php echo $temp->category; ?></option>
                                 <?= ($temp->category == "Normal" ? '<option>Outage</option>' : '<option>Normal</option>') ?>
                                </optgroup>
                           </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Shift Schedule: <font color="red">*</font></td>
                        <td>
                            <select name="shift" value="<?php echo $temp->shift; ?>" class="form-control"  style="width: 150px;">
                                <option><?php echo $temp->shift; ?></option>
                                <?= ($temp->shift == "0100-1000" ? '' : '<option>0100-1000</option>') ?>
                                <?= ($temp->shift == "0200-1100" ? '' : '<option>0200-1100</option>') ?>
                                <?= ($temp->shift == "0500-1400" ? '' : '<option>0500-1400</option>') ?>
                                <?= ($temp->shift == "0600-1500" ? '' : '<option>0600-1500</option>') ?>
                                <?= ($temp->shift == "0700-1600" ? '' : '<option>0700-1600</option>') ?>
                                <?= ($temp->shift == "0800-1700" ? '' : '<option>0800-1700</option>') ?>
                                <?= ($temp->shift == "0900-1800" ? '' : '<option>0900-1800</option>') ?>
                                <?= ($temp->shift == "1000-1900" ? '' : '<option>1000-1900</option>') ?>
                                <?= ($temp->shift == "1100-2000" ? '' : '<option>1100-2000</option>') ?>
                                <?= ($temp->shift == "1200-2100" ? '' : '<option>1200-2100</option>') ?>
                                <?= ($temp->shift == "1300-2200" ? '' : '<option>1300-2200</option>') ?>
                                <?= ($temp->shift == "1330-2230" ? '' : '<option>1330-2230</option>') ?>
                                <?= ($temp->shift == "1400-2300" ? '' : '<option>1400-2300</option>') ?>
                                <?= ($temp->shift == "1500-2400" ? '' : '<option>1500-2400</option>') ?>
                                <?= ($temp->shift == "1600-0100" ? '' : '<option>1600-0100</option>') ?>
                                <?= ($temp->shift == "1700-0200" ? '' : '<option>1700-0200</option>') ?>
                                <?= ($temp->shift == "1800-0300" ? '' : '<option>1800-0300</option>') ?>
                                <?= ($temp->shift == "1900-0400" ? '' : '<option>1900-0400</option>') ?>
                                <?= ($temp->shift == "2000-0500" ? '' : '<option>2000-0500</option>') ?>
                                <?= ($temp->shift == "2100-0600" ? '' : '<option>2100-0600</option>') ?>
                                <?= ($temp->shift == "2200-0700" ? '' : '<option>2200-0700</option>') ?>
                                <?= ($temp->shift == "2230-0730" ? '' : '<option>2230-0730</option>') ?>
                                <?= ($temp->shift == "2300-0800" ? '' : '<option>2300-0800</option>') ?>
                                <?= ($temp->shift == "2400-0900" ? '' : '<option>2400-0900</option>') ?>
                                <?= ($temp->shift == "RES" ? '' : '<option>RES</option>') ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Content: <font color="red">*</font></td>
                        <td><textarea name="content" id="editor1" class="ckeditor"><?php echo $temp->content; ?> </textarea></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="<?php echo $temp->id; ?>">
        </div>
        <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <input type="submit" name="save" class="btn btn-warning" value="Save As Draft">
                <input type="submit" name="send" class="btn btn-primary" value="Send Report">
            </div>
        </div>
    </div>
</form>

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
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('reason_editor');
        CKEDITOR.replace('plan_editor');
        
    });
    
</script>
@endsection

 
