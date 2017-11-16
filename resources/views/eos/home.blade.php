@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
<link href="{{ asset("tag-it/css/jquery.tagit.css") }}"  rel="stylesheet" type="text/css">
<link href="{{ asset("tag-it/css/tagit.ui-zendesk.css") }}" rel="stylesheet" type="text/css">
<style>
    table tbody tr td:first-child {
        text-align: left;
    }
    td.highlight {
        background-color: whitesmoke !important;
    }

    table.dataTable.display tbody tr.odd > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd > .sorting_1 {
        background-color: #f1f1f1;
    }
    table.dataTable.display tbody tr.odd > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd > .sorting_2 {
        background-color: #f3f3f3;
    }
    table.dataTable.display tbody tr.odd > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd > .sorting_3 {
        background-color: whitesmoke;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_1 {
        background-color: #a6b3cd;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_2 {
        background-color: #a7b5ce;
    }
    table.dataTable.display tbody tr.odd.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.odd.selected > .sorting_3 {
        background-color: #a9b6d0;
    }

    table.dataTable.display tbody tr.even > .sorting_2, table.dataTable.order-column.stripe tbody tr.even > .sorting_2 {
        background-color: #fbfbfb;
    }
    table.dataTable.display tbody tr.even > .sorting_3, table.dataTable.order-column.stripe tbody tr.even > .sorting_3 {
        background-color: #fdfdfd;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_1, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_1 {
        background-color: #acbad4;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_2, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_2 {
        background-color: #adbbd6;
    }
    table.dataTable.display tbody tr.even.selected > .sorting_3, table.dataTable.order-column.stripe tbody tr.even.selected > .sorting_3 {
        background-color: #afbdd8;
    }
    table.dataTable.display tbody tr:hover > .sorting_1, table.dataTable.order-column.hover tbody tr:hover > .sorting_1 {
        background-color: #eaeaea;
    }
    table.dataTable.display tbody tr:hover > .sorting_2, table.dataTable.order-column.hover tbody tr:hover > .sorting_2 {
        background-color: #ebebeb;
    }
    table.dataTable.display tbody tr:hover > .sorting_3, table.dataTable.order-column.hover tbody tr:hover > .sorting_3 {
        background-color: #eeeeee;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_1, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_1 {
        background-color: #a1aec7;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_2, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_2 {
        background-color: #a2afc8;
    }
    table.dataTable.display tbody tr:hover.selected > .sorting_3, table.dataTable.order-column.hover tbody tr:hover.selected > .sorting_3 {
        background-color: #a4b2cb;
    }
    .inactiveLink {
        pointer-events: none;
        cursor: default;
    }
</style>
@endsection

@section('content')
<?php $total_tickets = 0; ?>
@foreach ($eosreports as $eosreport)
<?php
$tickets = count(json_decode($eosreport->tickets));
$total_tickets += $tickets
?>
@endforeach
<div class="row">
    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3> {{ $hardware }} </h3>
                <p>HARDWARE</p>
            </div>
            <div class="icon">
                <i class="fa fa-wrench"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->

    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3> {{ $software }} </h3>
                <p>SOFTWARE</p>
            </div>
            <div class="icon">
                <i class="fa fa-windows"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3> {{ $ups }} </h3>
                <p>UPS</p>
            </div>
            <div class="icon">
                <i class="fa fa-battery-half"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- ./col -->
    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $cosmocom }}</h3>
                <p>COSMOCOM</p>
            </div>
            <div class="icon">
                <i class="fa fa-headphones"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $network }}</h3>
                <p>NETWORK</p>
            </div>
            <div class="icon">
                <i class="fa fa-wifi"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-fuchsia">
            <div class="inner">
                <h3>{{ $virus }}</h3>
                <p>ANTI-VIRUS</p>
            </div>
            <div class="icon">
                <i class="fa fa-bug"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-2 col-xs-6" style="width: 14.2%;">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $mis }}</h3>
                <p>MIS/MIS-EWS</p>
            </div>
            <div class="icon">
                <i class="fa fa-laptop"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<p class="error text-center alert alert-danger hidden"></p>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="vertical-align: middle;">Recent End of Shift Reports - <?php if($unsent > 0){ ?><span class="btn-danger">You have unsent Reports ({{ $unsent }})</span> <?php } ?></h3>
        <span style="float:right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Create EOS</button></span>
    </div>
    <div class="box-body">
        <table id="table" class="table table-hover table-bordered row-border order-column table-striped">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Title</th>
                    <th>Submitted By</th>
                    <th>Shift</th>
                    <th>Tickets Closed</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($eosreports as $eosreport)
                <tr>
                    <td> {{ date("F j, Y, g:i a", strtotime($eosreport->created_at)) }} </td>
                    <td><a href="#" data-toggle="modal" data-id="{{ $eosreport->id }}">Cebu-IT End of Shift Report</a></td>
                    <td> {{ \App\Employee::where('uid', $eosreport->logged_by)->first()->name }} </td>
                    <td> {{ $eosreport->shift }} </td>
                    <td>{{ count(json_decode($eosreport->tickets)) }} <span style="display: none;"> {{ $eosreport->tickets.' '.$eosreport->summary }} </span> </td>
                    <td> 
                        @if($eosreport->status === 'saved')
                        <small class="label label-warning"> 
                            @elseif($eosreport->status === 'sent')
                            <small class="label label-success">
                                @endif        
                                {{ strtoupper($eosreport->status) }} 
                            </small> 
                    </td>
                    <td>
                        <a href="eos/send/{{ $eosreport->id }}" class="btn btn-warning btn-xs <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'inactiveLink ' : '' ?>" <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'disabled' : '' ?>><span class="glyphicon glyphicon-envelope"></span></a>
                        <a href="eos/edit/{{ $eosreport->id }}" class="btn btn-primary btn-xs <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'inactiveLink ' : '' ?>" <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'disabled ' : '' ?>><span class="glyphicon glyphicon-edit"></span></a>
                        <a href="eos/delete/{{ $eosreport->id }}" class="btn btn-danger btn-xs <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'inactiveLink ' : '' ?>" <?= $eosreport->status != 'saved' || $session_user != $eosreport->logged_by ? 'disabled ' : '' ?>><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<form method="POST" action="eos/save" id="boolean">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 4px;  width: 800px; right: 24%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title text-bold" id="myModalLabel" style="color: #1778c3">New End of Shift Report</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-6">
                        <label>Submitted By <i class="fa fa-fw fa-question-circle"></i></label>
                        <input name="submitted_by" id="batch" type="text" value="{{ Auth::user()->name }}" class="form-control" style="border-radius: 4px;" required readonly>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Shift Schedule<i class="fa fa-fw fa-question-circle"></i></label>
                        <select type="text" name="shift" class="form-control" style="border-radius: 4px;" required>
                            <option value="">Select Schedule</option>
                            <option value="0100-1000">0100-1000</option>
                            <option value="0200-1100">0200-1100</option>
                            <option value="0300-1200">0300-1200</option>
                            <option value="0500-1400">0500-1400</option>
                            <option value="0600-1500">0600-1500</option>
                            <option value="0700-1600">0700-1600</option>
                            <option value="0800-1700">0800-1700</option>
                            <option value="0900-1800">0900-1800</option>
                            <option value="1000-1900">1000-1900</option>
                            <option value="1100-2000">1100-2000</option>
                            <option value="1200-2100">1200-2100</option>
                            <option value="1300-2200">1300-2200</option>
                            <option value="1330-2230">1330-2230</option>
                            <option value="1400-2300">1400-2300</option>
                            <option value="1500-2400">1500-2400</option>
                            <option value="1600-0100">1600-0100</option>
                            <option value="1700-0200">1700-0200</option>
                            <option value="1800-0300">1800-0300</option>
                            <option value="1900-0400">1900-0400</option>
                            <option value="2000-0500">2000-0500</option>
                            <option value="2100-0600">2100-0600</option>
                            <option value="2200-0700">2200-0700</option>
                            <option value="2230-0730">2230-0730</option>
                            <option value="2300-0800">2300-0800</option>
                            <option value="2400-0900">2400-0900</option>
                        </select>
                    </div>
                    
                    <!-- Tickets queue -->

                    <div class="form-group col-md-12" style="margin-bottom: 2px;">
                        <label>TICKETS QUEUE <i class="fa fa-fw fa-question-circle"></i></label><br>
                        <label>No. of Tickets when Shift Started:<i class="fa fa-fw"></i></label>
                        <input type="number" min="0" step="1" name="tickets_in" id="tckets_in" class="text_field" style="cursor:pointer; width: 60px; border-radius: 4px; border-color: #ccc; border-style: solid; border-width: 1px;" required>
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No. of Tickets when Shift Ended:<i class="fa fa-fw"></i></label>
                        <input type="number" min="0" step="1" name="tickets_out" id="tickets_out" class="text_field" style="cursor:pointer; width: 60px; border-radius: 4px; border-color:  #ccc; border-style: solid; border-width: 1px; " required>
                        
                    </div>
                    
                    <!-- end Tickets queue -->
                    
                    <div class="form-group col-md-12" style="margin-bottom: 2px;">
                        <br>
                        <label>Tickets Processed <i class="fa fa-fw fa-question-circle"></i></label><br>
                        <span class="ticket-list" style="display: block;"></span>
                        <button type="button" class="btn btn-default add-ticket" style="cursor:pointer; width: 100px;"><i class="fa fa-plus"></i> Add Ticket</button>
                        <button type="button" class="btn btn-default clear-option" style="cursor:pointer;display: none;"><i class="fa fa-fw fa-trash"></i> Clear Options</button>

                    </div>
                    
                    <!--summary change to issues columns-->
                    <div class="form-group col-md-12" style="margin-top: 12px;">
                        <label>Issues that have impact to our customers (internal/external)<i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="summary" id="" class="form-control" placeholder="Issues of your end of shift report / type 'None' if there isn't" style="border-radius: 4px;" required></textarea>
                    </div>
                    <!--summary change to issues columns-->
                    
                    <!--additional columns-->
                    <div class="form-group col-md-12" style="margin-top: 12px;">
                        <label>(+) or (-) Financial impact coming from your department<i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="fin_impact" id="" class="form-control" placeholder="This field should be fill-out / type 'None' if there isn't" style="border-radius: 4px;" required></textarea>
                    </div>
                    
                    <div class="form-group col-md-12" style="margin-top: 12px;">
                        <label>People/Process/Tool challenges that have inter-department concerns<i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="challenges" id="" class="form-control" placeholder="This field should be fill-out / type 'None' if there isn't" style="border-radius: 4px;" required></textarea>
                    </div>
                    
                    <div class="form-group col-md-12" style="margin-top: 12px;">
                        <label>Shift Highlights<i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="shift_highlight" id="" class="form-control" placeholder="This field should be fill-out/ type 'None' if there isn't" style="border-radius: 4px;" required></textarea>
                    </div>
                    
                    <div class="form-group col-md-12" style="margin-top: 12px;">
                        <label>Shift Lowlights<i class="fa fa-fw fa-question-circle"></i></label>
                        <textarea name="shift_lowlight" id="" class="form-control" placeholder="This field should be fill-out / type 'None' if there isn't" style="border-radius: 4px;" required></textarea>
                    </div>

                   <!--end additional columns-->

                    <div class="form-group col-md-12" style="margin-bottom: 2px;">
                        <label>CC email recipients <i class="fa fa-fw fa-question-circle"></i></label>
                        <input type="text" name="email_cc" id="mySingleField" style="display: none;">
                        <ul id="singleFieldTags" style="border-radius: 4px; border-color: #d2d6de;"></ul>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">Close</button>
                    <button type="reset" name="reset" class="btn btn-warning"> Clear All</button>
                    <input type="submit" name="submit" class="btn btn-primary" values="Submit" id="submit_eos">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset("tag-it/js/tag-it.js") }}" type="text/javascript" charset="utf-8"></script>

<!--<script src="{{ asset("materialize_js/main.js") }}"></script>-->

<script>
    
$(function () {
    $('#table').DataTable();
    $('#editor').wysihtml5({
        toolbar: {
            "font-styles": true, // Font styling, e.g. h1, h2, etc.
            "emphasis": true, // Italics, bold, etc.
            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, // Button which allows you to edit the generated HTML.
            "link": true, // Button to insert a link.
            "image": false, // Button to insert an image.
            "color": false, // Button to change color of font
            "blockquote": false, // Blockquote
        }
    });
});

var material = '<div class="input-field input-group col-md-12" style="margin-bottom: 5px;">' +
        '<div class="input-group-btn"><select type="text" name="category[]" class="btn btn-default" required><option value="">Select Category</option>' +
        '<option value="virus">Anti-Virus</option><option value="hardware">Hardware</option><option value="software">Software</option><option value="ups">UPS</option><option value="cosmocom">Cosmocom</option><option value="employee packages">Employee Packages</option>' +
        '<option value="network">Network</option><option value="mis">MIS/MIS-EWS</option></select></div>' +
        '<input type="text" name="ticket_desc[]" id="option_name[]" placeholder="Input Ticket Number" class="form-control" required/>' +
        '<span class="delete-option input-group-addon bg-red" style="border-bottom-right-radius: 4px; border-top-right-radius: 4px; border: 1px solid red;"><i class="fa fa-fw fa-remove"></i></span>' +
        '</div>';

$(document).on('click', '.add-ticket', function () {
    $(".ticket-list").append(material);
    $(".clear-option").show();
});

$(document).on('click', '.clear-option', function () {
    $(".input-field").remove();
    $(".clear-option").hide();
});

$(document).on('click', '.delete-option', function () {
    $(this).parent(".input-field").remove();
    if($('.input-field').children(':visible').length == 0) {
        $(".clear-option").hide();
    }
});

</script>
<script>
    $(function () {
        var sampleTags = [<?= $_emails ?>];
        //-------------------------------
        // Minimal
        //-------------------------------
        $('#myTags').tagit();

        //-------------------------------
        // Single field
        //-------------------------------
        $('#singleFieldTags').tagit({
            availableTags: sampleTags,
            // This will make Tag-it submit a single form value, as a comma-delimited field.
            singleField: true,
            singleFieldNode: $('#mySingleField')
        });

        // singleFieldTags2 is an INPUT element, rather than a UL as in the other 
        // examples, so it automatically defaults to singleField.
        $('#singleFieldTags2').tagit({
            availableTags: sampleTags
        });

        //-------------------------------
        // Preloading data in markup
        //-------------------------------
        $('#myULTags').tagit({
            availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
            // configure the name of the input field (will be submitted with form), default: item[tags]
            itemName: 'item',
            fieldName: 'tags'
        });

        //-------------------------------
        // Tag events
        //-------------------------------
        var eventTags = $('#eventTags');

        var addEvent = function (text) {
            $('#events_container').append(text + '<br>');
        };

        eventTags.tagit({
            availableTags: sampleTags,
            beforeTagAdded: function (evt, ui) {
                if (!ui.duringInitialization) {
                    addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                }
            },
            afterTagAdded: function (evt, ui) {
                if (!ui.duringInitialization) {
                    addEvent('afterTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
                }
            },
            beforeTagRemoved: function (evt, ui) {
                addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            afterTagRemoved: function (evt, ui) {
                addEvent('afterTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            onTagClicked: function (evt, ui) {
                addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
            },
            onTagExists: function (evt, ui) {
                addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
            }
        });

        //-------------------------------
        // Read-only
        //-------------------------------
        $('#readOnlyTags').tagit({
            readOnly: true
        });

        //-------------------------------
        // Tag-it methods
        //-------------------------------
        $('#methodTags').tagit({
            availableTags: sampleTags
        });

        //-------------------------------
        // Allow spaces without quotes.
        //-------------------------------
        $('#allowSpacesTags').tagit({
            availableTags: sampleTags,
            allowSpaces: true
        });

        //-------------------------------
        // Remove confirmation
        //-------------------------------
        $('#removeConfirmationTags').tagit({
            availableTags: sampleTags,
            removeConfirmation: true
        });

    });
</script>
@endsection