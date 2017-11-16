@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
@endsection

@section('content')

<!-- Default box -->
<form role="form" method="POST" action="store">
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">Create New Retention Case</h2></div><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Please fill all the required fields below to create new retention case
            </div>
        </div>
        <div class="box-body">
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

            <table class="table table-bordered">
                <tbody>
                <th colspan="2" style="font-family: Verdana"><center>Create New Retention Case</center></th>
                
                <tr style="display: none">
                    <th style="width: 150">Logged By: </th>
                    <td><input type="hidden" name="loggedby" class="form-control" value="{{Auth::user()->uid}}">{{Auth::user()->name}}</td>
                </tr>
                <tr>
                    <th style="width: 150">Customer ID: </th>
                    <td><input type="text" name="customer_id" style="width: 250px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150">Contract ID: </th>
                    <td><input type="text" name="contract_id" style="width: 250px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150">Email Address: </th>
                    <td><input type="text" name="email_address" style="width: 250px" class="form-control"></td>
                </tr>
                <tr>
                    <th>Date of Retention Offer Sent: </th>
                    <td>
                        <div class="input-group date" data-provide="datepicker" style="width: 250px; float: left; ">
                            <div class="input-group-addon">
                                <span class="fa fa-calendar"></span>
                            </div>
                            <input type="text" name="date" class="form-control pull-right"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th style="width: 150">Current Price: </th>
                    <td><input type="text" name="current_price" style="width: 250px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150px;">Price Offered: </th>
                    <td><input type="text" name="price_offered" style="width: 250px" class="form-control"></td>
                </tr>
                <tr>
                    <th style="width: 150px;">Status</th>
                    <td><select class="form-control" name="status" style="width: 250px">
                            <option value="Successful">Successful</option>
                            <option value="Unsuccessful">Unsuccessful</option>
                            <option value="Retention Attempt">Retention Attempt</option>
                    </select></td>
                </tr>
                </tbody>
            </table>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="box-footer" >
            <div class="foot-area" style="float: right;">
                <button class="btn btn-primary" type="submit" name="send"><i class="fa fa-floppy-o"></i>&nbsp; Submit Now</button>
            </div>
        </div> 
    </div> 
</form>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $breakdown['name'] }}</h3>
    </div>

    <table>
        <tr>
            <td style="width:678px"></td>
            <td>
                <form action="filter_date" method="POST" role="form">
                    <div class="input-group date" data-provide="datepicker" style="width: 207px; float: left; ">
                        <div class="input-group-addon">
                            From:
                        </div>
                        <input type="text" name="date_from" placeholder="Date From" class="form-control pull-right"/>
                    </div>
                    <div class="input-group date" data-provide="datepicker" style="width: 207px; float: left; ">
                        <div class="input-group-addon">
                            To:
                        </div>
                        <input type="text" name="date_to" placeholder="Date To" class="form-control pull-right"/>
                    </div>
                    <div class="input-group margin">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-flat" type="submit"><i class="fa fa-search"></i> Search</button>
                        </span>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </td>
        </tr>
    </table>

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
                <?php $user = \App\Employee::where('uid', $row->loggedby)->first();?>
                <tr>
                    <td><center><a href="edit/{{$row-> id}}">{{ $row->id }}</center></td>
                    <td><center>{{ $user->name }}</center></td>
                    <td><center>{{ $row->customer_id }}</center></td>
                    <td><center>{{ $row->contract_id }}</center></td>
                    <td><center>{{ date('F j, Y', strtotime($row->date)) }}</center></td>
                    <td><center>{{ date('F j, Y g:i A', strtotime($row->created_at)) }}</center></td>
                    <td><center>
                        <?php
                        if ($row->status == "Successful")
                            echo '<span class="label label-success"> Successful </span>';
                        else if ($row->status == "Retention Attempt")
                            echo '<span class="label label-warning">Retention Attempt</span>';
                        else if ($row->status == "Unsuccessful")
                            echo '<span class="label label-danger">Unsuccessful</span>';
                        ?>
                    </center></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script>
$(function () {
    $('#table_breakdown').DataTable();
});
</script>

@endsection