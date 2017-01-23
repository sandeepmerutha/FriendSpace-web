<nav>
    <div class="nav-wrapper container">
        <a href="<?php echo $GLOBALS['base_url'];?>home" class="brand-logo"><?php echo $GLOBALS['website_name']; ?></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#">Sass</a></li>
            <?php
            if (isset($_SESSION['session_id'])){ ?>
                <li><a class="dropdown-button" data-activates="dropdown1">User <i class="fa fa-angle-down"></i></a>
                    <!-- Dropdown Structure -->
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="<?php echo $GLOBALS['base_url']; ?>login/changePassword">Change Password</a></li>
                        <li><a href="#!">Setting</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $GLOBALS['base_url']; ?>logout">logout</a></li>
                    </ul>
                </li>
            <?php }
            else{ ?>
                <li><a href="<?php echo $GLOBALS['base_url']; ?>">Login</a></li>
            <?php }
            ?>
        </ul>
    </div>
</nav>