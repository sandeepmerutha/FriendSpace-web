<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 7/12/16
 * Time: 8:59 PM
 */

//Basic Setting
$GLOBALS['base_url'] = "http://localhost/FriendSpace-web/";
$GLOBALS['dynamic_url']="http://localhost/FriendSpace-web/";
$GLOBALS['seourl'] = "true";

$GLOBALS['first_page'] = "login";
$GLOBALS['website_name'] = "FriendSpace";

//Database Setting
$GLOBALS['hostname']="localhost";
$GLOBALS['username']="root";
$GLOBALS['password']="";
$GLOBALS['database']="FriendSpace";

//common views
$GLOBALS['header'] = "header.php";
$GLOBALS['footer'] = "footer.php";

//Facebook App Details
define('FB_APP_ID', '380604015649201');
define('FB_APP_SECRET', '0330c4bbb019e7ff8d2340af61cd0206');
define('FB_REDIRECT_URI', 'http://localhost/FriendSpace-web/register');

