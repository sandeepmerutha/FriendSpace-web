<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 8/12/16
 * Time: 1:49 AM
 */

class auth_model extends DBconfig{

    public function __construct()
    {
        $connection = new DBconfig();
        $this->connection = $connection->connectToDatabase();
        $this->helper = new helper();
    }

    public function register($data){
        $final_data = array();
        $keys =  array_keys($data);
        foreach ($keys as $key){
            $values  = mysqli_real_escape_string($this->connection,$data[$key]);
            $final_data[$key] = $values;
        }
        $result = $this->helper->db_insert($final_data, "users");
        return $result;
    }

    public function update($data) {
        $final_data = array();
        $keys = array_keys($data);
        $SessionId = $_SESSION["easyphp_sessionid"];
        $resultRaw = $this->helper->db_select("user_id", "sessions", "WHERE sessionid='$SessionId'");
        $session_array = $resultRaw->fetch_assoc();
        $user_id = $session_array['user_id'];
        foreach($keys as $key) {
            //mysqli_real_escape_string used to avoid SQL injections
            $value = mysqli_real_escape_string($this->connection, $data[$key]);
            $final_data[$key] = $value;
        }
        $result = $this->helper->db_update($final_data, "users", "WHERE id='$user_id'");
        return $result;
    }

    public function checkifexists($where) {
        $result = $this->helper->check("users", $where);
        return $result;
    }

    public function login($email, $password,$remember="0"){
        $email = mysqli_real_escape_string($this->connection, $email);
        $password = mysqli_real_escape_string($this->connection, $password);
        $result = $this->helper->check("users", "WHERE email='$email' && password='$password'");
        if($result) {
            $sessionid = substr(md5(microtime()),rand(0,26),15);
            $resultRaw = $this->helper->db_select("*", "users", "WHERE email='$email' && password='$password'");
            $result = $resultRaw->fetch_assoc();
            $data = array('sessionid' => $sessionid, 'user_id' => $result['id'], 'device' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR']);
            $_SESSION["easyphp_sessionid"] = $sessionid;
            if($remember == "1") {
                $cookie_name = "tutbuzzeasyphpsessionid";
                $cookie_value = $sessionid;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }
            $this->helper->db_insert($data, "sessions");
        }
        return $result;
    }

    public function checksession($sessionid) {
        $result = $this->helper->check("sessions", "WHERE sessionid='$sessionid' ");
        return $result;
    }

    public function userDetails() {
        $SessionId = $_SESSION["easyphp_sessionid"];
        $resultRaw = $this->helper->db_select("user_id", "sessions", "WHERE sessionid='$SessionId'");
        $session_array = $resultRaw->fetch_assoc();
        $user_id = $session_array['user_id'];
        $resultRaw = $this->helper->db_select("*", "users", "WHERE id='$user_id'");
        $result = $resultRaw->fetch_assoc();
        return $result;
    }

    public function deleteSession() {
        $SessionId = $_SESSION["easyphp_sessionid"];
        $result = $this->helper->db_delete("sessions", "WHERE sessionid='$SessionId'");
        $_SESSION['redirecturl'] = "";
        session_destroy();
        if(!isset($_SESSION["easyphp_sessionid"]) || $result) {
            header("Location: ".$GLOBALS['ep_dynamic_url']."login");
            die();
        }
    }
    public function fb_login($data){
        print_r($data);
        die();
    }
    public function google_login($data){
        print_r($data);
        die();
    }
    public function twitter_login($data){
        print_r($data);
        die();
    }
    public function forgetPassword($email){
        $email = mysqli_real_escape_string($this->connection,$email);
        $temp_id = substr(md5(microtime()),rand(0,26),15);
        $data = array('temp_id' => $temp_id);
        $result = $this->helper->db_update($data, "users", "WHERE email='$email'");
        $resultRaw = $this->helper->db_select("name", "users", "WHERE email='$email'");
        $user_array = $resultRaw->fetch_assoc();
        $name = $user_array['name'];
        $baseurl = $GLOBALS['ep_base_url'];

        if($result) {
            $subject = "Forgot Password Request";
            $body = "Hi $name, <br/> Please click the following link for password reset - <br/> ".$baseurl."login/passwordreset/secret/$temp_id <br/> Thanks,";
            $alertmsg = "Password reset successfully requested, Please check your mail for more details";
            mail($email,$subject, $body,"premchandsaini779@gmail.com");
        }

        return $result;
    }

    public function changePassword($password) {
        $user_id = $_SESSION['easyphp_session_id'];
        $password = mysqli_real_escape_string($this->connection, $password);
        $password = md5($password);
        $data = array("password"=>$password);
        $result = $this->helper->db_update($data, "users", "WHERE user_id='$user_id'");
        return $result;
    }
}