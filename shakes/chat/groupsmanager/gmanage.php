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
		
              <div>
                <h3>Add Group Members</h3>
                <?php $john->group_add_friends($enroll);?>
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
