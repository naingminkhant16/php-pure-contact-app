<?php require "header.php";
if (empty($_SESSION['auth'])) {
    echo redirect("login.php");
}

$contact = contact($_GET['id']);
if (isset($_POST['update'])) {
    if (contactUpdate()) {
       echo redirect("index.php");
    }
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>My Contact</h5>
                    <span class="small">home/<?= $contact->name ?>/Edit</span>
                </div>
                <a href="index.php" class="btn btn-outline-primary">Home</a>
            </div>

            <form action="" method="POST">
                <input type="hidden" name="id" value="<?= $contact->id ?>">
                <div class="mb-3">
                    <div class="form-floating ">
                        <input type="text" name="name" value="<?= oldData('name', $contact->name) ?>" class="form-control" id="nameinput" placeholder="Your Name">
                        <label for="nameinput">Name</label>
                    </div>
                    <?= showErr("name") ?>
                </div>
                <div>
                    <div class="form-floating">
                        <input type="text" name="phone" class="form-control" value="<?= oldData('name', $contact->phone) ?>" id="phoneinput" placeholder="Your Phone">
                        <label for="phoneinput">Phone</label>
                    </div>
                    <?= showErr("phone") ?>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" name="update" class="btn btn-outline-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>
<?php require "footer.php" ?>