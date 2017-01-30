
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <div class="card-block">
                <form class="col s12" method="post" action="<?php echo $GLOBALS['base_url']; ?>login/forgot">

                    <div class='row'>
                        <div class='input-field col s12'>
                            <input class='validate' type='email' name='email' id='email' />
                            <label for='email'>Enter your email</label>
                        </div>
                    </div>
                    <br />
                    <center>
                        <div class='row'>
                            <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect cyan darken-3'>Submit</button>
                        </div>
                    </center>

                </form>
            </div>
                <!--Footer-->
                <div class="login-footer">
                    <div class="options">
                        <span class="float-lg-left"><a href="<?php echo $GLOBALS['base_url']; ?>login">Go Back</a></span>
                    </div>
                </div>
            </div>
        </div>
        <!--/Form without header-->
    </div>
</div>
