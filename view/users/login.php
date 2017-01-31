
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <form class="col s12" method="post" action="<?php echo $GLOBALS['base_url']; ?>login">

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='text' name='username' id='username' />
                        <label for='username'>Enter your email</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='password' name='password' id='password' />
                        <label for='password'>Enter your password</label>
                    </div>
                    <div class="right-align">
                        <a class='cyan-text text-darken-3' href='<?php echo $GLOBALS['base_url']; ?>login/forgot'><b>Forgot Password?</b></a>
                    </div>
                </div>
                <div style="padding-left: 10px">
                    <input type="checkbox" id="remember" name="remember" />
                    <label for="remember">Remember me</label>
                </div>
                <br />
                <center>
                    <div class='row'>
                        <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect cyan darken-3'>Login</button>
                    </div>
                </center>
                <div class="text-divider"><h6><strong>OR</strong></h6></div>
                <center>
                    <div class='row'>
                        <a type="button" class="btn btn-large waves-effect btn-fb" href="<?php echo $GLOBALS['base_url']; ?>register?type=facebook"><i class="fa fa-facebook-square"></i> Login with Facebook</a>
                    </div>
                </center>
            </form>
        </div>
        <div class="card">
            <div class="login-footer">
                Don't have an account? <a href="<?php echo $GLOBALS['base_url']; ?>register" class="cyan-text text-darken-3">Sign up</a>
            </div>
        </div>






        </div>
        <!--/Form without header-->
    </div>
</div>

