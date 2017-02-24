
<div class="flex-center">
    <div class="login-form">
        <!--Form without header-->
        <div class="card">
            <!--Header-->
            <div class="login-header">
                <img src="<?php echo $GLOBALS['base_url']; ?>view/assets/img/logo/logo_name.png">
            </div>
            <form class="col s12" id="register-form" method="post" action="<?php echo $GLOBALS['base_url']; ?>register">
                <?php
                if(!empty($errors)) {
                    foreach($errors as $message) {
                        echo "<div class=''>".$message[0]."</div><br/>";
                    }
                }
                if (!empty($result)) {
                    if($result == 1) {
                        echo "<div> Your Account Created, Please cheack You email Address for activate you Account.</div>";
                    }
                }
                ?>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='email' name='email' id='email' />
                        <label for='email'>Enter your email</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='validate' type='text' name='name' id='full_name' />
                        <label for='full_name'>Full Name</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='input-field col s12'>
                        <input class='datepicker' type='date' name='dob' id='dob' placeholder="DD/MM/YYYY"/>
                        <label class="active" for="dob">Date of Birth</label>
                    </div>
                </div>

                <div class='row'>
                    <div class='input-field col s12'>
                        <label class="active"  data-error="Please Select Gender" for="gender"></label>
                        <select class="validate" name="gender" id="gender" required>
                            <option value="" disabled selected>Gender</option>
                            <option value="m">Male</option>
                            <option value="f">Female</option>
                        </select>

                    </div>
                </div>

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
                        <button type='submit' name='register' class='col s12 btn btn-large waves-effect cyan darken-3'>Sign Up</button>
                    </div>
                </center>

            </form>
        </div>
        <div class="card">
            <div class="login-footer">
                Already have an account? <a href="<?php echo $GLOBALS['base_url']; ?>login" class="cyan-text text-darken-3">Login</a>
            </div>
        </div>
    </div>
</div>