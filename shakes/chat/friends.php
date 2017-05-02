<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john->check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$username = $john->get_username();
	$enroll = $john->get_enroll();
?>

<body onload="me();">

<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
    <!--search box-->
    <div class="body_inner">
    <div>
    <form class="bs-example bs-example-form" role="form"> 
        <div class="input-group input-group-xm" width="92%"> 
            <span class="input-group-addon">search</span> 
            <input type="text" name="user_search" placeholder="search" onkeyup="searchUsersOnline()" onemptied="emptysearch();" autofocus id="searchm" autocomplete="on" class="form-control" >
        </div> 
    </form>
        <br/>
        <div class="friends_list frn_list" id="friends_list">
        </div>
    </div>

<!--friends box-->
<div class="friends">
    <br/>
    <div class="friends_list frn_list" id="friends_list">
			<table>
	      <?php
	        //it gets the username and the enrollment number
	        $enroll = $john->get_enroll();
	        $friend = false;
	        $john->friends($enroll,$friend);
				?>
	    </table>
		</div>
</div>
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
        <h1>WELCOME</h1>
        <div class="post"></div>

        <input type="button" class="close-dialog" value="Close" />
    </div>
</div>

<?php
//get the footer
include("../extra/footer.php");
}
?>
