<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
$enroll = $john -> get_enroll();
//collect the search term
if(isset($_POST["user_search"])){
	$john -> search_users($enroll,$_POST["user_search"]);
}

?>
