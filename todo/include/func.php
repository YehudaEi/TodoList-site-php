<?php

session_start();

define('DB', array('host' => 'localhost', 'username' => 'todo', 'password' => '', 'dbname' => 'todo'));

$DBConn = new mysqli(DB['host'], DB['username'], DB['password'], DB['dbname']);
mysqli_set_charset($DBConn, "utf8mb4");

function cleanString($str){
    global $DBConn;
    
    return $DBConn->real_escape_string($str);
}

function userExistById($id){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `users` WHERE `user_id` = '.$id.';');
    
    return $res->num_rows > 0 ? true : false;
}

function userExistByUsername($username){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `users` WHERE `username` = "'.cleanString($username).'";');
    
    return $res->num_rows > 0 ? true : false;
}

function getTodoByUserId($id){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `todo_user_id` = "'.$id.'";');
    
    return $res->fetch_all();
}

function todoShellUser($userId, $todoId){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `todo_id` = "'.cleanString($todoId).'" AND  `todo_user_id` = "'.cleanString($userId).'";');
    
    return $res->num_rows > 0 ? true : false;
}

function deleteTodo($id){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `isDeleted` = "1" WHERE `todo_id` = "'.$id.'";');
}

function moveTodo($id, $newType){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `type` = "'.cleanString($newType).'" WHERE `todo_id` = "'.$id.'";');
}

function newTodo($userId, $title, $description, $tags){
    global $DBConn;
    
    $DBConn->query("INSERT INTO `todo` (`todo_id`, `todo_user_id`, `type`, `title`, `description`, `tags`, `isDeleted`, `date`) VALUES 
                    (NULL, '".$userId."', 'todo', '".cleanString($title)."', '".cleanString($description)."', '".cleanString($tags)."', '0', CURRENT_TIMESTAMP);");
}

function createUser($username, $password){
    global $DBConn;
    
    $DBConn->query("INSERT INTO `users` (`user_id`, `username`, `password`) VALUES (NULL, '".cleanString(strtolower($username))."', '".cleanString(password_hash($password, PASSWORD_DEFAULT))."');");
}

function login(){
    global $DBConn;
    
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    
    if(!isset($_SESSION['id']) && ($username == null || $password == null))
        return false;
    
    if(isset($_SESSION['id']))
        return $_SESSION['id'];
    
    if(isset($_GET['register']))
        return false;
    
    if(!empty($username) && !empty($password)){
        $res = $DBConn->query('SELECT * FROM `users` WHERE `username` = "'.cleanString(strtolower($username)).'";');
        $res = $res->fetch_array();
        
        if(password_verify($password, $res['password'])){
            $_SESSION['id'] = $res['user_id'];
            
            return $res['user_id'];
        }
        else
            return -1;
    }
    
    return false;
}
 