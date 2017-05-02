<?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "john_carter";
  $con = mysqli_connect("{$host}", "{$user}", "{$pass}","{$db}");

   if (!$con)
   {
   	die('Connect Error: ' . mysqli_connect_error());
   }

   //$GLOBALS["con"] = $con;
?>
