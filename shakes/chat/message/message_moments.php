<?php
require('../../includes/init.php');
header("Content-Type: application/json");
require_once('../chatFunctions.php');
//check the login detail if true
if($john->check_login()) {
	//get the username, enrollment and action type
	$username = $john->get_username();
	$enroll = $john->get_enroll();
	$action = "";
	if(isset($_REQUEST["action"])){
		$action = $_REQUEST["action"];
	}

	if((isset($_REQUEST['roll'])) or (isset($_REQUEST['rname']))){
		$to_roll = $john->conn->real_escape_string((int)$_REQUEST['roll']);
		$to_user = $john->conn->real_escape_string($_REQUEST['rname']);
	}

	if($action=="startChatbox"){
		$john->chatwithfrnd($to_user,$to_roll,$enroll);
	}elseif($action=="startChatSession"){
		$john->startChatSession($to_roll,$enroll);
	}elseif($action=="sendChat"){
		$msg = $_REQUEST['msg'];
		$to_user = $john->conn->real_escape_string($_REQUEST['name']);
		$t = time()-3;
		$sql = "SELECT NULL FROM stud_data WHERE usr_roll='".$to_roll."' AND time>=".$t;
		$result = $john->select($sql);
		$count = $result->num_rows;
		if($count==1){
			$john->sendChat($to_roll,$to_user,$msg,$enroll,$username);
		}else{
			$john->sendChat($to_roll,$to_user,$msg,$enroll,$username);
		}
	}elseif($action=="sendMChat") {
		$msg = $_REQUEST['msg'];
		$to_user = $john->conn->real_escape_string($_REQUEST['name']);
		$sql = "SELECT NULL FROM stud_data WHERE usr_roll={$to_roll}";
		$result = $john->select($sql);
		$count = $result->num_rows;
		if($count==1){
			$john->chatSendfrnd($to_roll,$to_user,$msg,$enroll,$username);
		}
	}elseif($action=="getChat"){
		$john->getChat($to_roll,$enroll);
	}elseif($action=="getnewChats"){
		if(isset($_REQUEST["id"])){
			$id = $_REQUEST["id"];
		}else{
			$id = 0;
		}
		$to_user = $john->conn->real_escape_string($_REQUEST['rname']);
		$john->newchatwithfrnd($to_user,$to_roll,$enroll,$id);
	}elseif($action=="popUpChat"){
		$john->popUpChat($enroll);
	}
}
?>
