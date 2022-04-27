<?php require "header.php" ?>
<div class="container" style="max-width: 600px;">
    <div class="row">
        <div class="col-12">
            <div class="my-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5>My Contact</h5>
                    <span class="small">home</span>
                </div>
                <a href="create.php" class="btn btn-outline-primary">Create</a>
            </div>
            <?php
            // if(isset($_POST['del'])){
            if (!empty($_SESSION['flashMessage'])) {
                echo alert(showFlashMessage(), "success");
            }
            if (isset($_POST['del'])) {
                if (contactDelete()) echo alert("Contact successfully deleted.", "success");
                else echo alert("Fail", "danger");
            }
            // }
            ?>
            <ul class="list-group">
                <?php foreach (contacts() as $contact) : ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 h4"><?= $contact->name ?></p>
                                <p class="mb-0 text-black-50"><?= $contact->phone ?></p>
                            </div>
                            <div>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?= $contact->id ?>">
                                    <button name="del" onclick="return confirm('Are u sure u wanna delete?')" class="btn btn-sm btn-outline-danger">Delete</button>
                                    <i class="fas fa-trash text-danger"></i>
                                </form>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>
<?php require "footer.php" ?>