<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login()){
	header('location: ../index.php');
	exit();
}else{
	include('header.php');

	$username = $john -> get_username();
	$enroll = $john -> get_enroll();

	if(isset($_REQUEST["comment"]) and isset($_REQUEST["user_enroll"])){
	if($_REQUEST["comment"] == "comment" and $_REQUEST["user_enroll"] == $enroll){
		$post_id = $_POST['post_id'];
		$user_enroll = $_POST['user_enroll'];
		$cont = $_POST['com'];
		$date = date("d-m-Y");
		$time = time();
		if($cont != ""){
		$sql1 = "INSERT into post_comments(id,post_id,user_enroll,content,time,date) VALUES(NULL,'".$post_id."','".$user_enroll."', '".$cont."', '".$time."', '".$date."')";
		$john->insert($sql1);
		}
	  }
	}
?>

<body onload="me();">
<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
				<?php $_SESSION['from'] = "timeline"; ?>
        <div>
        	<?php
        	if((isset($_REQUEST["username"])) and (isset($_REQUEST["enroll"]))){
				$username = $_REQUEST["username"];
				$enroll = $_REQUEST["enroll"];
			}
        		//$_SESSION['user_id'] = $enroll;
        		//$_SESSION['username'] = $username;
				//call the news feeds function from chatfunction
            	$john -> user_feeds($enroll, $username);
        	?>
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

</div>
<?php
//get the footer
include("../extra/footer.php");
}
?>
