<?php

    include('db_connect.php');
    if($_POST["todo_id"]){
        $data = array(
        ':todo_id'  => $_POST['todo_id']
        );

        $query = "
        DELETE FROM todo_list  
        WHERE todo_id = :todo_id
        ";

        $statement = $connect->prepare($query);

        if($statement->execute($data)){
            echo 'done';
        }
    }
?>