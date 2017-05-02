<?php
require_once("../../includes/init.php");
require_once('../chatFunctions.php');
if(!$john->check_login())
	header('location: ../index.php');
else {
	$username = $john->get_username();
	$enroll = $john->get_enroll();

	if($_POST['token'] == $john->token_session()){
		if(isset($_POST['id'])){
			if($_POST['len'] != 0){
				for ($i=0; $i < $_POST['len']; $i++) {
					if($_POST["$i"] != ""){
						$sql = "INSERT INTO groups_users (id,groups_id,user_id) VALUES(null,{$_POST["id"]},{$_POST["$i"]})";
						$john->insert($sql);
					}
				}
			}
		}
		header("Location: ../groups");
	  	exit();
  	}else{
      	header("Location: ../groups");
	  	exit();
  	}

 }