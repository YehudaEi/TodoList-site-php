<?php
if(!defined('TODO')) die('access denied');


$method = $_GET['method'] ?? null;
$userId = $isLogged;

if($method == "get"){
    $data = getTodoByUserId($userId);
    
    $newData = array(
        "todo" => array(),
        "doing" => array(),
        "done" => array(),
        "count" => 0
    );
    
    foreach ($data as $dat){
        $id = $dat[0];
        $type = $dat[2];
        $title = htmlspecialchars($dat[3]);
        $description = nl2br(htmlspecialchars($dat[4]));
        $ttags = json_decode($dat[5], true);
        $isDeleted = $dat[6];
        $date = $dat[7];
        
        if($isDeleted == 0){
            $tags = array();
            foreach ($ttags as $tag){
                $tag['name'] = htmlspecialchars($tag['name']);
                $tag['type'] = htmlspecialchars($tag['type']);
                
                $tags[] = $tag;
            }
            
            $newData[$type][] = array(
                "id" => $id,
                "type" => $type,
                "date" => $date,
                "title" => $title,
                "description" => $description,
                "tagiot" => $tags,
            );
            
            ++$newData['count'];
        }
    }
    
    echo json_encode($newData);
}
elseif($method == "save"){
    if(isset($_POST['data'])){
        $data = getTodoByUserId($userId);
        $newData = json_decode($_POST['data'], true);
        
        foreach ($data as $dat){
            foreach ($newData['todo'] as $newDat){
                if(todoShellUser($userId, $newDat['id']) && $dat[0] == $newDat['id']){
                    if($dat[2] != $newDat['type'])
                        moveTodo($dat[0], $newDat['type']);
                }
            }
            foreach ($newData['doing'] as $newDat){
                if(todoShellUser($userId, $newDat['id']) && $dat[0] == $newDat['id']){
                    if($dat[2] != $newDat['type'])
                        moveTodo($dat[0], $newDat['type']);
                }
            }
            foreach ($newData['done'] as $newDat){
                if(todoShellUser($userId, $newDat['id']) && $dat[0] == $newDat['id']){
                    if($dat[2] != $newDat['type'])
                        moveTodo($dat[0], $newDat['type']);
                }
            }
        }
        
        echo '{"ok":true}';
    }
}
elseif($method == "add"){
    if(isset($_POST['matala'])){
        $data = json_decode($_POST['matala'], true);
        
        if(isset($data['title']) && isset($data['description']) && isset($data['tagiot'])
            && is_string($data['title']) && is_string($data['description']) && is_array($data['tagiot'])){

            newTodo($userId, $data['title'], $data['description'], json_encode($data['tagiot'], true));
            echo '{"ok":true}';
        }
    }
}
elseif($method == "edit"){
    if(isset($_POST['matala'])){
        $data = json_decode($_POST['matala'], true);
        
        if(todoShellUser($userId, $data['id']) && isset($data['title']) && isset($data['description']) && isset($data['tagiot'])
            && is_string($data['title']) && is_string($data['description']) && is_array($data['tagiot'])){

            editTodo($userId, $data['id'], $data['title'], $data['description'], json_encode($data['tagiot'], true));
            echo '{"ok":true}';
        }
    }
}
elseif($method == "delete"){
    if(isset($_POST['id']) && todoShellUser($userId, $_POST['id'])){
        deleteTodo($_POST['id']);
        
        echo '{"ok":true}';
    }
}
