@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/iCheck/all.css") }}">
<link rel="stylesheet" type="text/css" href="{{ asset ("/bower_components/bootstrap-sweetalert/dist/sweetalert.css") }}">
<style>
.animated {
    -webkit-transition: height 0.2s;
    -moz-transition: height 0.2s;
    transition: height 0.2s;
}

.stars
{
    margin: 20px 0;
    font-size: 24px;
    color: #ffbb00;
}
</style>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        <a href='{{ URL::to('survey/home') }}' class="btn bg-info margin-bottom"><i class="fa fa-arrow-circle-left"></i> &nbsp;Back to Surveys</a>
        @if($question->id)
        <a href='{{URL::to('survey/'.$survey->id)}}' class="btn bg-info margin-bottom" style="float: right;"><i class="fa fa-plus"></i> New Question</a>
        @endif
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <span class="box-title" style="font-size: 16px; display: block">
                    <div class="box-title pull-right">
                        <a href='{{ URL::to('survey/view/'.$survey->id) }}' title="Take Survey"><i class="fa fa-fw fa-send"></i></a>
                        <a href="{{ URL::to('survey/'.$survey->id.'/edit') }}" title="Edit Survey"><i class="fa fa-pencil"></i></a>
                        <a href="{{ URL::to('survey/scores/'.$survey->id) }}" title="View Scores of Answers"><i class="fa fa-fw fa-book"></i></a>
                        <a href="{{ URL::to('survey/answers/'.$survey->id) }}" title="View Answers of Survey"><i class="fa fa-folder-open"></i></a>
                    </div>
                    {{ ucwords($survey->title) }} - 
                    @if($question->id)
                        Update Question
                    @else
                        Add Question
                    @endif 
                </span>

            </div>
            <div class="box-body">
                @if($question->id)
                    <form method="POST" action="{{ URL('question/'.$question->id.'') }}/update" id="boolean">
                @else
                    <form method="POST" action="{{ $survey->id }}/questions" id="boolean">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="text-div margin-bottom">
                        <label> Type <i class="fa fa-fw fa-question-circle"></i></label>
                        <select class="form-control" name="question_type" id="question_type" style="border-radius: 4px;">
                            @if(empty($question->id))
                                <option value="" disabled selected>Choose your option</option>
                            @endif
                            <option value="text" <?= $question->question_type == 'text' ? 'selected' : '' ?>>Text</option>
                            <option value="textarea" <?= $question->question_type == 'textarea' ? 'selected' : '' ?>>Textarea</option>
                            <option value="checkbox" <?= $question->question_type == 'checkbox' ? 'selected' : '' ?>>Checkbox</option>
                            <option value="radio" <?= $question->question_type == 'radio' ? 'selected' : '' ?>>Radio Buttons</option>
                            <option value="rating" <?= $question->question_type == 'rating' ? 'selected' : '' ?>>Rating</option>
                        </select>
                    </div>
                    <div class="text-div" style="margin-bottom: 5px;">
                        <label for="title">Question <i class="fa fa-fw fa-question-circle"></i></label>
                        <input name="title" id="title" type="text" value="<?= $question->id ? $question->title : '' ?>" placeholder="Type question here" class="form-control" style="border-radius: 4px;">
                    </div>

                    <div class="text-div">
                        @if($question->id && $question->question_type == 'radio')
                            @foreach($question->option_name as $key=>$value)
                            <div class="radio-data">
                                <div class="input-field input-group col-md-12" style="margin-bottom: 5px;">
                                    <div class="input-group-btn"><button type="button" class="btn btn-default">Option</button></div>
                                    <input type="text" name="option_name[]" value="{{ $value }}" id="option_name[]" class="form-control" />
                                    <span class="delete-option input-group-addon bg-red" style="border-bottom-right-radius: 4px; border-top-right-radius: 4px; border: 1px solid red;"><i class="fa fa-fw fa-remove"></i></span>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        @if($question->id && $question->question_type == 'checkbox')
                            @foreach($question->option_name as $key=>$value)
                            <div class="checkbox-data">
                                <div class="input-field input-group col-md-12" style="margin-bottom: 5px;">
                                    <div class="input-group-btn"><button type="button" class="btn btn-default">Option</button></div>
                                    <input type="text" name="option_name[]" value="{{ $value }}" id="option_name[]" class="form-control" />
                                    <span class="delete-option input-group-addon bg-red" style="border-bottom-right-radius: 4px; border-top-right-radius: 4px; border: 1px solid red;"><i class="fa fa-fw fa-remove"></i></span>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <span class="radio-reminder label-warning" style="display: none;">Note: If you want an option with an included textarea, please type in the option "<i>type-text:YourOption</i>". example: type-text:Training: List the top 5 Training topics you need</span>
                        <span class="form-g" style="display: block;"></span>
                    </div>

                    <div class="stars starrr" data-rating="0" style="display: none;"><input id="ratings-hidden" name="rating" type="hidden"></div>
                    <div class="text-div" style="margin-top: 15px;">
                        <button type="button" class="btn btn-default add-option" style="cursor:pointer; <?php echo in_array($question->question_type, array('radio', 'checkbox')) ? '' : ' display: none' ?>;"><i class="fa fa-plus"></i> New Option</button> &nbsp;
                        <button type="button" class="btn btn-default clear-option" style="cursor:pointer; <?= in_array($question->question_type, array('radio', 'checkbox')) ? '' : ' display: none' ?>;"><i class="fa fa-fw fa-trash"></i> Clear Options</button>
                        <a href="{{ URL::to('/survey/'.$survey->id.'/delete') }}" style="float:right;" class="btn btn-danger delete-survey"><i class="fa fa-trash-o"></i> &nbsp;Delete Survey</a> 
                        @if($question->id)
                            <input type="text" name="images" placeholder="filename of image goes here" class="form-control" style="width: 200px; border-radius: 4px; margin-top: 5px;">
                            <button class="btn btn-primary waves-effect waves-light" style="float: right; margin-right: 5px;"><i class="fa fa-save"></i> &nbsp;Update Question</button>
                        @else
                            <button class="btn btn-primary waves-effect waves-light" style="float: right; margin-right: 5px;"><i class="fa fa-save"></i> &nbsp;Submit Question</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header">
      <i class="ion ion-clipboard"></i>
      <h3 class="box-title">{{ ucwords($survey->title) }}</h3>
      <span class="text-danger text-bold">(Note: You may sort your questions.)</span>
    </div>
    <form action="{{ URL('survey/sort/'.$survey->id.'') }}" method="POST">
        <div class="box-body">
            <ul class="todo-list">
                @foreach ($survey->questions as $question)
                    <li data-toggle="collapse" data-target="#test{{ $question->id }}" style="margin-bottom: 5px; border: 1px solid #ccc;">
                        <input type="hidden" name="order[]" value="{{ $question->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <span class="handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <span class="text">{{ $question->title }}</span>
                        @if($question->question_type === 'text')
                            <small class="label label-primary">
                        @elseif($question->question_type === 'radio')
                            <small class="label label-success">
                        @elseif($question->question_type === 'checkbox')
                            <small class="label label-warning">
                        @elseif($question->question_type === 'textarea')
                            <small class="label label-danger">
                        @elseif($question->question_type === 'rating')
                            <small class="label label-info">
                        @endif        
                            {{ strtoupper($question->question_type) }}</small>
                        <div class="tools">
                            <a href="{{ URL('survey/'.$survey->id.'/'.$question->id) }}" style="color: #dd4b39;"> <i class="fa fa-edit"></i></a> &nbsp;
                            <a href="{{ URL::to('/question/'.$question->id.'/delete') }}" class="delete-survey" style="color: #dd4b39;"><i class="fa fa-trash-o"></i></a>
                        </div>
                        <div class="collapse" id="test{{ $question->id }}" style="margin-left: 23px; margin-right: 23px; margin-top: 10px;">
                            @if($question->question_type === 'text')
                            {{ Form::text('title', '', array('class' => 'form-control'))}}
                            @elseif($question->question_type === 'textarea')
                            <p style="margin:0px; padding:0px;">
                                <textarea id="textarea1" class="form-control"></textarea>
                                <label for="textarea1">Provide answer</label>
                            </p>
                            @elseif($question->question_type === 'radio')
                            @foreach($question->option_name as $key=>$value)
                            <p style="margin:0px; padding:0px;">
                                <input type="radio" name="radio" id="{{ $key }}" class="flat-red" /> &nbsp;
                                <label for="{{ $key }}">{{ $value }}</label>
                            </p>
                            @endforeach
                            @elseif($question->question_type === 'checkbox')
                            @foreach($question->option_name as $key=>$value)
                            <p input="margin:0px; padding:0px;">
                                <input type="checkbox" id="{{ $key }}" checked class="flat-red" />
                                <label for="{{$key}}" style="vertical-align: top;">{{ $value }}</label>
                            </p>
                            @endforeach
                            @elseif($question->question_type === 'rating')
                                <div class="stars starrr" data-rating="0"></div>
                            @endif 
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="box-footer clearfix no-border">
              <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> &nbsp;Save Order of Questions</button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('additional_scripts')
@if(count($survey->questions) > 0)

@endif
<script src="{{ asset('/materialize_js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('materialize_js/materialize.js') }}"></script>
<script src="{{ URL::asset('materialize_js/materialize.min.js') }}"></script>
<script src="{{ URL::asset('materialize_js/init.js') }}"></script>
<script src="{{ URL::asset('materialize_js/rating.min.js') }}"></script>
<script src="{{ asset('/bower_components/admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset ('/bower_components/bootstrap-sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('/bower_components/admin-lte/dist/js/pages/dashboard.js') }}"></script>
@endsection