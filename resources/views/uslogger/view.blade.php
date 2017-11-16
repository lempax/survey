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
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Team</label><br>
                            <h4>{{$uslogger->dept->name}}</h4>
                        </div>
                        
                        <div class="col-md-3">
                            <label>Agent Name:</label><br>
                            <h4>{{$uslogger->usagent-> lname}}</h4>
                        </div>

                        <div class="col-md-3">
                            <label>Order Date:</label><br>
                            <h4>{{$uslogger->orderdate}}</h4>
                        </div>
                    </div>
                    <br><hr><br>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Case ID:</label><br>
                            <h4>{{$uslogger->caseid}}</h4>
                        </div>
                    
                        <div class="col-md-3">
                            <label>Contract ID:</label><br>
                            <h4>{{$uslogger->contractid}}</h4>
                        </div>

                        <div class="col-md-3">
                            <label>Product Description:</label><br>
                            <h4>{{$uslogger->desc}}</h4>
                        </div>
                        
                    </div>
                    <br>
                    <button type="button" class="btn bg-red btn-sm back"><i class="fa fa-arrow-left "></i> Back</button>
                    @if(\Auth::user()->roles == 'AGENT')
                    <button type="button" class="btn bg-blue btn-sm edit"><i class="fa fa-sticky-note-o" value="{{$uslogger->id}}" ></i> Edit</button>
                    @endif

                </div>
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
    $('.back').on("click", function() {
            window.location = "{{ url('/uslogger') }}";
    });
    $('.edit').on("click", function() {
            window.location = "{{ url('/uslogger/edit/'.$uslogger->id) }}";
    });
});
</script>

@endsection