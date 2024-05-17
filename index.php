<?php
   
   include("db_connect.php");

   $query = "SELECT * FROM todo_list  ORDER BY todo_id DESC";
   $statement = $connect->prepare($query);

   $statement->execute();

   $result = $statement->fetchAll();


?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List in PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .list-group-item {
            font-size: 26px;
        }
    </style>
</head>
<body>

<br />
<br />
<div class="container">
    <h1 align="center">To-Do List in PHP</h1>
    <br />
    <br />
    <div class="panel panel-default" id="todoPanel">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="panel-title">My To-Do List</h3>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <div class="panel-body">
            <form method="post" id="to_do_form">
                <span id="message"></span>
                <div class="input-group">
                    <input type="text" name="todo_name" id="todo_name" class="form-control input-lg" autocomplete="off"
                           placeholder="Title..."/>
                    <div class="input-group-btn">
                        <button type="submit" name="submit" id="submit" class="btn btn-success btn-lg">Add todo</button>
                    </div>
                </div>
            </form>
            <br />
            <div class="list-group">
                <?php
                foreach ($result as $row) {
                    $style = '';
                    if ($row["todo_status"] == 1) {
                        $style = 'text-decoration: line-through';
                    }
                    echo '<a href="#" style="' . $style . '" class="list-group-item" id="list-group-item-' . $row["todo_id"] . '" data-id="' . $row["todo_id"] . '">' . $row["todo_details"] . ' <span class="badge" data-id="' . $row["todo_id"] . '">X</span></a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
 
 $(document).ready(function(){
  
  $(document).on('submit', '#to_do_form', function(event){
   event.preventDefault();

   if($('#todo_name').val() == '')
   {
    $('#message').html('<div class="alert alert-danger">Enter todo Details</div>');
    return false;
   }
   else
   {
    $('#submit').attr('disabled', 'disabled');
    $.ajax({
     url:"add_todo.php",
     method:"POST",
     data:$(this).serialize(),
     success:function(data)
     {
      $('#submit').attr('disabled', false);
      $('#to_do_form')[0].reset();
      $('.list-group').prepend(data);
     }
    })
   }
  });

  $(document).on('click', '.list-group-item', function(){
   var todo_id = $(this).data('id');
   $.ajax({
    url:"complete_todo.php",
    method:"POST",
    data:{todo_id:todo_id},
    success:function(data)
    {
     $('#list-group-item-'+todo_id).css('text-decoration', 'line-through');
    }
   })
  });

    $(document).on('click', '.badge', function () {
        var todo_id = $(this).data('id');
        
        var confirmDelete = confirm("Are you sure you want to delete this todo?");
        
        if (confirmDelete) {
            $.ajax({
                url: "delete_todo.php",
                method: "POST",
                data: {todo_id: todo_id},
                success: function (data) {
                    $('#list-group-item-' + todo_id).fadeOut();
                }
            });
        }
    });

 });
</script>