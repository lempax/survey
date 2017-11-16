@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')
<div class="box">
    <div class="box-header">
        <h1 class="box-title">{{ $breakdown['name'] }}</h1></br></br>
        <div class="alert alert-info alert-dismissable"> 
            <b>Note:</b> Displays agents weekly points. </b>
        </div>
        
    </div>
       <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-8">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                @if(in_array(Auth::user()->roles, ['MANAGER','SOM']))
                                <div class="form-group">
                                    <select class="form-control" aria-controls="teams" id="team_selection" name="team_selection">
                                        <option value="all">All Teams</option>
                                        @foreach($name_selection as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <select class="form-control" aria-controls="weeks" id="week_selection" name="week_selection">
                                        @for ($i = 1; $i <= date('W') - 0; $i++)
                                        <option value="{{ $i }}" {{ $i == date('W') ? 'selected' : '' }}>Week {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                                    <i class="fa fa-calendar"></i>
                                </button>
                                <span id="date_range_info" class="text-info" style="font-size: 120%"></span>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <div id="textHeader" class="text-right" style="font-size: 150%"></div>
                        </div>
                    </div>
                </div>
    <div class="box-body">
<!--        <b>[ Date: <font color="blue">{{date("F j, Y")}} </font>]</b>
        <br><br>-->
        <form method="GET" action="{{ asset('pointsystem/home') }}" role="form">
         <table id="table_breakdown" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    @foreach($breakdown['headers'] as $i => $head)
                    <th style="{{ $breakdown['headerStyle'][$i] }}">{{ $head }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
       
                    
            
               <?php foreach ($rows as $row):?>
                    <tr>
                         <?php $personid =  $row->uid;?>
                        <td><a href="edit/{{$personid}}">{{ $row->fname. "  ". $row->lname }}</a></td>
<!--                    <td>{{ $row->kudos }}</td>
                        <td>{{ $row->crr }}</td>
                        <td>{{ $row->nps }}</td>
                        <td>{{ $row->aht }}</td>
                        <td>{{ $row->sas }}</td>
                        <td>{{ $row->agentposfb }}</td>
                        <td>{{ $row->nolate }}</td>
                        <td>{{ $row->noabsent }}</td>
                        <td>{{ $row->ootd }}</td>
                        <td>{{ $row->trivia }}</td>
                        <td>{{ $row->totalpoints }}</td>
-->
                    <tr>

             <?php endforeach;?>
            </tbody>
        </table>
      </form>
    </div>
</div>

@endsection

@section('additional_scripts')
<!--<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>
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
        CKEDITOR.replace('notes');
    });
    
</script>-->
@endsection


