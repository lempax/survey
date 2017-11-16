@extends('layouts.master')
@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection


@section('content')
<div class="box">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li><a href="#tab1" data-toggle="tab">Add Assets</a></li>
            <li><a href="#tab2" data-toggle="tab">Show All Assets</a></li>
            <li class="active"><a href="#tab3" data-toggle="tab">New Issuance</a></li>
            <li><a href="#tab4" data-toggle="tab">All Transactions</a></li> 
            <li><a href="#tab5" data-toggle="tab">Re-issue Item</a></li> 
            <li><a href="#tab6" data-toggle="tab">All Returned Assets</a></li> 
        </ul>
    </div>
    <div class="tab-content">
        <?php $uid = Auth::user()->uid; ?>  
        <div class="tab-pane" id="tab1">
            <form  method="POST" action="{{ asset('/assets/addasset') }}" role="form">
                <div class="box-body">
                    <p><i>Please make sure to fill up all the required <font color="red">(*)</font> fields below to add a new item.</i></p>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-bordered" style="width: 600px;">
                        <thead>
                            <tr>   
                                <th colspan=2 style="text-align:center;">ADD ITEM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align:middle;">Category: <font color="red">*</font></td>
                                <td>
                                    <?php $category = DB::table('item_categories')->get();?>
                                    <select class="form form-control" name="category" style="width: 250px;">
                                        <option>Select Category</option>
                                        @foreach($category as $cat)
                                        <option>{{$cat->category}}</option>
                                        @endforeach
                                    </select>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Item Name: <font color="red">*</font></td>
                                <td><input type="text" required name="name" class="form form-control" style="width: 250px;"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Other Details<br>(Serial, Contract #, etc):</td>
                                <td><textarea name="serial" class="form-control" style="height:100px; width:300px;"></textarea></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Quantity: <font color="red">*</font></td>
                                <td><input type="text" required name="quantity" class="form form-control" style="width: 250px;"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Supplier:</td>
                                <td><input type="text" class="form form-control" name="supplier" style="width: 250px;"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Delivery Date:</td>
                                <td>
                                    <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                        <div class="input-group-addon">
                                          <span class="fa fa-calendar"></span>
                                        </div>
                                        <input type="text" name="date_delivered" class="form-control" style="width: 150px;">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Warranty Validity:</td>
                                <td>
                                    <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                        <div class="input-group-addon">
                                          <span class="fa fa-calendar"></span>
                                        </div>
                                        <input type="text" class="form-control" name="warranty_date" style="width: 150px;">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    <div style="text-align: right;">
                                        <button class="btn btn-primary" type="submit"> Add item</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped" id="show_assets">
                    <thead>
                        <tr>
                            @foreach($breakdown['assets_headers'] as $i => $head)
                            <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($assets AS $asset)
                            <tr>
                                <td>{{$asset->category}}</td>
                                <td>{{$asset->name}}</td>
                                <td>{{$asset->serial}}</td>
                                <td>{{$asset->quantity}}</td>
                                <td>{{$asset->supplier}}</td>
                                <td>{{ date("F j, Y", strtotime($asset->date_delivered)) }}</td>
                                <td>{{ date("F j, Y", strtotime($asset->warranty_date)) }}</td>
                            </tr>
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
         <div class="tab-pane active" id="tab3">
             <div class="box-body" style="width: 800px;">
                <form  method="POST" action="{{ asset('/assets/issue') }}" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table class="table table-bordered" style="width:800px;">
                        <thead>
                            <tr>
                                <th style="text-align: center;" colspan="2">ISSUANCE FORM</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align:middle;">Issuance No: <font color="red">*</font></td>
                                <td><input type="text" class="form form-control" name="issued_id" readonly value="<?php echo time(); ?>" style="width: 200px;"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Date: <font color="red">*</font></td>
                                <td><input type="text" class="form form-control" readonly value="{{ date('F j, Y') }}" style="width: 200px;"></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Department: <font color="red">*</font></td>
                                <td>
                                    <?php $department = DB::table('departments')->get()?>
                                    <select class="form form-control" id="department" name="department" style="width: 300px;">
                                        <option>Select Department</option>
                                        @foreach($department as $dept)
                                        <option value="{{ $dept->departmentid }}">{{$dept->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Issued to: <font color="red">*</font></td>
                                <td>
                                    <div id="employee"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align:middle;">Purpose:</td>
                                <td>
                                    <textarea id="purpose" name="purpose" class="ckeditor" style="height: 200px;"> </textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table><br>
                    
                    <table class="table table-bordered" style="width:400px;">
                        <thead  style="background-color: #f0f0f0;">
                            <th style="font-weight: normal;">QUANTITY</th>
                            <th style="font-weight: normal;">ITEM NAME</th>
                            <th style="font-weight: normal;">SERIAL #</th>
                            <th></th>
                        </thead>
                        <tbody id="item_selections"></tbody>
                        <tr>
                            <td colspan="4">
                                <div style="float:right;">
                                    <button class="btn btn-primary" type="button" id="add_item">Add Items</button> 
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: right;">
                       <button class="btn btn-primary" type="submit"><i class="fa fa-send-o"> </i> Submit Issuance</button>
                    </div>
                </form>
             </div>
         </div>
        <div class="tab-pane" id="tab4">
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped" id="all_transactions">
                    <thead>
                        <tr>
                            @foreach($breakdown['issuance_headers'] as $i => $head)
                            <th style="{{ $breakdown['headerStyle2'][$i] }}">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($issuance AS $issue)
                        <?php
                            $by = DB::table('employees')->where('uid', $issue->issued_by)->first();
                            $to = DB::table('employees')->where('uid', $issue->issued_to)->first();
                            $dept = DB::table('departments')->where('departmentid', $issue->department)->first();
                        ?>
                            <tr>
                                <td><a href="view/{{$issue->issued_id}}">{{ $issue->issued_id }}</a></td>
                                <td>{{ $by->fname }} {{ $by->lname }}</td>
                                <td>{{ $to->fname }} {{ $to->lname }}</td>
                                <td>{{ $dept->name }}</td>
                                <td>{{ date("F j, Y", strtotime($issue->date_issued)) }}</td>
                                <td>
                                    <?php 
                                        if($issue->status=="pending")
                                            echo '<span class="label label-warning">Pending</span>'; 
                                        else if ($issue->status=="approved")
                                            echo '<span class="label label-success">Approved</span>'; 
                                        else if ($issue->status=="disapproved")
                                            echo '<span class="label label-default">Disapproved</span>'; 
                                    ?>
                                </td>
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
<script src="{{ asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script type="text/javascript">
    $('#department').on('change', function() 
    {  var selItem = $(this).val();
        //ajax
        $.get("{{ url('/assets/getemployee') }}" + '/' + selItem , function(data){
            //success
            $.each(data, function(){
                $('#employee').html(data);
            });
        });  
    });  
</script>
<script src="{{ asset("/bower_components/admin-lte/plugins/jQuery/jQuery-1.8.3.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        $('#show_assets').DataTable();
        $('#all_transactions').DataTable();
        CKEDITOR.config.toolbar = [
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']}
        ];
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.instances.InstanceName.setData("");
        CKEDITOR.replace('purpose');
    });
</script>
<script>
    $('#add_item').click(function() {
        window.open("{{ url('/assets/selectitem') }}", 'popUpWindow', 'width=1010, height=550, toolbar=no, resizable=1, scrollbars=yes, status=no, menubar=no');
    });
</script>
<script>   
    function updateItems(items) {
        for (var index in items) {
            var rowWrapper = $("<tr/>");
            var item_qty = $("<td style=\"font-weight: bold\">" + items[index].qty + "<input type=\"hidden\" name=\"quantity[]\" value=\"" + items[index].qty + "\"/></td>");
            var item_name = $("<td>" + items[index].name + "<input type=\"hidden\" name=\"item_id[]\" value=\"" + items[index].id + "\"/></td>");
            var item_serial = $("<td>" + items[index].serial + "<input type=\"hidden\" name=\serial[]\" value=\"" + items[index].serial + "\"/></td>");
            var removeButton = $("<td style=\"text-align: center;\"><i class=\"fa fa-fw fa-times-circle fa-lg\" onclick=\"deleteItem();\"></i></td>");
            removeButton.click(function() {
                $(this).parent().remove();
            });

            rowWrapper.append(item_qty);
            rowWrapper.append(item_name);
            rowWrapper.append(item_serial);
            rowWrapper.append(removeButton);

            var ctr = 0;
            $("input[name^=item_qty]").each(function() {
                var name = $(this).closest('tr').find("td:nth-child(3)").text();
                var serial = $(this).closest('tr').find("td:nth-child(4)").text();    
                if (name === items[index].name && serial === items[index].serial) {
                    ctr++;
                }
            });
            if (ctr === 0)
                $("#item_selections").append(rowWrapper);
        }
    }
</script>
@endsection