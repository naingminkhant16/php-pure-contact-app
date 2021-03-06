<?php
require "header.php";
if (empty($_SESSION['auth'])) {
    echo redirect("login.php");
}
?>
<div class="container">
    <div class="row justify-content-center my-2">
        <div class="col-lg-6">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>My Contact</h5>
                    <span class="small">home / login as <?= $_SESSION['auth']->name ?></span>
                </div>

                <a href="create.php" class="btn btn-outline-primary"><i class="fas fa-plus"></i></a>
            </div>
            <?php
            if (!empty($_SESSION['flashMessage'])) {
                echo alert(showFlashMessage(), "success");
            }
            if (isset($_POST['del'])) {
                if (contactDelete()) echo alert("Contact successfully deleted.", "danger");
                else echo alert("Fail", "danger");
            }
            if (isset($_POST['bulk_delete_button'])) {
                echo  contactBulkDelete() ? alert("Successfullt deleted contacts", 'warning') : '';
            }

            ?>
            <form action="" method="POST" id="bulk_delete"></form>

            <ul class="list-group">
                <?php foreach (contacts() as $contact) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <!-- <div class=""> -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="contact<?=$contact->id?>" form="bulk_delete" name="bulk_delete_ids[]" value="<?= $contact->id ?>">
                                <label class="form-check-label" for="contact<?=$contact->id?>">
                                    <?= $contact->name ?><br>
                                    <span class="small text-black-50"><?= $contact->phone ?></span>
                                </label>
                            </div>
                            <div class="">
                                <a href="edit.php?id=<?= $contact->id ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a>
                                <form action="" class="d-inline-block" method="POST">
                                    <input type="hidden" name="id" value="<?= $contact->id ?>">
                                    <button name="del" onclick="return confirm('Are u sure u wanna delete?')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash text-danger"></i></button>
                                    
                                </form>
                            </div>
                        <!-- </div> -->
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="d-flex justify-content-between  mt-3">
                <button type="submit" form="bulk_delete" class="btn btn-outline-danger" name="bulk_delete_button">Delete Selected</button>
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Search...">
                        <button class="btn btn-outline-secondary">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require "footer.php" ?>