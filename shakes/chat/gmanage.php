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
  $token = $john->token_session();
	$save = false;
	$name = false;
	$id ="";
	$private = 1;
	$empty = "empty fields";

  if($_POST['token'] == $john->token_session()){
      if(isset($_POST['name']) && isset($_POST['id']) && (isset($_POST["img"]))){
  		  $img = $_POST['img'];
        $name = $_POST["name"];
        $id = $_POST["id"];
      }else{
        header("Location: groups");
        exit();
      }
  }else{
      header("Location: groups");
		  exit();
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
            <td id="about">ADD PARTICIPANTS</td>
            <td id="friends"><a href="groups">View Groups</a></td>
            <td id="empty">
                  <form action="gupdate" method="post">
                      <input type="hidden" name="name" value="<?php echo $name;?>">
                      <input type="hidden" name="img" value="<?php echo $img;?>">
                      <input type="hidden" name="id" value="<?php echo $id;?>">
                      <input type="hidden" name="token" value="<?php echo $token;?>">
                      <input type="submit" class="btn btn-link" value="Edit Group">
                  </form></td>
            <td id="gallery"></td>
						<td id="empty"></td>
        </tr>
        </table>
    </div>
</div>


<div class="body_inner_2">
    <div class="profile_container">
<!-- this specific block of code displays all the groups created by the logged in user -->
		      <div class="profile" >
              <div>
              <?php echo "<h2 class=\"btn btn-default btn-xm btn-block\">{$name}</h2>";?>
                <?php $john->group_add_friends($enroll,$id);?>
              </div>
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
