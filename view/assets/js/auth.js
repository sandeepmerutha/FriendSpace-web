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
                email: {
                    required: true
                }
            },
        messages:
            {
                password:{
                    required: "Please enter your password"
                },
                email: {
                    required: "Please enter your username or email"
                }
            },
        errorClass: 'invalid',
        errorPlacement: function(error, element) {
            element.next("label").attr("data-error", error.contents().text());
        }
        //submitHandler: Login
    });
    /*function Login() {
        var $data = $("#login-form").serialize();
        //$(".btn-login").html('sending...');
       $.ajax({
            type: 'POST',
            url:'login',
            data: $data,
            /!*beforeSend: function () {
                $(".btn-login").html('sending...');
            },
            success:function () {
                $(".btn-login").html('sending...');
                setTimeout(' window.location.href = "login"; ',2000);
            }*!/
        })

    }*/

});


$('document').ready(function()
{
    $("#register-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 4
            },
            email: {
                required: true,
                remote: {
                    url: "register/check",
                    type: "post",
                    name: "email",
                    data: {
                        email: function () {
                            return $("#email").val();
                        }
                    }
                }
            },
            dob: {
                required: true
            },
            gender: {
                required: function(){
                    if($("select[name=gender]").val() == 1){
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 15
            },
            password_again: {
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            name: {
                required: "Name is required",
                minlength: "your name is too short"
            },
            email: {
                required: "Email is required",
                remote: "Email already exists"
            },
            dob: {
                required: "Date of Birth in required"
            },
            gender: {
                required: "Gender is Required"
            },
            password: {
                required: "Password is required",
                minlength: "Password at least have 6 characters"
            },
            password_again: {
                required: "Retype your password",
                equalTo: "Password did not match !"
            }
        },
        errorClass: 'invalid',
        errorPlacement: function (error, element) {
            element.next("label").attr("data-error", error.contents().text());
        }
    });
});
