<?php
if(isset($_SESSION['login'])) {

    if (isset($hotspots)) {

        foreach ($hotspots as $hotspot) {
           echo $hotspot->hotspot_id;
            echo '<br>';
        }
    }

}