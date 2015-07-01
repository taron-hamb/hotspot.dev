<?php
if(isset($_SESSION['login'])){

}
else{
//    include_once('header.php');
?>
<div class="container">
    <form action="<?php echo base_url(); ?>user/login" method="post" >
        <table>
            <tr><td><input name="login" type="text" placeholder="Login"/></td></tr>
            <tr><td><input name="password" type="password" placeholder="Password"/></td></tr>
            <tr><td><input type="submit" value="Log In"/></td></tr>
            <?php
            if(isset($message)){
            ?>
            <tr><td><?php echo $message ?></td></tr>
            <?php
            }
            ?>
        </table>
    </form>
</div>
<?php
}