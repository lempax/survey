@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<input type="hidden" name="_method" value="PUT">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value="<?php echo $rows->id; ?>">
<div class="box">
    @if($errors->any())
    <br><div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
            <i class="fa fa-warning">&nbsp;</i><b> FAILED.</b>
            Please fill in all necessary input fields.  
        </div>
    @endif
    <div class="box-footer">
        <a href="{{ asset('/iteminventory/view') }}"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Back to Item Inventory</u></font></a>
    </div>
    <div class="box-body" style="width: 40%; float: left;">
        <table class="table table-bordered">
            <tbody>
                <th colspan="2"><center>{{$rows->name}}</center></th>
                <tr>
                    <td>Category:</td>
                    <?php $categ = DB::table('item_categories')->where('cid', $rows->cid)->first(); ?>
                    <td>{{$categ->category}}</td>
                </tr>
                <tr>
                    <td>Unit Price:</td>
                    <td>{{$rows->price}}</td>
                </tr>
                <tr>
                    <td>On stock:</td>
                    <td>{{$rows->quantity}}</td>
                </tr>
                <tr>
                    <td>Supplier:</td>
                    <td>{{$rows->supplier}}</td>
                </tr>
                <tr>
                    <td>Delivery Date:</td>
                    <td>{{date('F j, Y', strtotime($rows->date_delivered))}}</td>
                </tr>
                <tr>
                    <td>Date Updated:</td>
                    <td>{{date('F j, Y', strtotime($rows->updated_at))}}</td>
                </tr>
                <tr>
                    <td>Warranty Date:</td>
                    <td>
                        <?php
                            if($rows->warranty_date=='0000-00-00')
                                echo '';
                           else echo date('F j, Y', strtotime($rows->warranty_date));
                        ?>
                       </td>
                </tr>
                <th colspan="2"><center><input type="submit" class="btn btn-primary" name="edit_item" onClick="editToggle()" value="Edit Item"></center></th>
            </tbody>
        </table>
    </div>
    <div class="box-body">
        <fieldset class="collapsible" style="width:400px;">
            <legend><font size="4">OPTIONS</font></legend>
            <form method="POST" action="{{ asset('/iteminventory/updatestocks') }}" role="form">
                <div>Update stock count:</div>
                <div style="float: left;">
                    <input type="text" class="form-control" style="width: 200px;" name="stock_count">
                </div>
                <input type="submit" class="btn btn-primary" value="Update Stocks">
                <input type="hidden" name="id" value="<?php echo $rows->id; ?>">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
            <br>
            <form method="POST" action="{{ asset('/iteminventory/changecategory') }}" role="form">
                <div>Change category:</div>
                <div style="float: left;">
                    <select class="form-control" style="width: 220px;" name="new_ctgry">
                        @foreach($categories AS $category)
                            <option>{{$category->category}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Change">
                <input type="hidden" name="id" value="<?php echo $rows->id; ?>">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </fieldset>
        <br>
        <div id="edit_item" style="display: none;">
        <fieldset class="collapsible" style="width:400px;">
            <legend><font size="4">EDIT ITEM</font></legend>
            <form  method="POST" action="{{ asset('/iteminventory/update') }}" role="form">
                <table>
                    <tbody>
                        <tr">
                            <td>Item Name:</td>
                            <td style="padding-left: 10px">Supplier:</td>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" style="width: 200px;" name="name" value="<?php echo $rows->name; ?>"></td>
                            <td style="padding-left: 10px"><input type="text" class="form-control" style="width: 200px;" name="supplier" value="<?php echo $rows->supplier; ?>"></td>
                        </tr>
                        <tr>
                            <td>Delivery Date:</td>
                            <td style="padding-left: 10px">Unit Price:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group date" data-provide="datepicker" style="width: 100px;">
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                    <input type="text" class="form-control" style="width: 160px;" name="date_delivered"  value="<?php echo date('m/d/Y', strtotime($rows->date_delivered)); ?>">
                                </div>
                            </td>
                            <td style="padding-left: 10px"><input type="text" class="form-control" style="width: 200px;" name="price"  value="<?php echo $rows->price; ?>"></td>
                        </tr>
                        <tr>
                            <td>Warranty Validity:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group date" data-provide="datepicker" style="width: 100px;">
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                    <input type="text" class="form-control" style="width: 160px;" name="warranty_date"  value="<?php if($rows->warranty_date == '0000-00-00') echo ''; else echo date('F j, Y', strtotime($rows->warranty_date)); ?>">
                                </div>
                            </td>
                        </tr>
                        <th colspan="2"><div style="float: right"><input type="submit" class="btn btn-primary" value="Update Item"></div></th>
                    </tbody>
                </table>
                <input type="hidden" name="id" value="<?php echo $rows->id; ?>">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </fieldset>
    </div>
    </div>
    <div class="box-body">
        <fieldset class="collapsible">
            <legend>Item History</legend>
                @foreach($histories AS $history)
                <i class="fa fa-paperclip"></i>&nbsp;&nbsp;
                    <?php  echo '['.date('F j, Y h:i A',strtotime($history->created_at)).'] ('.$history->changed_by.') - '.$history->description ?><br>
                @endforeach
        </fieldset>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script type="text/javascript">
    function editToggle() {
        $('#edit_item').toggle();
    }
</script>
@endsection


