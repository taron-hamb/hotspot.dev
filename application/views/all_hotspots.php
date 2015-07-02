<?php
if(isset($_SESSION['login'])) {

    include_once('header.php');

    if (isset($from_to_times) && !empty($from_to_times)) {

        ?>
        <div class="container">
            <div class="row log_out_panel">
                <div class="col-xs-9">
                    <a href="<?php echo base_url(); ?>user/index"><button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>Back</button></a>
                </div>
                <div class="col-xs-3 log_out">
                    <a href="<?php echo base_url(); ?>user/logout"><button type="submit" class="btn btn-success">Log Out</button></a>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered">

<?php

        foreach ($from_to_times as $from_to_time) {
?>
            <tr>
<?php
                $from = $from_to_time['from'];
                $to =  $from_to_time['to'];
                $from_time = strtotime($from);
                $to_time = strtotime($to);
                echo '<td class="text-primary">From '.$from.' To '.$to.'&nbsp;</td><td class="icons_td"><a href="'.base_url().'user/get_excel/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Download Excel"><i class="fa fa-file-excel-o fa-2x text-success"></i></a></td><td class="icons_td"><a href="'.base_url().'user/get_csv/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Download CSV"><i class="fa fa-file-text fa-2x text-primary"></i></a></td>&nbsp;<td class="icons_td"><a href="'.base_url().'user/delete/'.$from_time.'/'.$to_time.'/" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times fa-2x text-danger"></i></a></td>';

?>
            </tr>
<?php
        }
?>
            </table>
        </div>
<?php

    }else{

        redirect('/user/get_hotspot/');
    }

    include_once('footer.php');
}