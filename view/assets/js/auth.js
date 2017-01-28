/**
 * Created by pcsaini on 25/1/17.
 */
$('document').ready(function()
{
    $("#login-form").validate({
        rules:
            {
                password: {
                    required: true
                },
                username: {
                    required: true
                }
            },
        messages:
            {
                password:{
                    required: "Please enter your password"
                },
                username: {
                    required: "Please enter your username"
                }
            },
        errorClass: 'invalid',
        errorPlacement: function(error, element) {
            element.next("label").attr("data-error", error.contents().text());
        }
    });

});
