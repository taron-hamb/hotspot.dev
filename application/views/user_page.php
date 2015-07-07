<?php

if (isset($_SESSION['login'])) {

    include_once('header.php');
?>

    <div class="container">
        <?php
        ?>
        <div class="row log_out_panel">
            <div class="col-xs-12 log_out">
                <a href="<?php echo base_url(); ?>user/logout"><button type="submit" class="btn btn-success btn3d btn-md">Log Out</button></a>
            </div>

        </div>
            <?php
        ?>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Hotspot ID</th>
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