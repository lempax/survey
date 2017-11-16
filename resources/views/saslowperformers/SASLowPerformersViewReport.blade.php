@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">

@endsection

@section('content')
<div class="col-md-6" style="width: 100%;">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Create New Case</a></li>
            <li><a href="#tab_2" data-toggle="tab">View All Reports</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box-body table-responsive">
                    <form name="myform" role="form" method="POST" action="storecase">
                       <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <b>Note: </b> All fields are required. Don't leave anything empty.
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
                                    <th colspan="2" style="font-family: Verdana"><center>Create New Case</center></th>
                                    <tr>
                                        <th style="width: 150px">Date: </th>
                                        <td><?php echo $date = date("F j, Y, g:i a"); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="width: 150px">Team: </th>
                                        <td> <input type="hidden" name="team_name" value="{{  Auth::user()->department->departmentid }}"/>{{  Auth::user()->department->name }}</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 150px;">Agent Name: </th>
                                        <td>
                                            <div class="form-group" style="width: 220px">
                                                <select class="form-control" name="agent_name">
                                                    <optgroup label="{{  Auth::user()->department->name }}">
                                                       <?php $subordinates = Auth::user()->subordinates() ?>
                                                       @foreach ($subordinates AS $subordinate)
                                                        <option value="{{ $subordinate->uid }}">{{ $subordinate->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                             </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 160px">Total Calls of the Week: </th>
                                        <td><input class="form-control" type="text" name="total_calls" style="width: 150px;"></input></td>
                                    </tr>
                                    <tr>
                                        <th style="padding-top: 70px; width: 150px;">Reason for <br>Zero Sales: </th>
                                        <td>
                                            <textarea id="ckeditor1" name="reasons"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="padding-top: 70px; width: 150px">Supervisor <br>Action Plan: </th>
                                        <td>
                                            <textarea id="ckeditor2" name="sup_actionplan"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        <div class="box-footer" >
                            <div class="foot-area" style="float: right;">
                                <button class="btn btn-warning" type="reset" name="reset"><i class="fa fa-eraser"></i> Clear All</button>
                                <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-save"></i> Submit Now</button>
                            </div>
                        </div> 
                         </form>
                    </div>
               </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="box-header">
                            <h3 class="box-title">{{ $breakdown['name'] }}</h3>
                            <label style="float: right; font-size:16px; padding-right: 10px;"><?php echo "Date : " .date("F j, Y"); ?></label>
                    </div>      
                    <div class="box-body">
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
                                <?php 
                                    $name = DB::table('employees')->where('uid', $cell->agent_name)->first();
                                    $team = DB::table('departments')->where('departmentid', $cell->team_name)->first();
                                ?>
                                
                                <tr>
                                    <td><center><a href="edit/{{$cell->id}}">{{ $cell->id }}</a></center></td>
                                    <td><center>{{ date("F j, Y  h:i A", strtotime($cell->created_at)) }}</center></td>
                                    <td><center><?php echo $team->name?></center></td>
                                    <td><center><?php echo $name->fname.' '.$name->lname ?></center></td>
                                    <td><center>{{ $cell->total_calls }}</center></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
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
            CKEDITOR.instances.ckeditor2.setData(' ');
        });
</script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

@endsection