@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<div class="box">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab">Add New Item</a></li>
            <li class=""><a href="#tab2" data-toggle="tab">Manage Inventory</a></li>
            <li class=""><a href="#tab3" data-toggle="tab">Item Categories</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissable" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                        <i class="fa fa-warning">&nbsp;</i><b> FAILED.</b>
                        Please fill in all necessary input fields.  
                    </div>
                @endif 
                @if(Session::has('flash_message'))
                    <div class="alert alert-success" aria-hidden="true" style="text-align: center; margin-left: 10px; width: 400px;">
                        <i class="fa fa-check">&nbsp;</i><b>{{ Session::get('flash_message') }}</b>
                    </div>
                @endif
                <div class="alert alert-info alert-dismissable"> 
                    <b>Note:</b> Fields having <font color="red">*</font> are required!
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><small>&times</small></button>
                </div>
                <form method="POST" action="{{ asset('/iteminventory/add') }}" role="form">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Category: <font color="red">*</font></td>
                                <td>
                                    <select class="form-control" style="width: 200px;" name="category">
                                        @foreach($categories AS $category)
                                            <option>{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Item Name:  <font color="red">*</font></td>
                                <td><input type="text" class="form-control" style="width: 200px;" name="name"></td>
                            </tr>
                            <tr>
                                <td>Type:  <font color="red">*</font></td>
                                <td>
                                    <select name="type" class="form-control" style="width: 200px;">
                                        <option>Select Type</option>
                                        <option>regular</option>
                                        <option>equipment</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Serial: <font color="red">*</font></td>
                                <td>
                                    <table id="myTable">
                                        <th style="padding: 5px">
                                            <input class="btn btn-primary" type="button" value="+ ADD SERIAL" onclick="displayResult(); addCounter()">
                                        </th>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>Unit Price: <font color="red">*</font></td>
                                <td><input type="text" class="form-control" style="width: 200px;" name="price"></td>
                            </tr>
                            <tr>
                                
                                <td>Quantity: <font color="red">*</font></td>
                                <td>
                                    <textarea id="result" name="quantity" class="form-control" style="width: 200px; height: 35px"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Supplier: <font color="red">*</font></td>
                                <td><input type="text" class="form-control" style="width: 200px;" name="supplier"></td>
                            </tr>
                            <tr>
                                <td>Delivery Date:  <font color="red">*</font></td>
                                <td>
                                    <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                        <div class="input-group-addon">
                                          <span class="fa fa-calendar"></span>
                                        </div>
                                      <input type="text" class="form-control" style="width: 160px;" name="date_delivered">
                                   </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Warranty Validity:</td>
                                <td>
                                    <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                        <div class="input-group-addon">
                                          <span class="fa fa-calendar"></span>
                                        </div>
                                      <input type="text" class="form-control" style="width: 160px;" name="warranty_date">
                                   </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Additional Details: <font color="red">*</font></td>
                                <td><textarea name="addn_details" id="editor_1" class="ckeditor"> </textarea></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="box-footer">
                        <div class="foot-area" style="float: right;">
                            <button type="submit" name="add" class="btn btn-primary" onclick="setToZero();">ADD ITEM</button>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>

            <div class="tab-pane" id="tab2">
                <form method="POST" action="{{ asset('/iteminventory/sort') }}" role="form">
                    <div class="box-body" style="float: left;">
                        <select name="sortcategory" class="form-control" style="width: 250px;">
                            <option selected>Show All</option>
                            @foreach($categories AS $category)
                                <option value="{{$category->cid}}">{{$category->category}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-body"><input type="submit" class="btn btn-primary" value="Show Category"></div> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <div class="box-body"><br>
                    <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown['headers'] as $i => $head)
                                <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach($rows AS $row)
                            <?php $serial = DB::table('item_serials')->where('item_id', $row->id)->get(); ?>
                            <tr>
                                <td style="vertical-align:middle;"><a href="viewitem/{{$row->id}}"><u>{{$row->name}}</u></a></td>
                                <td style="vertical-align:middle;">
                                    @foreach($serial AS $srl)
                                    {{ $srl->serial }}<br>
                                    @endforeach
                                </td>
                                <td style="vertical-align:middle;">{{$row->supplier}}</td>
                                <td style="vertical-align:middle;">{{date('F j, Y', strtotime($row->updated_at))}}</td>
                                <td style="vertical-align:middle;">{{$row->price}}</td>
                                <td style="vertical-align:middle;">{{$row->quantity}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="tab-pane" id="tab3">
                <div class="box-body">
                    @if(Session::has('category_message'))
                        <div class="alert alert-success" aria-hidden="true">
                            {{ Session::get('category_message') }}
                        </div>
                    @endif
                    <div style="float: left; width: 40%">
                        <table  class="table table-bordered">
                            <tbody>
                                <th>CATEGORY NAME</th>
                                @foreach($categories AS $category)
                                <tr>
                                    <td>{{ $category->category }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="float:left; width: 50px">&nbsp</div>
                    <div style="float:left; width: 300px;">
                        <fieldset class="collapsible">
                            <legend>OPTIONS</legend>
                            <form method="POST" action="{{ asset('/iteminventory/addcategory') }}" role="form">
                                <div class="box-body">   
                                    <table>
                                       <tbody>
                                           <tr style="padding: 5px">
                                               <td style="padding: 5px">Category:</td>
                                               <td style="padding: 5px"><input type="text" class="form-control" style="width: 200px;" name="category"></td>
                                           </tr>
                                       </tbody>
                                   </table>
                                </div>
                                <div style="float: right">
                                   <button type="submit" class="btn btn-primary">Add Category</button>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                            <br><br><br>
                            <form  method="POST" action="{{ asset('/iteminventory/removecategory') }}" role="form">
                                <div  style="float: left">
                                    <select class="form-control" style="width: 220px;" name="ctgry">
                                        @foreach($categories AS $category)
                                            <option>{{$category->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Remove">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript">
    $(function () {
        $('#table_breakdown').DataTable();
        CKEDITOR.config.toolbar = [
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']}
        ];
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('editor_1');
    });
</script>
<script type="text/javascript">
    var table = document.getElementById("myTable");
    var x = '';
    var div = 'contain';

    function displayResult() {
        for(x = 0; x <= (table.rows.length) - 1; x++){
            temp_status = status + x;
            temp_div = div + x;
        }   
        document.getElementById("myTable").insertRow(-1).innerHTML = 
            '<td style="padding: 5px"><input type="text" class="form-control" style="width: 200px;" name="serial[]"></td>\n\
             <td style="vertical-align: middle;"><i class="fa fa-fw fa-minus-circle fa-lg" onclick="deleteRow(); subtractCounter();"></i></td>';      
    }
    
    function deleteRow() {
        document.getElementById("myTable").deleteRow(-1);
    }
</script>
<script type="text/javascript">
    function addCounter() {
        if(typeof(Storage) !== "undefined") {
            if (localStorage.clickcount) {
                localStorage.clickcount = Number(localStorage.clickcount)+1;
            } else {
                localStorage.clickcount = 1;
            }
            document.getElementById("result").innerHTML = localStorage.clickcount;
        } 
    }
    
    function subtractCounter() {
      if(localStorage.clickcount>0){
            localStorage.clickcount = Number(localStorage.clickcount)-1;
      }  
        document.getElementById("result").innerHTML = localStorage.clickcount;
    } 
    
    function setToZero() {
        localStorage.clickcount = 0;
    } 
</script>
@endsection
