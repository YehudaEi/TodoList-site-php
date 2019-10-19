<?php
define('TODO', 1);

require_once 'include/func.php';

$isLogged = login();

if((!$isLogged || $isLogged < 0) && !isset($_GET['register'])){
    if($isLogged == -1)
        $message = "שם המשתמש או הסיסמה שגויים!";
    elseif($isLogged == -2)
        $message = "שם המשתמש או הסיסמה ארוכים מידי";
    
    include 'include/login.php';
}
elseif((!$isLogged || $isLogged < 0) && isset($_GET['register'])) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && 
        is_string($_POST['username']) && is_string($_POST['password']) && is_string($_POST['password2'])){
        
        if(strlen($_POST['username']) > 50){
            $message = "שם המשתמש ארוך מידי...";
        }
        elseif(strlen($_POST['password']) > 50 || strlen($_POST['password2']) > 50){
            $message = "הסיסמה ארוכה מידי...";
        }
        elseif(userExistByUsername($_POST['username'])){
            $message = "שם המשתמש כבר קיים במערכת";
        }
        elseif($_POST['password'] !== $_POST['password2']){
            $message = "הסיסמאות אינן תואמות";
        }
        else{
            createUser($_POST['username'], $_POST['password']);
            header("Location: ?login");
            die();
        }
        include 'include/register.php';
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