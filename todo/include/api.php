<?php

$method = $_GET['method'] ?? null;
$userId = $isLogged;

if($method == "Get"){
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
        $title = $dat[3];
        $description = $dat[4];
        $tags = json_decode($dat[5]);
        $isDeleted = $dat[6];
        $date = $dat[7];
        
        if($isDeleted == 0){
            $newData[$type][] = array(
                "id" => $id,
                "type" => $type,
                "date" => $date,
                "title" => $title,
                "pirot" => $description,
                "tagiot" => $tags,
            );
            
            ++$newData['count'];
        }
    }
    
    echo json_encode($newData);
}
elseif($method == "Add"){
    if(isset($_POST['matala'])){
        $data = json_decode($_POST['matala'], true);
        
        if(isset($data['title']) && isset($data['pirot']) && isset($data['tagiot'])
            && is_string($data['title']) && is_string($data['pirot']) && is_array($data['tagiot'])){

            newTodo($userId, $data['title'], $data['pirot'], json_encode($data['tagiot'], true));
            echo '{"ok":true}';
        }
    }
}
elseif($method == "Save"){
    if(isset($_POST['Data'])){
        $data = getTodoByUserId($userId);
        $newData = json_decode($_POST['Data'], true);
        
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
elseif($method == "Delete"){
    if(isset($_POST['id']) && todoShellUser($userId, $_POST['id'])){
        deleteTodo($_POST['id']);
        
        echo '{"ok":true}';
    }
}
