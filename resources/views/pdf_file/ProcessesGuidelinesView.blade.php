@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<!-- Default box -->
<div class="box">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
           <li class="active"><a href="#tab1" data-toggle="tab">Upload PDF</a></li>
           <li class=""><a href="#tab2" data-toggle="tab">View All</a></li>
           <li class=""><a href="#tab3" data-toggle="tab">Add Category</a></li>
        </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <form role="form" method="POST" action="store" enctype="multipart/form-data">
                <div>
                    <div class="box-header with-border">
                        <div><h2 class="box-title" style="font-size: 20px;">Posting of Processes/Guidelines</h2></div><br>
                        <div class="alert alert-info alert-dismissable" style="width: 450px;">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Please fill all the required fields below
                        </div>
                    </div>
                    <div class="box-body" style="width: 600px;">
                        <div>
                            @if($errors->any())
                            <div class="alert alert-danger" aria-hidden="true"style="width: 450px;">
                                <p>Warning :</p>
                                @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            @if(Session::has('flash_message'))
                            <div class="alert alert-success" aria-hidden="true"style="width: 450px;">
                                {{ Session::get('flash_message') }}
                            </div>
                            @endif
                        </div>

                        <table class="table table-bordered">
                            <tbody>
                            <th colspan="2" style="font-family: Verdana"><center>Upload File</center></th>

                            <tr style="display: none">
                                <th style="width: 150px">Uploader: </th>
                                <td><input type="hidden" name="uploader" class="form-control" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px;"></th>
                                <td><input type="hidden" name="date_uploaded" class="form-control" value="<?php date('F d, Y')?>"></td>
                            </tr>    
                            <tr>
                                <th style="width: 150px;">Title: </th>
                                <td><input type="text" name="pdf_title" style="width: 250px" class="form-control"></td>
                            </tr>
                            <tr>
                                <th style="width: 150px">Type : </th>
                                <td><select class="form-control" name="type" style="width: 250px">
                                    <option value=" ">Select Type</option>
                                    <option value="1">Work Proceedings</option>
                                    <option value="2">Forms</option>
                                    <option value="3">Layouts</option>
                                </select></td>
                            </tr>
                            <tr>
                                <th style="width: 150px;">Select File: </th>
                                <td><input type="file" name="pdf_name" id="pdf_name"></td>
                            </tr>
                            
                            </tbody>
                        </table>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="box-footer">
                        <div class="foot-area">
                            <button class="btn btn-primary" type="submit" name="send"><i class="fa fa-fw fa-upload"></i>&nbsp; Upload PDF</button>
                        </div>
                    </div> 
                </div> 
            </form>
        </div>
        
        <div class="tab-pane" id="tab2">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            
        <div class="box-body">     
            <center><table class="table table-bordered" style="width: 550px;">
                <thead>
                    <tr>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }}'><center>{{ $head }}</center></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td><center><a href="download/{{$row-> pdf_name}}">{{ $row-> pdf_title }}</a></center></td>
                        <td><center>
                            <a href="edit/{{$row-> pdf_id}}"><span class="label label-info"> Edit </span></a>&nbsp;&nbsp;&nbsp;
                            <a href="delete/{{$row-> pdf_id}}"><span class="label label-danger" > Delete </span></a>
                        </center></td>

                    </tr>
                    @endforeach
                </tbody>
            </table></center>
        </div>
        </div>
        
        <div class="tab-pane" id="tab3">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            
            <form role="form" method="POST" action="cStore">
                <table class="table table-bordered" style="width:500px;">
                    <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>Add Category</center></th>

                    <tr>
                        <th style="width: 150px">Category Name </th>
                        <td><input type="text" name="category_name" style="width: 250px" class="form-control"></td>
                    </tr>
                    </tbody>
                </table>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-footer" >
                    <div class="foot-area">
                        <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-fw fa-save"></i>&nbsp; Add Category</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
    </div> 
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>

@endsection