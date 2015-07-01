<?php
if(isset($_SESSION['login'])) {

    if (isset($from)) {

        $from_time = $from;
        $days = 14 * 24 * 60 * 60;
        $to_time = $from_time + $days;
        $now = strtotime('now');
        $to = date('Y-m-d',$to_time);

        while($to_time < $now){
            $from =  date('Y-m-d',$from_time);
            $to = date('Y-m-d',$to_time);
            echo 'From '.$from.' To '.$to.'&nbsp;<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/excel.png" style="height:25px;"></a>&nbsp;<a href="'.base_url().'user/get_csv/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/csv.png" style="height:25px;"></a><br>';
            $to_time += $days;
            $from_time += $days;
        };
        echo 'From '.$to.' To '.date('Y-m-d',$now).'&nbsp;<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/excel.png" style="height:25px;"></a>&nbsp;<a href="'.base_url().'user/get_csv/'.$from_time.'/'.$to_time.'/"><img src="/resources/img/csv.png" style="height:25px;"></a><br>';
    }
}
