<?php
function alert($message, $color)
{
    return "<div class='alert alert-$color'>'$message'</div>";
}

function contacts()
{
    $sql = "SELECT * FROM contacts";
    $query = mysqli_query($GLOBALS['connect'], $sql);
    $contacts = [];
    while ($row = mysqli_fetch_object($query)) {
        array_push($contacts, $row);
    }
    return $contacts;
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

function oldData($inputName)
{
    if (isset($_POST[$inputName])) {
        return $_POST[$inputName];
    }
    return "";
}
function redirect($uri)
{
    return "<script>location.href='$uri'</script>";
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
    $sql = "INSERT INTO contacts(name,phone) VALUES ('$name','$phone')";
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

    $sql = "DELETE FROM contacts WHERE id='$id'";
    if (!mysqli_query($GLOBALS['connect'], $sql)) {
        return false;
    }
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
