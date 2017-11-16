@extends('layouts.master')

@section('additional_styles')
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form style="margin-top: 15px;padding: 10px;" action="{{ URL::to('sas/submit') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            <table class="table table-bordered table-hover table-striped" style="margin: 10px 10px 10px 10px; width: 500px;">
                <thead>
                    <tr>
                        <th style="text-align: center; background-color: #00A65A; color: #fff; letter-spacing: 3px; text-transform: uppercase;">SAS PAYOUT FILE UPLOAD</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file">
                            <p class="help-block">Upload CSV file. </p> <button class="btn btn-primary">Import File</button></td>
                    </tr>
                </tbody>
            </table><br>
            </form>
        </div>
    </div>
</div>
@endsection


@section('additional_scripts')
@endsection