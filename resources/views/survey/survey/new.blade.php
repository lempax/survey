@extends('layouts.master')
@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Survey</h3>
    </div>
    <div class="box-body">
        <form method="POST" action="create" id="boolean">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="title">Batch #</label>
                <input name="batch" id="batch" type="text" class="form-control" placeholder="#">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input name="title" id="title" type="text" class="form-control" placeholder="Survey Title goes here..">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="editor" class="form-control" style="height: 300px;" placeholder="Survey Description goes here.."></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-primary">Submit Survey</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<script>
    $(function () {
    $("#editor").wysihtml5();
 });
</script>
@endsection