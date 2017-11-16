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
            <form action="{{url('/uslogger/edit/'.$uslogger->id)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                        Team<br>
                        <input class="form-control" disabled value="{{$team->name}}"> <br>
                        <input type="text" name="team" value="{{$team->gid}}" hidden="hidden">

                        Agent Name:<br>
                        <input class="form-control" disabled value="{{$agent->lname.', '.$agent->fname}}" ><br>
                        <input type="text" name="name" value="{{$agent->uid}}" hidden="hidden" >

                        Order Date:<br>
                        <input class="form-control" type="date" name="orderdate" value="{{$uslogger->orderdate}}"><br>

                        Case ID:<br>
                        <input class="form-control" type="text" name="caseid" value="{{$uslogger->caseid}}"><br>

                        Contract ID:<br>
                        <input class="form-control" type="text" name="contractid" value="{{$uslogger->contractid}}"><br>

                        Product Description:<br>
                        <input class="form-control" type="text" name="desc" value="{{$uslogger->desc}}"><br>
                        
                        </div>
                    </div>

                    

                    <button type="button" class="btn bg-red btn-sm back"><i class="fa fa-close"></i> Cancel</button>
                    <button type="submit" class="btn bg-blue btn-sm"><i class="fa fa-sticky-note-o"></i> Update</button>

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
        $('.back').on("click", function() {
            window.location = "{{ url('/uslogger') }}";
        });
    });
</script>

@endsection


