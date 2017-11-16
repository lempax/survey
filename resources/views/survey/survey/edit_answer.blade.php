@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/iCheck/all.css") }}">
<style>
    .animated {
        -webkit-transition: height 0.2s;
        -moz-transition: height 0.2s;
        transition: height 0.2s;
    }

    #countdown p {
        display: inline-block;
        font-weight: bold;
        margin-bottom: 0px;
    }

    .overlay {
        position: fixed; 
        width: 100%; 
        height: 100%; 
        top: 0px; 
        left: 0px; 
        background-color: #000; 
        opacity: 0.7;
        filter: alpha(opacity = 70) !important;
        display: none;
        z-index: 100;
    }

    .overlayContent{
        position: fixed; 
        width: 100%;
        top: 100px;
        left: 0px;
        text-align: center;
        display: none;
        overflow: hidden;
        z-index: 100;
    }

    .contentGallery{
        margin: 0px auto;
    }

    .imgBig, .imgSmall{
        cursor: pointer;
    }

    .imgSmall{
        float: left;
        margin-right: 10px;
    }

    span.form-error {
        position: absolute;
        left: 33px;
        bottom: -8px;
    }
</style>
@endsection

@section('content')
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-info"></i> Note!</h4>
    Please make sure you have filled up your answers before clicking next button.
    <div style="font-weight: bold; margin-top: 5px;">{!! $survey->description !!}</div>
</div>

<div class="box box-success box-solid">
    <div class="box-header with-border margin-bottom">
        {{ $survey->title }} - {{ date("F j, Y") }}
        <span id="countdown" class="text-bold pull-right">Countdown Timer: Disabled</span>
    </div>
    
    
    
    {!! Form::open(array('action'=>array('AnswerController@update', $survey->id), 'id' => 'myform')) !!}
    <div class="box-body">
        <div class="divs">
            @foreach ($survey_mail as $key => $question)
            <div class="col-md-12 question-container" id="questcon{{ $key+1 }}">
                <h5 class="text-bold" style="margin-top: 0px;">Question {{ $key+1 }} of {{ count($survey_mail) }}</h5>
                <span> Choose the appropriate answer (you can choose more than 1):</span><br>
                @foreach(explode(",", $question['answer']) AS $_arr)
                <p style="margin:0px; padding:0px; margin-top: 10px;">
                    <?php $value = str_replace(array("/", "[", "]"), "", $_arr); ?>
                    <input type="checkbox" id="something{{ $question['question_id'] }}" name="{{ $question['question_id'] }}[answer][]" value="{{ str_replace(array("/", "[", "]"), "", $_arr) }}" class="flat-red" checked/><label style="margin-left: 10px;" for="something{{$key}}">{{ str_replace(array("/", "[", "]"), "", $_arr) }}</label>
                    <textarea name="ques_text_{{ $question['question_id'] }}[text-answer][]" class="form-control quest-text text-radio" data-text="radio{{ $question['question_id'] }}" style="border-radius: 4px; width: 600px; height: 130px; margin-left: 30px;" placeholder="{{ "What type of ".$value." (List the top 5 ".$value." you need)" }}"></textarea>
                </p>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>

<span id="page-counter" style="display: none" >1</span>
<a id="prev" class="btn btn-success">Previous Question</a> {{ Form::submit('Submit This Exam', array('class'=>'btn btn-primary', 'id' => 'submit', 'style="text-align:center;"')) }}
<a id="next" class="btn btn-success pull-right">Next Question</a>


{!! Form::close() !!}
@endsection

@section('additional_scripts')
<script src="{{ asset('/bower_components/admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('/materialize_js/timer.js') }}"></script>
<script src="{{ asset('/jquery-validator/form-validator/jquery.form-validator.min.js') }}"></script>

<script>
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
});
</script>

<script>
var total_ques = {{ count($survey_mail) }};
$(document).ready(function () {
    $(".text-radio").on('click', function (event) {
        var _this = $(this);
        console.log(_this);

        if (typeof _this.attr('data-text') !== 'undefined'){
            var target = _this.data('text');
            if (_this.is(':checked')) {
                var container = _this.parents('.question-container');
                container.find('textarea[data-text="' + target + '"]').removeAttr('disabled');
            }
        } else{
            var container = _this.parents('.question-container');
            container.find('.quest-text').attr('disabled', 'disabled');
        }
    });

    $("#prev").hide();
    $("#submit").hide();

    $(".divs > div").each(function (e) {
        if (e != 0) {
            $(this).hide();
        }
    });

    $("#next").click(function () {
        var counter = parseInt($('#page-counter').html());
        var has_error = false;

        $('#questcon' + counter).find('.text-radio').each(function(){
            var cur_input = $(this);
            console.log('test 1');
            cur_input.validate(function(valid, elem) {
                console.log('test 2');
                if (!valid){
                    console.log('test 3');
                    has_error = true;
                }
            });
        });

        if (!has_error){
            if ($(".divs > div:visible").next().length != 0) {
                $(".divs > div:visible").next().show().prev().hide();
                $("#prev").show();
            } else {
                $("#next").hide();
                $("#submit").show();
            }
            $('#page-counter').html(counter + 1);
        }
    });

    $("#prev").click(function () {
        if ($(".divs > div:visible").prev().length != 0) {
            $(".divs > div:visible").prev().show().next().hide();
            $("#submit").hide();
            $("#next").show();
        } else {
            $("#prev").hide();
        }
        $('#page-counter').html(counter - 1);
    });
});
</script>

<script>
$(document).ready(function () {
    $("#countdown").countdown({
        date: "25 July 2017 14:00:00", 
        format: "on"
    }, this);
});
</script>

<script>
$(".imgSmall").click(function () {
    $(".imgBig").hide();
    var target = $(this).data("img");
    $(".imgBig[data-imgtarget='imgBig" + target + "']").show();
    $(".close").show();
    $(".overlay").show();
    $(".overlayContent").show();
});

$(".close").click(function () {
    var target = $(".imgBig").data("imgtarget");
    console.log(target);
    $(".imgBig[data-imgtarget='imgBig" + target + "']").hide();
    $(".overlay").hide();
    $(".overlayContent").hide();
});
</script>
@endsection