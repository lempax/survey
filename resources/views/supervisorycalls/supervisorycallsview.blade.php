@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <a href="{{ asset('/supervisorycalls/new') }}"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Back to Supervisory Calls Form</u></font></a>
    </div>
    <div class="box box-body" style="padding-top: 30px">
    @if(Session::has('flash_message'))
        <div class="alert alert-success" aria-hidden="true"  style="text-align: center; margin-left: 10px; width: 400px;">
            <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
        </div>
    @endif
    <form method="POST" action="{{ asset('/supervisorycalls/update') }}" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{$rows->id}}">
        <input type="hidden" name="requested_by" value="{{$rows->requested_by}}">
       
        <br>
        <table class="table table-bordered" style="width: 700px; float: left;">
            <tbody>
                <tr>
                    <td style="vertical-align:middle; font-weight: bold;">Case Number:</td>
                    <td><input class="form form-control" style="width: 150px;" name="case_number" value="{{$rows->case_number}}"></td>
                </tr>
                <tr>
                    <td style="vertical-align:middle; font-weight: bold;">Team:</td>
                    <td>
                        <?php 
                            $dept = DB::table('departments')->where('departmentid', Auth::user()->departmentid)->first();
                            $selTeam = DB::table('departments')->where('departmentid', $rows->team)->first(); 
                        ?>
                            <input class="form-control" type="text" value="{{ $selTeam->name }}" name="" style="width: 350px;" readonly>
                            <input class="form-control" type="hidden" value="{{ $rows->team }}" name="team" style="width: 350px;">

                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle; font-weight: bold;">Supervisor:</td>
                    <td>
                        <div id="agents">
                            <?php 
                                $agents = DB::table('employees')->where('departmentid', $rows->team)->get();
                                $selected = DB::table('employees')->where('uid', $rows->agent_name)->first();
                            ?>
                                <input type="text" name="" style="width: 350px;" class="form-control" value="{{$selected->fname . ' '.$selected->lname }}" readonly>
                                    <input type="hidden" name="agent_name" value="{{ $rows->agent_name }}">
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle; font-weight: bold;">Case Date:</td>
                    <td>
                        <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                            <div class="input-group-addon">
                              <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" class="form-control" name="case_date" value="<?php echo date("m/d/Y", strtotime($rows->case_date)) ?>" style="width: 150px;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:middle; font-weight: bold;">Date Tracked:</td>
                    <td>{{date('F j, Y', strtotime($rows->updated_at))}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="float:right;"><button class="btn btn-primary" type="submit"><i class="fa fa-send-o"></i> Update</button></div>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>
</div>
@endsection

@section('additional_scripts')
<script type="text/javascript">
    $('#team').on('change', function() 
    {  var selItem = $(this).val();
        //ajax
        $.get("{{ url('/supervisorycalls/getagent') }}" + '/' + selItem , function(data){
            //success
            $.each(data, function(){
                $('#agents').html(data);
            });
        });  
    });  
</script>
<!--<script src="{{ asset("/bower_components/admin-lte/plugins/jQuery/jQuery-1.8.3.min.js") }}"></script>
--><script src="{{ asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
@endsection
