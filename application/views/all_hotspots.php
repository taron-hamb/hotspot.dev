<?php
if(isset($_SESSION['login'])) {

    if (isset($from)) {
        $from_time = strtotime($from[0]) - 60 * 60 * 24;
        $to_last = strtotime(end($from));
        $days = 14 * 24 * 60 * 60;
        $to_time = $from_time + $days;
        $now = strtotime('now');
        $to = date('Y-m-d',$to_time);
        $from =  date('Y-m-d',$from_time);

        while($to_time <= $now){

            $from =  date('Y-m-d',$from_time);
            $to = date('Y-m-d',$to_time);
            echo 'From '.$from.' To '.$to.'&nbsp;<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/excel.png" style="height:25px;"></a>&nbsp;<a href="'.base_url().'user/get_csv/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/csv.png" style="height:25px;"></a>&nbsp;<a href="'.base_url().'user/delete/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/delete.png" style="height:25px;"></a><br>';
            $to_time += $days;
            $from_time += $days;
            if($to_time > $to_last){

                $to_time = $to_last;
            }
            if($from_time > $to_last){

                break;
            }

        };


    }

}
