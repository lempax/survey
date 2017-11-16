@extends('layouts.master')
@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')
<div class="box">
    <div class="box-header">Edit Survey</div>
    <div class="box-body">
        <form method="POST" action="/survey/{{ $survey->id }}/update">
            {{ method_field('PATCH') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <input type="text" name="title" id="title" class="form-control" value="{{ $survey->title }}">
            </div>
            <div class="form-group">
                <textarea id="editor" name="description" class="form-control">{{ $survey->description }}</textarea>
            </div>
            <div class="input-field col s12">
                <button class="btn waves-effect waves-light">Update</button>
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