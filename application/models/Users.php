<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {

//    public function __construct(){
//        var_dump("asdasdasd");exit;
//    }

    public function login($login,$password)
    {

        $this->db->where('login', $login);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
//        echo "<pre>";
//var_dump($query->result_id->num_rows);exit;
        if($query->result_id->num_rows == 1)
        {
            return true;
        }
        else
        {
            return false;
        }


    }

}
