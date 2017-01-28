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

//Google App Details
define('GOOGLE_APP_NAME', 'FriendSpace Google+ login');
define('GOOGLE_OAUTH_CLIENT_ID', '405868638980-unp8g9bf95dq71morl9lmmh2is16v962.apps.googleusercontent.com');
define('GOOGLE_OAUTH_CLIENT_SECRET', 'o1PGoAblAW4BljkbtP5YDTGk');
define('GOOGLE_OAUTH_REDIRECT_URI', 'http://localhost/FriendSpace-web/');
define("GOOGLE_SITE_NAME", 'FriendSpace');


//Twitter login
define('TWITTER_CONSUMER_KEY', 'GP7PL3M9V7CZgJCyV2iAfaE9j');
define('TWITTER_CONSUMER_SECRET', 'f3byuN3ATvfOPhjNlLTWKDMH941PKkY6YZbmC2ibnarAr4Xpw0');
define('TWITTER_OAUTH_CALLBACK', 'http://localhost/FriendSpace-web');


