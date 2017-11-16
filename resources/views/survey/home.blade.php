@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset ("/bower_components/bootstrap-sweetalert/dist/sweetalert.css") }}">
<link href="{{ asset("tag-it/css/jquery.tagit.css") }}"  rel="stylesheet" type="text/css">
<link href="{{ asset("tag-it/css/tagit.ui-zendesk.css") }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="vertical-align: middle;">Recent Surveys</h3>
        <span style="float:right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> New Survey</button></span>
    </div>
    <div class="box-body">
        <table id="table" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Title</th>
<!--                    <th>Description</th>-->
                    <th>Batch No.</th>
                    <th>No. of Invited</th>
                    <th>No. of Respondents</th>
                    <th>Logged By</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                <tr>
                    <td> <a href="{{ $survey->id }}">{{ $survey->title }}</a> </td>
<!--                    <td> {!! $survey->description !!} </td>-->
                    <td> {{ $survey->batch_no }} </td>
                    <td>{{ count(json_decode($survey->invited)) }}</td>
                    <td> {{ $survey->respondents }} </td>
                    <td> {{ \App\Employee::where('uid', $survey->user_id)->first()->name }} </td>
                    <td> {{ date("F j, Y", strtotime($survey->created_at)) }} </td>
                    <td>
                        <input type="checkbox" name="status[]" class="status" id="{{ $survey->id }}" data-size="small" <?= $survey->status === 'true' ? 'checked' : '' ?> data-toggle="toggle" data-on="Open" data-off="Closed" data-onstyle="success" data-offstyle="danger">
                    </td>
                    <td>
                        <a href="view/{{ $survey->id }}" class="btn btn-success btn-xs" title="Answer Exam"><i class="fa fa-fw fa-send"></i></a>
                        <a href="{{ $survey->id }}" class="btn btn-danger btn-xs" title="Edit Exam"><i class="fa fa-pencil fa-lg"></i></a>
                        <a href="scores/{{ $survey->id }}" class="btn btn-primary btn-xs" title="View Scores of Answers"><i class="fa fa-fw fa-book fa-lg"></i></a>
                        <a href="answers/{{ $survey->id }}" class="btn btn-warning btn-xs" title="View Survey Answers"><i class="fa fa-folder-open fa-lg"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<form method="POST" action="create" id="boolean">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 4px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title text-bold" id="myModalLabel" style="color: #1778c3">Add Survey</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-6">
                        <label>Batch no. <i class="fa fa-fw fa-question-circle"></i></label>
                        <input name="batch_no" id="batch" placeholder="Number" type="text" class="form-control" style="border-radius: 4px;" required>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Date <i class="fa fa-fw fa-question-circle"></i></label>
                        <input type="text" name="" value="{{ date('F j, Y g:i a') }}" class="form-control" style="border-radius: 4px;">
                    </div>

                    <div class="form-group col-md-12" style="margin-bottom: 0px;">
                        <label>Survey Respondents <i class="fa fa-fw fa-question-circle"></i></label>
                        <input type="text" name="invited" id="mySingleField" style="display: none;">
                        <ul id="singleFieldTags" style="border-radius: 4px; border-color: #d2d6de;"></ul>
                    </div>

                    <div class="form-group col-md-12">
                        <label>Survey Title <i class="fa fa-fw fa-question-circle"></i></label>
                        <input name="title" id="title" type="text" class="form-control" placeholder="Survey Title" style="border-radius: 4px;" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Short Description <i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="description" id="editor" class="form-control" placeholder="What survey is about" style="border-radius: 4px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">Close</button>
                    <button type="reset" name="reset" class="btn btn-warning"> Clear All</button>
                    <input type="submit" id="submit" name="submit" class="btn btn-primary" values="Submit">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset("tag-it/js/tag-it.js") }}" type="text/javascript" charset="utf-8"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset ('/bower_components/bootstrap-sweetalert/dist/sweetalert.min.js') }}"></script>
<script>
$(function () {
    $('#table').DataTable();
    $('#editor').wysihtml5({
        toolbar: {
            "font-styles": true, 
            "emphasis": true, // Italics, bold, etc.
            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, // Button which allows you to edit the generated HTML.
            "link": true, // Button to insert a link.
            "image": false, // Button to insert an image.
            "color": false, // Button to change color of font
            "blockquote": false, // Blockquote
        }
    });
});
</script>

<script>
$(function(){
   // var sampleTags = ['c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy', 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];
    var sampleTags = [<?= $_emails ?>];
    //-------------------------------
    // Minimal
    //-------------------------------
    $('#myTags').tagit();

    //-------------------------------
    // Single field
    //-------------------------------
    $('#singleFieldTags').tagit({
        availableTags: sampleTags,
        // This will make Tag-it submit a single form value, as a comma-delimited field.
        singleField: true,
        singleFieldNode: $('#mySingleField')
    });

    // singleFieldTags2 is an INPUT element, rather than a UL as in the other 
    // examples, so it automatically defaults to singleField.
    $('#singleFieldTags2').tagit({
        availableTags: sampleTags
    });

    //-------------------------------
    // Preloading data in markup
    //-------------------------------
    $('#myULTags').tagit({
        availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
        // configure the name of the input field (will be submitted with form), default: item[tags]
        itemName: 'item',
        fieldName: 'tags'
    });

    //-------------------------------
    // Tag events
    //-------------------------------
    var eventTags = $('#eventTags');

    var addEvent = function(text) {
        $('#events_container').append(text + '<br>');
    };

    eventTags.tagit({
        availableTags: sampleTags,
        beforeTagAdded: function(evt, ui) {
            if (!ui.duringInitialization) {
                addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
            }
        },
        afterTagAdded: function(evt, ui) {
            if (!ui.duringInitialization) {
                addEvent('afterTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
            }
        },
        beforeTagRemoved: function(evt, ui) {
            addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
        },
        afterTagRemoved: function(evt, ui) {
            addEvent('afterTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
        },
        onTagClicked: function(evt, ui) {
            addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
        },
        onTagExists: function(evt, ui) {
            addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
        }
    });

    //-------------------------------
    // Read-only
    //-------------------------------
    $('#readOnlyTags').tagit({
        readOnly: true
    });

    //-------------------------------
    // Tag-it methods
    //-------------------------------
    $('#methodTags').tagit({
        availableTags: sampleTags
    });

    //-------------------------------
    // Allow spaces without quotes.
    //-------------------------------
    $('#allowSpacesTags').tagit({
        availableTags: sampleTags,
        allowSpaces: true
    });

    //-------------------------------
    // Remove confirmation
    //-------------------------------
    $('#removeConfirmationTags').tagit({
        availableTags: sampleTags,
        removeConfirmation: true
    });

});
</script>

<script>
$(document).ready(function() {
    $('.status').change(function(){
        var _this = $(this);
        var status = $(this).val();
        var id = $(this).prop('id');
        var data = {
                'status': $(this).is(':checked'),
                '_token': '{{ CSRF_TOKEN() }}',
                'id': id
        };

        if(_this.is(":checked")){
            var text = 'Exam will be opened.';
            var button = 'btn-success';
            var confirm_title = 'Opened';
            var button_text = 'Yes, Open it.';
            var toggle_status = 'off';
        }else{
            var text = 'Exam will be closed.';
            var button = 'btn-danger';
            var confirm_title = 'Closed';
            var button_text = 'Yes, Close it.';
            var toggle_status = 'on';
        }

        swal({
            title: "Are you sure?",
            text: text,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: button,
            confirmButtonText: button_text,
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: confirm_title,
                        text: 'Email is now sent.',
                        type: "success"
                    });

                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        url: '{{ URL::to("survey/status") }}',
                        data: data,
                        success: function(response){
                           console.log(response);
                        },
                        error: function(){
                            console.log(status);
                        }
                    });
                } else {
                    _this.bootstrapToggle(toggle_status);
                    swal("Cancelled", "Status is not changed.", "error");
                }
        });
        console.log(data);
    });
    
    $('#submit').click(function(){
        var data = {
            'batch': $('#batch').val(),
            'invited': $('#invited').val(),
            'title': $('#title').val(),
            'description': $('#editor').val()
        };
        
        $.ajax({
           type: 'POST',
           dataType: 'JSON',
           url: '{{ URL::to('') }}',
           data: data,
           success: function(data){
               $('#table').append("<tr><td>"+ data.title +"</td><td>"+ data.description +"</td><td>"+ data.invited +"</td><td>"+ data.loggedby +"</td><td>"+ data.created_on +"</td><td>"+ data.status +"</td><td>"+ data.id +"</td></tr>");
           },
           error: function(e){
               console.log(e.status);
           }
        });
    });
});
</script>
@endsection

