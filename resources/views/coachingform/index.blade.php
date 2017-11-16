

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
                <div class="row col-md-8">
                    
                    <div class="col-md-3">
                <form id ="sortform" action =" {{url('coachingform/')}}" method ='POST'>
                {{csrf_field()}}
                    <div class="form-inline">
                        @if(\Auth::user()->roles == "AGENT")
                        <select id="chooseForm" class="form-control" name="chooseFormAgent">
                        @else
                        <select id="chooseForm" class="form-control" name="chooseForm">
                        @endif
                            <option value="none" class="w" selected disabled hidden>Sort Forms</option>
                            @if($sortForm == "All")
                            {
                                <option value="All" class="w" value = "All" selected>All Forms</option>
                            }
                            @else
                            {
                                <option value="All" class="w" value = "All">All Forms</option>
                            }
                            @endif
                            @if($sortForm == "Pending")
                            {
                                <option value="Pending" class="w" value = "Pending" selected>Pending Forms</option>
                            }
                            @else
                            {
                                <option value="Pending" class="w" value = "Pending">Pending Forms</option>
                            }
                            @endif
                            @if($sortForm == "Ongoing")
                            {
                                <option value="Ongoing" class="w" value = "Ongoing" selected>Ongoing Forms</option>
                            }
                            @else
                            {
                                <option value="Ongoing" class="w" value = "Ongoing">Ongoing Forms</option>
                            }
                            @endif
                            @if($sortForm == "Complete")
                            {
                                <option value="Complete"class="w" value = "Complete" selected>Completed Forms</option>
                            }
                            @else
                            {
                                <option value="Complete"class="w" value = "Complete">Completed Forms</option>
                            }
                            @endif
                            
                        </select>
                    </div>
                    </div>
                    
                @if(\Auth::user()->roles != "AGENT")    
                <div class="col-md-3">
                    {{csrf_field()}}
                    <?php 
                        $months = array(
                            array("month" => "January",
                                "num" => "1"),
                            array("month" => "Febuary",
                                "num" => "2"),
                            array("month" => "March",
                                "num" => "3"),
                            array("month" => "April",
                                "num" => "4"),
                            array("month" => "May",
                                "num" => "5"),
                            array("month" => "June",
                                "num" => "6"),
                            array("month" => "July",
                                "num" => "7"),
                            array("month" => "August",
                                "num" => "8"),
                            array("month" => "September",
                                "num" => "9"),
                            array("month" => "October",
                                "num" => "10"),
                            array("month" => "November",
                                "num" => "11"),
                            array("month" => "December",
                                "num" => "12")
                        );
                    ?>
                        <div class="form-inline">
                            <select id="monthForm" class="form-control" name="monthForm">
                                <option value="none" class="w" selected disabled hidden>Sort by Month</option>
                                @foreach ($months as $month)
                                {
                                    @if($monthForm == $month['num'])
                                    <option value="{{ $month['num'] }}"class="w" selected >{{ $month['month'] }}</option>
                                    @else
                                    <option value="{{ $month['num'] }}"class="w" >{{ $month['month'] }}</option>
                                    @endif
                                }
                                @endforeach
                            </select>
                        </div>
                </div>
                @endif
                @if(\Auth::user()->roles != "AGENT")
                    <?php $agnts = \Auth::user()->subordinates()->sortBy('lname'); ?>
                    <div class="col-md-3">
                    {{csrf_field()}}
                        <div class="form-inline">
                            <select id="agentForm" class="form-control" name="agentForm">
                                <option value="none" class="w" selected disabled hidden>Sort by Agent</option>
                                <?php
                                    if($agentForm)
                                    {
                                        $cntr = 0;
                                    }
                                ?>
                                @if($agentForm)
                                    @if($cntr == 0)
                                    <option value="{{ \Auth::user()->uid }}" class="w" selected>{{ \Auth::user()->lname.', '.\Auth::user()->fname }}</option>
                                    @else
                                    <option value="{{ \Auth::user()->uid }}" class="w">{{ \Auth::user()->lname.', '.\Auth::user()->fname }}</option>
                                    @endif
                                @else
                                    <option value="{{ \Auth::user()->uid }}" class="w">{{ \Auth::user()->lname.', '.\Auth::user()->fname }}</option>
                                @endif
                                
                                @foreach( $agnts as $agnt)
                                    @if( $agentForm == $agnt->uid)
                                        <option value="{{ $agnt->uid }}" class="w" selected>{{ $agnt->lname.', '.$agnt->fname }}</option>
                                        $cntr++;
                                    @else
                                        <option value="{{ $agnt->uid }}" class="w">{{ $agnt->lname.', '.$agnt->fname }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                @endif
                </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>FORM ID</th>
                  <th>DATE CREATED</th>
                  <th>TYPE OF FORM</th>
                    <th>CREATED BY</th>
                    <th>EMPLOYEE</th>
                  <th>STATUS</th>
                  <th>TAG</th>
                  <th>OPTIONS</th>
                </tr>
                </thead>
                <tbody id ="tformbody">
                        @foreach ($forms as $form)
                        <tr id = "{{$form->id}}">
                            <td>{{ $form->id }}</td>
                            <td>{{ $form->created_at}}</td>
                            <td>{{ $form->type }}</td>
                            <td>{{ $form->createdBy->name }}</td>
                            <td>{{ $form->agent->name }}</td>
                            <td>{{ $form->status }}</td>
                            @if($form->tag == 1)
                            <td>Mishandled Case</td>
                            @elseif($form->tag == 0)
                            <td></td>
                            @elseif($form->tag == 2)
                            <td>Touchpoint Overlunch</td>
                            @elseif($form->tag == 3)
                            <td>Touchpoint Overbreak</td>
                            @else
                            <td>---</td>
                            @endif
                          
                            <td>
                                @if (\Auth::user()->roles == "IT")
                                <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>
                                @else
                                
                                    @if ($form->status == 'Pending')
                                    <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>
                                    <button type="button" class="btn btn-primary btn-sm edit" value="{{ 'coachingform/'.$form->id.'/editForm' }}">Edit</button>
                                        @if ($form->creator == \Auth::user()->uid)
                                         <button type="button" id="delete" class="btn btn-primary btn-sm delete" value="{{ $form->id }}">Delete</button>
                                        @endif 
                                    @elseif($form->status == 'Ongoing')
                                        @if ($form->creator == \Auth::user()->uid)
                                        <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>
                                        <button type="button" id="delete" class="btn btn-primary btn-sm delete" value="{{ $form->id }}">Delete</button>
                                        <button type="button" class="btn btn-primary btn-sm complete" value="{{ 'coachingform/'.$form->id.'/updateStatus' }}">Complete</button>

                                        @elseif($form->manager == \Auth::user()->uid)
                                        <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>

                                        @elseif($form->superior == \Auth::user()->uid)
                                        <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>

                                        @endif 
                                    @elseif($form->status == 'Complete')
                                    <button type="button" class="btn btn-primary btn-sm view" value="{{ 'coachingform/'.$form->id.'' }}">View</button>
                                    @endif
                                @endif
                                
                        @endforeach
                </tbody>
                    
              </table>
              <input type ="hidden" id ="userroles" data-value ="{{\Auth::user()->roles}}">
             @if (\Auth::user()->roles == 'AGENT' || \Auth::user()->roles == 'IT')
             @else
             <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Create Form</button>
             @endif
             @if(in_array(\Auth::user()->roles, array('SUPERVISOR', 'SOM', 'MANAGER')))
             <button type="button" class="btn btn-primary" id="viewCoachingTarget">View Reports</button>
             @else
             @endif
            </div>
            </div>

            <!-- /.box-body -->
           
                <!-- Modal -->
                <?php
                    $teams = Auth::user()->teams();
                ?>
            <input type ="hidden" id ="userteams" data-value ="{{count($teams)}}">
                @if(count($teams) <= 1 && \Auth::user()->roles != "AGENT")
                <div id="myModal" class="modal fade" role="dialog">
                
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="{{ url('/coachingform/createForm') }}" method="POST">
                         {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Create Form</h4>
                            </div>
                        <div class="modal-body">
                             <div class ="form-group">
                               Type of Form:<br>
                        @if(\Auth::user()->roles != "L2")
                                <select class = "form-control" name = "type">
                                        <option value = "Generic Form">Generic Form</option>
                                        <option value = "Statistics Form">Statistics Form</option>
                                 </select>
                        @else
                                <select class = "form-control" name = "type">
                                        <option value = "Generic Form">Generic Form</option>
                                 </select>
                        @endif
                                </div>
  
                             <div class ="form-group" id = "agentName" name="agent_id">
                               Name of Agent:<br>
                                <select class = "form-control" name="agent_id">
                                        <!-- foreach sa mga employee -->
                                        @if(\Auth::user()->roles != "IT")
                                        @foreach ($agents as $agent)
                                        <option value="{{ $agent->uid }}">{{ $agent->lname.', '.$agent->fname }}</option>
                                        @endforeach
                                        @endif
                                </select>
                              </div>

                        </div>
                                 <div class="modal-footer">
                                    <button type="submit" class="btn btn-default" id ="createbutton"> Create Form</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                         </form>
                    </div>

                  </div>
                </div>
                @else
                <div id="myModal" class="modal fade" role="dialog">
                
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form action="{{ url('/coachingform/createForm') }}" method="POST">
                         {{ csrf_field() }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Create Form</h4>
                            </div>
                        <div class="modal-body">
                             <div class ="form-group">
                               Type of Form:<br>
                                <select class = "form-control" name = "type">
                                        <option value = "Generic Form">Generic Form</option>
                                        <option value = "Statistics Form">Statistics Form</option>
                                 </select>
                                </div>
                                Name of Team:<br>
                                 <select class = "form-control" id = "teamName" >
                                         <!-- foreach sa mga employee -->
                                         @foreach ($teams as $team)
                                         <option value="{{ $team->gid }}">{{ $team->name }}</option>
                                         @endforeach
                                 </select>
                                <br>
                             <div class ="form-group" id = "agentDiv" name="agent_id">
                               Name of Agent:<br>
                                <select class = "form-control" name="agent_id" id = "agentName">

                                </select>
                              </div>
                              
                        </div>
                                 <div class="modal-footer">
                                    <button type="submit" class="btn btn-default" id ="createbutton"> Create Form</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                         </form>
                        </div>
                    </div>

                  </div>
                @endif
                



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
     
    var count = $("#userteams").data('value');
    console.log(count);
    if(count > 1)
    {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var first = $("#teamName").val();
    $.ajax({
        method: "post",
        url: "./coachingform/getMembers",
        data: {'_token': CSRF_TOKEN,
               'id': first
               },
        success: function(members) {
          var table = $('#example1').DataTable();
          console.log(members);
          var agents = members;
          console.log(agents);
          $("#agentDiv").css("display", "block");
          $("#agentName").empty()
          $.each(agents,function(key,value)
          {
             $("#agentName").append('<option value = "'+value.uid+'">'+value.fname + ' ' + value.lname+'</option>'); 
          });
        },
        error: function() {

            alert('An error occured.');
        }
    });
    }
    
    
    $("#example1").on("click",".delete", function(){
        var id = $(this).closest('.delete').val();
         
        if(confirm("Are you sure you want to delete this form?")) {
             
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                method: "post",
                url: "./coachingform/deleteForm",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function() {
                  var table = $('#example1').DataTable();
                  console.log(id);
                  table
                    .row('#'+id)
                    .remove()
                    .draw();
                  alert("Form successfully deleted.");
                },
                error: function() {
                     
                    alert('An error occured.');
                }
            });
        }
        });
        $("#viewCoachingTarget").on('click',function()
         {
            window.location = "coachingtarget";
         });
        $("#example1").on("click", ".edit", function(){
         var form = $(this).closest('.edit').val();    
         window.location= form;
        });
        $("#example1").on("click", ".view", function(){
         var form = $(this).closest('.view').val();    
         window.location= form;
        });
         $("#chooseForm").on('change',function()
         {
            $('#sortform').submit();
         });
         $("#monthForm").on('change',function()
         {
            $('#sortform').submit();
         });
         $("#agentForm").on('change',function()
         {
            $('#sortform').submit();
         });
         $(".complete").on("click", function() {
             var form = $(this).closest('.complete').val();
             window.location= form;
         });   

        $("#teamName").change(function()
        {
            var option = $(this).find('option:selected').val();
            console.log(option);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                method: "post",
                url: "./coachingform/getMembers",
                data: {'_token': CSRF_TOKEN,
                       'id': option
                       },
                success: function(members) {
                  var table = $('#example1').DataTable();
                  console.log(members);
                  var agents = members;
                  console.log(agents);
                  $("#agentDiv").css("display", "block");
                  $("#agentName").empty()
                  $.each(agents,function(key,value)
                  {
                     $("#agentName").append('<option value = "'+value.uid+'">'+value.fname + ' ' + value.lname+'</option>'); 
                  });
                },
                error: function() {
                     
                    alert('An error occured.');
                }
            });
        });
                
                
  });
 
</script>

@endsection
