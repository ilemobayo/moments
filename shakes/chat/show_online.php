<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
//check if the login detail is true
if(!$john->check_login()) {
	header("location: ../index");
	exit();
}
	//get the enrollment number
	$enroll = $john->get_enroll();
	//get the value in the search box
	$search = "";
	if(isset($_REQUEST["search"])){
		$search = $_REQUEST["search"];
	}
		//updating the time
		$time = time();
		$sql = "UPDATE stud_data SET time='{$time}' WHERE usr_roll='{$enroll}'";
		$john->update($sql);

	// getting online users
	$time = time()-3;
	if($search==""){
		$sql = "SELECT friend_name, friend_enroll FROM user_friend WHERE online='yes' AND user_enroll='{$enroll}'";
		//$sql = "SELECT friend_name, friend_enroll FROM user_friend WHERE user_enroll='{$enroll}'";
  	}else{
		$sql = "SELECT friend_name, friend_enroll FROM user_friend WHERE user_enroll=".$enroll." AND online='yes' AND UCASE(friend_name) LIKE '%$search%'";
  	}
  	$result = $john->select($sql);
	$count = $result->num_rows;
	if($count>0) {
      while($row = $result->fetch_assoc()) {
          $imgsql= $john->select("SELECT uimg FROM stud_data WHERE usr_roll='{$row['friend_enroll']}'");
          $rowimg = $imgsql->fetch_row();
          //friends with no picture
          if (($rowimg[0] =='') || ($rowimg[0] =='usr_photo/')) {
            $rowimg[0] = "icons/nop/shakes_no_pic.png";
					}
          echo "<div id='user'>"
          		."<a href='message_chat?chat_name={$row["friend_name"]}&enrollment={$row['friend_enroll']}' title='chat with {$row['friend_name']}'>"
                . "<img src='../$rowimg[0]' height='30px' width='30px' class='frn_img'>"
                .$row['friend_name']."<div class='frd_online'></div></a></div>";
			}
	}else{
		echo "<div class='err_msg'>No friends yet</div>";
	}

?>
