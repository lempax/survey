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

<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section ('content')
<meta name ="csrf-token" content = "{{csrf_token() }}"/>
 <div class="box box-primary">
        <div class="box-header with-border">
            <center><h3 class="box-title"><p align="center" style="font-family: Calibri Light; font-size: 16px;">
                <span style="font-family: Calibri Light; font-size: 22px; font-weight: bold;">MENU FOR THE WEEK</span>
            </p></h3></center>
        </div>
    </div>
<div class="row">
        
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
            <p align="center" style="font-family: Calibri Light; font-size: 16px;">
                <br>
                <span style="font-family: Calibri Light; font-size: 22px; font-weight: bold;">Menu</span>
            </p>    
            </div> 
            @if ($menu)
            <form id="createMenu" action="{{ URL('cafeteria/editmenu/'.$week.'') }}" method="POST">
            @else
            <form id="createMenu" action="{{ URL('cafeteria/addToMenu/'. $week.'') }}" method="POST">
            @endif
                {{csrf_field()}}
            <div class="box-body">

                 <table id="menuTable" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th><span class="glyphicon glyphicon-wrench"></span> Options</th>
                        </tr>
                     </thead>
                     @if($menu)
                     @foreach($menuItems as $item)
            <tr id="{{$item->id}}">
                <td>{{$item->item_name}}</td>
                @if($item->cat_id == 1)
                <td>Dessert</td>
                @elseif($item->cat_id == 2)
                <td>Snack</td>
                @elseif($item->cat_id == 3)
                 <td>Beverages</td>
                @else
                 <td>Viands/Ulam</td>
                @endif
                <td>{{$item->price}}</td>            
                <td>
                    <button type='button' value="{{ $item->id }}" class='btn btn-danger remove'><span class='glyphicon glyphicon-remove'></span></button>
                    <input type="text" name="itemID[]" value="{{ $item->id }}" hidden>
                </td>
            </tr>
            @endforeach
            @else
            @endif
                 </table>
            </div> 
            <div id="displayMenu">
                <?php $date = \Carbon\Carbon::now(); ?>
                <input type="text" value="{{ $date->format('W') }}" name="currentWeek" hidden>

                
            </div>
            <div class="box-footer">
                @if($menu)
                    @if($count == 0)
                        <button type="submit" name="createMenu" class="btn btn-primary createMenu"> Create Menu </button>
                    @else
                        <button type="submit" name="createMenu" class="btn btn-primary createMenu"> Update Menu </button>
                    @endif
                @else
                <button type="submit" name="createMenu" class="btn btn-primary createMenu"> Create Menu </button>
                @endif
                <button type="button" name="cancel" class="btn btn-default createMenu" id="cancel"> Cancel </button>
            </div>
                
                
            </form>
        </div>
    </div>
    <div class="col-md-6">
    <div class="box box-primary">
    <div class="box-header with-border">
    <p align="center" style="font-family: Calibri Light; font-size: 16px;">
        <br>
        <span style="font-family: Calibri Light; font-size: 22px; font-weight: bold;">Item List</span>
    </p>    
    </div> 
    
    <div class="box-body">
       
        <table id="itemTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Price</th>
                <th><span class="glyphicon glyphicon-wrench"></span> Options</th>
                </tr>
            </thead>
            @if($menu)
            @foreach($tableItems as $item)
            <tr id="{{$item->id}}">
                <td>{{$item->item_name}}</td>
                @if($item->cat_id == 1)
                <td>Dessert</td>
                @elseif($item->cat_id == 2)
                <td>Snack</td>
                @elseif($item->cat_id == 3)
                 <td>Beverages</td>
                @else
                 <td>Viands/Ulam</td>
                @endif
                <td>{{$item->price}}</td>            
                <td>
                    <center>
                    <button type="button" name="edit" class="btn btn-primary edit" id="editModal" value="{{$item->id}}"><span class=" glyphicon glyphicon-edit"></span> </button>    
                    <button type="button" name="delete" class="btn btn-danger delete" value="{{$item->id}}"><span class=" glyphicon glyphicon-remove"></span> </button>
                    <button type="button" name="addToMenu" class="btn btn-info addmenu" value="{{$item->id}}"><span class=" glyphicon glyphicon-plus"></span></button>
                    </center>
                </td>
            </tr>
            @endforeach
            @else
             @foreach($items as $item)
            <tr id="{{$item->id}}">
                <td>{{$item->item_name}}</td>
                @if($item->cat_id == 1)
                <td>Dessert</td>
                @elseif($item->cat_id == 2)
                <td>Snack</td>
                @elseif($item->cat_id == 3)
                 <td>Beverages</td>
                @else
                 <td>Viands/Ulam</td>
                @endif
                <td>{{$item->price}}</td>            
                <td>
                    <center>
                    <button type="button" name="edit" class="btn btn-primary edit" id="editModal" value="{{$item->id}}"><span class=" glyphicon glyphicon-edit"></span> </button>    
                    <button type="button" name="delete" class="btn btn-danger delete" value="{{$item->id}}"><span class=" glyphicon glyphicon-remove"></span> </button>
                    <button type="button" name="addToMenu" class="btn btn-info addmenu" value="{{$item->id}}"><span class=" glyphicon glyphicon-plus"></span></button>
                    </center>
                </td>
            </tr>
            @endforeach
            @endif

        </table>
 
    <button type="button" name="create" class="btn btn-primary-default" id="showModal"><span class="glyphicon glyphicon-pencil"></span> Create Item</button>     
 </div>
        
    </div>
        
</div>
</div>
<div id="addItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Food Item</h4>
      </div>
      <div class="modal-body">
        <form id ="addItem" action ="{{ URL('cafeteria/addItem/'.$week.'') }}" method ='POST'>
            {{csrf_field()}}  
        Category:  <select class="form-control" required name="category" id="category">
            <option value="Dessert">Dessert</option>
            <option value="Snack">Snack</option>
            <option value="Beverage">Beverage</option>
            <option value="Viand">Viands/Ulam</option>
        </select><br>    
        Item Name: <input type="text" class="form-control" name="itemname" id="itemname" required><br>
        Price : <input type="text" class="form-control" name="price" id="price" required>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-default add" name="add"><span class="glyphicon glyphicon-plus"></span> Add Item</button>
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
      </div>
      </form>
    </div>

  </div>
</div>

<div id="editItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Food Item</h4>
      </div>
        <form id ="addItem" action ="{{ URL('cafeteria/updateItem/'.$week.'') }}" method ='POST'>
        {{csrf_field()}}  
        <div class="modal-body">
       Category:  <select class="form-control" required name="ecategory" id="ecategory">
                    <option value="Dessert">Dessert</option>
                    <option value="Snack">Snack</option>
                    <option value="Beverage">Beverage</option>
                    <option value="Viand">Viands/Ulam</option>
                  </select><br>    
        Item Name: <input type="text" class="form-control" name="eitemname" id="eitemname" required><br>
        Price : <input type="text" class="form-control" name="eprice" id="eprice" required>
        <input type="hidden" name="eid" id="eid">

      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-default update" name="update" value="" id="updateItem"><span class="glyphicon glyphicon-check"></span> Update Item</button>
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
      </div>
        </form>
    </div>

  </div>
</div> 
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

<script>
$(document).ready(function()
{

$('#from').datepicker({
   autoclose:true 
});
$('#cancel').on('click', function() {
    window.location = '{{ url("/cafeteria")}}';
});

$('#menuTable').DataTable({
    "lengthChange" : false
});
 $('#itemTable').DataTable({
    "lengthChange" : false
});
 
$('#showModal').click(function()
{
    $('#addItemModal').modal('show');
});
 
$('#chooseItem').click(function(){
    $('#chooseItemModal').modal('show');
}); 

$('#addItemModal').on('click' , '.cancel' , function()
{
   $('#itemname').val('');
   $('#price').val('');
   $('#category').val('Dessert');
});

 $('#itemTable').on('click' , '.delete' , function()
 {
     var id = $(this).closest('.delete').val();
    
    if(confirm('Do you want to delete this item?'))
    {
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                method: "post",
                url: "../deleteItem",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function() {
                  var table = $('#itemTable').DataTable();
                  console.log(id);
                  table
                    .row('#'+id)
                    .remove()
                    .draw();
                  alert("Item successfully deleted.");
                },
                error: function() {
                     
                    alert('Error occured.');
                }
            });
    }
 });
 
 $('#itemTable').on('click', '.edit' , function()
    {   
        var id = $(this).closest('.edit').val();
        console.log(id);
        var table = $('#itemTable').DataTable();
        var row = table.row('#'+id).data();
        console.log(row);
        var name= row[0];
        var category = row[1];
        var price= row[2];
        if(category == "Dessert") {
                $('#ecategory').val("Dessert");
           } 
           else if(category == "Snack") {
               $('#ecategory').val("Snack");
           }  
           else if(category == "Beverages") {
               $('#ecategory').val("Beverage");
           }
           else {
               $('#ecategory').val("Viand");
           }



           $('#eitemname').val(name);

           $('#eprice').val(price);
           $('#eid').val(id);
        $('#editItemModal').modal('show'); 
   });
// $('#itemTable').on('click' , '.edit' , function()
// {
//    var id = $(this).closest('.edit').val();
//    
//    if(confirm('Do you want to edit this item?'))
//    {
//         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//             $.ajax({
//                method: "post",
//                url: "./updateItem",
//                data: {'_token': CSRF_TOKEN,
//                       'id': id
//                       },
//                success: function(json) {
//                    var itemn = json.data.item_name;
//                    var itemc = json.data.cat_id;
//                    var itemp = json.data.price;
//                    var itemi = json.data.id;
//                    if(itemc == 1) {
//                         $('#ecategory').val("Dessert");
//                    } 
//                    else if(itemc == 2) {
//                        $('#ecategory').val("Snack");
//                    }  
//                    else if(itemc == 3) {
//                        $('#ecategory').val("Beverage");
//                    }
//                    else {
//                        $('#ecategory').val("Viand");
//                    }
//                        
//                    
//                    $('#eitemname').val(itemn);
//                    
//                    $('#eprice').val(itemp);
//                    $('#eid').val(itemi);
//                    $('#editItemModal').modal('show');
//                },
//                error: function() {
//                     
//                    alert('Error occured.');
//                }
//            });
//    }
//
// });
 
 $('#itemTable').on('click', '.addmenu', function() {
      var id = $(this).closest('.addmenu').val();
                var table = $('#menuTable').DataTable();
                var iTable = $('#itemTable').DataTable();
                var row = iTable.row('#'+id).data();
                var name= row[0];
                var category = row[1];
                var price= row[2];
                var btn = "<button type='button' value='"+id+"' class='btn btn-danger remove'><span class='glyphicon glyphicon-remove'></span></button>";
                console.log(name);
            
                var newRow = table.row.add([name, category, price, btn]).draw();
                var theNode = $('#menuTable').dataTable().fnSettings().aoData[newRow[0]].nTr;
                theNode.setAttribute('id', id);
                iTable.row('#'+id).remove().draw();
                $('#displayMenu').append('<input type="text" name="itemID[]" value="'+id+'" hidden>');
 });
 
  $('#menuTable').on('click', '.remove', function() {
      var id = $(this).closest('.remove').val();
        console.log(id);
        var table = $('#itemTable').DataTable();
        var iTable = $('#menuTable').DataTable();
        //console.log(iTable.rows().data());
        var row = iTable.row('#'+id).data();
        console.log(iTable.row('#'+id).data());
        var name= row[0];
        var category = row[1];
        var price= row[2];
        var btn = "<center><button type='button' name='edit' class='btn btn-primary edit' id='editModal' value='"+id+"'><span class='glyphicon glyphicon-edit'></span> </button><button type='button' name='delete' class='btn btn-danger delete' value='"+id+"'><span class='glyphicon glyphicon-remove'></span> </button><button type='button' name='addToMenu' class='btn btn-info addmenu' value='"+id+"'><span class='glyphicon glyphicon-plus'></span></button></center>";

        var newRow = table.row.add([name, category, price, btn]).draw();
        var theNode = $('#itemTable').dataTable().fnSettings().aoData[newRow[0]].nTr;
        theNode.setAttribute('id', id);
        iTable.row('#'+id).remove().draw();
 });
 
});
    
</script>
@endsection