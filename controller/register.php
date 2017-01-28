<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 6:54 PM
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


class register {

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
            $request = new FacebookRequest($session, 'GET', '/me',array(
    'fields' => 'id,name,birthday'));
            $response = $request->execute();
            $graph = $response->getGraphObject(GraphUser::className());

            $fb_data = $graph->asArray();
            $id = $graph->getId();
            $image = "https://graph.facebook.com/".$id."/picture?width=100";
            $fb_data['image'] = $image;
            header('Location: '.$GLOBALS['base_url'].'register/next?id='.$id);
            /*if (facebookIdExists($id)) {
                # code...
            }
            else{
                header('Location: '.$GLOBALS['base_url'].'register/next?data='.$fb_data);
            }*/
        }

        if(isset($_SESSION["easyphp_sessionid"])) {
            $ifSessionExists = $this->model->checksession($_SESSION["easyphp_sessionid"]);
            if($ifSessionExists) {
                header("Location: ".$GLOBALS['ep_dynamic_url']."home");
                die();
            }
        }
        if(isset($_GET['redirecturl'])) {
            $_SESSION['redirecturl'] = $_GET['redirecturl'];
        }

        if (!empty($_POST)) {
            $data['post'] = $_POST;
            //including validation
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $password_again = $_POST['password_again'];
            $password = md5($password);
            $arrayData = array('email' => $email,'name'=>$name,'password'=>$password);
            $this->model->register($arrayData);  
        }
        $data['page_title'] = "Register";
        $data['view_page'] = "users/register.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];
        return $data;
    }
    public function next(){
        $data['post'] = $_POST;
        $data['fb_data'] = $_GET['fb_data'];
        print_r($data['fb_data']);
        $data['page_title'] = "Register";
        $data['view_page'] = "users/register_next.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];
        return $data;
    }
    public function checkDuplicateUsername($username) {
        $result = $this->model->checkifexists("WHERE username='$username'");
        return $result;
    }

    public function checkDuplicateEmail($email) {
        $result = $this->model->checkifexists("WHERE email='$email'");
        return $result;
    }
    public function facebookIdExists($id){
        return false;
    }

}