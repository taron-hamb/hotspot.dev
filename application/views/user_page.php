<?php

if (isset($_SESSION['login'])) {

    include_once('header.php');
?>

    <div class="container">
        <?php
        ?>
        <div class="row log_out_panel">
            <div class="col-xs-9">
                <h4>Your login: <?php echo $_SESSION['login'] ?></h4>
            </div>
            <div class="col-xs-3 log_out">
                <a href="<?php echo base_url(); ?>user/logout"><button type="submit" class="btn btn-success btn3d btn-md">Log Out</button></a>
<!--                <button type="button" class="btn3d btn btn-default btn-lg"><span class="glyphicon glyphicon-download-alt"></span> Default</button>-->
            </div>

        </div>
            <?php
        ?>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Hotspot_id</th>
            </tr>
            <?php foreach ($hotspot_id as $hotspot):?>
            <tr>

                <td class="text-primary"><a href="<?=base_url(); ?>user/get_hotspot/<?= $hotspot->hotspot_id;?>"><?php echo $hotspot->hotspot_id ; ?></a></td>

            </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php
    include_once('footer.php');
}