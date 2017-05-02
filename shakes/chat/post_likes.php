<?php
ob_start();
require('../includes/init.php');
include('chatFunctions.php');
$enroll = $john->get_enroll();
$username = $john->get_username();


//like other images/photos within the application
if ((isset($_REQUEST['checkimg'])) and (!isset($_REQUEST['enroll'])) and (isset($_REQUEST['img']))) {
		$id = $enroll;
		$img = $_REQUEST['img'];
		//check if user has coment
		$sql = "SELECT * FROM image_likes WHERE user ='".$id."' AND img = '".$img."'";
		$result = $john->select($sql);
		$row = $result->fetch_row();
		if($row > 0){
			$sql = "SELECT null FROM image_likes WHERE img = '".$img."'";
			$result = $john->select($sql);
			$count = $result->num_rows;
			if($count != 0){
				if ($count == 1) {
					echo "you like this photo.";
				}elseif($count == 2){
					$count = $count - 1;
					echo "you and ".$count." other likes this photo.";
				}else{
					$count = $count - 1;
					echo "you and ".$count." others likes this photo.";
				}
			}
		}else{
			$sqll = "SELECT null FROM image_likes WHERE img = '".$img."'";
			$resultwick = $john->select($sqll);
			$count = $resultwick->num_rows;
			if($count != 0){
				if ($count == 1) {
					echo $count." person likes this photo.";
				}else{
					echo $count." people likes this photo.";
				}
			}
		}
}


//like other images/photos within theo application
if ((isset($_REQUEST['likeimg'])) and (isset($_REQUEST['enroll'])) and (isset($_REQUEST['img']))) {
		$id = $_REQUEST['enroll'];
		$img = $_REQUEST['img'];
		//check if user has coment
		$sql = "SELECT * FROM image_likes WHERE user ='".$id."' AND img = '".$img."'";
		$result = $john->select($sql);
		$row = $result->fetch_row();
		if($row > 0){
			$sql = "SELECT null FROM image_likes WHERE img = '".$img."'";
			$result = $john->select($sql);
			$count = $result->num_rows;
			if($count != 0){
				if ($count == 1) {
					echo "you like this photo.";
				}elseif($count == 2){
					$count = $count - 1;
					echo "you and ".$count." other likes this photo.";
				}else{
					$count = $count - 1;
					echo "you and ".$count." others likes this photo.";
				}
			}
		}else{
			$sql1 = "INSERT into image_likes(id,img,user) VALUES(NULL,'".$img."', '".$id."')";
			$john->insert($sql1);
			$sqll = "SELECT null FROM image_likes WHERE img = '".$img."'";
			$resultwick = $john->select($sqll);
			$count = $resultwick->num_rows;
			if($count != 0){
				if ($count == 1) {
					echo "you like this photo.";
				}elseif($count == 2){
					$count = $count - 1;
					echo "you and ".$count." other likes this photo.";
				}else{
					$count = $count - 1;
					echo "you and ".$count." others likes this photo.";
				}
			}
		}
}




if(isset($_REQUEST["Like"]) and $_REQUEST['user_enroll'] == $enroll){
	if($_REQUEST["Like"] == "Like"){
	$post_id = $_POST['post_id'];
	$user_enroll = $_POST['user_enroll'];
	$like = 1;
	//check if user has coment
	$sql = "SELECT * FROM likes WHERE post_id ='".$post_id."' AND user_enroll = '".$enroll."'";
	$query = mysqli_query($con,$sql);
	$check = mysqli_fetch_row($query);
	if($check >= 1){
		$sql1 = "DELETE FROM likes WHERE post_id ='".$post_id."' AND user_enroll = '".$user_enroll."'";
		$query1 = mysqli_query($con,$sql1);
		//get number of likes
		$sqllike = "SELECT l_like FROM likes WHERE post_id ='".$post_id."'";
		$result = mysqli_query($con,$sqllike);
		$c_likes = mysqli_num_rows($result);
		echo "<img src=\"../icons/postaction/like_32.jpg\">";
	}
	else{
		$sql1 = "INSERT into likes(id,post_id,l_like, user_enroll) VALUES(NULL,'".$post_id."', '".$like."' , '".$user_enroll."')";
		$john->insert($sql1);
		echo "<img src=\"../icons/postaction/liked_32.png\">";
	}
	}
}

if(isset($_REQUEST["comment"]) and isset($_REQUEST["user_enroll"])){
	if($_REQUEST["comment"] == "comment" and $_REQUEST["user_enroll"] == $enroll){
		$post_id = $_POST['post_id'];
		$user_enroll = $_POST['user_enroll'];
		$cont = $_POST['com'];
		$date = date("d-m-Y");
		$time = time();
		if($cont == ""){
			//do nothing
			back_to_john($post_id);
		}
		$sql1 = "INSERT into post_comments(id,post_id,user_enroll,content,time,date) VALUES(NULL,'".$post_id."','".$user_enroll."', '".$cont."', '".$time."', '".$date."')";
		$john->insert($sql1);
		back_to_john($post_id);
	}
}

function back_to_john($id = null){
	if(isset($_SESSION['from'])){
		if($_SESSION['from'] == "post_section"){
			//reset the from section so that you can use the go back button to move back to feeds
			$_SESSION['from'] = "chat";
			header("location: post_section?id={$id}");
			exit();
		}elseif ($_SESSION['from'] == "chat") {
			header("location: chat#{$id}");
			exit();
		}elseif($_SESSION['from'] == "timeline"){
			if((isset($_SESSION['user_id'])) and (isset($_SESSION['username']))){
				$cater = "{$_SESSION['from']}?enroll={$_SESSION['user_id']}&username={$_SESSION['username']}";
			}else{
				$cater = $_SESSION['from'];
			}
			header("location: {$cater}#{$id}");
			exit();
		}
	}
}

ob_end_flush();
?>
