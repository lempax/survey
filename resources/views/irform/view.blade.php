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
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Agent:</label>
                            <h4> {{ $irform->agent->name }}</h4>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Supervisor:</label><br>
                            <h4>{{ $irform->sup->name }}</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Type:</label><br>
                            @if ($irform->type == 2)
                            <h4 id="type">Touchpoint Overlunch</h4>
                            @elseif($irform->type == 3)
                            <h4 id="type">Touchpoint Overbreak</h4>
                            @endif
                            
                        </div>
                        <div class="col-md-6">
                            <label>Team:</label><br>
                            <h4>{{ $irform->dept->name }}</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                        <label>Summary:</label><br>
                        <h4>{{ $irform->summary }}</h4>
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
                              <h4>{{ $irform->minutes }}</h4>
                        </div>
                        <div class="col-md-3">
                            <label>Attached Files</label><br>
                               @if($attachments)
                               @foreach($attachments as $attachment)

                               <a href="./download/{{$attachment}}" value="{{$attachment}}" name="attachment[]">•{{$attachment}}</a><br>
                               @endforeach
                               @endif
                        </div>
                    </div>
                    <hr>

                <button type="button" class="btn bg-blue btn-sm back" value="{{$irform->id}}"><i class="fa fa-arrow-left"></i> Back</button>                    
                <button type="button" class="btn bg-green btn-sm edit" value="{{$irform->id}}"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn bg-red btn-sm delete" value="{{$irform->id}}"><i class="fa fa-close"></i> Delete</button>
                
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
     $(document).ready(function(){
        $('.edit').on("click", function() {
            window.location = "{{ url('/irforms/edit/'.$irform->id) }}";
        });
        $('.delete').on("click", function() {
            window.location = "{{ url('/irforms/delete/'.$irform->id) }}";
        });
        $('.back').on("click", function() {
            window.location = "{{ url('/irforms') }}";
        });
        getType($('#type').text());
        
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
    });
    
</script>    

@endsection


