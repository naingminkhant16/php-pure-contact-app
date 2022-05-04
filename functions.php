<?php
function alert($message, $color)
{
    return "<div class='alert alert-$color'>$message</div>";
}
function textFilter($input)
{
    // $input = trim($input);
    // $input = stripslashes($input);
    // $input = htmlentities($input, ENT_QUOTES);
    return htmlentities(stripslashes(trim($input)), ENT_QUOTES);
}
function contacts()
{
    if ($_GET['keyword']) {
        $keyword = textFilter($_GET['keyword']);
        $sql = "SELECT * FROM contacts WHERE name LIKE '%$keyword%' AND user_id={$_SESSION['auth']->id}";
    } else {
        $sql = "SELECT * FROM contacts WHERE user_id={$_SESSION['auth']->id}";
    }

    $query = mysqli_query($GLOBALS['connect'], $sql);
    $contacts = [];
    while ($row = mysqli_fetch_object($query)) {
        array_push($contacts, $row);
    }
    return $contacts;
}
function contact($id)
{
    $sql = "SELECT * FROM contacts WHERE id=$id";
    $query = mysqli_query($GLOBALS['connect'], $sql);
    return mysqli_fetch_object($query);
}
function storeFlashMessage($msg)
{
    $_SESSION['flashMessage'] = $msg;
}
function showFlashMessage()
{
    $message = $_SESSION['flashMessage'];
    unset($_SESSION['flashMessage']);
    return $message;
}
function storeErr($inputName, $message)
{
    $_SESSION['error'][$inputName] = $message;
}

function showErr($inputName)
{
    $message = $_SESSION['error'][$inputName];
    unset($_SESSION['error'][$inputName]);
    return "<p class='small text-danger'>{$message}</p> ";
}

function oldData($inputName, $default = null)
{
    if (!empty($_POST[$inputName])) {
        return $_POST[$inputName];
    }
    if ($default) {
        return $default;
    }
    return null;
}
function redirect($uri)
{
    return "<script>window.location.href='$uri'</script>";
}
function contactCreate()
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if (empty($name)) {
        storeErr("name", "Name is empty");
    } else {
        if (strlen($name) < 3) {
            storeErr("name", "Name is too short");
        } else {
            if (strlen($name) > 20) {
                storeErr("name", "Name is too long");
            } else {
                if (!preg_match("/^[A-Za-z ]*$/", $name)) {
                    storeErr("name", "Only Letter and space are allowed");
                }
            }
        }
    }

    if (empty($phone)) {
        storeErr("phone", "Phone is empty");
    } else {
        if (strlen($phone) < 8) {
            storeErr("phone", "Phone is too short");
        } else {
            if (strlen($phone) > 15) {
                storeErr("phone", "Phone is too long");
            } else {
                if (!preg_match("/^[0-9]*$/", $phone)) {
                    storeErr("phone", "Only Number is allowed");
                }
            }
        }
    }

    if (!empty($_SESSION['error'])) {
        return false;
    }
    $user_id = $_SESSION['auth']->id;
    $sql = "INSERT INTO contacts(user_id,name,phone) VALUES ('$user_id','$name','$phone')";
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
    unset($_POST);
    storeFlashMessage("Content is created successfully.");
    return true;
}

function contactDelete()
{
    $id = $_POST['id'];
    $user_id = $_SESSION['auth']->id;
    $sql = "DELETE FROM contacts WHERE id='$id' AND user_id='$user_id'";
    // die(var_dump(mysqli_query($GLOBALS['connect'], $sql)));
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
    return true;
}
function contactBulkDelete()
{
    $user_id = $_SESSION['auth']->id;
    $ids = join(',', $_POST['bulk_delete_ids']);

    $sql = "DELETE FROM contacts WHERE id in($ids) AND user_id='$user_id'";
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
    // storeFlashMessage("Successfully deleted contacts");
    return true;
}
function register()
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name)) {
        storeErr("name", "Name is empty");
    } else {
        if (strlen($name) < 3) {
            storeErr("name", "Name is too short");
        } else {
            if (strlen($name) > 20) {
                storeErr("name", "Name is too long");
            } else {
                if (!preg_match("/^[A-Za-z ]*$/", $name)) {
                    storeErr("name", "Only Letter and space are allowed");
                }
            }
        }
    }

    if (empty($email)) {
        storeErr("email", "Email is empty");
    } else {
        if (strlen($email) < 3) {
            storeErr("email", "email is too short");
        } else {
            if (strlen($email) > 20) {
                storeErr("email", "email is too long");
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    storeErr("email", "Invalid Email format");
                }
            }
        }
    }


    if (empty($password)) {
        storeErr("password", "password is empty");
    } else {
        if (strlen($password) < 8) {
            storeErr("password", "password is too short");
        } else {
            if (strlen($password) > 20) {
                storeErr("password", "password is too long");
            }
        }
    }

    if (!empty($_SESSION['error'])) {
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,password) VALUES ('$name','$email','$password')";
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
    unset($_POST);
    storeFlashMessage("Register successful.Login now.");
    return true;
}

function login()
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        storeErr("email", "email is empty");
    } else {
        if (strlen($email) < 3) {
            storeErr("email", "email is too short");
        } else {
            if (strlen($email) > 20) {
                storeErr("email", "email is too long");
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    storeErr("email", "Invalid Email format");
                }
            }
        }
    }

    if (empty($password)) {
        storeErr("password", "password is empty");
    } else {
        if (strlen($password) < 8) {
            storeErr("password", "password is too short");
        } else {
            if (strlen($password) > 20) {
                storeErr("password", "password is too long");
            }
        }
    }
    if (!empty($_SESSION['error'])) {
        return "Email or Password wrong";
    }
    $sql = "SELECT * FROM users WHERE email='$email'";
    $query = mysqli_query($GLOBALS['connect'], $sql);
    $row = mysqli_fetch_object($query);

    if (is_null($row)) {
        return "Email or Password wrong";
    };
    if (!password_verify($password, $row->password)) {
        return "Email or Password worng";
    }
    $_SESSION['auth'] = $row;

    return true;
}

function contactUpdate()
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $id = $_POST['id'];

    if (empty($name)) {
        storeErr("name", "Name is empty");
    } else {
        if (strlen($name) < 3) {
            storeErr("name", "Name is too short");
        } else {
            if (strlen($name) > 20) {
                storeErr("name", "Name is too long");
            } else {
                if (!preg_match("/^[A-Za-z ]*$/", $name)) {
                    storeErr("name", "Only Letter and space are allowed");
                }
            }
        }
    }

    if (empty($phone)) {
        storeErr("phone", "Phone is empty");
    } else {
        if (strlen($phone) < 8) {
            storeErr("phone", "Phone is too short");
        } else {
            if (strlen($phone) > 15) {
                storeErr("phone", "Phone is too long");
            } else {
                if (!preg_match("/^[0-9]*$/", $phone)) {
                    storeErr("phone", "Only Number is allowed");
                }
            }
        }
    }

    if (!empty($_SESSION['error'])) {
        return false;
    }

    $sql = "UPDATE contacts SET name='$name',phone='$phone' where id='$id'";
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
    unset($_POST);
    storeFlashMessage("Content is updated successfully.");
    return true;
}
