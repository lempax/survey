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

<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<form action="{{ url('/coachingform/'.$form->id.'/update') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}

    <!--Start of Header-->
    <div class="box box-primary">
        <div class="box-header with-border">
            @if ($userMarket == "UK")
            <center><h3 class="box-title">1&1 Internet Philippines Inc. | 1st Level Coaching | UK Technical Support Department</h3></center>
            @else
            <center><h3 class="box-title">1&1 Internet Philippines Inc. | 1st Level Coaching | US Technical Support Department</h3></center>
            @endif
        </div>
    </div>
    <!--End of Header-->    
    
    <!--Start of Inputs-->
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="form-group col-lg-6">
                    @if($form == null)
                        Name of Agent: <input type="text" value="{{ $agent->name }}" class="form-control" name="agent-id" disabled>
                        Name of Coach: <input type="text" value="{{ \Auth::user()->name }}" class="form-control" name="creator"disabled>
                       
                        <input type="text" value="{{ $page_title }}"  name="type" hidden>
                        <input type="text" value="{{ $agent->uid }}"  name="agent_id" hidden>
                </div>
                <div class="form-group col-lg-6">
                        Date of Coaching:<input type="text" value="{{ \Carbon\Carbon::now() }}" class="form-control" name="" disabled>
                    @else
                        <input type="text" value="{{ $form->id }}"  id="form_id" name ="form_id" hidden>
                        Name of Agent: <input type="text" value="{{ $form->agent->name }}" class="form-control" name="agent-id" disabled>
                        <input type="text" value="{{ $agent->uid }}"  name="agent_id" hidden>                       
                        Name of Coach: <input type="text" value="{{ $form->createdBy->name }}" class="form-control" name="creator"disabled>
                </div>
                <div class="form-group col-lg-6">
                        Date of Coaching:<input type="text" value="{{ $form->created_at }}" class="form-control" name="" disabled>
                    @endif
                </div>
                <div class='form-group col-lg-6'>
                @if ($form->creator == \Auth::user()->uid)
                    Select Tag:
                        <select name="tag" id="selectTag" class='form-control'>
                            @if ($form->tag == 0)
                            <option value="0" selected></option>
                            <option value="1">Mishandled Case</option>
                            <option value="2">Touchpoint Overlunch</option>
                            <option value="3">Touchpoint Overbreak</option>
                            @elseif ($form->tag == 1)
                            <option value="0"></option>
                            <option value="1" selected>Mishandled Case</option>
                            <option value="2">Touchpoint Overlunch</option>
                            <option value="3">Touchpoint Overbreak</option>
                            @elseif ($form->tag == 2)
                            <option value="0"></option>
                            <option value="1">Mishandled Case</option>
                            <option value="2" selected>Touchpoint Overlunch</option>
                            <option value="3">Touchpoint Overbreak</option>
                            @elseif ($form->tag == 3)
                            <option value="0"></option>
                            <option value="1">Mishandled Case</option>
                            <option value="2">Touchpoint Overlunch</option>
                            <option value="3" selected>Touchpoint Overbreak</option>
                            @endif
                        </select>
                @else
                    @if($form->tag == 0)
                        
                    @elseif ($form->tag == 1)
                    <h4>Mishandled Case</h4>
                    @elseif ($form->tag == 2)
                    <h4>Touchpoint Overlunch</h4>
                    @elseif ($form->tag == 3)
                    <h4>Touchpoint Overbreak</h4>
                    @else
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
    <!--End of Inputs-->
        
    <!--Start of Supervisor's Comment-->
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h3 class="box-title">Supervisor's Comment</h3></center>
            </div>
                
            @if ($form->agent_id != \Auth::user()->uid)
            <div class="box-body pad">
                <textarea class="form-control" placeholder="Enter your comment" id = "supervisorArea" name="content">{!! $form->content !!}</textarea>
            <hr>
            </div>
            </div>   
        <div class="box box-primary">    
            <div class ="box-body pad">
                    <center><h3 class="box-title">Attachments</h3></center>
                        <div class="box-body">
                            @if($attachments)
                               @foreach($attachments as $attachment)

                                    <div class='form-group attachments'>
                                        <div class='pull-right box-tools'>
                                            <button type='button' class='btn btn-default btn-sm delete'> <i class='fa fa-times'></i></button>
                                        </div>
                                            <center><a href="../download/{{$attachment}}" value="{{$attachment}}" name="attachment[]">{{$attachment}}</a></center>
                                            <input type="text" name='attachments[]' value='{{$attachment}}' hidden>
                                    </div>
                               
                               @endforeach
                            @endif
                            <center><input type="file" name="attachments[]" multiple></center>
                        </div>
                </div>
            </div>

            @else
            <div class="box-body pad">
                {!! $form->content !!}
        
                <hr>
            </div>
            </div>
        <div class="box box-primary">
            <div class ="box-body pad">
                        <center><h3 class="box-title">Attachments</h3></center>
                           <div class="box-body">
                               @if($attachments)
                               @foreach($attachments as $attachment)

                               <center><a href="./download/{{$attachment}}" value="{{$attachment}}" name="attachment[]">{{$attachment}}</a></center>
                               @endforeach
                               @endif
                           </div>
                    </div>
            </div>
            @endif  
       
    <!--End of Supervisor's Comment-->
        
    <!-- Start of Agents' Action Plan -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h3 class="box-title">Agent's Action Plan</h3></center>      
                <center><small>Please note: The action plan must be <b>SMART</b></small><br></center>
                <center><small>Specific | Measurable | Attainable | Realistic | Time Bounded</small></center>
            </div>

            
    
        <div class="box-body" id = "addActionArea">
            <!--append all the action plans-->
            <?php $ctr = 0;?>
            @foreach($actions as $action)
             <div class='box-header with-border actionsDiv' id ='wholeAction' data-id="{{$action->id}}">
                 @if ($form->agent_id == \Auth::user()->uid)
                    <div class='pull-right box-tools'>
                        <button type='button' class='btn btn-default btn-sm delete' id ='delAction'> <i class='fa fa-times'></i></button>
                    </div>
                 @endif
                    <label>Target Date : </label> {{$action->target_date}} <br>
                    <label style='padding:3px'>Follow-up Date : </label> {{$action->followup_date}}
                    <div>{!!$action->text!!}</div>
            <input type="hidden" class="form-control pull-right"  name="actionplan[{{$ctr}}][target_date]" value = "{{$action->target_date}}">
            <input type="hidden" class="form-control pull-right "  name="actionplan[{{$ctr}}][followup_date]" value = "{{$action->followup_date}}">
            <textarea class="textarea" name="actionplan[{{$ctr}}][text]" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; display: none;" hidden>{!!$action->text!!}</textarea>
                  
            </div>
            <?php $ctr++; ?>
            @endforeach
                <input type ="hidden" id ="actionplansctr" data-value ="{{$ctr}}">
        </div>
           <div class ="form-group">
                @if ($form->agent_id == \Auth::user()->uid)
                    <div class="box-footer">
                    <center><button type="button" class="btn btn-primary" id ="addActionPlanbutton">Add Action Plan</button></center>
                    </div>
                @else
                @endif
                
                <div class="box-header with-border" id='inputAction' style="display:none">
                    <div class="form-group">
                        <label>Target Date: </label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                               </div>
                                <input type="text" class="form-control pull-right" id="datepicker" class="datepicker">
                            </div>                            
                    </div>                      
                    <div class="form-group">
                        <label>Follow-up Date: </label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                               </div>
                               <input type="text" class="form-control pull-right" id="datepicker1" class="datepicker1">
                            </div>                            
                    </div>  
                        <div class="form-group">
                            <label>Action:</label>
                            <textarea class="actionArea" id="actionArea" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>  
                   <center>
                        <div>
                                <button type="button" id="addAction" class="btn btn-primary">Add</button>
                                <button type="button" id="cancelAction" class="btn btn-default">Cancel</button>       
                        </div>
                   </center>
                </div>
            </div>

        </div>
    <!--End of Agents' Action Plan -->
        
    <!--Start of the Signature Footer-->
        <div class="box box-primary">  
           <div class="box-body">
              <table class="table table-bordered"  style="text-align: center;">
                <tr class="signatures">
                    @if($form->createdBy->roles == "MANAGER")
                    <td style="background-image: url('../../signature/{{$form->creator}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                     <br> {{$form->createdBy->name}} <br>
                        Manager <br>
                        (Signature over printed Name)
                    </td>
                    @elseif($form->createdBy->roles == "SOM")
                    <td style="background-image: url('../../signature/{{$form->creator}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                     <br> {{$form->createdBy->name}} <br>
                        Shift Operations Manager <br>
                        (Signature over printed Name)
                    </td>
                    @elseif ($form->createdBy->roles == "SUPERVISOR")
                    <td style="background-image: url('../../signature/{{$form->creator}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                     <br> {{$form->createdBy->name}} <br>
                        Supervisor <br>
                        (Signature over printed Name)
                    </td>
                    @elseif ($form->createdBy->roles == "L2")
                    <td style="background-image: url('../../signature/{{$form->creator}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                     <br> {{$form->createdBy->name}} <br>
                        Escalations Agent <br>
                        (Signature over printed Name)
                    </td>
                    @endif
                    @if(!$actions->isEmpty())
                        @if($form->agent->roles == "SOM")
                        <td style="background-image: url('../../signature/{{$form->agent_id}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                         <br> {{$form->agent->name}} <br>
                            Shift Operations Manager <br>
                            (Signature over printed Name)
                        </td>
                        @elseif($form->agent->roles == "SUPERVISOR")
                        <td style="background-image: url('../../signature/{{$form->agent_id}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                         <br> {{$form->agent->name}} <br>
                            Supervisor <br>
                            (Signature over printed Name)
                        </td>
                        @elseif($form->agent->roles == "L2")
                        <td style="background-image: url('../../signature/{{$form->agent_id}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                         <br> {{$form->agent->name}} <br>
                            Escalations Agent <br>
                            (Signature over printed Name)
                        </td>
                        @elseif ($form->agent->roles == "AGENT")
                        <td style="background-image: url('../../signature/{{$form->agent_id}}'); background-repeat: no-repeat; background-position: center"><br><br/>
                         <br> {{$form->agent->name}} <br>
                            Technical Support Representative <br>
                            (Signature over printed Name)
                        </td>
                        @endif
                    @else
                        @if($form->agent->roles == "SOM")
                        <td><br><br/><br><br>
                            Shift Operations Manager <br>
                            (Signature over printed Name)
                        </td>
                        @elseif($form->agent->roles == "SUPERVISOR")
                        <td><br><br/><br><br>
                            Supervisor <br>
                            (Signature over printed Name)
                        </td>
                        @elseif($form->agent->roles == "L2")
                        <td><br><br/><br><br>
                            Escalations Agent <br>
                            (Signature over printed Name)
                        </td>
                        @elseif ($form->agent->roles == "AGENT")
                        <td><br><br/><br><br>
                            Technical Support Representative <br>
                            (Signature over printed Name)
                        </td>
                        @endif
                    @endif
                  
                </tr>
            
              </table>
            </div>
            <div class="box-footer">
             <center>
                 <button type="submit" class="btn btn-primary">Update Form</button>
                 <button type="button" class="btn btn-primary" id ="closeButton">Close Form</button>
                 </center>
             </div>
        </div>

    </form>
    <!--End of the Signature Footer-->
        

<!--Start of Comment Section-->
<div class="box box-primary">
    <center><h3 class="box-title">Comments</h3></center>
        <div class="form-group" id="commentSection">
        <!--Append all the comments-->
        @if ($form == null)
        @else
            @foreach ($comments as $comment)
                @if ($comment->status == 'Public')
                <div class='box-header with-border' id ='commentSec' data-id="{{$comment->id}}">
                    <div class='form-group'>{{$comment->createdBy->name}}<br>{{$comment->created_at}}<br> {!!$comment->comment!!}</div>
                </div>
                @elseif ($comment->status == 'Private' && \Auth::user()->roles == 'SUPERVISOR' || \Auth::user()->roles == 'MANAGER')
                <div class='box-header with-border' id ='commentSec' data-id="{{$comment->id}}">
                    <div class='form-group'>{{$comment->createdBy->name}}<br>{{$comment->created_at}} <br>{!!$comment->comment!!}</div>
                </div>   
                @endif
            @endforeach
        @endif
        </div>
        <div class="box-footer">
            <div class="box-body pad" id="commentArea" style="display:none">
                <center><textarea id="comment" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" class="comment"> </textarea></center>
                    @if(\Auth::user()->roles== 'SUPERVISOR' || \Auth::user()->roles == 'MANAGER')
                    <center>    
                        <input type="radio" id="option" name="option" value="Public" checked> Public
                        <input type="radio" id="option" name="option" value="Private"> Private
                    </center>
                   @else
                    <center>
                        <input type="radio" id="option" name="option" value="Public" hidden checked>
                    </center>
                   @endif
                    <center>
                        <div>
                            <button type="button" class="btn btn-primary" id="addComment">Add</button>
                            <button type="button" class="btn btn-primary" id="cancelComment">Cancel</button>
                        </div>
                    </center>
            </div>
            @if($form == null)
            @else
            <center><button type="button" class="btn btn-primary"  id ="commentShow">Add Comment</button></center>
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

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<script type = "text/javascript">
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    //CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $("#datepicker").datepicker({
        autoclose: true
    });
    $("#datepicker1").datepicker({
        autoclose: true
    });
    $("#supervisorArea").wysihtml5();
    $(".actionArea").wysihtml5();
    $(".comment").wysihtml5();

 });

 $(document).ready(function()
  {
  var ctr = $("#actionplansctr").data("value");
        $("#addAction").click(function()
        {
            var tdate = $("#datepicker").val();
            var fdate = $("#datepicker1").val();
            var action = $("#actionArea").val();

            
                if ($("#datepicker").val() == "" || $("#datepicker1").val() == "" || $("#actionArea").val() == "")
                {
                    var agree = alert("Please fill-in the neccessary inputs.");              
                }
                else
                {
                    var newAction ="<div class='box-header with-border actionsDiv'><div class='pull-right box-tools'><button type='button' class='btn btn-default btn-sm delete' id='delete'> <i class='fa fa-times'></i></button></div><label>Target Date :</label> " + tdate + "<br><label style='padding:3px'>Follow-up Date : </label> " + fdate+ "<div>" + action +"</div>" +
                   '<input type="hidden" class="form-control pull-right"  name="actionplan['+ctr+'][target_date]" value = '+tdate+'>' +
                   '<input type="hidden" class="form-control pull-right "  name="actionplan['+ctr+'][followup_date]" value = '+fdate+'>' +
                   '<textarea class="textarea" name="actionplan['+ctr+'][text]" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px; display: none;" hidden>'+action+'</textarea>'
                   + '</div>';


                        $("#addActionArea").append(newAction);
                        ctr++;
                        $("#datepicker").val('');
                        $("#datepicker1").val('');
                        $('.actionArea', $('.wysihtml5-sandbox').contents()).empty();
                        $('#inputAction').hide();
                        $('#addActionPlanbutton').show();
                        console.log(newAction);
                }

        });
        
             
       $("#commentShow").click(function()
        {
            $("#comment").val('');
            $("#commentArea").show();
            $("#commentShow").hide();
            
        });

        $("#cancelComment").click(function()
        {
            $("#comment").val('');
            $("#commentArea").hide();
            $("#commentShow").show();
            
        });
    
        $("#addComment").click(function()
        {
            var comment = $("#comment").val();
            var security = $('input[name=option]:checked').val();
            var role = $("#role").val();
            

            if (comment == "")
            {
                alert("Please fill in the field");
            }
            else
            {
                var data = new Array (comment, security);
                alert("Comment successfully added.");               
                addComment(data);

                $('#commentArea').hide();
                $("#commentShow").show();
                $("#comment").val('');
 

                
            }
        });
         function addComment(data) {
         
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = $("#form_id").val();
                $.ajax({
                    method: "post",
                    url: "../"+id+"/addComment",
                    data: {
                        '_token': CSRF_TOKEN,
                        'content': data[0],
                        'stats': data[1]
                    },
                    success:function(json){
                    console.log(json);
                    var comment = json.data.comment;
                    var name = json.creator.fname + " " + json.creator.lname;
                    var date = json.data.created_at;
                    var id= json.data.id;
                        
                             var newComment = $("<div class='box-header with-border' id ='commentSec' data-id="+id+">\n\
                                            <div class='pull-right box-tools'>\n\
                                            </div>\n\
                                            <div class='form-group'>"+name+"<br>"+date+" <br>"+comment+'</div>\n\
                                        </div>');
                        $("#commentSection").append(newComment);
                        $('.comment', $('.wysihtml5-sandbox').contents()).empty();
                    },
                    error: function(a,b,c) {
                        console.log(b.responseText);
                    }
                });
        }
    
    $("#commentSection").on("click", ".delete" , function()
    {
        var del = $(this).closest("#commentSec").data("id");
        deleteComment(del);
    });
    
   
        function deleteComment(id) {
        var aid= id;
        
                if(confirm("Are you sure you want to delete this comment?"))
                {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        method: "post",
                        url: "{{ url('/irforms/getagent') }}",
                        data: {'_token': CSRF_TOKEN,
                               'id': id
                               },
                        success: function(id) {

                            $('div [data-id='+aid+']').remove();
                        },
                        error: function(a,b,c) {
                        console.log(b.responseText);
                    }
                    });
                }
                else
                {
                    
                }
        }
              
             
            $("#cancel").click(function()
            {
               var agree = confirm('Do you want to cancel this form?');
               
               if (agree == true)
               {
                   window.location='{{ url("/coachingform")}}';
               }
            });
            
            $("#closeButton").click(function()
            {
               var agree = confirm("Do you want to close this form?");
               
               if (agree == true)
               {
                  window.location='{{ url("/coachingform")}}';
               }
            });
            $('#addActionPlanbutton').click(function()
            {
                $('#inputAction').show();
                $('#addActionPlanbutton').hide();
            });
            
            $('#cancelAction').click(function()
            {
               $('#inputAction').hide();
               $('#addActionPlanbutton').show();
            });
            
            $(".attachments").on("click", '.delete', function() {
                if(confirm('Are you sure you want to delete this attachment/s?'))
                {
                    $(this).closest(".attachments").remove();
                }

            });
            
            $("#addActionArea").on("click" ,".delete", function(){
            if (confirm('Are you sure you want to delete this action plan?'))
            {
                $(this).closest('#wholeAction').remove();
            }

        });
});

</script>
@endsection