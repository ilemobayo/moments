<?php
require('../../includes/init.php');
include('../chatFunctions.php');
$enroll = $john->get_enroll();
$username = $john->get_username();

if((isset($_REQUEST['post_id'])) and (isset($_REQUEST['user_enroll']))){
  $post_id = $_REQUEST['post_id'];
  $enroll = $_REQUEST['user_enroll'];
  $john->likes($post_id,$enroll);
}

?>
