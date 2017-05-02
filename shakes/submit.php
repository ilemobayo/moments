<?php
require_once('includes/init.php');
require_once("chat/security/encrypt.php");

$firstname = mysqli_real_escape_string($con,$_POST['firstname']);
$surname = mysqli_real_escape_string($con,$_POST['surname']);
$user = $surname." ".$firstname;
$dob = $_POST['dob'];
$gender = mysqli_real_escape_string($con,$_POST['gender']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$pass = mysqli_real_escape_string($con,$_POST['passw']);.
$re_pass = mysqli_real_escape_string($con,$_POST['re-passw']);
$online = "yes";
//encrypt all data
// $en = new enc("{$user_email}","{$pass}");
// $user = $en->encrypt($user);
// $firstname = $en->encrypt($firstname);
// $surname = $en->encrypt($surname);
// $gender = $en->encrypt($gender);

//enroll generator
$enroll = time()*1000;

if($firstname=="" || $pass=="" || $re_pass == ""){
	header('location:index.php?err=0');
	exit();
}
elseif($pass!=$re_pass){
	header('location:index.php?err=1');
	exit();
}
else {
	$sql = "SELECT null FROM stud_data WHERE (firstname='".$firstname."' AND surname='".$surname."') AND user_email ={$email} ";
	$result = mysqli_query($con,$sql);
	$count = mysqli_num_rows($result);
	if($count>0){
		header('location:index.php?err=2');
		exit();
	}else{
		//hash password
		$pass = md5("5".$pass."@");
		//insert into database
		$sql = "INSERT INTO stud_data(id,user_email,usr_name,firstname,surname,usr_roll,usr_pass,gender,date_of_birth,reg_date,online)
		 		VALUES(Null,'".$email."','".$user."','".$firstname."','".$surname."','".$enroll."','".$pass."','".$gender."','".$dob."','".time()."','".$online."')";
		if(mysqli_query($con,$sql)){
			mkdir("shakes_user_data/{$user}/", 0777, true);//create users folder
			mkdir("shakes_user_data/{$user}/audios/", 0777, true);//create users audio subfolder
			mkdir("shakes_user_data/{$user}/photos/", 0777, true);//create users photo subfolder
			mkdir("shakes_user_data/{$user}/videos/", 0777, true);//create users video subfolder
		}else{
			header('location:index.php?err=4');
			exit();
		}
		header('location:index.php?err=3');
		exit();
	}		
}
?>
