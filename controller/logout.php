<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 8:34 PM
 */

class logout{

    public function __construct()
    {
        $this->model = new auth_model();
    }

    public function index(){
        $this->model->deleteSession();
        $data['ep_title'] = "Logout";
        $data['view_page'] = "false";
        $data['ep_header'] = "false";
        $data['ep_footer'] = "false";
    }
}