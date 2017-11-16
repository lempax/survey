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
@endsection


@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<div class="box">
    <div class="box-body">
        @if(\Auth::user()->roles == "SOM" || \Auth::user()->roles == "MANAGER")
        <div class="row">
            <div class="col-md-2">
                <select class = "form-control" id = "teamName">
                    <option value="none" class="w" selected disabled hidden>Select Supervisor</option>
                    @foreach($supervisors as $supervisor)
                        <option value="{{ $supervisor->uid }}" class="w" >{{ $supervisor->lname.', '.$supervisor->fname }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
        <table id="coachingTargetList" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>REPORT ID</th>
                    <th>CREATED BY</th>
                    <th>DATE CREATED</th>
                    <th>OPTIONS</th>
                </tr>
            </thead>
            <tbody id ="tformbody">
                @if(count($reports) > 0)
                <?php 
                    
                    $sCount = count($reports);
                ?>
                @if(\Auth::user()->roles == "SUPERVISOR")
                @foreach($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->createdBy->name }}</td>
                    <td>{{ $report->created_at }}</td>
                    <td>
                        <button type="button" class="btn bg-teal btn-sm view" value="{{$report->id}}">View</button>
                        <button type="button" class="btn bg-blue btn-sm edit" value="{{$report->id}}">Edit</button>
                        <button type="button" class="btn bg-red btn-sm delete" value="{{$report->id}}">Delete</button>
                       
                        
                    </td>
                </tr>
                @endforeach
                
                @endif
                @endif
            </tbody>
        </table>

        @if(\Auth::user()->roles == "SUPERVISOR" )
        <button type="button" id="createReport" class="btn btn-sm bg-blue">Create Report</button>
        <button type="button" class="btn btn-sm bg-blue" id="viewCoachingForms">View Coaching Forms</button>
        @endif
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

<script>
    $(function () 
    {
        $("#coachingTargetList").DataTable
        ({
            "lengthChange": false,
            "ordering":false         
        });
    });
    $(document).ready(function(){
        $("#viewCoachingForms").on("click", function() {
            window.location = 'coachingform';
        });
        
        $('.view').on("click", function() {
            window.location = 'coachingtarget/'+$(this).val();
        });
        
        $('.edit').on("click", function() {
            window.location = 'coachingtarget/edit/'+$(this).val();
        });
        $('.delete').on("click", function() {
            window.location = 'coachingtarget/delete/'+$(this).val();
        });
         $("#createReport").on("click", function() {
            window.location = 'coachingtarget/createtarget';
        });
    });
</script>
@endsection