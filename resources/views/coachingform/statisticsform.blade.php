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
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}">
@endsection
@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
<form action = "{{ url('/coachingform/addForm') }}" method="post" enctype="multipart/form-data">
     {{ csrf_field() }} 


    <div class="box box-primary">
        <div class="box-header with-border">
            @if ($userMarket == "UK")
            <center><h3 class="box-title">1&1 Internet Philippines Inc. | 1st Level Coaching | UK Technical Support Department</h3></center>
            @else
            <center><h3 class="box-title">1&1 Internet Philippines Inc. | 1st Level Coaching | US Technical Support Department</h3></center>
            @endif
        </div>
    </div>


        <div class="box box-primary">
            <div class="box-body">
                
                @if($form == null)
                <div class="form-group col-lg-6">             
                <label for="name">Name:</label>
                <input type="text" class="form-control" value="{{ $agent->name }}" id="agentName"  disabled>               
                </div>
                <input type="text" value="{{ $page_title }}"  name="type" hidden>
                <input type="text" value="{{ $agent->uid }}" name ="agent_id" hidden>
                   <input type="text" value="{{\Auth::user()->roles }}" id="role" name ="role" hidden>
                <div class="form-group col-lg-6">
                  <label for="exampleInputPassword1">Hire Date: </label>
                  <input type="text" class="form-control" value="{{ $agent->created_at }}" id="hireDate"  disabled>
                </div>     
                <div class="form-group col-lg-6">
                  <label for="date">Date of Coaching:</label>
                  <input type="text" class="form-control" value="{{ \Carbon\Carbon::now() }}" id="coachingDate"  disabled>
                </div>
                  
                <div class="form-group col-lg-6">
                  <label for="date">Tenure:</label>
                  <input type="text" class="form-control" value="{{ $agent->roles }}" id="tenure" disabled> 
                </div>
                <input type="text" value="{{ $page_title }}"  name="type" hidden>
                @else
                  <div class="form-group col-lg-6">             
                <label for="name">Name:</label>
                <input type="text" class="form-control" value="{{ $form->agent->name }}" id="agentName"  disabled>               
                </div>
                <input type="text" value="{{ $form->agent->uid }}" name ="agent_id" hidden> 
                <div class="form-group col-lg-6">
                  <label for="exampleInputPassword1">Hire Date: </label>
                  <input type="text" class="form-control" value="{{ $form->agent->created_at }}" id="hireDate"  disabled>
                </div>     
                <div class="form-group col-lg-6">
                  <label for="date">Date of Coaching:</label>
                  <input type="text" class="form-control" value="{{ $form->created_at }}" id="coachingDate"  disabled>
                </div>
                  
                <div class="form-group col-lg-6">
                  <label for="date">Tenure:</label>
                  <input type="text" class="form-control" value="{{ $form->agent->roles }}" id="tenure" disabled> 
                </div>
                <input type="text" value="{{ $form->id }}"  id="form_id" name ="form_id" hidden>
                @endif
          
            </div> <!-- /.box-body -->
        </div>  
        
  
        <div class="row">    
            <div class="col-md-6">
                <div id="primary" class="box box-primary">
                    <div class="box-header with-border">
                        <center><h3 class="box-title">Performance</h3></center>
                    </div>  
                    <div class="box-body">
                 @if($form == NULL)
                        <table id="metricsTable"class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Metrics</th>
                                <th>Running</th>
                                <th>Target</th>
                            </tr>
       
                            <tr>
                                <td>Call Productivity</td>
                                <td><input type="text" class="form-control" id="cproductivityr" name="content[cproductivity][running]" required></td>
                               <td><input type="text" class="form-control" id="cproductivityt" name="content[cproductivity][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>   
                            <tr>
                                <td>Email Productivity</td>
                                <td><input type="text" class="form-control" id="eproductivityr" name="content[eproductivity][running]" required></td>
                                <td><input type="text" class="form-control" id="eproductivityt" name="content[eproductivity][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>NPS</td>
                                <td><input type="text" class="form-control" id="npsr" name="content[nps][running]" required></td>
                                <td><input type="text" class="form-control" id="npst" name="content[nps][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>CRR</td>
                                <td><input type="text" class="form-control" id="crrr" name="content[crr][running]" required></td>
                                <td><input type="text" class="form-control" id="crrt" name="content[crr][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>QFB</td>
                                <td><input type="text" class="form-control" id="qfbr" name="content[qfb][running]" required></td>
                                <td><input type="text" class="form-control" id="qfbt" name="content[qfb][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>AHT</td>
                                <td><input type="text" class="form-control" id="ahtr" name="content[aht][running]" required></td>
                                <td><input type="text" class="form-control" id="ahtt" name="content[aht][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>SAS</td>
                                <td><input type="text" class="form-control" id="sasr" name="content[sas][running]" required></td>
                                <td><input type="text" class="form-control" id="sast" name="content[sas][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>Released Rate</td>        
                                <td> <input type="text" class="form-control" id="releasedrater" name="content[reldate][running]" required></td>
                                <td><input type="text" class="form-control" id="releasedratet" name="content[reldate][target]" required></td>
                                <td><input type="checkbox" name="record"></td>
                            </tr>
                            
                            <tr>
                                <td>Attendance Rate</td>
                                <td><input type="text" class="form-control" id="attendancerater" name="content[attrate][running]" required></td>
                                <td><input type="text" class="form-control" id="attendanceratet" name="content[attrate][target]" required></td>
                                <td><input type="checkbox" name="record"> </td>
                            </tr> 
                            </tbody>
                        </table>
                 
                     <div class="box-footer">
                            <div class="form-group">
                                <label  class="pull-left" style="margin-right:5px">Metrics:</label>
                                <input type="text" class="col-lg-4" id="metrics" style="margin-right:5px">
                                <button type="button" class="btn btn-primary" id="addRow">Add Row</button>
                                <button type="button" class="btn btn-primary pull-right" id="deleteRow">Delete Row</button>
                            </div>
                        </div>
                @else
                        <table id="metricsTable"class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Metrics</th>
                                <th>Running</th>
                                <th>Target</th>
                            </tr>
                    @foreach($content[0] as $key => $kpi)  
                    @if($key == "cproductivity")  
                        <tr>
                            <td>Call Productivity</td>
                            @foreach($kpi as $key => $metrics)
                            @if($key == "running")
                            <td>{{$metrics}}</td>
                            @elseif($key == "target")
                            <td>{{$metrics}}</td>
                            @endif
                            @endforeach
                        </tr>
                    @elseif($key == "eproductivity")
                        <tr>
                            <td>Email Productivity</td>
                            @foreach($kpi as $key => $metrics)
                             @if($key == "running")
                            <td>{{$metrics}}</td>
                             @elseif($key == "target")
                            <td>{{$metrics}}</td>
                             @endif
                            @endforeach
                          
                        </tr>
                    @elseif($key == "nps")
                            <tr>
                                <td>NPS</td>
                                @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                @endif
                                @endforeach
                            </tr>
                    @elseif($key == "crr")        
                            <tr>
                                <td>CRR</td>
                                @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                 @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                @endif
                                @endforeach

                            </tr>
                    @elseif($key == "qfb")        
                            <tr>
                                <td>QFB</td>
                                 @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                 @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                 @endif
                                @endforeach
                            </tr>
                    @elseif($key == "aht")        
                            <tr>
                                <td>AHT</td>
                                 @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                 @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                 @endif
                                @endforeach
                            </tr>
                    @elseif($key == "sas")         
                            <tr>
                                <td>SAS</td>
                                @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                 @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                @endif
                                @endforeach
                            </tr>
                    @elseif($key == "reldate")        
                            <tr>
                                <td>Released Rate</td>  
                                  @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                 @endif
                                @endforeach

                            </tr>
                    @elseif($key == "attrate")        
                            <tr>
                                <td>Attendance Rate</td>
                                @foreach($kpi as $key => $metrics)
                                @if($key == "running")
                                <td>{{$metrics}}</td>
                                 @elseif($key == "target")
                                <td>{{$metrics}}</td>
                                  @endif
                                @endforeach

                            </tr>
                    @else
                    
                    <tr>
                        <td>{{ $key }}</td>
                         @foreach($kpi as $k => $metrics)
                        @if($k == "running")
                        <td>{{$metrics}}</td>
                         @elseif($k == "target")
                        <td>{{$metrics}}</td>
                         @endif
                        @endforeach

                         
                    </tr>
                @endif 
                @endforeach <!-- foreach for metrics-->
                         </tbody>
                        </table>
                @endif <!-- $form == null -->

                    
                    </div>
                </div> 
            </div> 
            
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <center><h3 class="box-title">Tag</h3></center>               
                    </div>           
                    <div class="box-body pad"> 
                        @if($form == NULL)
                        <select class="form-control" name="tag">
                            <option value="0" class="w" selected hidden>--Select a Tag--</option>
                            <option value="1">Mishandled Case</option>
                        </select>
                        @else
                            @if($form->tag == 1)
                            <p>Mishandled Case</p>
                            @else
                            <p></p>
                            @endif
                        @endif

                    </div>
                </div> 
            </div>
        
            
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <center><h3 class="box-title">Comments/Additional Notes</h3></center>               
                    </div>           
                    <div class="box-body pad"> 
                      @if($form == NULL)   
                        <textarea class="textarea" id="editor1" name="comments" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>   
                      @else
                         {!! $content[1] !!} 
                        <textarea name="comments" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" hidden> {{$content[1]}} </textarea> 

                      @endif
                    </div>
                </div> 
            </div>
        </div>  <!-- row 1-->  

       
      
        <div class="box box-primary">
            <div class="box-header with-border">
              <center><h3 class="box-title">Factors Affecting Performance/Behavior</h3></center>
            </div>
            
            <div class="box-body pad">
                 @if($form == NULL)
                    <textarea class="textarea" id="editor1" name="factors" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required> </textarea>   
                 @else
                 {!!$content[2] !!}
                     <textarea name="factors" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" hidden> {{$content[2]}} </textarea> 
                @endif   
            </div>
              
        </div>

    
    
        <div class="box box-primary">
            <div class="box-header with-border">
                <center><h3 class="box-title">Action Plan</h3>
                    <label>(Who does What, By When and How)</label> </center>
            @if($form ==NULL)
            <div class="box-body" id="actionPlanInfo" name="text">
                
            </div>
            @else
            <div class="box-body" id="actionPlanInfo" name="text">
            @foreach($actions as $plans => $p)
                
                    <div class="box-header with-border actionsDiv">
    
                         <label>Target Date:</label>  {{ $p->target_date }}
                        <label style="padding:3px">Follow-up Date: </label> {{ $p->followup_date}}
                        <div> 
                            {!!$p->text!!}
                        </div>
                    </div>
                   

            @endforeach
               </div>
               
               @endif    
               
            </div>
        </div>
 
    
    @if($form != NULL)
       
        <div class="box box-primary" id="com">
            <center><h3 class="box-title">Comments</h3></center>
            <div class="box-body" id="commentSection" name="comment">
            @foreach($comments as $comment)
                @if($comment->status == 'Public')
                <div class="box-header with-border divComment" data-id="{{$comment->id}}">
                   @if($comment->uid == \Auth::user()->uid)
                    <div class="pull-right box-tools"><button type="button" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i></button></div>
                     @endif
                    {{$comment->createdBy->name }}
                  
                    {{$comment->created_at}}

                    <div>
                        {!! $comment->comment !!}
                    </div>
                   
                </div> 
                @elseif($comment->status == 'Private' && \Auth::user()->roles == 'SUPERVISOR' || \Auth::user()->roles == 'MANAGER')
                 <div class="box-header with-border divComment" data-id="{{$comment->id}}">
                    <div class="pull-right box-tools"><button type="button" class="btn btn-default btn-sm delete"><i class="fa fa-times"></i></button></div>
                    {{$comment->createdBy->name }}
                  
                    {{$comment->created_at}}

                    <div>
                        {!! $comment->comment !!}
                    </div>
                </div> 
                @endif

            @endforeach
            </div>
            <div class="box-footer">
                <div class="box-body pad" id="commentArea" style="display:none">         
                    <center><textarea id="comments" style="width: 50%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"> </textarea> 
                    </center>
                    @if(\Auth::user()->roles== 'SUPERVISOR' || \Auth::user()->roles == 'MANAGER' || \Auth::user()->roles == 'SOM')
                    <center>   <input type="radio" id="option" name="option" value="Public" checked> Public
                    <input type="radio" id="option" name="option" value="Private"> Private
                    @else
                    <input type="radio" id="option" name="option" value="Public" hidden checked>
                    </center>
                    @endif
                    <center>
                    <div>
                       <button type="button" class="btn btn-primary" id="addComment">Add</button>
                       <button type="button" class="btn btn-default" id="cancelComment">Cancel</button>
                    </div>
                    </center>
                </div>
                <center> <button type="button" class="btn btn-primary" id="btnAddComment" >Add Comment</button></center>
            </div>
        </div>
    @endif
    
    @if(\Auth::user()->roles != 'AGENT' && $form == NULL)
         <div class="box box-primary">
              <center><h3 class="box-title">Attachments</h3></center>
             <div class="box-body">
                 <center><input type="file" name="attachments[]" multiple></center> 
             </div>
       
         </div>
    @else
    
      <div class="box box-primary">
              <center><h3 class="box-title">Attachments</h3></center>
             <div class="box-body">
                 @if($attachments)
                 @foreach($attachments as $attachment)
                 
                 <center><a href="./download/{{$attachment}}" value="{{$attachment}}" name="attachment[]">{{$attachment}}</a></center> 
                 @endforeach
                 @endif
             </div>
       
         </div>
    @endif
    
    @if($form != NULL)
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
        </div>
    @endif
    
    @if($form == NULL)        
        <div class="box-footer">
            <center>
                <button type="submit" class="btn btn-primary">Submit</button>
     </form>
                <button type="button" class="btn btn-primary cancel">Cancel</button>
        </div>
    @else
        <div class="box-footer">
        <center>
            @if($form->status == 'Pending' && $form->agent_id != \Auth::user()->uid)
            <select class="form-control" style="width: 11%" id="status"> 
                <option value="Approve">Approve Form</option>
                <option value="Update">Update Form</option>
                <option value="Delete">Delete Form</option>
            </select>
            <button type="button" class="btn btn-primary" id="submit">Submit</button>
            <button type="button" class="btn btn-primary" id ="closeButton">Close Form</button>
            @elseif ($form->status == 'Pending' && $form->agent_id == \Auth::user()->uid)
            <select class="form-control" style="width: 11%" id="status">
                <option value="Update">Update Form</option>
             </select>
            <button type="button" class="btn btn-primary" id="submit">Submit</button>
            <button type="button" class="btn btn-primary" id ="closeButton">Close Form</button>
            @elseif($form->status == 'Ongoing' && $form->agent_id != \Auth::user()->uid)
             <select class="form-control" style="width: 11%" id="status">
                 <option value="Delete">Delete Form</option>
             </select>
            <button type="button" class="btn btn-primary" id="submit">Submit</button>
            <button type="button" class="btn btn-primary" id ="closeButton">Close Form</button>
            @else
            <button type="button" class="btn btn-primary" id ="closeButton">Close Form</button>
            @endif
            
        </center>
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
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>

<script>

$(function() {
    $(".textarea").wysihtml5();
    
      $('#targetDate').datepicker({
      autoclose: true
    });
     $('#followUpDate').datepicker({
      autoclose: true
    });
    $('#modal-content').modal('show');

});



 $(document).ready(function(){
     
     $("#submit").on("click",function() {
         var status = $('#status option:selected').val();
         var id = $('#form_id').val();
         if(status == 'Approve'){
             window.location = "./"+id+"/updateStatus";
         }
        else if(status == 'Update')
        {
            window.location = "./"+id+"/editForm";
        }
        else
        {
            if(confirm("Are you sure you want to delete this form?")) {
                
              var id = $('#form_id').val();  
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    
                    method: "post",
                    url: "./deleteForm",
                    data: {'_token': CSRF_TOKEN,
                        'id': id
                         },
                success: function() {
                 window.location = '{{ url("/coachingform") }}';
                  alert("Form successfully deleted.");
                },
                error: function(xhr) {
                    console.log(xhr.status);
                    alert('An error occured.');
                }
             
                });
                  
            }
        }   
             
     });
       $(".cancel").click(function() {

        var form = $('.cancel').val();
        var agree = confirm('Do you want to cancel this form?');
               
        if (agree == true)
        {
            window.location= '{{ url("/coachingform")}}';
        }
     });
       
       $('#create').click(function() {
           $('#aplan').show();
           $('#create').hide();
       });
       
       $('#cancelAction').click(function() {
            $('#aplan').hide();
            $('#create').show();
       });
       
    $("#btnAddComment").click(function() {
      $("#commentArea").show();
      $("#btnAddComment").hide();
    
    });
    
    $('#cancelComment').click(function() {
        $('#commentArea').hide();
         $('#btnAddComment').show();
    });

    $("#addComment").click(function() { 
        var comment = $("#comments").val();
        var security = $('input[name=option]:checked').val();
        var role = $('#role').val();
 
        
        
         if (comment == "") {
            alert("Please fill in the field");
        } else {  
            var data = new Array(comment,security);
        addComment(data);
       
        
        $('#commentArea').hide();
        $('#btnAddComment').show();
        }
        
        $("#comments").val('');
   });

     $("#commentSection").on("click", ".delete", function() {
           var aid = $(this).closest(".divComment").data("id");
        deleteComment(aid);
     });

    $("#addRow").click(function(){
       var metrics= $("#metrics").val();
        if( metrics == "") {
           alert("Please fill in field");
       }
       else {
       var row = "<tr><td>" + metrics + "</td><td><input type='text' class='form-control' id='" + metrics + " running' name = 'content[" + metrics +"][target]'></td><td><input type='text' class='form-control' id='" + metrics + "target' name = 'content[" + metrics +"][running]'></td><td><input type='checkbox' name='record'></td></tr>";

       $("#metricsTable").append(row);
       $("#metrics").val('');
        }
   });

    $("#deleteRow").on("click", function() {
   var confirmation = confirm('Are you sure you want to delete this row/s?');
        if(confirmation == true)
        {
            $("input:checked").each(function(){                
                $(this).closest("tr").remove();
            });
        }
            
    });

    $("#createAction").click(function() { 
        var targetDate = $("#targetDate").val();
        var followUpDate = $("#followUpDate").val();
        var action = $("#actionplan").val();

        if(targetDate == "" || followUpDate == "" || action == "") {
                alert('Please fill in all field/s.');   
        } else {
//        var data = new Array(targetDate,followUpDate,action);
//        addActionPlan(data); 
            // iyang DATA ID wala na.
        var newAction ="<div class='box-header with-border actionsDiv'><div class='pull-right box-tools'><button type='button' class='btn btn-default btn-sm delete' id='delete'> <i class='fa fa-times'></i></button></div><label>Target Date:</label>" + targetDate + "<label style='padding:3px'>Follow-up Date: </label>" + followUpDate + "<div>" + action +"</div></div>";
        $("#actionPlanInfo").append(newAction);
//        $("#actionplan").val('');
        $('#aplan').hide();
        $('#create').show();
         }
    });
    
    
    $("#actionPlanInfo").on("click",'.delete', function(){
    if(confirm('Are you sure you want to delete this action plan/s?')) 
    { 
        $(this).closest(".actionsDiv").remove();
    }
    });
     
     function deleteActionPlan(id) {
     var aid= id;
        if(confirm("Are you sure you want to delete this action plan?")) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "post",
                url: "./"+id+"/delPlan",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function(id) {
                
                    $('div [data-id='+aid+']').remove();
                },
                error: function() {
                    alert('An error occured.');
                }
            });
        }
    }
    
       function addComment(data) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          
            var id = $("#form_id").val();
                $.ajax({
                method: "post",
                url: "./"+id+"/addComment",
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
            var divComment = "<div class='box-header with-border divComment' data-id='"+id+"'><div class='pull-right box-tools'><button type='button' class='btn btn-default btn-sm delete'><i class='fa fa-times'></i></button></div>"+ name + date + "<div>" + comment + "</div></div>"; 
                $("#commentSection").append(divComment);  
                },
                error: function(a,b,c) {
                    console.log(b.responseText);
                    alert('An error occured');
                }
                });
        } 
        
            function deleteComment(id) {
                var aid= id;
            if(confirm("Are you sure you want to delete this comment?")) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                method: "post",
                url: "./"+id+"/delComment",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function(id) {
                
                    $('div [data-id='+aid+']').remove();
                },
                error: function() {
                    alert('An error occured.');
                }
            });
        }
    }

    
       $("#closeButton").click(function()
            {
               var agree = confirm("Do you want to close this form?");
               
               if (agree == true)
               {
                  window.location='{{ url("/coachingform")}}';
               }
            });


});
  
</script>

@endsection