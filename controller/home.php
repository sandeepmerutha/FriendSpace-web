<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 12:32 PM
 */
class home extends authcheck{

    public function __construct()
    {
        $this->model = new auth_model();
        $this->authcheck = new authcheck();
        $this->sessionid = $_SESSION["sessionid"];
    }
    public function index(){
        $userdata = $this->model->userDetails();
        $data['userdata'] = $userdata;
        $data['page_title'] = "Dashboard";
        $data['view_page'] = "users/home.php";
        $data['header'] = $GLOBALS['header'];
        $data['footer'] = $GLOBALS['footer'];
        return $data;
    }
}