

@extends ('layouts.master')
@section('additional_styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<!-- Pace style -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/pace/pace.min.css") }}">

<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
<!-- Time Picker -->
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css") }}">
<style>

</style>
@endsection
 

@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
    <div class="box">
        <div class="box-body">
            <form action="{{ url('/irforms/edit/'.$irform->id) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div class="form-group">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Agent:</label>
                                <input type="text" name="agent" class="form-control" disabled value="{{ $irform->agent->name }}">
                        </div>
                        
                        <div class="col-md-6">
                            <label>Supervisor:</label><br>
                            <input type="text" name="supid" id="supervisor" class="form-control" value="{{ $irform->sup->name }}" disabled><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Type:</label><br>
                            <select class="form-control" id="type" name="type">
                                @if($irform->type == "Touchpoint Overbreak")
                                <option value="Touchpoint Overbreak" class="w" selected>Touchpoint Overbreak</option>
                                <option value="Touchpoint Overlunch" class="w">Touchpoint Overlunch</option>

                                @else
                                <option value="Touchpoint Overlunch" class="w" selected>Touchpoint Overlunch</option>
                                <option value="Touchpoint Overbreak" class="w">Touchpoint Overbreak</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Team:</label><br>
                            <input type="text" name="team" id="team" class="form-control" value="{{ $irform->dept->name }}" disabled><br>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                        <label>Summary:</label><br>
                        <textarea rows="5" name="summary" class="form-control" style="resize:none">{{ $irform->summary }}</textarea>
                        </div>
                        <div class="col-md-6">
                        <label>Violation:</label><br>
                        <h4 id="violation"></h4>
                        
                        </div>
 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Minutes Overbreak/Overlunch</label>
                            <input type="number" name="minutes" class="form-control input-lg" style="text-align:center" value="{{ $irform->minutes }}">
                        </div>
                        <div class="col-md-3">
                            <label>Attachments</label>
                            <input type="file" class="" name="attachments[]" multiple></center>
                            
                        </div>
                        <div class="col-md-6">
                            <label>Attached Files</label>
                            @if($attachments)
                            @foreach($attachments as $attachment)
                            <div class='form-group attachments'>
                                        <div class='pull-right box-tools'>
                                            <button type='button' class='btn bg-red btn-sm delete'> <i class='fa fa-times'></i></button>
                                        </div>
                                            <a href="../download/{{$attachment}}" value="{{$attachment}}" name="attachment[]">{{$attachment}}</a></center>
                                            <input type="text" name='attachments[]' value='{{$attachment}}' hidden>
                                    </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <hr>
                    
                    <button type="button" class="btn bg-red btn-sm back" value="{{$irform->id}}"><i class="fa fa-close"></i> Cancel</button>
                    <button type="submit" class="btn bg-blue btn-sm" value="{{$irform->id}}"><i class="fa fa-sticky-note-o"></i> Update Form</button>

                </div>
            </form>
        </div>
    </div>
                



@endsection

@section ('additional_scripts')
<!-- DataTables -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<!-- SlimScroll -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
<!-- FastClick -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/fastclick/fastclick.js") }}"></script>
<!-- PACE -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/pace/pace.min.js") }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<!-- timepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.js") }}"></script>
<script>
    $(document).ready(function()
    {
        $('#agent').on('change',function(){
            getAgent($('#agent').val());
        });
        $('.back').on("click", function() {
            window.location = "{{ url('/irforms') }}";
        });
        $(".attachments").on("click", '.delete', function() {
                if(confirm('Are you sure you want to delete this attachment/s?'))
                {
                    $(this).closest(".attachments").remove();
                }
        });
        getType($('#type').val());
        
        $('#type').on('change', function(){
            getType($('#type').val());
        });
        
        function getType(type) 
        {
            var type= type;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "post",
                url: "{{ url('/irforms/gettype') }}",
                data: {'_token': CSRF_TOKEN,
                       'type': type
                       },
                success: function(response) {
                    console.log(response);
                    $("#violation").text(response.violation);
                },
                error: function(e) {
                    alert("gg");
                }
            });
        }
        
        function getAgent(id) 
        {
            var id= id;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "post",
                url: "{{ url('/irforms/getagent') }}",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function(supervisor,team) {
                    
                    $('#supervisor').val(supervisor.lname);
                    $('#team').val(team.name);
                },
                error: function() {
                    alert("gg");
                }
            });
        }
    });
</script>

@endsection