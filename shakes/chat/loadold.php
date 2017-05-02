<?php
//ob_start();
require('../includes/init.php');
include('chatFunctions.php');
$username = $john->get_username();
$enroll = $john->get_enroll();

if(isset($_REQUEST['lastid'])){
		$id = $_REQUEST['lastid'];
		//call the news feeds function from chatfunction
		$john->news_feeds($enroll, $username, $id);
}

if(isset($_REQUEST['getnewlastid'])){
	echo "loadold({$_SESSION['last_id']})";
}

//ob_end_flush();
?>