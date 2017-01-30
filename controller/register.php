<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 6:54 PM
 */


class register {

    public function __construct()
    {
        $this->model = new auth_model();
    }
    public function index(){
        $fb = new Facebook\Facebook([
            'app_id' => FB_APP_ID,
            'app_secret' => FB_APP_SECRET,
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $redirectUrl = FB_REDIRECT_URI;
        if(isset($_GET['type']) && $_GET['type'] == 'facebook' ){
            $fb_url = $helper->getLoginUrl($redirectUrl);
            header('Location: ' . $fb_url);
        }

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (isset($accessToken)) {
            $fb->setDefaultAccessToken($accessToken);
            try {
                $response = $fb->get('me?fields=id,name,birthday,gender');
                $userNode = $response->getGraphUser();
            }catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $fb_data = array();
            $fb_data['fb_id'] = $userNode->getId();
            $fb_data['name'] = $userNode->getName();
            $fb_data['dob'] = $userNode->getBirthday();
            $fb_data['gender'] = $userNode->getGender();
            $fb_data['location'] = $userNode->getLocation();
            $fb_data['register_status'] = '1';
            if ($this->fbIdExists($fb_data['fb_id'])){
                $userData = $this->model->userDetails();
                $_SESSION['easyphp_sessionid'] = $userData['user_id'];
                header("Location: ".$GLOBALS['ep_dynamic_url']."home");
            } else{
                $result = $this->model->register($fb_data);
                header("Location: ".$GLOBALS['ep_dynamic_url']."home");
                die();
            }
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
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $password = md5($password);
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $email_code = substr(md5(rand(0,9999)),10);
            $arrayData = array('email' => $email,'name'=>$name,'password'=>$password,'dob'=>$dob,'gender'=>$gender,'email_code'=>$email_code);
            if($this->model->register($arrayData)){
                header("Location: ".$GLOBALS['ep_dynamic_url']."home");
                die();
            }
            else{
                $data['errors'] = array(array("Some Error"));
            }
        }
        $data['page_title'] = "Register";
        $data['view_page'] = "users/register.php";
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
    public function fbIdExists($id){
        $result = $this->model->checkifexists("WHERE fb_id ='$id'");
        return $result;
    }

}