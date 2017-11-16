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
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }}">
@endsection
@section ('content')
<div id="primary" class="box box-primary">
    <div class="box-header">
        <center><h1 class="box-title">Menu for the Week</h1></center>
    </div>  
    <div class="row">
        <div class="container-fluid">
            <div class="form-group col-md-2">
                <select class="form-control" aria-controls="weeks" id="week_selection" name="week_selection">
                    @for ($i = 1; $i <= date('W') - 0; $i++)
                    <option value="{{ $i }}" {{ $i == $week ? 'selected' : '' }}>Week {{ $i }}</option>
                    @endfor
                </select>
            </div> 
        </div>
    </div>


    <div class="row">
        <div class="container-fluid">
            <div class="col-md-6">
                <center><h3>Viand/Ulam</h3></center>

                <table class="table table-striped">
                    <tr>
                        <th class="col-md-6">Product</th>
                        <th class="text-center">Price</th>
                    </tr>
                    @foreach($viandItems as $viandItem)
                    <tr>
                        <td class="col-md-6">{{$viandItem->item_name}}</td>
                        <td class="text-center">{{$viandItem->price}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-md-6">
                <center><h3>Snacks</h3></center>
                <table class="table table-striped">
                    <tr>
                        <th class="col-md-6">Product</th>
                        <th class="text-center">Price</th>
                    </tr>
                    @foreach($snackItems as $snackItem)
                    <tr>
                        <td class="col-md-6">{{$snackItem->item_name}}</td>
                        <td class="text-center">{{$snackItem->price}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="container-fluid">
            <div class="col-md-6">
                <center><h3>Dessert</h3></center>
                <table class="table table-striped">
                    <tr>
                        <th class="col-md-6">Product</th>
                        <th class="text-center">Price</th>
                    </tr>
                    @foreach($dessertItems as $dessertItem)
                    <tr>
                        <td class="col-md-6">{{$dessertItem->item_name}}</td>
                        <td class="text-center">{{$dessertItem->price}}</td>
                    </tr>
                    @endforeach
                </table>
            </div> 


            <div class="col-md-6">
                <center><h3>Beverages</h3></center>
                <table class="table table-striped">
                    <tr>
                        <th class="col-md-6">Product</th>
                        <th class="text-center">Price</th>
                    </tr>
                    @foreach($beverageItems as $beverageItem)
                    <tr>
                        <td class="col-md-6">{{$beverageItem->item_name}}</td>
                        <td class="text-center">{{$beverageItem->price}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    @foreach($department as $dep)
    @if($dep->name == 'Facilities & Admin Cebu' || $dep->departmentid == 21224108)
    <div class="box box-footer">
        <input type="text" name="agent" value="{{$agent}}" hidden>
        @if($menuForTheWeek == NULL)
        <button class="btn btn-primary" type="submit" id="modify">Add Menu</button>
        @else
        @if($items == 0)
        <button class="btn btn-primary" type="submit" id="edit">Create Menu</button>
        @else
        <button class="btn btn-primary" type="submit" id="edit">Edit Menu</button>
        @endif
        @endif
    </div>
    @endif
    @endforeach

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
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") }}"></script>

<script>

$(function () {
    $('#modify').click(function ()
    {
        window.location.href = '../createmenu/' + $('#week_selection').val();
    });
    $('#edit').click(function ()
    {
        window.location.href = './editmenu/' + $('#week_selection').val();
    });

    $('#week_selection').on('change', function () {
        document.location.href = './' + $('#week_selection').val();
    });



});

</script>

@endsection