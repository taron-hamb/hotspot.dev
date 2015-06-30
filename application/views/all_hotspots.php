<?php
if(isset($_SESSION['login'])) {

    if (isset($from)) {

        $from_time = $from;
        $days = 14 * 24 * 60 * 60;
        $to_time = $from_time + $days;
        $now = strtotime('now');

        while($to_time < $now){
            $from =  date('Y-m-d',$from_time);
            $to = date('Y-m-d',$to_time);
            echo '<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/">from_'.$from.'_to_'.$to.'</a><br>';
            $to_time += $days;
            $from_time += $days;
        };
        echo '<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/">from_'.$to.'_to_'.date('Y-m-d',$now).'</a><br>';

    }

}
