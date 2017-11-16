@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="vertical-align: middle;">Exam Answers</h3>
        <span style="float:right">
            <a href="{{ URL::to("survey/downloadexcel/".$survey->id." ") }}" class="btn btn-primary" title="Download Excel"><i class="fa fa-download"></i>&nbsp; Download Answers</a>
        </span>
    </div>
    <div class="box-body">
        <table id="table" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Answer ID</th>
                    <th>Employee</th>
                    <th>Exam</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exam_answers AS $exam_answer)
                <?php $user = \App\Employee::where('uid', $exam_answer->user_id)->first(); ?>
                <tr>
                    <td><a href="{{ URL::to("survey/exam_answer/".$exam_answer->answer_id."/".$exam_answer->user_id." ") }}">{{ $exam_answer->answer_id }}</a></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ ucwords($survey->title) }}</td>
                    <td><small class="label label-success">Complete</small></td>
                    <td>{{ date("F j, Y", strtotime($exam_answer->created_at)) }}</td>
                    <td>{{ date("g:i a", strtotime($exam_answer->created_at)) }}</td>
                    <td>
                        <a href="{{ URL::to("survey/exam_answer/".$exam_answer->answer_id."/".$exam_answer->user_id." ") }}" class="btn btn-success btn-xs" title="View Answer"><i class="fa fa-send"></i></a>
                        <a href="{{ URL::to("survey/downloadpdf/".$exam_answer->answer_id."/".$exam_answer->user_id." ") }}" class="btn btn-danger btn-xs" title="download PDF"><i class="fa fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

<script>
$(document).ready(function () {
    $('#table').DataTable({
        order: [
            [0, 'desc']
        ],
    });
});
</script>
@endsection