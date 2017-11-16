@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<form method="POST" action="{{asset('birthdaycard/file')}}" role="form" enctype="multipart/form-data">
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="vertical-align:middle;">Logged By:</td>
                        <td><input type="hidden" value="{{Auth::user()->name}}"><input type="hidden" name="user" value="{{Auth::user()->username}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Employee name: </td>
                        <td><select name="filename" class="form-control" style="width: 200px;">
                                <?php foreach ($subordinates as $r):?>
                                 <?php
                                 echo '<option value='.$r->username.'>'. $r->fname . ' '.$r->lname.'</option>';
                                 ?>
                                <?php endforeach;?>
                            </select>
                    </tr>
                    <tr>
                        <td style="vertical-align:middle;"><font color="red">*</font> Upload Birthday Card </td>
                    <td>                   
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="file" name="import_file" class="form-control" style="width: 250px;">                
                    </td>
                    </tr>                  
                </tbody>                
            </table>
            <div class="alert alert-info alert-dismissable">           
            <b>Note:</b> * only accepts JPG filetype with 843 x 956 dimension.
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
        </div>
        <div class="box-footer">
            <div class="footer-area" style="float: end;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" name="submit" class="btn btn-primary" value="submit">
            </div>
        </div>
        </div>     
    </div>
</form>
@endsection
@section('additional_scripts')
@endsection