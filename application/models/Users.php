<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model
{

//    public function __construct(){
//        var_dump("asdasdasd");exit;
//    }

    public function login($login, $password)
    {

        $this->db->where('login', $login);
        $this->db->where('password', md5($password));
        $query = $this->db->get('users');

        if ($query->result_id->num_rows == 1) {
            return true;
        } else {
            return false;
        }


    }

    public function get_hotspots()
    {
        $this->db->distinct();
        $this->db->select('hotspot_id');

        $query = $this->db->get('requests');
        return $query->result();
    }

    public function get_hotspot($hotspot_id)
    {
        $this->db->select('login');


        $this->db->where('hotspot_id', $hotspot_id);
        $query = $this->db->get('requests');
        $result = $query->result();
        $sort = array();

        foreach ($result as $login) {
            array_push($sort, $login->login);
        }


        sort($sort);

        return $sort;

    }

    public function get_excel($from_time, $to_time)
    {

            $result = $this->db->query("SELECT * FROM requests WHERE UNIX_TIMESTAMP(login) BETWEEN '$from_time' AND '$to_time'");

            return $result->result_array();

    }

    public function delete($from_time, $to_time){

        $result = $this->db->query("DELETE FROM requests WHERE UNIX_TIMESTAMP(login) BETWEEN '$from_time' AND '$to_time'");
        redirect($_SERVER['HTTP_REFERER']);

    }

}