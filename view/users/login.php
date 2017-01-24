
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <hr>
            <div class="card-block">
                <form method="post" action="">
                    <!--Body-->
                    <div class="md-form">
                        <i class="fa fa-user prefix"></i>
                        <input type="text" id="username" name="username" class="form-control">
                        <label for="username">Your email</label>
                    </div>

                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input type="password" id="password" name="password" class="form-control">
                        <label for="password">Your password</label>
                    </div>

                    <div class="text-xs-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <!--Footer-->
                <div class="login-footer">
                    <div class="options">
                        <span class="float-lg-left">New user? <a>Sign Up</a></span>
                        <span class="float-md-right"><a>Forget Password</a></span>
                    </div>
                </div>
            </div>


            <div class="social-login">
                <h4>Login with</h4>
                <!--Facebook-->
                <a type="button" class="btn btn-primary btn-fb" href="<?php echo $GLOBALS['base_url']; ?>login?type=facebook"><i class="fa fa-facebook"></i></a>
                <!--Google-->
                <a type="button" class="btn btn-primary btn-gplus" href="<?php echo $GLOBALS['base_url']; ?>login?type=google"><i class="fa fa-google-plus"></i></a>
                <!--Twitter-->
                <a type="button" class="btn btn-primary btn-tw" href="<?php echo $GLOBALS['base_url']; ?>login?type=twitter"><i class="fa fa-twitter"></i></a>
            </div>

        </div>
        <!--/Form without header-->
    </div>
</div>

