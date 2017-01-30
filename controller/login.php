<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 1:48 AM
 */


class login{

    public function __construct()
    {
        $this->model = new auth_model();
    }
    public function index(){
        if (!empty($_POST)) {
            $data['post'] = $_POST;
            $email = $_POST['email'];
            $password = $_POST['password'];
            $remember = $_POST['remember'];
            $email = strip_tags($email);
            $password = strip_tags($password);
            $remember = strip_tags($remember);
            $password = md5($password);
            $result = $this->model->login($email, $password, $remember);
            if($result) {
                if(isset($_SESSION['redirecturl'])) {
                    header("Location: ".$_SESSION['redirecturl']);
                    die();
                }
                else {
                    header("Location: ".$GLOBALS['dynamic_url']."home");
                    die();
                }
            }
            else {
                $data['errors'] = array(array("Email and Password do not match, Please try again"));
            }
        }
        $data['page_title'] = "Login";
        $data['view_page'] = "users/login.php";
        $data['header'] = $GLOBALS['header'];
        $data['navbar'] = "false";
        $data['footer'] = $GLOBALS['footer'];

        return $data;
    }
    public function forgot(){
        if (!empty($_POST)) {
            $data['post'] = $_POST;
            $email = strip_tags($_POST['email']);
            $email = trim($email);
            $this->model->mail($email,"Forgot Password","Link");
            /*if ($this->emailExists($email)) {
                $data['result'] = $this->model;
            }
            else{
                $data['errors'] = array(array("Email Address Not Exists"));
            }*/
        }

        $data['page_title'] = "Forget Password";
        $data['view_page'] = "users/forgot.php";
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