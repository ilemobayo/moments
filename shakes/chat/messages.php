<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
    header('location: ../index.php');
else {
    include('header.php');
    $username = $john -> get_username();
    $enroll = $john -> get_enroll();
?>

<body onload="me();">

<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="inbox_section">
  <div class="inbox_layer">
    <table width='100%'>
      <?php $john -> inbox($enroll); ?>
    </table>
  </div>
</div>

<div class="mini-fied_chat">
	<div id="online_box" class="online">
		<audio controls="controls" style="display:none;" id="soundHandle"></audio>  <!--this tag is for chat sound	-->
		<div id="online_users_box" class="online">
		</div>
		<div id="online_search_box" class="online" >
			<input type="text" name="user_search" onKeyDown="searchUsersOnline()" placeholder="Find friends or groups"/>
		</div>
	</div>
	<div id='chatbox'>
        </div>
</div>


<?php
//get the footer
include("../extra/footer.php");
}
?>
