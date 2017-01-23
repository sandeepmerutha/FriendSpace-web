<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 1:48 AM
 */

require_once('library/Facebook/FacebookSession.php');
require_once('library/Facebook/FacebookRedirectLoginHelper.php');
require_once('library/Facebook/FacebookRequest.php');
require_once('library/Facebook/FacebookResponse.php');
require_once('library/Facebook/FacebookSDKException.php');
require_once('library/Facebook/FacebookRequestException.php');
require_once('library/Facebook/FacebookAuthorizationException.php');
require_once('library/Facebook/GraphObject.php');
require_once('library/Facebook/GraphUser.php');
require_once('library/Facebook/GraphSessionInfo.php');
require_once( 'library/Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'library/Facebook/HttpClients/FacebookCurl.php' );
require_once( 'library/Facebook/HttpClients/FacebookCurlHttpClient.php' );
require_once( 'library/Facebook/Entities/AccessToken.php' );
require_once( 'library/Facebook/Entities/SignedRequest.php' );


use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;


class login{

    public function __construct()
    {
        $this->model = new auth_model();
    }
    public function index(){


        FacebookSession::setDefaultApplication(FB_APP_ID, FB_APP_SECRET);

        $helper = new FacebookRedirectLoginHelper(FB_REDIRECT_URI);

        if(isset($_GET['type']) && $_GET['type'] == 'facebook' ){

            $fb_url = $helper->getLoginUrl(array('email'));
            header('Location: ' . $fb_url);
        }

        $session = $helper->getSessionFromRedirect();

        if(isset($_SESSION['token'])){
            $session = new FacebookSession($_SESSION['token']);
            try{
                $session->validate(FB_APP_ID, FB_APP_SECRET);
            }catch(FacebookAuthorizationException $e){
                echo $e->getMessage();
            }
        }

        $data = array();

        if(isset($session)){
            $_SESSION['token'] = $session->getToken();
            $request = new FacebookRequest($session, 'GET', '/me');
            $response = $request->execute();
            $graph = $response->getGraphObject(GraphUser::className());

            $data = $graph->asArray();
            $id = $graph->getId();
            $image = "https://graph.facebook.com/".$id."/picture?width=100";
            $data['image'] = $image;
            if($this->model->fb_login($data)){
                header("Location: ".$GLOBALS['dynamic_url']."home");
            }
            else{header("Location: ".$GLOBALS['dynamic_url']."login");}
        }
        /*********Facebook Login **********/


        /*******Google ******/

        $client = new Google_Client();
        $client->setScopes(array('https://www.googleapis.com/auth/plus.login','https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
        $client->setApprovalPrompt('auto');
        if(isset($_GET['type']) && $_GET['type'] == 'google' ) {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
        }

        $plus       = new Google_PlusService($client);
        $oauth2     = new Google_Oauth2Service($client);
//unset($_SESSION['access_token']);

        if(isset($_GET['code'])) {
            $client->authenticate(); // Authenticate
            $_SESSION['access_token'] = $client->getAccessToken(); // get the access token here
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        }

        if(isset($_SESSION['access_token'])) {
            $client->setAccessToken($_SESSION['access_token']);
        }

        if ($client->getAccessToken()) {
            $_SESSION['access_token'] = $client->getAccessToken();
            $user         = $oauth2->userinfo->get();
            try {
                if($this->model->google_login( $user ))header("Location: ".$GLOBALS['dynamic_url']."home");
                else header("Location: ".$GLOBALS['dynamic_url']."login");
            }catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        /*******Google ******/

        /*** Twitter****/
        if (TWITTER_CONSUMER_KEY === '' || TWITTER_CONSUMER_SECRET === '' || TWITTER_CONSUMER_KEY === 'TWITTER_CONSUMER_KEY_HERE' || TWITTER_CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') {
            echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
            exit;
        }


        if(isset($_GET['type']) && $_GET['type'] == 'twitter' ){
            $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
            $request_token = $connection->getRequestToken(TWITTER_OAUTH_CALLBACK);
            $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
            //echo "<pre>";print_r($connection);echo "</pre>";
            //echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
            switch ($connection->http_code) {
                case 200:
                    $url = $connection->getAuthorizeURL($token); //echo $url;exit;
                    header('Location: ' . $url);
                    break;
                default:
                    $error = 'Could not connect to Twitter. Refresh the page or try again later.';
            }
        }else{
            if(( isset( $_SESSION['oauth_token'] ) ) ){
                $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
                $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
                $_SESSION['access_token'] = $access_token;
                $content = $connection->get('account/verify_credentials');
                $data = array();
                if( !empty( $content->id )){
                    $data['id'] = $content->id;
                    $data['name'] = $content->name;
                    $data['screen_name'] = $content->screen_name;
                    $data['picture'] = $content->profile_image_url;
                    try {
                        if($this->model->twitter_login($data))header("Location: ".$GLOBALS['dynamic_url']."home");
                    }catch (Exception $e) {
                        $error = $e->getMessage();
                    }

                }else{
                    session_unset();
                    session_destroy();
                    header("Location: ".$GLOBALS['dynamic_url']."login");
                }
            }
        }
        /*** Twitter****/



        /*if (!empty($_POST)){
            $data['post'] = $_POST;
            $username = $_POST['username'];
            $password = $_POST['password'];

            $username = strip_tags($username);
            $password = strip_tags($password);

            $password = md5($password);

            $result = $this->model->login($username,$password);
            if (!$result == false){
                $_SESSION['id'] = $result;
                header("Location: ".$GLOBALS['dynamic_url']."home");
                die();
            }
            else{
                $data['errors'] = array(array("username and password don't match"));
            }
        }

        if ($this->model->loggedIn() == true){
            header("location: ".$GLOBALS['dynamic_url']."home");
            exit();
        }*/
        $data['page_title'] = "Login";
        $data['view_page'] = "users/login.php";
        $data['header'] = $GLOBALS['header'];
        $data['navbar'] = "false";
        $data['footer'] = $GLOBALS['footer'];

        return $data;
    }
    public function forget(){
        if (!empty($_POST)) {
            $data['post'] = $_POST;
            $email = strip_tags($_POST['email']);
            $email = trim($email);
            if ($this->emailExists($email)) {
                $data['result'] = $this->model;
            }
            else{
                $data['errors'] = array(array("Email Address Not Exists"));
            }
        }

        if ($this->model->loggedIn() == true){
            header("location: ".$GLOBALS['dynamic_url']."home");
            exit();
        }

        $data['page_title'] = "Forget Password";
        $data['view_page'] = "users/forget.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];

        return $data;
    }

    public function changePassword(){
        //$this->authcheck = new authcheck();
        if (!empty($_POST)) {
            $userdata = $this->model->userDetail();
            $password_confirm = strip_tags($_POST['password_confirm']);
            $password = strip_tags($_POST['password']);
            $password_verify = strip_tags($_POST['password_verify']);
            if(md5($password_confirm) !== $userdata['password']){
                $data['errors']  = array(array("Wrong Current Password"));
            }
            else if ($password !== $password_verify){
                $data['errors'] = array(array("Password Don't Match"));
            }
            else {
                $data['result'] = $this->model->changePassword($password);
            }
        }
        $data['page_title'] = "Change Password";
        $data['view_page'] = "users/change_password.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];

        return $data;

    }

    public function emailExists($email) {
        $result = $this->model->checkIfExists("users","WHERE email='$email'");
        return $result;
    }
}