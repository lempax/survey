$(document).ready(function () {
    $('.collapsible').collapsible({
        accordion: false
    });

    $('.modal-trigger').leanModal();

    $(document).on('click', '.delete-option', function () {
        $(this).parent(".input-field").remove();
        
        if($('.input-field').children(':visible').length == 0) {
            $(".clear-option").hide();
        }
    });

    $(document).on('click', '.clear-option', function () {
        $(".input-field").remove();
        $(".clear-option").hide();
    });

    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $(document).on('click', '.delete-survey', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this survey",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: "Deleted!",
                            text: "The survey has been deleted.",
                            type: "success"
                        }, function(){
                            window.location = href;
                        });
                    } else {
                        swal("Cancelled", "The survey is safe :)", "error");
                    }
                });
    });

    // will replace .form-g class when referenced
    var material = '<div class="input-field input-group col-md-12" style="margin-bottom: 5px;">' +
            '<div class="input-group-btn"><button type="button" class="btn btn-default">Option</button></div>' +
            '<input type="text" name="option_name[]" id="option_name[]" class="form-control" />' +
            '<span class="delete-option input-group-addon bg-red" style="border-bottom-right-radius: 4px; border-top-right-radius: 4px; border: 1px solid red;"><i class="fa fa-fw fa-remove"></i></span>' +
            '</div>';

    // for adding new option
    $(document).on('click', '.add-option', function () {
        $(".form-g").append(material);
    });
    
    
    // allow for more options if radio or checkbox is enabled
    $(document).on('change', '#question_type', function () {
        var selected_option = $('#question_type :selected').val();
        var option_values = $(".form-g").html(material);
        if (selected_option === "radio") {
            option_values.show();
            $(".stars").hide();
            $(".add-option").show();
            $(".clear-option").show();
            $(".radio-data").show();
            $(".checkbox-data").hide();
            $(".radio-reminder").hide();
        } else if (selected_option === "checkbox") {
            option_values.show();
            $(".stars").hide();
            $(".add-option").show();
            $(".clear-option").show();
            $(".radio-data").hide();
            $(".checkbox-data").show();
            $(".radio-reminder").show();
        } else if (selected_option === "text" || selected_option === "textarea") {
            $(".input-g").remove();
            $(".add-option").hide();
            $(".clear-option").hide();
            $(".radio-reminder").hide();
            option_values.hide();
            $(".stars").hide();
            $(".radio-data").hide();
            $(".checkbox-data").hide();
            $(".radio-reminder").hide();
        } else if (selected_option === "rating") {
            $(".stars").show();
            option_values.hide();
            $(".add-option").hide();
            $(".clear-option").hide();
            $(".radio-data").hide();
            $(".checkbox-data").hide();
            $(".radio-reminder").hide();
        } else {
            $(".input-g").remove();
            $(".add-option").hide();
            $(".clear-option").hide();
            $(".radio-data").hide();
            $(".checkbox-data").hide();
            $(".radio-reminder").hide();
        }
    });
});

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

