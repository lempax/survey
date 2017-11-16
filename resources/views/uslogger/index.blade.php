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
<style>
    table, td, th
    {
        border:1px solid black;
    }
    #table1
    {
        table-layout: fixed;
        border-collapse: collapse;
        width:100%;
        text-align: center;
    }
    table input
    {
        width: 100%;
        border: none;
    }
</style>
@endsection


@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
    <div class="box">
        <div class="box-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>LOGGER ID</th>
                  <th>AGENT</th>
                    <th>TEAM</th>
                    <th>ORDER DATE</th>
                    <th>CASE ID</th>
                    <th>CONTRACT ID</th>
                    <th>CREATED AT</th>
                    <th>OPTIONS</th>
                </tr>
                </thead>
                <tbody id ="tformbody">
                    @foreach($usloggers as $uslogger)
                <tr>
                <td>{{ $uslogger->id }}</td>
                <td>{{ $uslogger->usagent->lname.', '.$uslogger->usagent->fname}}</td>
                <td>{{ $uslogger->dept->name }}</td>
                <td>{{ $uslogger->orderdate }}</td>
                <td>{{ $uslogger->caseid }}</td>
                <td>{{ $uslogger->contractid }}</td>     
                <td>{{ $uslogger->created_at }}</td>
                <td>
                <button type="button" class="btn bg-blue btn-sm view" value="{{$uslogger->id}}"><i class="fa fa-eye"></i> View</button> 
                
                @if(\Auth::user()->roles == 'AGENT')
                <button type="button" class="btn bg-green btn-sm edit" value="{{$uslogger->id}}"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn bg-red btn-sm delete" value="{{$uslogger->id}}"><i class="fa fa-close"></i> Delete</button>
                @endif
                </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <form action="uslogger/create" method="post">
                {{ csrf_field() }}
                
                @if(\Auth::user()->roles == 'AGENT')
                <input type="submit" class="btn btn-primary" value="Log SAS Case">
                @endif
                
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

<script>
  $(function () {
    $("#example1").DataTable({
                "lengthChange": false ,
                "ordering":false
    });
    });
    
     $(document).ready(function(){
        $('#example1').on("click", '.edit', function() {
            window.location = 'uslogger/edit/'+$(this).val();
        });
        $('#example1').on("click", '.delete', function() {
            window.location = 'uslogger/delete/'+$(this).val();
        });
        $('#example1').on("click", '.view', function() {
        window.location = 'uslogger/view/'+$(this).val();
        });
    });

</script>

@endsection
