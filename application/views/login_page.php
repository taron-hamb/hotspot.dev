<?php
if(isset($_SESSION['login'])){

}
else{
    include_once('header.php');
?>

    <div class="text-center" style="padding:50px 0">
        <div class="logo">login</div>
        <!-- Main Form -->
        <div class="login-form-1">
            <form id="login-form" action="<?php echo base_url(); ?>user/login" method="post" class="text-left">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                    <div class="login-group">
                        <div class="form-group">
                            <label for="lg_username" class="sr-only">Username</label>
                            <input type="text" class="form-control" id="lg_username" name="login" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label for="lg_password" class="sr-only">Password</label>
                            <input type="password" class="form-control" id="lg_password" name="password" placeholder="password">
                        </div>

                    </div>
                    <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="etc-login-form">
                    <?php
                    if(isset($message)){
                        ?>
                       <?php echo $message ?>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
        <!-- end:Main Form -->
    </div>
<?php
    include_once('footer.php');
}
