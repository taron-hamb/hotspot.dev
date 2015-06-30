<?php
if(isset($_SESSION['login'])) {

    if (isset($hotspots)) {

        foreach ($hotspots as $hotspot) {
            print_r($hotspot->id);
            echo '<br>';
        }
    }

}