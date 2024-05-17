<?php

include('db_connect.php');

if($_POST["todo_id"])
{
 $data = array(
  ':todo_status'  => 1,
  ':todo_id'  => $_POST["todo_id"]
 );

 $query = "
 UPDATE todo_list 
 SET todo_status = :todo_status 
 WHERE todo_id = :todo_id
 ";

 $statement = $connect->prepare($query);

 if($statement->execute($data))
 {
  echo 'done';
 }
}

?>