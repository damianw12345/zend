/**
 * Created by damian.warzecha on 2016-08-12.
 */

// $('input[login]').
//
//

// function checkAvailability() {
//     $("#loaderIcon").show();
//     jQuery.ajax({
//         url: "check_availability.php",
//         data:'username='+$("#username").val(),
//         type: "POST",
//         success:function(data){
//             $("#user-availability-status").html(data);
//             $("#loaderIcon").hide();
//         },
//         error:function (){}
//     });
// }

$(document).ready(function () {
    $('[name="reg_login"]').keyup(function () {
        var username = $(this).val();
        $.ajax({
            url:"ajax",
            method:"POST",
            data:{user_name:username},
            dataType:"json",
            success: function (data)
            {
                $('[name="reg_login"]').parent().removeClass("has-error has-feedback");
                $('[name="reg_login"]').parent().addClass("has-success has-feedback");
                $('#test').replaceWith('<label id="test">'+data.html+'</label>');
                $('[name="reg_login"]').attr('id', 'inputSuccess2');
                $('.glyphicon').remove();
                $('<span class="glyphicon glyphicon-ok form-control-feedback"></span>').insertAfter('[name="reg_login"]');
            },
            error: function (data)
            {
                $('[name="reg_login"]').parent().removeClass("has-success has-feedback");
                $('[name="reg_login"]').parent().addClass("has-error has-feedback");
                $('#test').replaceWith('<label id="test">'+data.html+'dupa'+'</label>');
                $('[name="reg_login"]').attr('id', 'inputError2');
                $('.glyphicon').remove();
                $('<span class="glyphicon glyphicon-remove form-control-feedback"></span>').insertAfter('[name="reg_login"]');
            }
        });
        // alert('dupa');
    });
});