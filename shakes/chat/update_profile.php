<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
	header('location: ../index.php');
else {

//get user enrollment number
$enroll = $john -> get_enroll();
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////       image processor      ///////////////////////////////
if($_FILES['ima'] !== ""){
	$ima = $_FILES['ima']['name'];
	$imup=$_FILES['ima']['tmp_name'];
    $temp = explode(".", $ima);
    $new = round(microtime(true)).".".end($temp);
	$path="../shakes_user_data/{$_POST["username"]}/photos/$new";
	move_uploaded_file($imup, $path);
	$path="shakes_user_data/{$_POST["username"]}/photos/$new";
}
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
//////	check if the img variable is empty or not   ///////////
	if ($ima == "")
	{
		//////////////////////////////////// this will not insert any thing in the img column  / /////////////////////////////////////////////
		$sql = "UPDATE stud_data  SET  user_email='".$_POST['email']."',gender = '".$_POST['gender']."', date_of_birth = '".$_POST['dob']."',address = '".$_POST['address']."',state = '".$_POST['state']."',country = '".$_POST['country']."',phone = '".$_POST['phone']."',profession = '".$_POST['profession']."',school_three = '".$_POST['school_one']."',school_two = '".$_POST['school_two']."',school_one = '".$_POST['school_one']."',relationship = '".$_POST['relationship']."' WHERE usr_roll='".$enroll."'";
	}
	else
	{
		//////////////////////////////////// this will not insert the sent image inside the img column  / /////////////////////////////////////////////
		$sql = "UPDATE stud_data  SET  user_email='".$_POST['email']."',gender = '".$_POST['gender']."', date_of_birth = '".$_POST['dob']."',address = '".$_POST['address']."',state = '".$_POST['state']."',country = '".$_POST['country']."',phone = '".$_POST['phone']."',profession = '".$_POST['profession']."',school_three = '".$_POST['school_one']."',school_two = '".$_POST['school_two']."',school_one = '".$_POST['school_one']."',relationship = '".$_POST['relationship']."', uimg = '".$path."' WHERE usr_roll='".$enroll."'";
	}



//echo $sql;

	$result = mysqli_query($con,$sql);

	//////// check if there is error
	if($result == 1){
		header('location:profile');
		exit();
	}
	else
	{
		header('location: profile');
		exit();
	}

}
?>
