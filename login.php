<?php
require "header.php";
if (!empty($_SESSION['auth'])) {
    unset($_SESSION['auth']);
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>Account Login</h5>
                    <span class="small">home</span>
                </div>

                <a href="register.php" class="btn btn-outline-primary">Register</a>
            </div>
            <?php
            if (!empty($_SESSION['flashMessage'])) {
                echo alert(showFlashMessage(), "success");
            }
            if (isset($_POST['login'])) {
                $login = login();
                if ($login === true) {
                    echo redirect("dashboard.php");
                } else {
                    echo alert($login, "danger");
                }
            }
            ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Your Email</label>
                    <input type="text" class="form-control" name="email" value="<?= oldData('email') ?>">
                    <?= showErr('email') ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Your Password</label>
                    <input type="password" class="form-control" name="password">
                    <?= showErr('password') ?>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require "footer.php" ?>