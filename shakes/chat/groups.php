<?php
require_once("../includes/init.php");
require_once('chatFunctions.php');
if(!$john->check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$username = $john->get_username();
	$enroll = $john->get_enroll();
?>

<body onload="me();">
<div class="message">

<?php include("navigation/nav.php"); ?>


<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="body_inner">
		<div class="profile">
        <table>
        <tr>
            <td id="about" class="myGroups">GROUPS</td>
            <td id="friends" ><a href="groups_create">Create Group</a></td>
            <td id="empty"></td>
            <td id="empty"></td>
						<td id="empty"></td>
        </tr>
        </table>
    </div>
</div>


<div class="body_inner">
    <div class="profile_container">
<!-- this specific block of code displays all the groups created by the logged in user
    				<div class="profile profile_area">
    							<div class="user_panel_title_box zwq">
        								<div class="setting_title">Groups</div>
    							</div>
    							<div class="about-rule-1x" ></div>-->
										<div id="dgsh_jik">
												<table class="table" id="vusg8e9_idn">
															 <!--each group is listed here -->
                                                             <?php $john->getgroups($enroll); ?>
														</table>
										</div>
        		</div>
<!-- end of manage groups created by the loggedin user of the network -->
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

<div class="dialog-body">
    <div class="dialog-content">
        <div class="post"></div>
        <input type="button" class="close-dialog" value="Close" />
    </div>
</div>

<?php
//get the footer
include("../extra/footer.php");
}
?>
