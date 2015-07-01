<?php
if(isset($_SESSION['login'])) {

    include_once('header.php');

    if (isset($from) && !empty($from)) {
        $from_time = strtotime($from[0]) - 60 * 60 * 24;
        $to_last = strtotime(end($from));
        $days = 14 * 24 * 60 * 60;
        $to_time = $from_time + $days;
        $now = strtotime('now');
        $to = date('Y-m-d',$to_time);
        $from =  date('Y-m-d',$from_time);
        if($to_time > $to_last){

            $to_time = $to_last;
        }
        ?>
        <div class="container">
            <div class="row log_out_panel">
                <div class="col-xs-9">
                    <a href="<?php echo base_url(); ?>user/index"><button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>Back</button></a>
                </div>
                <div class="col-xs-3 log_out">
                    <a href="<?php echo base_url(); ?>user/logout"><button type="submit" class="btn btn-default">Log Out</button></a>
                </div>
            </div>
            <table class="table table-striped">
<?php
        while($to_time <= $to_last){
?>
            <tr><td>
<?php
            $from =  date('Y-m-d',$from_time);
            $to = date('Y-m-d',$to_time);
            echo 'From '.$from.' To '.$to.'&nbsp;<a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Download Excel"><img src="/assets/img/excel.png" ></a>&nbsp;<a href="'.base_url().'user/get_csv/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Download CSV"><img src="/assets/img/csv.png"></a>&nbsp;<a href="'.base_url().'user/delete/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Delete"><img src="/assets/img/delete.png"></a><br>';
            $to_time += $days;
            $from_time += $days;
            if($to_time > $to_last){

                $to_time = $to_last;
            }
            if($from_time > $to_last){

                break;
            }
?>
                </td></tr>
<?php
        };
?>
            </table>
        </div>
<?php

    }else{

        redirect('/user/get_hotspot/');
    }

    include_once('footer.php');
}