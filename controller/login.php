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
        if(isset($_SESSION["sessionid"])) {
            $ifSessionExists = $this->model->checksession($_SESSION["sessionid"]);
            if($ifSessionExists) {
                header("Location: ".$GLOBALS['dynamic_url']."home");
                die();
            }
        }
        else if(isset($_COOKIE['friendspacecreatedbypcsaini'])) {
            $ifCookieExists = $this->model->checksession($_COOKIE['friendspacecreatedbypcsaini']);
            if($ifCookieExists) {
                $_SESSION["sessionid"] = $_COOKIE['friendspacecreatedbypcsaini'];
                header("Location: ".$GLOBALS['dynamic_url']."home");
                die();
            }
        }
        else {
            $_SESSION["sessionid"] = "";
        }
        if(isset($_GET['redirecturl'])) {
            $_SESSION['redirecturl'] = $_GET['redirecturl'];
        }
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
    public function forget(){
        if (!empty($_POST)) {
            $data['post'] = $_POST;
            $email = strip_tags($_POST['email']);
            $email = trim($email);
            if ($this->emailExists($email)) {
                $data['result'] = $this->model->forgetPassword($email);
            }
            else{
                $data['errors'] = array(array("Email Address Not Exists"));
            }
        }

        $data['page_title'] = "Forget Password";
        $data['view_page'] = "users/forget.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];

        return $data;
    }

    public function recoverPassword($temp_id){

       if (!empty($_POST)){
            $password = $_POST['password'];
            $password = trim(strip_tags($password));
            if ($this->model->resetPassword($temp_id,$password)){
                header("Location: ".$GLOBALS['dynamic_url']."home");
                die();
            }
            else{
                $data['errors'] = array(array("Some Errors in Mail"));
            }

        }
        $data['temp_id'] = $temp_id;
        $data['page_title'] = "Recover Password";
        $data['view_page'] = "users/recover_password.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];

        return $data;
    }

    public function changePassword(){
        $this->authcheck = new authcheck();
        if (!empty($_POST)) {
            $userdata = $this->model->userDetails();
            $current_password = trim(strip_tags($_POST['current_password']));
            $password = trim(strip_tags($_POST['password']));
            if ($userdata['password'] != md5($current_password)){
                $data['errors'] = array(array("Wrong Current Password"));
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
        $result = $this->model->checkifexists("WHERE email='$email'");
        return $result;
    }
}