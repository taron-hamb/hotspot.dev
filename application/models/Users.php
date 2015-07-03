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
        $result = $query->result_array();

        if ($result) {
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
        $from_time = str_replace('%20',' ',$from_time);
        $to_time = str_replace('%20',' ',$to_time);
        $result = $this->db->query("SELECT * FROM requests WHERE login >= '$from_time' AND login <= '$to_time'");

        return $result->result_array();

    }

    public function get_one_item($time){

       $this->db->where('login',$time);
        $result = $this->db->get('requests');
        return $result->result_array();
    }

    public function delete($from_time, $to_time){

        $from_time = str_replace('%20',' ',$from_time);
        $to_time = str_replace('%20',' ',$to_time);
//        var_dump($rep_time);
//        exit;
        $this->db->query("DELETE FROM requests  WHERE login >= '$from_time' AND login <= '$to_time'");
//        print_r($from_time);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hotspot_request($count,$hotspot_id){

        $now = date('Y-m-d H:i:s');

        $browser = ['iPhone/Safari','Windows/Chrome','Linux/Chrome'];
        $email = 'abcdefghijklmnopqrstuvwxyz';
        for($i = 1;$i < $count;$i = $i + 7){
            $em_shuff = str_shuffle($email);
            $em = substr($em_shuff,0,7);
            shuffle($browser);
            $time = strtotime($now) + $i*18*54*36;
            $data['login'] = date('Y-m-d H:i:s',$time);
            $data['email'] = $em.'@gmail.com';
            $data['hotspot_id'] = $hotspot_id;
            $data['mac_address'] = 'D4:F4:6F:E4:03:DD';
            $data['browser'] = $browser[0];

            $this->db->insert('requests',$data);
        }
        header('Location: /');
    }

}