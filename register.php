<?php require "header.php" ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>Account Register</h5>
                    <span class="small">home/register</span>
                </div>
                <a href="login.php" class="btn btn-outline-primary">Login</a>
            </div>
            <?php
            if (isset($_POST['register'])) {
                if (register()) {
                    echo redirect("login.php");
                }
            }
            ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" class="form-control" name="name" value="<?= oldData('name') ?>">
                    <?= showErr('name') ?>
                </div>
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
                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require "footer.php" ?>