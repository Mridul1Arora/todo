<?php

include('db_connect.php');

if(isset($_POST["todo_name"])){

    $check = "SELECT todo_id FROM todo_list WHERE todo_details = :todo_details";
    $check_statement = $connect->prepare($check);
    $check_statement->bindParam(':todo_details', $_POST["todo_name"]);
    $check_statement->execute();
    $todo_exists = $check_statement->fetch(PDO::FETCH_ASSOC);

    if($todo_exists){
        echo "Todo already exists";
        exit;
    }

    $data = array(
        ':todo_details' => trim($_POST["todo_name"]),
        ':todo_status' => 0
    );

    $query = "
        INSERT INTO todo_list 
        (todo_details, todo_status) 
        VALUES (:todo_details, :todo_status)
    ";

    $statement = $connect->prepare($query);

    if($statement->execute($data)){
        $todo_list_id = $connect->lastInsertId();

        echo '<a href="#" class="list-group-item" id="list-group-item-'.$todo_list_id.'" data-id="'.$todo_list_id.'">'.$_POST["todo_name"].' <span class="badge" data-id="'.$todo_list_id.'">X</span></a>';
    } else {
        echo "Error adding todo";
    }
}
?>
