@extends('layouts.master')
@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection
<style>
    input[type=file] {
        display:block;
        top: 0;
        left: 0;
        height:0;
        width:0;
        opacity: 0;
        filter: alpha(opacity=0);
        font-size: 8pt;
        z-index: 1;
        visibility: hidden;
        margin-left: -40px;
    }
    .table tr:hover td{
        background: #E2E8EF;
    }
</style>


@section('content')
<div class="box" style="width: 920px;">
    <div class="box-body">
        <center><table id="items" class="table table-bordered" style="width: 900px; font-family: arial; font-size: 14px;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th style="text-align: center;"><input id="selectall" class="selectall" type="checkbox" value="invalid" style="border: 1px solid;border-color: #ccccb3;"/></th>
                    <th style="text-align: center; vertical-align:middle;">QTY</th>
                    <th style="text-align: center; vertical-align:middle;">CATEGORY</th>
                    <th style="text-align: center; vertical-align:middle;">ITEM NAME</th>
                    <th style="text-align: center; vertical-align:middle;">DETAILS</th>
                    <th style="text-align: center; vertical-align:middle;">SUPPLIER</th>
                    <th style="text-align: center; vertical-align:middle;">ON STOCKS</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php $row = 0;?>
                @foreach($items AS $item) 
                <?php if($item->quantity > 0) {?>
                <tr>
                    <td style="vertical-align:middle;"><center><input name="item_id[]" value="{{ $item->id }}" class="chkNumber" id="selectall" type="checkbox" style="border: 1px solid;border-color: #ccccb3;"/></center></td>
                    @if($item->quantity > 1)
                        <td style='text-align: center;'><input type="text" class="form-control" name="item_qty[]" style="width: 50px;"></td>
                    @else
                        <td>1</td>
                    @endif
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->serial }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td><b><?= $item->quantity != 1 ? $item->quantity : "" ?></b></td>
                </tr>
                <?php $row++; }?>
                @endforeach
            </tbody>
            </table></center>
        <br>
        <button class="btn btn-primary" type="button" id="select_button">Add selected items</button>       
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script type="text/javascript">
    $(function () {
        $('#items').DataTable();
    });
</script>
<script>  
/////-----------------------------------------------/////
/////                   CHECKBOX JS                 /////
/////-----------------------------------------------/////

    $('.selectall').click(function () {
        $('.chkNumber').prop('checked', $(this).is(':checked'));
    });

    $('.chkNumber').click(function () {
        if ($('.chkNumber:checked').length === $('.chkNumber').length) {
            $('.selectall').prop('checked', true);
        }
        else {
            $('.selectall').prop('checked', false);
        }
    });
     
/////-----------------------------------------------/////
/////              SELECT ITEMS BUTTON              /////
/////-----------------------------------------------/////
    
    $('#select_button').click(function () {
        var items = [];
        var qtyEmpty = 0;
        var qtyOver = 0;
        $('input:checked').each(function () {
            var qty = $(this).closest('tr').find("td:nth-child(2)");
            var category = $(this).closest('tr').find("td:nth-child(3)");
            var name = $(this).closest('tr').find("td:nth-child(4)").text();
            var serial = $(this).closest('tr').find("td:nth-child(5)").text();
            var supplier = $(this).closest('tr').find("td:nth-child(6)").text();
            if (this.value != "on"){
                if(this.value != "invalid"){
                    if (qty.find("input").val() === undefined) {
                        var item = {id: this.value, qty: qty.text(), category: category.text(), name: name, serial: serial, supplier: supplier};
                        items.push(item);
                    }else{
                        var item = {id: this.value, qty: qty.find("input").val(), category: category.text(), name: name, serial: serial, supplier: supplier};
                        if (qty.find("input").val() === "" || qty.find("input").val() === '0')
                            qtyEmpty++;

                        var item_count = parseInt($(this).closest('tr').find("td:nth-child(7)").text());
                        if (parseInt(qty.find("input").val()) > item_count)
                            qtyOver++;
                        items.push(item);
                    }
                }
            }
        });       
        if ($('input:checked').length >= 0) {
            if (qtyEmpty === 0) {
                if (qtyOver !== 0) {
                    alert('Requested items should NOT exceed total items on stock!');
                    return false;
                } else {
                    if (window.opener && !window.opener.closed) {
                        window.opener.updateItems(items);
                        window.close();
                    }
                }
            } else {
                alert('Enter a valid quantity.');
                return false;
            }
        }    
        
    });
    
/////-----------------------------------------------///// 
/////                   ROW HIGHLIGHT               /////
/////-----------------------------------------------/////

    $('#selectall').click(function () {
        if ($(this).is(':checked'))
            $('tr :checkbox').attr('checked', true);
        else
            $('tr :checkbox').attr('checked', false);
        checkSelected();
    });
    $("tr :checkbox").click(function () {
        $(this).closest("tr").css("background-color", this.checked ? "#a9b9ca" : "");
    });
    $('td').click(function (event) {
        var $target = $(event.target);
        if (!$target.is("input") && !$target.is("a")) {
            if ($(this).closest('tr').find('input').is(':checked'))
                $(this).closest('tr').find('input').attr('checked', false);
            else
                $(this).closest('tr').find('input').attr('checked', true);
        } else if ($target.is("a"))
            $(this).closest('tr').find('input').attr('checked', false);
        checkSelected();
    });
    function checkSelected() {
        $('tr').each(function () {
            if ($(this).find('input').is(':checked'))
                $(this).css("background-color", "#adbdd1");
            else
                $(this).css("background-color", "");
        });
    }
      
</script>
@endsection