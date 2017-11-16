@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">

@endsection

@section('content')
<form method="GET" action="{{ asset('/itemissuance/view') }}" role="form">
    <input type="hidden" name="_method" value="PUT">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">View Item Issuance</h3>
        </div>
        <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Form cannot be edited.
        </div>
        <div class="box-body">
            <div>
                <a href="javascript:window.close()"><i class="fa fa-arrow-circle-left"></i><font color="grey" size="3">&nbsp;&nbsp;<u>Previous Page</u></font></a><br>
            </div>
            <br>
            <div style="float:left; width: 575px">
                <table class="table table-bordered">
                    <?php 
                        $issuer = \App\Employee::where('uid', $rows->issued_by)->first(); 
                        $to = \App\Employee::where('uid', $rows->issued_to)->first();
                    ?>
                    <input type="hidden" name="issued_by" value="<?php echo $rows->issued_by; ?>"/>
                    <tbody>
                        <th colspan="2" style="font-family: Verdana"><center>View Issuance</center></th>
                        <tr>
                            <th style="width: 100px">Issuance No.: </th>
                            <td><?php echo $rows->issued_id; ?></td>
                        </tr>
                        <tr>
                            <th style="width: 100px">Date: </th>
                            <td><?php echo $date = date("F j, Y"); ?></td>
                        </tr>
                            <th style="width: 100px">Department: </th>
                            <td>
                                <?php echo $rows->department; ?>
                            </td>
                        <tr>
                            <th style="width: 100px;">Issued To: </th>
                            <td>
                                <div class="form-group" style="width: 220px">
                                    <?php echo $to->fname.' '.$to->lname ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="width: 100px;">Purpose: </th>
                            <td>
                                <div class="form-group" style="width: 300px">
                                    <?php echo $rows->purpose; ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <fieldset>
                    <legend style="font-size:16px;">Attach MRIS Form</legend>
                    <?php echo $rows->attached_mris; ?>
                </fieldset>
                <fieldset>
                    <legend style="font-size:16px;">Attach IRIS Form</legend>
                    <?php echo $rows->attached_iris; ?>
                </fieldset>   
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div style=" float: right; width: 580px">
                <div class="box-body">
                    <table class="table table-bordered" style="width: 900px;">
                        <thead>
                        <th colspan="4" style="font-family: Verdana"><center>Items Selected</center></th>
                            <tr>
                                @foreach($breakdown['headers'] as $i => $head)
                                <th style="{{ $breakdown['headerStyle'][$i] }}"><center>{{ $head }}</center></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                                
                                $issue = DB::table('issueditem')->where('issued_id', $rows->issued_id)->get();
                            foreach($issue AS $row) {
                                $item = DB::table('items')->where('id', $row->item_id)->first();
                                $total_qty = DB::table('issueditem')->where('issued_id', $row->issued_id)->sum('quantity'); 
                            ?>

                            <tr>
                                <td><center>{{ $row->quantity }}</center></td>
                                <td><center>{{ $item->name }}</center></td>
                                <td><center>{{ $row->serial }}</center></td>
                                <td><center>{{ $item->price }}</center></td>
                            </tr>  
                            <?php } ?>
                            <th><center>Total Items: {{ $total_qty }}</center></th>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>          
</form>
@endsection
