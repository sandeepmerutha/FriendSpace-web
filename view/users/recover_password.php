
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <form class="col s12" id="password-form" method="post" action="<?php echo $GLOBALS['base_url']; ?>login/recoverPassword/secret/<?php echo $temp_id; ?>">
                <?php
                if(!empty($errors)) {
                    foreach($errors as $message) {
                        echo "<div class=''>".$message[0]."</div><br/>";
                    }
                }
                ?>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='password' name='password' id='password' />
                        <label for='password'>Password</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='password' name='password_again' id='password' />
                        <label for='password'>Conform Password</label>
                    </div>
                </div>

                <br />
                <center>
                    <div class='row'>
                        <button type='submit' name='register' class='col s12 btn btn-large waves-effect cyan darken-3'>Change Password</button>
                    </div>
                </center>

            </form>
        </div>
    </div>
</div>