<?php
require_once('../includes/init.php');
include('chatFunctions.php');
if(!$john->check_login()){
		header('location: ../index.php');
}else {
	$username = $john->get_username();
	$enroll = $john->get_enroll();

	$post_content = $_POST['usr_message'];
	$privacy = $_POST['privacy'];
	$time = time();
	$date = date("d M Y");

	if (!empty($_FILES)) {
		$img = $_FILES['file']['name'];
		$tempFile = $_FILES['file']['tmp_name'];
        $temp = explode(".", $img);
        $new = round(microtime(true)).".".end($temp);
		$targetPath = "../shakes_user_data/{$username}/photos/$new";
		if(move_uploaded_file($tempFile, $targetPath)){
				$path="shakes_user_data/{$username}/photos/$new";
			  //if not insert into the database
				$sql="INSERT into user_post(id,user_enroll,p_content,time_s,file_path,privacy,pdate) VALUES(null,'".$enroll."', '".$post_content."', '".$time."', '".$path."', '".$privacy."', '".$date."')";
					$query = $john->insert($sql);
		}
	}elseif(!empty($_POST['video'])){
		$path="{$_POST['video']}";
		//if not insert into the database
		$sql="INSERT into user_post(id,user_enroll,p_content,time_s,file_path,privacy,pdate) VALUES(null,'".$enroll."', '".$post_content."', '".$time."', '".$path."', '".$privacy."', '".$date."')";
			$query = $john->insert($sql);
	}else{
		$path="usr_photo/";
		//if not insert into the database
		$sql="INSERT into user_post(id,user_enroll,p_content,time_s,file_path,privacy,pdate) VALUES(null,'".$enroll."', '".$post_content."', '".$time."', '".$path."', '".$privacy."', '".$date."')";
			$query = $john->insert($sql);
	}

	header('Location: chat');
	exit();
}
?>
