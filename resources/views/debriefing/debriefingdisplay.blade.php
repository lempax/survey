@extends('layouts.master')

@section('content')

<form method="POST" action="{{ asset('/debriefing/update') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">View Debriefing Report</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> You can click the <i>(SAVE AS DRAFT) </i> button, if you still want to edit your case later. Click <i>(SEND REPORT)</i> to immediately send your case as an email. 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>

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
                            <input readonly type="text" class="form-control" name="reporttype" style="width: 300px;" value="<?php echo $temp->reporttype; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Category: <font color="red">*</font></td>
                        <td>
                            <input readonly type="text" class="form-control" name="category" style="width: 200px;" value="<?php echo $temp->category; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Shift Schedule: <font color="red">*</font></td>
                        <td>
                            <input readonly type="text" class="form-control" name="shift" style="width: 200px;" value="<?php echo $temp->shift; ?>">
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
        CKEDITOR.config.readOnly = true;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('reason_editor');
        CKEDITOR.replace('plan_editor');
        
    });
    
</script>
@endsection

 
