<?php

if(!empty($_POST)){

    $login = $_POST['LOGIN'];
    $email = $_POST['Email'];
    $hotspot_id = $_POST['HOTSPOT_ID'];
    $mac_address = $_POST['MAC_ADDRESS'];
    $browser = $_POST['BROWSER'];

    $link =  mysql_connect('localhost','root','');
    $connect = mysql_select_db('hotspot', $link);
    if($connect){

        $query = "INSERT INTO requests (login,email,hotspot_id,mac_address,browser) VALUES ('$login','$email','$hotspot_id','$mac_address','$browser')";
        $result = mysql_query($query);
        if($result){
            echo 'Complete insert';
        }

    }

}
