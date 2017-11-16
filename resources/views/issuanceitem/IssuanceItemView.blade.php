@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')
<div class="col-md-6" style="width: 100%;">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Create New Issuance</a></li>
            <li><a href="#tab_2" data-toggle="tab">Show All Issuance</a></li>            
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box-body table-responsive">
                <form method="POST" action="{{asset('/itemissuance/store')}}" role="form">
                    <div class="box">
                        <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <b>Note: </b> All fields are required. Don't leave anything empty.
                        </div>
                        <div>
                            @if($errors->any())
                                <div class="alert alert-danger" aria-hidden="true">
                                    <p>Warning :</p>
                                    @foreach($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                            @if(Session::has('flash_message'))
                                <div class="alert alert-success" aria-hidden="true">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif
                        </div>
                        <div style="float:left; width: 555px">
                            <table class="table table-bordered">
                                <tbody>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <th colspan="2" style="font-family: Verdana"><center>Issuance Form</center></th>
                                    <tr>
                                        <th style="width: 100px">Issuance No.: </th>
                                        <td> 
                                            <input type="text" class="form form-control" name="issued_id" readonly value="<?php echo time(); ?>" style="width: 200px;">
                                            <input type="hidden" name="issued_by" value="{{ Auth::user()->uid }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 100px">Date: </th>
                                        <td><input type="text" class="form form-control" readonly value="{{ date('F j, Y') }}" style="width: 200px;"></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 100px">Department: </th>
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
                                        <th style="width: 100px;">Issued To: </th>
                                        <td>
                                            <div id="employee">
                                                
                                            </div>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="padding-top: 120px; width: 100px;">Purpose: </th>
                                        <td>
                                            <textarea id="purpose" name="purpose" class="ckeditor" style="height: 200px;"> </textarea>
                                        </td>
                                    </tr>
                                </table>
                                <fieldset>
                                    <legend style="font-size:16px;">Attach MRIS Form</legend>
                                    <select name="attached_mris" class="input-select" style="width: 300px">
                                        <optgroup label="Select MRIS Form">
                                            <option value=" ">--------------------</option>
                                            <?php $mris_forms = DB::table('mris_forms')->get();?>
                                             @foreach ($mris_forms as $form)
                                                <option value="<?= $form->id ?>"><?= $form->id, ' - ', $form->requested_by?></option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </fieldset>
                                <fieldset>
                                    <legend style="font-size:16px;">Attach IRIS Form</legend>
                                    <select name="attached_iris" class="input-select" style="width: 300px">
                                        <optgroup label="Select IRIS Form">
                                            <option value=" ">--------------------</option>
                                            <?php $iris_forms = DB::table('iris_forms')->get();?>
                                             @foreach ($iris_forms as $form)
                                                <option value="<?= $form->id ?>"><?= $form->id, ' - ', $form->requested_by?></option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </fieldset>
                                <div class="box-footer" >
                                    <div class="foot-area" style="float: left;">
                                        <br><button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit Issuance</button>
                                    </div>
                                </div>
                            </div>
                            <div style=" float: right; width: 555px">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th colspan="5" style="font-family: Verdana"><center>Items Selected</center></th>
                                            <tr>
                                                <th><center>Qty</th>
                                                <th><center>Item Name</th>
                                                <th><center>Serial No.</th>
                                                <th><center>Unit Price</th>
                                                <th><center>X</center></th>
                                            </tr>
                                        </thead>
                                        <tbody id="item_selections">      
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <tr>
                                                    <td colspan="5"></td>
                                                </tr>
                                                <td colspan="5">
                                                    <div style="float:right;">
                                                        <br><button class="btn btn-primary" type="button" id="add_item">Add Items</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane" id="tab_2">
                <div class="box-header">
                    <h1 class="box-title">{{ $breakdown['name'] }}</h1> 
                </div>
                <label style="padding-left: 10px; font-size:16px;"><?php echo "Date : " .date("F j, Y"); ?></label>
                <div class="box-body">
                    <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                @foreach($breakdown['headers'] as $i => $head)
                                    <th style="{{ $breakdown['headerStyle'][$i] }}"><center>{{ $head }}</center></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <?php 
                                    $issuer = DB::table('employees')->where('uid', $row->issued_by)->first();
                                    $to = DB::table('employees')->where('uid', $row->issued_to)->first();
                                    $dept = DB::table('departments')->where('departmentid', $row->department)->first();
                                ?>
                                <tr>
                                    <td><center>
                                        <?php echo '<a href="view/'.$row->issued_id.'"  target="_blank">'.$row->issued_id.'</a>'; ?>
                                    </center></td>
                                    <td><center>
                                        <?php echo $issuer->fname.' '.$issuer->lname ?>
                                    </center></td>
                                    <td><center>
                                        <?php echo $to->fname.' '.$to->lname ?>
                                    </center></td>                                       
                                <td><center>{{ $dept->name }}</center></td>
                                    <td><center>{{ date("F j, Y", strtotime($row->created_at)) }}</center></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional_scripts')
<script src="{{ asset("/bower_components/admin-lte/plugins/jQuery/jQuery-1.8.3.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
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
        CKEDITOR.replace('purpose');
    });
</script>
<script type="text/javascript">
    $('#department').on('change', function() 
    {  var selItem = $(this).val();
        $.get("{{ url('/itemissuance/getemployee') }}" + '/' + selItem , function(data){
            $.each(data, function(){
                $('#employee').html(data);
            });
        });  
    });  
</script>
<script>
    $('#add_item').click(function() {
        window.open("{{ url('/itemissuance/items_select') }}", 'popUpWindow', 'width=1000, height=500, toolbar=no, resizable=1, scrollbars=yes, status=no, menubar=no');
    });
</script>
<script>   
    function updateItems(items) {
        for (var index in items) {
            var rowWrapper = $("<tr/>");
            var item_qty = $("<td style=\"font-weight: bold; text-align: center;\">" + items[index].qty + "<input type=\"hidden\" name=\"quantity[]\" value=\"" + items[index].qty + "\"/></td>");
            var item_name = $("<td style=\"text-align: center;\">" + items[index].name + "<input type=\"hidden\" name=\"item_id[]\" value=\"" + items[index].id + "\"/></td>");
            var item_serial = $("<td style=\"text-align: center;\">" + items[index].serial + "<input type=\"hidden\" name=\serial[]\" value=\"" + items[index].serial + "\"/></td>");
            var item_price = $("<td style=\"text-align: center;\">" + items[index].price + "<input type=\"hidden\" name=\price[]\" value=\"" + items[index].price + "\"/></td>");
            var removeButton = $("<td style=\"text-align: center;\"><i class=\"fa fa-fw fa-times-circle fa-lg\" onclick=\"deleteItem();\"></i></td>");
            //var rowWrapper1 = $("<tr/>");
            //var item_qty_total = $("<td style=\"font-weight: bold; text-align: center;\">" + items[index].qty+=items[index].qty + "<input type=\"hidden\" name=\"quantity[]\" value=\"" + items[index].qty+=items[index].qty + "\"/></td>");
            
            removeButton.click(function() {
                $(this).parent().remove();
            });

            rowWrapper.append(item_qty);
            rowWrapper.append(item_name);
            rowWrapper.append(item_serial);
            rowWrapper.append(item_price);
            rowWrapper.append(removeButton);
            //rowWrapper1.append(item_qty_total);
            
            
            var ctr = 0;
            $("input[name^=item_qty]").each(function() {
                var name = $(this).closest('tr').find("td:nth-child(3)").text();
                var serial = $(this).closest('tr').find("td:nth-child(4)").text();    
                var price = $(this).closest('tr').find("td:nth-child(5)").text();    
                if (name === items[index].name && serial === items[index].serial && price === items[index].price) {
                    ctr++;
                }                
            });
            if (ctr === 0)
                $("#item_selections").append(rowWrapper);
            }
    }
</script>
@endsection