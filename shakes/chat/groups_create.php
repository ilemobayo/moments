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
<?php
	$save = false;
	$name = false;
	$details ="";
	$private = 1;
	$empty = "empty fields";

  if(isset($_POST['name']) && isset($_POST['details'])){
  	if(isset($_FILES["img"])){
  		$imga = $_FILES['img']['name'];
		$imgup=$_FILES['img']['tmp_name'];
  	}else{
  		$imga = "";
		$imgup= "";
  	}
    $name = $_POST["name"];
    $details = $_POST["details"];
    if(isset($_POST["private"])){
      $private = 1;
    }else{
      $private = 0;
    }
    $saved = $john->creategroup($name,$details,$private,$enroll,$imga,$imgup);
    if($saved){
      $save = "<div class=\"form-group\"><span class=\"help-block\">". $name ." has been created.</span></div>";
    }else {
      header("Location: groups.php");
		exit();
    }
  }

 ?>

<?php include("navigation/nav.php"); ?>


<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="body_inner">
		<div id="profile">
        <table>
        <tr>
            <td id="about">CREATE GROUP</td>
            <td id="friends"><a href="groups">View Groups</a></td>
            <td id="empty"></td>
            <td id="gallery"></td>
						<td id="empty"></td>
        </tr>
        </table>
    </div>
</div>


<div class="body_inner_2">
    <div class="profile_container">
<!-- this specific block of code displays all the groups created by the logged in user -->
		<?php
				if($save){
		?>
					<div class="profile" >
		<?php	echo $save; ?>
							<div>
								<h3>Add Group Members</h3>
								<?php $john->group_add_friends($enroll);?>
							</div>
					</div>
		<?php
				}elseif($empty) {
		?>
		<!--Create Group-->
	<div class="profile" >
		<div class="friends">
			<form class="form" role="form" method="post" enctype="multipart/form-data">
				<div class="form-group" >
                	<label for="inputfile">Group Photo</label>
                	<input type="file" id="inputfile" name="img" >
              	</div>

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
                  <button type="submit" class="btn btn-primary btn-xm btn-block">Create Group</button>
              </div>
    <?php
				}else {
		?>
		<!--Create Group-->
		<div class="profile_friends" >
		<div class="friends">
				<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="form-group" width="100%">
                		<label for="file">Group Photo</label>
                		<input type="file"  id="file" name="img" >
              		</div>
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
							<button type="submit" class="btn btn-primary btn-xm btn-block">Create Group</button>
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
