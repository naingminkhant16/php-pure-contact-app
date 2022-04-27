<?php require "header.php" ?>
<div class="container" style="max-width: 600px;">
    <div class="row">
        <div class="col-12">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>My Contact</h5>
                    <span class="small">home/create contact</span>
                </div>
                <a href="index.php" class="btn btn-outline-primary">Home</a>
            </div>
            <?php
            
            if (isset($_POST['create'])) {
                if (contactCreate()) {
                    // echo alert("Contact successfully created.", "success");
                    echo redirect("index.php");
                }
                // else echo alert("Fail", "danger");
            }
            // print_r($_SESSION['error']);
            ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <div class="form-floating ">
                        <input type="text" name="name" value="<?= oldData('name') ?>" class="form-control" id="nameinput" placeholder="Your Name">
                        <label for="nameinput">Name</label>
                    </div>
                    <?= showErr("name") ?>
                </div>
                <div>
                    <div class="form-floating">
                        <input type="text" name="phone" class="form-control" value="<?= oldData('phone') ?>" id="phoneinput" placeholder="Your Phone">
                        <label for="phoneinput">Phone</label>
                    </div>
                    <?= showErr("phone") ?>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" name="create" class="btn btn-outline-primary">Save Contact</button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php require "footer.php" ?>