/**
 * Created by pcsaini on 25/1/17.
 */
/*-------------------------------
    Login Form Validation
---------------------------------*/
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
    });

});

/*-------------------------------
 Register Form Validation
 ---------------------------------*/
$('document').ready(function()
{
    //email validation
    var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    $.validator.addMethod("validemail", function( value, element ) {
        return this.optional( element ) || eregex.test( value );
    });

    $("#register-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 4
            },
            email: {
                required: true,
                validemail : true,
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
                validemail: "Please Enter a valid Email address",
                remote: "Email already exists"
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

/*-------------------------------
 Reset Password Form Validation
 ---------------------------------*/
$('document').ready(function()
{
    $("#password-form").validate({
        rules: {
            current_password:{
                required: true,
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
            current_password:{
                required: "Current Password id required",
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

/*-------------------------------
 Forget Password Form Validation
 ---------------------------------*/
$('document').ready(function()
{
    //email validation
    var eregex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    $.validator.addMethod("validemail", function( value, element ) {
        return this.optional( element ) || eregex.test( value );
    });

    $("#forget_password").validate({
        rules: {
            email: {
                required: true,
                validemail : true
            }
        },
        messages: {
            email: {
                required: "Email is required",
                validemail: "Please Enter a valid Email address"
            }
        },
        errorClass: 'invalid',
        errorPlacement: function (error, element) {
            element.next("label").attr("data-error", error.contents().text());
        }
    });
});
