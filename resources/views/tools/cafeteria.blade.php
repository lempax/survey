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


<div class="box"> 
    <div class="box-header with-border">
    <p align="center" style="font-family: Calibri Light; font-size: 16px;">OUR
        <br>
        <span style="font-family: Calibri Light; font-size: 22px; font-weight: bold;">MENU FOR THE WEEK</span>
    </p>    
    </div>
    
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
            @foreach ($items as $item)
            <tr id="{{$item->id}}">
                <td>{{$item->itemname}}</td>
                <td>{{$item->category}}</td>
                <td>{{$item->price}}</td>            
                <td>
                @if ($departmentid != 21205570)
                @else
                    <center>
                    <button type="button" name="delete" class="btn btn-danger delete" value="{{$item->id}}"><span class=" glyphicon glyphicon-remove"></span> Remove</button>
                    <button type="button" name="edit" class="btn btn-primary edit" id="editModal" value="{{$item->id}}"><span class=" glyphicon glyphicon-edit"></span> Edit</button>
                    </center>
                @endif
                </td>
            </tr>
            @endforeach
        </table>
        <button type="button" name="add" class="btn btn-primary-default" id="showModal"><span class="glyphicon glyphicon-pencil"></span> Create Item</button>
    </div>
 
<!-- Create Modal -->
<div id="addItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Food Item</h4>
      </div>
      <div class="modal-body">
        <form id ="addItem" action =" {{url('cafeteria/addItem')}}" method ='POST'>
            {{csrf_field()}}  
        Item Name: <input type="text" class="form-control" name="itemname" id="itemname"><br>
        Category: <input type="text" class="form-control" name="category" id="category"><br>
        Price : <input type="text" class="form-control" name="price" id="price">
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-default" name="add"><span class="glyphicon glyphicon-plus"></span> Add Item</button>
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
        <form id ="addItem" action =" {{url('cafeteria/updateItem')}}" method ='POST'>
        {{csrf_field()}}  
        <div class="modal-body">
        Item Name: <input type="text" class="form-control" name="eitemname" id="eitemname"><br>
        Category: <input type="text" class="form-control" name="ecategory" id="ecategory"><br>
        Price : <input type="text" class="form-control" name="eprice" id="eprice">
        <input type="hidden" name="eid" id="eid">
        <input type="" name="eagent" id="eagent">
        <input type="" name="edid" id="edid">

      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-default update" name="update" value="" id="updateItem"><span class="glyphicon glyphicon-check"></span> Update Item</button>
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
      </div>
        </form>
    </div>

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
 $('#menuTable').DataTable({
     'lengthChange' : false
 }); 
 
 $('#showModal').click(function()
 {
     $('#addItemModal').modal('show');
 });
 
 $('#addItemModal').on('click' , '.cancel' , function()
 {
    $('#itemname').val('');
    $('#category').val('');
    $('#price').val('');
 });
 $('#menuTable').on('click' , '.delete' , function()
 {
     var id = $(this).closest('.delete').val();
    
    if(confirm('Do you want to delete this item?'))
    {
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                method: "post",
                url: "cafeteria/deleteItem",
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function() {
                  var table = $('#menuTable').DataTable();
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
 
 $('#menuTable').on('click' , '.edit' , function()
 {
    var id = $(this).closest('.edit').val();
    
    if(confirm('Do you want to edit this item?'))
    {
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                method: "post",
                url: "cafeteria/"+id,
                data: {'_token': CSRF_TOKEN,
                       'id': id
                       },
                success: function(json) {
                    var itemn = json.data.itemname;
                    var itemc = json.data.category;
                    var itemp = json.data.price;
                    var itemi = json.data.id;
                    var itemcr = json.data.creator;
                    var itemdep = json.data.departmentid;
                    
                    $('#eitemname').val(itemn);
                    $('#ecategory').val(itemc);
                    $('#eprice').val(itemp);
                    $('#eid').val(itemi);
                    $('#eagent').val(itemcr);
                    $('#edid').val(itemdep);
                    
                    $('#editItemModal').modal('show');
                },
                error: function() {
                     
                    alert('Error occured.');
                }
            });
    }

 });
 
 
 
});
    
</script>
@endsection