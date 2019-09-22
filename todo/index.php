<?php
require_once 'include/func.php';

$isLogged = login();

if((!$isLogged || $isLogged < 0) && !isset($_GET['register'])){
    if($isLogged == -1)
        $incorrectPassword = true;
    include 'include/login.php';
}
elseif((!$isLogged || $isLogged < 0) && isset($_GET['register'])) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && 
        is_string($_POST['username']) && is_string($_POST['password']) && is_string($_POST['password2'])){
        if(userExistByUsername($_POST['username'])){
            $usernameExist = true;
            include 'include/register.php';
        }
        elseif($_POST['password'] !== $_POST['password2']){
            $invalidPasswords = true;
            include 'include/register.php';
        }
        else{
            createUser($_POST['username'], $_POST['password']);
            header("Location: ?login");
        }
    }
    else
        include 'include/register.php';
}
elseif($isLogged > 0 && userExistById($isLogged)){
    if(isset($_GET['logout'])){
        unset($_SESSION['id']);
        header("Location: ?login");
    }
    
    elseif(isset($_GET['api']))
        include 'include/api.php';
    else{
        if(isset($_POST['username']))
            header("Location: ?todo");
        include 'include/todo.php';
    }
}
elseif(!userExistById($isLogged)){
    unset($_SESSION['id']);
    include 'include/login.php';
}
else
    die("Error!");