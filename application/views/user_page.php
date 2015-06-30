<?php
if(isset($_SESSION['login'])){

echo anchor(base_url().'user/logout', 'Log Out');


echo '<br>Your login: '.$_SESSION['login'].'<br>';

echo anchor(base_url().'user/get_hotspots', 'All HotSpots');
}