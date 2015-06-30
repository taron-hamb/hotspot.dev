<?php
if (isset($_SESSION['login'])) {

    echo anchor(base_url() . 'user/logout', 'Log Out');


    echo '<br>Your login: ' . $_SESSION['login'] . '<br>';

    ?>
    <table>
        <tr>
            <th style="border: 1px solid #ccc">Hotspot_id</th>
        </tr>
    <?php foreach ($hotspot_id as $hotspot):?>
        <tr>

            <td style="border: 1px solid #ccc"><a href="<?=base_url(); ?>user/get_hotspots/<?= $hotspot->hotspot_id;?>"><?php echo $hotspot->hotspot_id ; ?></a></td>

        </tr>
    <?php endforeach;?>
<?php
}
?>