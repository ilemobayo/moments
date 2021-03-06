<?php
require_once("../../includes/init.php");
require_once('../chatFunctions.php');
if(!check_login())
	header('location: ../../index.php');
else {
	include('../header.php');
	$username = get_username();
	$enroll = get_enroll();
?>

<body onload="me();">
<div class="searchbar">
<?php
        //check for the profile picture of the dataa passed
user_details($username,$enroll);
?>
<div class='me_online'></div>
</div><!-- header -->
<?php

  if(($_POST['name'] == "") && ($_POST['details'] == "")){
      $empty = "empty fields";
  }else{
    $name = $_POST['name'];
    $details = $_POST['details'];
    if($_POST['private'] == 1){
      $private = 1;
    }else{
      $private = 0;
    }
    $saved = creategroup($name,$details,$private,$enroll);
    if($saved){
      $save = "<div class=\"form-group\"><span class=\"help-block\">". $name ." has been created.</span></div>";
    }else {
      header("Location: groups.php");
			exit();
    }
  }

 ?>

<hr/>

<?php include("../navigation/nav.php"); ?>


<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="searchusers">
<!--Profile-->
    <div class="profile">
        <h2>MY SHAKES GROUP MANAGER</h2>
    </div>
		<div id="control_profile">
        <table>
        <tr>
            <td id="about" class="myGroups">My Groups</td>
            <td id="friends" class="friendl creat_group">Create Group</td>
            <td id="post">Find Group</td>
            <td id="gallery"></td>
						<td id="empty"></td>
        </tr>
        </table>
    </div>
</div>
<div class="searchusers_d">
    <div class="profile_container">
    <div class="profile profile_area">
    <div class="user_panel_title_box zwq">
        <div class="setting_title">Groups</div>
    </div>
    <div class="about-rule-1x"></div>

<br/>


        </div>

        <div class="profile_feeds creat_group">
        <?php
        //call the news feeds function from chatfunction

        ?>
        </div>

		<?php
				if($save){
					echo $save;
				}elseif($empty) {
		?>
				<!--Create Group-->
				<div class="profile_friends" >
				<div class="friends">
				    <form class="form-horizontal" role="form" method="post">
              <div class="form-group">
                <label for="name">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Group Name" >
              </div>
              <div class="form-group">
                <label for="details">Group Details</label>
                <textarea type="text" class="form-control" id="details" name="details"  rows="3" ></textarea>
              </div>
              <div class="form-group">
                <label> <input type="checkbox" name="private" value="1" > Make private </label>
                <span class="help-block">To avoid other shakes users viewing your group without an invite, please check the above box to avoid that.</span>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-default">Create Group</button>
              </div>
    <?php
				}else {
		?>
		<!--Create Group-->
		<div class="profile_friends" >
		<div class="friends">
				<form class="form-horizontal" role="form" method="post">
					<div class="form-group">
						<label for="name">Group Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Group Name" >
					</div>
					<div class="form-group">
						<label for="details">Group Details</label>
						<textarea type="text" class="form-control" id="details" name="details"  rows="3" ></textarea>
					</div>
					<div class="form-group">
						<label> <input type="checkbox" name="private" value="1" > Make private </label>
						<span class="help-block">To avoid other shakes users viewing your group without an invite, please check the above box to avoid that.</span>
					</div>
					<div class="form-group">
							<button type="submit" class="btn btn-default">Create Group</button>
					</div>
		<?php
        }
    ?>
            </form>

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
        <div class="post"></div>
        <input type="button" class="close-dialog" value="Close" />
    </div>
</div>

<?php
//get the footer
include("../extra/footer.php");
}
?>
