@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<!-- Default box -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#return" aria-expanded="true">
                    Edit Returned Item
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#add" aria-expanded="false">
                    Add a Manufacturer
                </a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#view" aria-expanded="false">
                    View All Returned Items
                </a>
            </li>
    </ul>
    
    <div class="tab-content">
            <div id="return" class="tab-pane active">
                <form name="myform" role="form" method="POST" action="{{ asset('/returneditem/update') }}">
                <input type="hidden" name="_method" value="PUT">
        
            <div class="alert alert-info alert-dismissable" style="width: 450px">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below for returning of items
            </div>
                
            <div>
                @if($errors->any())
                    <div class="alert alert-danger" aria-hidden="true" style="width: 450px">
                        <p>Warning :</p>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                    @if(Session::has('flash_message'))
                    <div class="alert alert-success" aria-hidden="true" style="width: 450px">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
        
        <div class="box-body">
            <table class="table table-bordered" style="width: 1000px">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>UPDATE RETURNED ITEM FORM</center></th>
                    
                    <tr style="display: none">
                    <th style="width: 150">Logged By: </th>
                    <td><input type="hidden" name="logged_by" class="form-control" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                    <input type="hidden" name="id" value="<?php echo $temp->id ?>">
                    </tr>
                    
                    <tr style="display: none">
                        <td style="font-weight: bold; width: 200px;">Category: </td>
                        <td><input type="text" name="cid" style="width: 350px; margin-left: 15px;" value="<?php echo $temp->cid ?>" class="form-control"></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold;">Item: </td>
                        <td><select type="text" id="items" value="<?php echo $temp->item_id ?>" name="item_id" onChange="run()" style="width: 350px; margin-left: 15px;" class="form-control">
                               <?php $item=\App\ItemInventory::where('id', $temp->item_id)->first();  ?>
                                <option value="{{ $temp->item_id }}">{{ $item->name }}</option>
                                
                                @foreach($items AS $item)
                                <?php $name=\App\ItemInventory::where('id', $item->id)->first();  ?>
                                <option value="{{ $item->id }}">{{$name->name}}</option>
                                @endforeach   
                        </select></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold;">Serial: </td>
                        <td><select type="text" id="serial" name="serial" style="width: 350px; margin-left: 15px;" class="form-control">                     
                                <option value="{{ $temp->serial }}">{{ $temp->serial }}</option>
                                
                        </select></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 170px;">Condition</td>
                        <td>
                            <input <?php if($temp->condition == 'GOOD') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="condition" value='GOOD' id="conGood"/> Good <br>
                            <input <?php if($temp->condition == 'NOT') echo 'checked'; ?> type='radio' style="margin-left: 15px;"  name="condition" value='NOT' id="conNot"/> Not Good
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold;">Is it under warranty?</td>
                        <td>
                            <div id="warranty">
                            <input <?php if($temp->warranty == 'YES') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="warranty" value='YES' id="warYes"/> Yes<br>
                            <input <?php if($temp->warranty == 'NO') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="warranty" value='NO' id="warNo"/> No
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 160px;">Name of Manufacturer: </td>
                        <td><div id="manufacturer" >
                        <input type="text" name="manufacturer" value="<?php echo $temp->manufacturer ?>" style="width: 350px; margin-left: 15px;" class="form-control">
                        </div></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 170px; ">Is under warranty item fixed?</td>
                        <td><div id="fixed_uw" style="display: none">
                            <input type='radio' name="fixed_uw" style="margin-left: 15px;" value='YES' id="yes_uw" checked/> Yes<br>
                        </div></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 170px;">Can it still be fixed?</td>
                        <td><div id="fixed">
                            <input <?php if($temp->fixed == 'YES') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="fixed" value='YES' id="fixYes"/> Yes<br>
                            <input <?php if($temp->fixed == 'NO') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="fixed" value='NO' id="fixNo"/> No
                        </div></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 170px;">Dispose item?</td>
                        <td><div id="disposed">
                            <input <?php if($temp->disposed == 'YES') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="disposed" value='YES' id="disposeYes"/> Yes<br>
                            <input <?php if($temp->disposed == 'NO') echo 'checked'; ?> type='radio' style="margin-left: 15px;" name="disposed" value='NO' id="disposeNo"/> No
                        </div></td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 160px;">Quantity: </td>
                        <td><input type="text" value="<?php echo $temp->quantity ?>" name="quantity" style="width: 350px; margin-left: 15px;" class="form-control"></td>
                    </tr>
                    
                    <tr>
                        <th style="width: 170px;">Returned by:</th>
                        <td>
                            <div class="form-group" style="width: 250px; float: left; margin-left: 13px; margin-bottom: 1px;">
                                <select class="form-control" name="username" value="<?php echo $temp->username ?>">
                                    <optgroup label="{{ Auth::user()->department->name}}">
                                        <?php $username = \App\Employee::where('uid', $temp->username)->first(); ?>
                                            <option value="{{ $temp->username }}" selected>{{ $username->name }}</option>
                                            <?php $subordinates = Auth::user()->subordinates(); ?>
                                            @foreach($subordinates AS $subordinate)
                                        <?= ($subordinate->uid == $temp->username ? '' : '<option value="'.$subordinate->uid.'">'.$subordinate->name.'</option>') ?>
                                            @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="font-weight: bold; width: 160px;">Date: </td>
                        <td name="date" style="margin-left: 15px;"><?php echo $date = date("F j, Y g:i A"); ?></td>
                    </tr>
                    
                </tbody>
            </table>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
       <div class="box-footer">
            <div class="foot-area" style="float: right;">
                <button type="submit" name="save" class="btn btn-warning"><i class="fa fa-save"></i> Save As Draft</button>
                <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-send"></i> Update Now</button>
            </div>
        </div>
    </form>
</div>
        
        <div id="add" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            
            <div class="box-body">
                <form name="myform" role="form" method="POST" action="{{ asset('/returneditem/mstore') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                    <div>
                        <table class="table table-bordered" style="width: 500px">
                            <th colspan="2" style="font-family: Verdana"><center>MANUFACTURER INFORMATION</center></th>
                            <tr>
                                <th style="width: 150px">Name: </th>
                                <td><input type="text" name="name" style="width: 250px" class="form-control"></td>
                            </tr>
                            <tr>
                                <th style="font-weight: bold; width: 160px;">Date: </td>
                                <td style="margin-left: 15px;"><input type="hidden" name="date" class="form-control" value="<?php echo date("Y-m-d H:i:s"); ?>"><?php echo date("Y-m-d H:i:s"); ?></td>
                            </tr>

                            <tr style="display:none">
                                <th style="font-weight: bold; width: 160px;">Manufacturer ID: </td>
                                <td style="margin-left: 15px;"><input type="text" style="width: 250px" name="manufacturer_id" class="form-control" value="<?php echo substr(number_format(time() * rand(), 0, '', ''), 0, 10); ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" style="float: right" name="save" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button></td>
                            </tr>
                        </table>
                    </div>
                
                    <div>
                        <table class="table table-bordered" style="width: 500px;">
                            <thead>
                                <tr>
                                    @foreach($breakdowns['headers'] as $i => $head)
                                    <th style='{{ $breakdowns['headerStyle'][$i] }}}'><center>{{ $head }}</center></th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($reman as $view)
                                <tr>
                                    <td><center>{{ $view->id}}</center></td>
                                    <td><center>{{ $view->name }}</center></td>
                                    <td><center>{{ date('F j, Y g:i A', strtotime($view->created_at)) }}</center></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
        
        
        <div id="view" class="tab-pane">
            <div class="box-header">
                <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
             </div>
            
            <div class="box-body">
            <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }}}'><center>{{ $head }}</center></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <?php $user = \App\Employee::where('uid', $row->logged_by)->first();
                          $itemName = \App\ItemInventory::where('id', $row ->item_id)->first();
                    ?>
                    <tr>
                        <td><center>{{ $itemName-> name }}</center></td>
                        <td><center>{{ $row-> serial }}</center></td>
                        <td><center>{{ $user-> name }}</center></td>
                        <td><center>{{ date('F j,  Y', strtotime($row->created_at)) }}</center></td>
                        <td><center><a href="{{$row-> id}}"><span class="label label-info"> Edit </span></a></center></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="../../plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
        if(document.getElementById('conGood').checked){
            $('#warranty').hide();
            $('#manufacturer').hide();
            $('#fixed_uw').hide();
            $('#fixed').hide();
            $('#disposed').hide();
        }
        
        if(document.getElementById('warNo').checked){
            $('#manufacturer').hide();
        }
        
        if(document.getElementById('warYes').checked){
            $('#fixed').hide();
            $('#disposed').hide();
            $('#fixed_uw').show();
        }
        
        if(document.getElementById('fixYes').checked){
            $('#disposed').hide();
        }
</script>
<script type="text/javascript">
    $('#conGood').click(function () {
        $('#warranty').hide();
        $('#manufacturer').hide();
        $('#fixed_uw').hide();
        $('#fixYes').removeAttr("checked");
        $('#name').val("");
        $('#fixed').hide();
        $('#disposed').hide();
        $('#disposeNo').removeAttr("checked");
        $('#disposeYes').removeAttr("checked");
    });

    $('#conNot').click(function () {
        $('#warranty').show();
        $('#warYes').removeAttr("checked");
        $('#warNo').removeAttr("checked");
    });

    $('#warYes').click(function () {
        $('#fixed').hide();
        $('#disposed').hide();
        $('#manufacturer').show();
        $('#fixed_uw').show();
        $('#yes_uw').prop("checked", true);
        $('#disposeNo').removeAttr("checked");
        $('#disposeYes').removeAttr("checked");
    });

    $('#warNo').click(function () {
        $('#manufacturer').hide();
        $('#fixed_uw').hide();
        $('#yes_uw').removeAttr("checked");
        $('#name').val("");
        $('#fixed').show();
        $('#fixNo').removeAttr("checked");
        $('#fixYes').removeAttr("checked");
    });

    $('#fixNo').click(function () {
        $('#disposed').show();
    });

    $('#fixYes').click(function () {
        $('#disposed').hide();
        $('#disposeYes').removeAttr("checked");
        $('#disposeNo').removeAttr("checked");
    });
</script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>

<script type="text/javascript">
        $('#items').on('change',function() 
        {
            var selItem = $(this).val();
            //ajax
            $.get(" {{url('/returneditem/get_serial') }}" + '/' + selItem , function(data){
                //success
                $.each(data, function(){
                    $('#serial').html(data);
                });
            });  
        });       
</script>
@endsection