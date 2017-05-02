<?php
require('../../includes/init.php');
include('../chatFunctions.php');
$username = $john->get_username();
$enroll = $john->get_enroll();

$john->getgroups($enroll);
?>
