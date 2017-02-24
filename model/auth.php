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
        $SessionId = $_SESSION["sessionid"];
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
        $result = $this->helper->check("users", "WHERE email='$email' OR username='$email' && password='$password'");
        if($result) {
            $sessionid = substr(md5(microtime()),rand(0,26),15);
            $resultRaw = $this->helper->db_select("*", "users", "WHERE email='$email' OR username='$email' && password='$password'");
            $result = $resultRaw->fetch_assoc();
            $data = array('sessionid' => $sessionid, 'user_id' => $result['id'], 'device' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR']);
            $_SESSION["sessionid"] = $sessionid;
            if($remember == "1") {
                $cookie_name = "friendspacecreatedbypcsaini";
                $cookie_value = $sessionid;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
            }
            $this->helper->db_insert($data, "sessions");
        }
        return $result;
    }


    public function loginWithFb($fb_id){
        $sessionid = substr(md5(microtime()),rand(0,26),15);
        $resultRaw = $this->helper->db_select("*", "users", "WHERE fb_id='$fb_id'");
        $result = $resultRaw->fetch_assoc();
        $data = array('sessionid' => $sessionid, 'user_id' => $result['id'], 'device' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR']);
        $_SESSION["sessionid"] = $sessionid;
        $result = $this->helper->db_insert($data, "sessions");
        return $result;
    }

    public function loginEmail($email){
        $sessionid = substr(md5(microtime()),rand(0,26),15);
        $resultRaw = $this->helper->db_select("*", "users", "WHERE email='$email'");
        $result = $resultRaw->fetch_assoc();
        $data = array('sessionid' => $sessionid, 'user_id' => $result['id'], 'device' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR']);
        $_SESSION["sessionid"] = $sessionid;
        $result = $this->helper->db_insert($data, "sessions");
        return $result;
    }

    public function checksession($sessionid) {
        $result = $this->helper->check("sessions", "WHERE sessionid='$sessionid' ");
        return $result;
    }

    public function userDetails() {
        $SessionId = $_SESSION["sessionid"];
        $resultRaw = $this->helper->db_select("user_id", "sessions", "WHERE sessionid='$SessionId'");
        $session_array = $resultRaw->fetch_assoc();
        $user_id = $session_array['user_id'];
        $resultRaw = $this->helper->db_select("*", "users", "WHERE id='$user_id'");
        $result = $resultRaw->fetch_assoc();
        return $result;
    }

    public function deleteSession() {
        $SessionId = $_SESSION["sessionid"];
        $result = $this->helper->db_delete("sessions", "WHERE sessionid='$SessionId'");
        $_SESSION['redirecturl'] = "";
        session_destroy();
        if(!isset($_SESSION["sessionid"]) || $result) {
            header("Location: ".$GLOBALS['dynamic_url']."login");
            die();
        }
    }

    public function forgetPassword($email){
        $email = mysqli_real_escape_string($this->connection,$email);
        $temp_id = substr(md5(microtime()),rand(0,26),15);
        $data = array('temp_id' => $temp_id);
        $result = $this->helper->db_update($data, "users", "WHERE email='$email'");
        $resultRaw = $this->helper->db_select("name", "users", "WHERE email='$email'");
        $user_array = $resultRaw->fetch_assoc();
        $name = $user_array['name'];
        $baseurl = $GLOBALS['base_url'];

        if($result) {

            $subject = "Forgot Password Request";
            $body = "Hi $name, <br/> Please click the following link for password reset - <br/> ".$baseurl."login/recoverPassword/secret/$temp_id <br/> Thanks";

            if ($this->mail($email,$subject,$body)){

                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function resetPassword($tempId,$password){
        $tempId = mysqli_real_escape_string($this->connection,$tempId);
        $password = mysqli_real_escape_string($this->connection,$password);

        $password = md5($password);
        $data = array("password"=>$password);
        $result = $this->helper->db_update($data, "users", "WHERE temp_id='$tempId'");
        return $result;

    }

    public function activate($email,$email_code){
        $email = mysqli_real_escape_string($this->connection,$email);
        $email_code = mysqli_real_escape_string($this->connection,$email_code);
        $data = array('register_status'=>1);
        $result = $this->helper->db_update($data,'users',"WHERE email='$email' AND email_code='$email_code'");
        return $result;
    }

    public function changePassword($password) {
        $SessionId = $_SESSION["sessionid"];
        $resultRaw = $this->helper->db_select("user_id", "sessions", "WHERE sessionid='$SessionId'");
        $session_array = $resultRaw->fetch_assoc();
        $user_id = $session_array['user_id'];
        $password = mysqli_real_escape_string($this->connection, $password);
        $password = md5($password);
        $data = array("password"=>$password);
        $result = $this->helper->db_update($data, "users", "WHERE id='$user_id'");
        return $result;
    }

    public function mail($to,$subject,$body){
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );                                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'friendspace779@gmail.com';                   // SMTP username
        $mail->Password = 'Friend@779';               // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
        $mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('friendspace779@gmail.com', 'Friend Space');     //Set who the message is to be sent from
        $mail->addReplyTo('friendspace779@gmail.com', 'Friend Space');  //Set an alternative reply-to address
        //$mail->addAddress('josh@example.net', 'Josh Adams');  // Add a recipient
        $mail->addAddress($to);               // Name is optional
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        //$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/usr/labnol/file.doc');         // Add attachments
        //$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

        if(!$mail->send()) {
            return false;
        }
        return true;
    }
}