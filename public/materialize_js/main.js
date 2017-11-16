$(document).ready(function () {
    $("#submit_eos").click(function () {
        $.ajax({
            type: 'post',
            url: 'eos/save',
            data: {
                '_token': $('input[name=_token]').val(),
                'shift' : $('input[name=shift]').val()
            },

            success: function (data) {
                if ((data.errors)) {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                } else {
                    $('.error').addClass('hidden');
                    $('#table').append("<tr><td>Cebu-IT End of Shift Report</td><td>" + data.shift + "</td><td>"+ data.shift +"</td><td><button class='edit-modal btn btn-info' data-id='' data-name=''><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='' data-name=''><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                }
            },
            error: function(x){ 
                console.log($('input[name=shift]').val()); 
            },
        });
    });
});