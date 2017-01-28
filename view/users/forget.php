
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
                        <input type="email" id="email" name="email" class="form-control">
                        <label for="email">Email</label>
                    </div>

                    <div class="text-xs-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!--Footer-->
                <div class="login-footer">
                    <div class="options">
                        <span class="float-lg-left"><a>Go Back</a></span>
                    </div>
                </div>
            </div>
        </div>
        <!--/Form without header-->
    </div>
</div>