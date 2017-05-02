<?php
require('../includes/init.php');
require_once('chatFunctions.php');
//check if the login detail is true
if($john->check_login()==true) {
	//get the enrollment number
	$enroll = $john->get_enroll();
        $t = time()-3;
        $sql = "SELECT from_enroll,from_user,msg FROM chat_messages WHERE to_enroll=".$enroll." AND time>=".$t."";
        $res = mysqli_query($con,$sql);
        $c = mysqli_num_rows($res);
        echo $c;
}
