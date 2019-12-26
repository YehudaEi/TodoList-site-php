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
        $type = $dat[3];
        $title = htmlspecialchars($dat[4]);
        $description = nl2br(htmlspecialchars($dat[5]));
        $ttags = json_decode($dat[6], true);
        $isDeleted = $dat[7];
        $isArchive = $dat[8];
        $date = $dat[9];
        
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
    
    echo json_encode($newData);
}
if($method == "getArchive"){
    $data = getArchiveTodoByUserId($userId);
    
    $newData = array(
        "archive1" => array(),
        "archive2" => array(),
        "archive3" => array(),
        "count" => 0
    );
    
    foreach ($data as $dat){
        $id = $dat[0];
        $title = htmlspecialchars($dat[4]);
        $description = nl2br(htmlspecialchars($dat[5]));
        $ttags = json_decode($dat[6], true);
        $isDeleted = $dat[7];
        $isArchive = $dat[8];
        $date = $dat[9];
        
        $tags = array();
        foreach ($ttags as $tag){
            $tag['name'] = htmlspecialchars($tag['name']);
            $tag['type'] = htmlspecialchars($tag['type']);
            
            $tags[] = $tag;
        }
        
        $type = "archive" . ((int)(($newData['count'] % 3)) + 1);
        
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
    
    echo json_encode($newData);
}
elseif($method == "save"){
    if(isset($_POST['data'])){
        $newData = json_decode($_POST['data'], true);
        $i = 1;
        
        foreach ($newData['todo'] as $newDat){
            if(todoShellUser($userId, $newDat['id'])){
                $data = getTodo($userId, $newDat['id']);
                
                if($data['id_in_column'] != $i)
                    setIdInColumn($data['todo_id'], $i);
                if($data['type'] != $newDat['type'])
                    moveTodo($data['todo_id'], $newDat['type']);
                
                ++$i;
            }
        }
        foreach ($newData['doing'] as $newDat){
            if(todoShellUser($userId, $newDat['id'])){
                $data = getTodo($userId, $newDat['id']);
                
                if($data['id_in_column'] != $i)
                    setIdInColumn($data['todo_id'], $i);
                if($data['type'] != $newDat['type'])
                    moveTodo($data['todo_id'], $newDat['type']);
                
                ++$i;
            }
        }
        foreach ($newData['done'] as $newDat){
            if(todoShellUser($userId, $newDat['id'])){
                $data = getTodo($userId, $newDat['id']);
                
                if($data['id_in_column'] != $i)
                    setIdInColumn($data['todo_id'], $i);
                if($data['type'] != $newDat['type'])
                    moveTodo($data['todo_id'], $newDat['type']);
                
                ++$i;
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
elseif($method == "archive"){
    if(isset($_POST['id']) && todoShellUser($userId, $_POST['id'])){
        archiveTodo($_POST['id']);
        
        echo '{"ok":true}';
    }
}
elseif($method == "unArchive"){
    if(isset($_POST['id']) && todoShellUser($userId, $_POST['id'])){
        unArchiveTodo($_POST['id']);
        
        echo '{"ok":true}';
    }
}
elseif($method == "delete"){
    if(isset($_POST['id']) && todoShellUser($userId, $_POST['id'])){
        deleteTodo($_POST['id']);
        
        echo '{"ok":true}';
    }
}
