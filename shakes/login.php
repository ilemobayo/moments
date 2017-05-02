<?php
require('includes/init.php');
require_once('chat/chatFunctions.php');

if((isset($_POST['keeploggedin'])) and (isset($_POST['user'])) and (isset($_POST['pass']))){
  $john -> validate_login($_POST['user'], $_POST['pass'], $_POST['keeploggedin']);
}elseif((isset($_POST['user'])) and (isset($_POST['pass']))){
  $john -> validate_login($_POST['user'], $_POST['pass'], $keep = 0);
}

?>
