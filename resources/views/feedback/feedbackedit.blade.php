@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<form method="POST" action="{{ asset('/feedback/create') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">View Feedback</h3>
        </div>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> This tool will be used solely by Mail.com agents to report mishandled cases, which will be reviewed by Mail.com Quality Assurance Officer.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>

        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Your Email Address:</td>
                        <td><input readonly type="text" name="email" value="<?php echo $temp->email; ?>" class="form-control" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Agent Involved:</td>
                        <td>
                            <?php $agent = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('uid', '=', $temp->agent)->get(); ?>
                            @foreach($agent as $agent1)
                                <input readonly name="agent" value="<?php echo $agent1->fname." ".$agent1->lname ?>" class="form-control"  style="width: 200px;">
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Other Agent Involved:</td>
                        <td>
                            <?php $otheragent = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('uid', '=', $temp->other_agent)->get(); ?>
                            @foreach($otheragent as $agent2)
                                <input readonly name="other_agent" value="<?php echo $agent2->fname." ".$agent2->lname ?>" class="form-control"  style="width: 200px;">
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Customer Number:</td>
                        <td><input readonly type="text" class="form-control" name="customer_number" style="width: 200px;" value="<?php echo $temp->customer_number; ?>"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Case ID:</td>
                        <td><input readonly type="text" class="form-control" name="case_id" value="<?php echo $temp->case_id; ?>" style="width: 200px;"></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">Description of the Problem:</td>
                        <td><textarea name="problem" id="problem" class="ckeditor"> <?php echo $temp->problem; ?> </textarea></td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;">How can this be solved?</td>
                        <td><textarea name="solution" id="solution" class="ckeditor"> <?php echo $temp->solution; ?> </textarea></td>
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
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript">
    $(function () {
        $('#table_breakdown').DataTable();
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
        CKEDITOR.replace('problem');
        CKEDITOR.replace('solution');
    });
    
</script>
@endsection


