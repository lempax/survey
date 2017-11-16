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
<meta name ="csrf-token" content = "{{ csrf_token() }}"/>
    <div class="box">
        <div class="box-body">
            <form action="store" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="text" name="supervisor_id" id="supervisor_id" hidden>
                <input type="text" name="team_id" id="team_id" hidden>
                <div class="form-group">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Agent:</label>
                            <select class="form-control" name="agent" id="agent" required="required">
                                <option value="none" class="w" selected disabled hidden>Select Agent</option>
                                @foreach($agents as $agent)
                                <option value="{{ $agent->uid }}">{{ $agent->lname.', '.$agent->fname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Supervisor:</label><br>
                            <input type="text" name="supid" id="supervisor" class="form-control" value="" disabled><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Type:</label><br>
                            <select class="form-control"id="type" name="type" required>
                                <option value="none" class="w" selected disabled hidden>Select Type</option>
                                <option value="3" class="w">Touchpoint Overbreak</option>
                                <option value="2" class="w">Touchpoint Overlunch</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Team:</label><br>
                            <input type="text" name="team" id="team" class="form-control" value="" disabled><br>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                        <label>Summary:</label><br>
                        <textarea rows="5" name="summary" class="form-control" placeholder="Enter your comment" style="resize:none" required="required"></textarea>
                        </div>
                        <div class="col-md-6">
                        <label>Violation:</label><br>
                        <div id="violation" name="violation"></div>

                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Minutes Overbreak/Overlunch</label>
                            <input type="number" name="minutes" class="form-control input-lg" style="text-align:center"  required="required">
                        </div>
                        <div class="col-md-3">
                            <label>Attachments</label>
                            <input type="file" class="" name="attachments[]" multiple></center>
                        </div>
                        <div class="col-md-3">
                            <label>Attached Files</label>
                        </div>
                    </div>
                    <hr>

                    <button type="button" class="btn bg-red btn-sm back"><i class="fa fa-close"></i> Cancel</button>
                    <button type="submit" class="btn bg-blue btn-sm"><i class="fa fa-sticky-note-o"></i> Create Form</button>

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
        $('#type').on('change', function(){
            getType($('#type').val());
        });
        $('.back').on("click", function() {
            window.location = "{{ url('/irforms') }}";
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
                success: function(response) {
                    console.log(response);
                    $('#supervisor').val(response.supervisor.lname+', '+response.supervisor.fname);
                    $('#team').val(response.team.name);
                    $('#supervisor_id').val(response.supervisor.uid);
                    $('#team_id').val(response.team.gid);
                    console.log(response.supervisor.uid);
                    console.log(response.team.gid);
                },
                error: function(e) {
                    console.log(e.responseText);
                    alert("gg");
                }
            });
        }
    });
</script>

@endsection
