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
<!--                --><?php
//                echo 'Your login: ' . $_SESSION['login'] ;
//                ?>
            </div>
            <div class="col-xs-3 log_out">
                <a href="<?php echo base_url(); ?>user/logout"><button type="submit" class="btn btn-default">Log Out</button></a>
            </div>

        </div>
            <?php
        ?>
        <table class="table table-striped">
            <tr>
                <th>Hotspot_id</th>
            </tr>
            <?php foreach ($hotspot_id as $hotspot):?>
            <tr>

                <td><a href="<?=base_url(); ?>user/get_hotspot/<?= $hotspot->hotspot_id;?>"><?php echo $hotspot->hotspot_id ; ?></a></td>

            </tr>
            <?php endforeach;?>
        </table>
    </div>
<?php
}
include_once('footer.php');