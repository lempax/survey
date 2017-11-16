@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')

<!-- Default box -->
<form role="form" method="POST" action="{{ asset('/sas/update') }}">
    <input type="hidden" name="_method" value="PUT"/>
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">View Case</h2></div><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Form cannot be edited.
            </div>
        </div>
        <div class="box-body">
            <div>
                @if($errors->any())
                    <div class="alert alert-danger" aria-hidden="true">
                        <p>Warning :</p>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if(Session::has('flash_message'))
                    <div class="alert alert-success" aria-hidden="true">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
            <table class="table table-bordered">
                <input type="hidden" name="id" value="<?php echo $data1->id; ?>"/>
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>View Case</center></th>
                    <tr>
                        <th style="width: 150px">Date: </th>
                        <td><?php echo $date = date("F j, Y, g:i a"); ?></td>
                    </tr>
                    <tr>
                        <th style="width: 150px">Team: </th>
                        <td><input type="hidden" name="team_name" value="<?php echo $data1->team_name ?>"/>{{  Auth::user()->department->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 150px;">Agent Name: </th>
                        <td>
                            <div class="form-group" style="width: 220px">
                                <?php $agent_name = \App\Employee::where('uid', $data1->agent_name)->first(); ?>
                                <input readonly type="text" name="agent_name" class="form-control" style="width: 150px;"  value="<?php echo $agent_name->name; ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 160px">Total Calls of the Week: </th>
                        <td><input readonly class="form-control" type="text" name="total_calls" style="width: 150px;" value="<?php echo $data1->total_calls; ?>"></input></td>
                    </tr>
                    <tr>
                        <th style="padding-top: 70px; width: 150px;">Reason for <br>Zero Sales: </th>
                        <td>
                            <textarea readonly id="ckeditor1" name="reasons"><?php echo $data1->reasons; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-top: 70px; width: 150px">Supervisor <br>Action Plan: </th>
                        <td>
                            <textarea readonly id="ckeditor2" name="sup_actionplan"><?php echo $data1->sup_actionplan; ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
        </div>
    </div>
</form>

@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
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
            CKEDITOR.replace('ckeditor1');
            CKEDITOR.replace('ckeditor2');
        });
</script>
@endsection
