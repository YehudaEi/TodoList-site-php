<?php
if(!defined('TODO')) die('access denied');

session_start();

define('DB', array('host' => 'localhost', 'username' => 'todo', 'password' => '', 'dbname' => 'todo'));
define('JS_VERSION', '1.1');

$DBConn = new mysqli(DB['host'], DB['username'], DB['password'], DB['dbname']);
mysqli_set_charset($DBConn, "utf8mb4");

function cleanString($str){
    global $DBConn;
    
    return trim($DBConn->real_escape_string($str));
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
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `isArchive` = "0" AND `isDeleted` = "0" AND `todo_user_id` = "'.cleanString($id).'" ORDER BY `todo`.`id_in_column` ASC;');
    
    return $res->fetch_all();
}

function getArchiveTodoByUserId($id){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `isArchive` = "1" AND `isDeleted` = "0" AND `todo_user_id` = "'.cleanString($id).'" ORDER BY `todo`.`id_in_column` ASC;');
    
    return $res->fetch_all();
}

function getTodo($userId, $todoId){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `todo_id` = "'.cleanString($todoId).'" AND  `todo_user_id` = "'.cleanString($userId).'";');
    
    return $res->fetch_array();
}

function todoShellUser($userId, $todoId){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `todo_id` = "'.cleanString($todoId).'" AND  `todo_user_id` = "'.cleanString($userId).'";');
    
    return $res->num_rows > 0 ? true : false;
}

function deleteTodo($id){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `isDeleted` = "1" WHERE `todo_id` = "'.cleanString($id).'";');
}

function archiveTodo($id){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `isArchive` = "1" WHERE `todo_id` = "'.cleanString($id).'";');
}

function unArchiveTodo($id){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `isArchive` = "0" WHERE `todo_id` = "'.cleanString($id).'";');
}

function moveTodo($id, $newType){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `type` = "'.cleanString($newType).'" WHERE `todo_id` = "'.$id.'";');
}

function setIdInColumn($id, $newId){
    global $DBConn;
    
    $DBConn->query('UPDATE `todo` SET `id_in_column` = "'.cleanString($newId).'" WHERE `todo_id` = "'.$id.'";');
}

function editTodo($userId, $id, $title, $description, $tags){
    global $DBConn;
    
    $res = $DBConn->query('SELECT * FROM `todo` WHERE `todo_id` = "'.cleanString($id).'" AND `todo_user_id` = "'.cleanString($userId).'";');
    $res = $res->fetch_array();
    
    if($res['isDeleted']) return;
    
    if($res['title'] != $title)
        $DBConn->query('UPDATE `todo` SET `title` = "'.cleanString($title).'" WHERE `todo_id` = "'.cleanString($id).'";');
    if($res['description'] != $description)
        $DBConn->query('UPDATE `todo` SET `description` = "'.cleanString($description).'" WHERE `todo_id` = "'.cleanString($id).'";');
    if($res['tags'] != $tags)
        $DBConn->query('UPDATE `todo` SET `tags` = "'.cleanString($tags).'" WHERE `todo_id` = "'.cleanString($id).'";');
    
}

function newTodo($userId, $title, $description, $tags){
    global $DBConn;
    
    $DBConn->query("INSERT INTO `todo` (`todo_id`, `todo_user_id`, `id_in_column`, `type`, `title`, `description`, `tags`, `isDeleted`, `isArchive`, `date`) VALUES 
                    (NULL, '".$userId."', '0', 'todo', '".cleanString($title)."', '".cleanString($description)."', '".cleanString($tags)."', '0', '0', CURRENT_TIMESTAMP);");
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
    
    if(strlen(trim($username)) > 50 || strlen(trim($username)) > 50)
        return -2;
    
    if(!empty(trim($username)) && !empty(trim($username))){
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
 