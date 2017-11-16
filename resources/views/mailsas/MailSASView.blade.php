@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<!-- Default box -->
<form role="form" method="POST" action="{{ asset('/msas/store') }}">
    <div class="box">
        <div class="box-header with-border">
            <div><h2 class="box-title" style="font-size: 20px;">Create New Cases</h2></div><br>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Note: </b> Please fill all the required fields to create new case.
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
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <tbody>
                    <th colspan="2" style="font-family: Verdana"><center>Add New Case</center></th>
                    <tr>
                        <th style="width: 230px">Logged By : &nbsp;<font style="color:red;">*</font></th>
                        <td><input type="hidden" name="emp_name" value="{{Auth::user()->uid}}">{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th style="width: 230px">Customer ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input class="form-control" type="text" name="custID" style="width: 150px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 230px">Case ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input class="form-control" type="text" name="caseID" style="width: 150px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 230px">Contract ID : &nbsp;<font style="color:red;">*</font></th>
                        <td><input class="form-control" type="text" name="contractID" style="width: 150px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 230px;">Product Cycle : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div class="form-group" style="width: 150px">
                                <select class="form-control" name="product_cycle">
                                    <optgroup label="Select Product Cycle">
                                        <option>Monthly</option>
                                        <option>Weekly</option>
                                    </optgroup>
                                </select>
                             </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 230px">Date of Upsells : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" name="date_upsells" class="form-control pull-right"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="width: 230px">Date of Order : &nbsp;<font style="color:red;">*</font></th>
                        <td>
                            <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                                <input type="text" name="order_date" class="form-control pull-right"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-top: 110px; width: 150px;">Notes : &nbsp;<font style="color:red;">*</th>
                        <td>
                            <textarea id="ckeditor1" name="notes"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            <div class="foot-area" style="float: right;">
                <button class="btn btn-warning" type="reset" name="reset"><i class="fa fa-eraser"></i> Clear All</button>
                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit Now</button>
            </div>
        </div> 
    </div> 
</form>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $breakdown['name'] }}</h3>
    </div>
    <label style="padding-left: 10px; font-size:16px;"><?php echo "Date : " .date("F j, Y"); ?></label>
    <div class="box-body" style="float: right;">
        <table>
            <tr>
                <td>
                    <form method="POST" action="{{ asset('/msas/filter_date') }}" role="form" style="padding-left: 630px; float: right;">
                         
                        <div style="float: right; ">
                            <button class="btn btn-info btn-flat" type="submit"><i class="fa fa-search"></i> Search</button>
                        </div>
                        <div class="input-group date" data-provide="datepicker" style="width: 150px; float: right;">
                              <div class="input-group-addon">
                                To: 
                              </div>
                              <input type="text" name="date_to" class="form-control" style="width: 100px;" placeholder="Pick a date">
                         </div>
                        <div class="input-group date" data-provide="datepicker" style="width: 150px; float: right;">
                              <div class="input-group-addon">
                                From:
                              </div>
                              <input type="text" name="date_from" class="form-control" style="width: 100px;" placeholder="Pick a date">
                         </div>
                        
                        <div style="float: right;">&nbsp;&nbsp;</div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <div class="box-body">
        <form method="POST" action="{{ asset('/msas/sort') }}" role="form">
            <table>
                <tr>
                    <td><input type="submit" name="today" class="btn btn-primary" value="Today"></td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="weekly" class="btn btn-primary" value="Weekly"></td>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="monthly" class="btn btn-primary" value="Monthly"></td>
                    <td>&nbsp;<input type="hidden" name="_token" value="{{ csrf_token() }}"></td>
                    <td><input type="submit" name="all" class="btn btn-primary" value="View All"></td>
                </tr>
            </table>
        <br><br>
        </form>
        <table id="table_breakdown" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        @foreach($breakdown['headers'] as $i => $head)
                        <th style='{{ $breakdown['headerStyle'][$i] }}'><center>{{ $head }}</center></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $cell)
                    <?php $user = \App\Employee::where('uid', $cell->emp_name)->first(); ?>
                    <tr>
                        <td><center>
                            <?php 
                                if($cell->emp_name ==  Auth::user()->uid)
                                    echo '<a href="edit/'.$cell->id.'">'. $user->name .'</a>'; 
                                else { echo $user->name; } 
                             ?>
                        </center></td>
                        <!--<td><center><a href="edit/{{$cell->id}}">{{ $user->name }}</a></center></td>-->
                        <td><center>{{ $cell->custID }}</center></td>
                        <td><center>{{ $cell->caseID }}</center></td>
                        <td><center>{{ $cell->contractID }}</center></td>
                        <td><center>{{ $cell->product_cycle }}</center></td>
                        <td><center>{{ date("F j, Y", strtotime($cell->date_upsells)) }}</center></td>
                        <td><center>{{ date("F j, Y", strtotime($cell->order_date)) }}</center></td>
                        <td><center>{{ $cell->notes }}</center></td>
                        <td><center>{{ date("F j, Y", strtotime($cell->created_at)) }}</center></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
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
            CKEDITOR.replace('ckeditor1');
            CKEDITOR.replace('ckeditor2');
            CKEDITOR.instances.ckeditor1.setData(' ');
            });
</script>
<<!-- DataTables -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
<!-- datepicker -->
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
@endsection