@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/iCheck/all.css") }}">
<link rel="stylesheet" href="{{ asset('/bower_components/bootstrap-sweetalert/dist/sweetalert.css') }}">
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
        left: 50px;
        bottom: 80px;
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

<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-info"></i> Note!</h4>
    Please make sure you have filled up your answers before clicking next button.
    <div style="font-weight: bold; margin-top: 5px;">{!! $survey->description !!}</div>
</div>

<div class="box box-success box-solid">
    <div class="box-header with-border margin-bottom">
        {{ $survey->title }} - {{ date("F j, Y") }}
        <span id="countdown" class="text-bold pull-right">Countdown Timer: Disabled
<!--            <p class="hours">00</p>
            <p class="timeRefHours">hours</p>
            <p class="minutes">00</p>
            <p class="timeRefMinutes">minutes</p>
            <p class="seconds">00</p>
            <p class="timeRefSeconds">seconds</p>-->
        </span>
    </div>

    {!! Form::open(array('action'=>array('AnswerController@store', $survey->id), 'id' => 'myform')) !!}

    <div class="box-body">
        <div class="divs">
            @foreach ($survey_mail as $key => $question)
            <div class="col-md-12 question-container" id="questcon{{ $key+1 }}">
                <h5 class="text-bold" style="margin-top: 0px;">Question {{ $key+1 }} of {{ count($survey_mail) }}</h5>
                <span>{{ $question->title }} </span><br>
                @if($question->question_type === 'text')
                <div>
                    <label for="answer">Answer</label>
                    <input id="answer" type="text" name="{{ $question->id }}[answer]" class="form-control" style="border-radius: 4px; width: 500px;" data-validation="required">             
                </div>
                @elseif($question->question_type === 'textarea')
                <br>
                <textarea id="textarea1" class="form-control text-radio" name="{{ $question->id }}[answer]" style="border-radius: 4px; height: 140px;" data-validation="required"></textarea><br>
                @elseif($question->question_type === 'rating')
                sdfss
                <div class="input-field col-md-12">
                    <div class="stars starrr" data-rating="0"><input id="ratings-hidden" name="{{ $question->id }}[answer]" type="hidden"></div>
                </div>
                @elseif($question->question_type === 'radio')
                <br>
                <table>
                    @foreach($question->option_name as $key=>$value)
                    <tr>
                        @if($value == 'type-text')
                        <td style="padding-right: 5px;"><input name="{{ $question->id }}[answer]" data-text="radio{{ $question->id }}" id="radio[{{ $question->id }}]" class="text-radio" type="radio" id="{{ $key }}" value="{{ $value }}" data-validation="required"/></td>
                        <td style="padding-right: 5px;"><textarea name="ques_text_{{ $question->id }}[text-answer]" disabled class="form-control quest-text text-radio" data-text="radio{{ $question->id }}" style="border-radius: 4px; width: 600px;" placeholder="Customer Reply (Type your answer)"></textarea></td>
                        @else
                        <td style="padding-right: 5px;"><input name="{{ $question->id }}[answer]" class="text-radio" type="radio" id="radio[{{ $question->id }}]" value="{{ $value }}" data-validation="required"/></td>
                        <td style="padding-right: 5px;"><label for="{{ $key }}" style="vertical-align: baseline; font-weight: normal; margin-top: 7px;">{{ $value }}</label></td>
                        @endif
                    </tr>
                    @endforeach
                </table>
                <br>

                @elseif($question->question_type === 'checkbox')
                @foreach($question->option_name as $key=>$value)
                <p style="margin:0px; padding:0px; margin-top: 10px;">
                    @if(strpos($value, 'type-text') !== false)
                    <?php $val = substr(strstr($value, ':'), 1); ?>
                        <input type="checkbox" id="something{{ $key }}" name="{{ $question->id }}[answer][]" value="{{ substr($val, 0, strrpos($val, ':')) }}" data-text="radio{{ $question->id }}" class="flat-red text-radio _testter" /><label style="margin-left: 10px;" for="something{{$key}}">{{ substr($val, 0, strrpos($val, ':')) }}</label>
                        <textarea  name="ques_text_{{ $question->id }}[text-answer][]" class="form-control quest-text text-radio" disabled data-text="radio{{ $question->id }}" style="border-radius: 4px; width: 600px; height: 130px; margin-left: 30px; display:none" placeholder="{{ strstr(str_replace(":","", strstr($value, ':')), 'What') }}"></textarea>
                    @else
                        <input type="checkbox" id="something{{ $key }}" name="{{ $question->id }}[answer][]" class="flat-red" value="{{ $value }}"/>
                        <label for="something{{$key}}">{{ $value }}</label>
                    @endif
                </p>
                @endforeach
                @endif 
                @if($question->images)
                <span class="text-bold">Note: Click the image below to view it's original size. </span><br><br>
                <?php
                $images = explode(",", $question->images);
                $index = 0;
                ?>
                @foreach($images AS $dd)
                <center>
                    <div class="overlay"></div>
                    <div class="overlayContent">
                        <span class="close text-bold" style="color: red; opacity: 1; position: relative; left: -55px; font-size: 30px;">X</span>
                        <img class="imgBig" style="align: center; display: none;" src="{{ asset('attachments/survey/' . str_replace('"', '', $dd)) }}"  data-imgtarget="imgBig{{ $question->id.$index }}" />
                    </div>
                </center>
                <img class="imgSmall" width="200" src="{{ asset('attachments/survey/' . str_replace('"', '', $dd)) }}" data-img="{{ $question->id.$index }}" />
                <?php $index++; ?>
                @endforeach
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
<input type="hidden" name="answer_id" value="{{ time() }}">

<span id="page-counter" style="display: none" >1</span>
<a id="prev" class="btn btn-success">Previous Question</a> {{ Form::submit('Submit This Exam', array('class'=>'btn btn-primary', 'id' => 'submit', 'style="text-align:center;"')) }}
<a id="next" class="btn btn-success pull-right">Next Question</a>


{!! Form::close() !!}
@endsection

@section('additional_scripts')
<script src="{{ asset('/bower_components/admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('/materialize_js/timer.js') }}"></script>
<script src="{{ asset('/jquery-validator/form-validator/jquery.form-validator.min.js') }}"></script>
<script src="{{ asset('/bower_components/bootstrap-sweetalert/dist/sweetalert.min.js') }}"></script>
<script>
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
});
</script>

<!--<script>
  (function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")}}if(!e){return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()})

$(function(){

  $('#new-review').autosize({append: "\n"});

  var reviewBox = $('#post-review-box');
  var newReview = $('#new-review');
  var openReviewBtn = $('#open-review-box');
  var closeReviewBtn = $('#close-review-box');
  var ratingsField = $('#ratings-hidden');

  openReviewBtn.click(function(e)
  {
    reviewBox.slideDown(400, function()
      {
        $('#new-review').trigger('autosize.resize');
        newReview.focus();
      });
    openReviewBtn.fadeOut(100);
    closeReviewBtn.show();
  });

  closeReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
      });
    closeReviewBtn.hide();
    
  });

  $('.starrr').on('starrr:change', function(e, value){
    ratingsField.val(value);
  });
});
</script>-->

<script>
var total_ques = {{ count($survey_mail) }};
$(document).ready(function () {
    $('input[type="checkbox"].flat-red').on('ifChanged', function () {
        var _this = $(this);
        
        if (typeof _this.attr('data-text') !== 'undefined'){
            var target = _this.data('text');
            
            if (_this.is(':checked')) {
                var container = _this.parents('.question-container');
                _this.parent().parent().find('textarea').removeAttr('disabled');
                _this.parent().parent().find('textarea').show();
                //$("textarea").attr("required", true);
                
            }
         else{
            var container = _this.parents('.question-container');
            _this.parent().parent().find('textarea').attr('disabled', 'disabled');
            _this.parent().parent().find('textarea').hide()
          //  $("textarea").attr("required", false);
            
        }
    }
   
    });

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
    
    var counter = 1;

    $("#next").click(function () {
        counter = parseInt($('#page-counter').html());
        var has_error = false;
        var total_textarea = 0;
        var enabled_textarea = 0;
 
       $('#questcon' + counter).find('textarea').each(function() {
           console.log($(this).is(':hidden'));
           if(!$(this).is(':hidden'))
               enabled_textarea++;
           
            if($(this).val())
            total_textarea++;
        
            if(enabled_textarea == 0) {
        
          swal("Warning!","You need to choose at lease one.");
          return false;
          
        }
        
        if(enabled_textarea != total_textarea) {
            swal("Warning!","Please fill in the empty fields.");
          return false;
        }
        
       });
       
     //  console.log("Total enabled textarea: " + enabled_textarea);
        
        

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

        $('#questcon' + counter).find('.flat-red').each(function(){
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
            if($('#questcon' + (counter + 1)).length)
                $('#page-counter').html(counter + 1);
        }
    });

    $("#prev").click(function () {
        counter = parseInt($('#page-counter').html());
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
