<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller{

    public function index()
    {
        $this->load->view('form');
    }

    public function add_request()
    {
        if(!empty($_POST)){

            $login = $_POST['LOGIN'];
            $email = $_POST['Email'];
            $hotspot_id = $_POST['HOTSPOT_ID'];
            $mac_address = $_POST['MAC_ADDRESS'];
            $browser = $_POST['BROWSER'];

            $result = $this->db->query("INSERT INTO requests (login,email,hotspot_id,mac_address,browser) VALUES ('$login','$email','$hotspot_id','$mac_address','$browser')");

            if($result){
                echo 'Complete insert';
            }



        }

    }

}