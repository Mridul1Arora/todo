<?php
   $connect = new PDO("mysql:host=localhost;dbname=todo", "root", "");
   if($connect){
   //  echo "finally connected";
   }
   else{
   //  echo "db not connected";
   }
?>