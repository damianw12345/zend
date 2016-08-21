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
    $('[name="reg_login"]').keypress(function () {
        var username = $(this).val();
        $.ajax({
            url:"ajax",
            method:"POST",
            data:{user_name:username},
            dataType:"json",
            success:function (data)
            {
                // $('[name="reg_login"]').before().html('<label for="inputError2">Input with error</label>');
                $('[name="reg_login"]').parent().addClass("has-error has-feedback");
                $('[name="reg_login"]').attr('id', 'inputError2');
                $('<span class="glyphicon glyphicon-remove form-control-feedback"></span>').insertAfter('[name="reg_login"]');
                // $('[name="reg_login"]').after().html('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');

            }
        });
        // alert('dupa');
    });
});