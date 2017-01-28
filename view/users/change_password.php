
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name_white.png">
            </div>
            <div class="card-block">
                <form id="login-form" method="post" action="">
                    <!--Body-->
                    <div class="md-form">
                        <input type="password" id="password" name="password" class="form-control">
                        <label for="password">Password</label>
                    </div>

                    <div class="md-form">
                        <input type="password" id="password_again" name="password_again" class="form-control">
                        <label for="password_again">Password</label>
                    </div>

                    <div class="text-xs-center">
                        <button type="submit" class="btn btn-primary">Change Password</button>
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
        </div>
        <!--/Form without header-->
    </div>
</div>