<?php
require('../includes/init.php');
include('chatFunctions.php');
//check if the login detail is true
if($john -> check_login()==true) {

//get the enrollment number
	$enroll = $john -> get_enroll();
	$john -> num_frn_request($enroll);
}
?>
