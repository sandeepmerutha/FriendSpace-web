<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 31/1/17
 * Time: 12:35 PM
 */
class home_model extends DBconfig {

    public function __construct()
    {
        $connection = new DBconfig();
        $this->connection = $connection->connectToDatabase();
    }
}