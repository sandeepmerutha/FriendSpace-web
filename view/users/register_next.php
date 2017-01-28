
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <form class="col s12" method="post">

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='text' name='username' id='username' />
                        <label for='username'>Username</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='col s12'>
                        <label for='dob'>Date of Birth</label>
                        <input class='validate datepicker' type='date' name='dob' id='dob' placeholder="DD/MM/YYYY"/>

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
    </div>
</div>