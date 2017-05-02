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
	$save = "";
	$name = false;
	$id ="";
	$empty = "empty fields";

  //update snippet
  if(isset($_POST["update"]) && isset($_POST["id"])){
    if(($_POST["token"] == $john->token_session())){
          if(isset($_FILES["img"])){
            $img = $_FILES['img']['name'];
            $imga = $_FILES['img']['name'];
            $imgup=$_FILES['img']['tmp_name'];
          }else{
            $img = "";
            $imga = "";
            $imgup= "";
          }
          $id = $_POST["id"];
          if(isset($_POST["name"])) {
            $name = $_POST["name"];
          }
          if(isset($_POST['details'])){
            $details = $_POST["details"];
          }
          $saved = $john->updategroup($name,$details,$id,$imga,$imgup);
          //if successfully updated
          if($saved){
              $save = "<div class=\"form-group\"><span class=\"help-block\">". $name ." has been updated.</span></div>";
              $_SESSION["exname"] = $name;
              if (isset($_SESSION["imgpath"])) {
                $img = $_SESSION["imgpath"];
              }
          }else{
              $save = "<div class=\"form-group\"><span class=\"help-block\">". $name ." was not updated.</span></div>";
          }
    }else{
      $save = "<div class=\"form-group\"><span class=\"help-block\">". $name ." could not be updated.</span></div>";
    }
  }else{
    if(($_POST["token"] == $john->token_session())){
      if(isset($_POST['name']) && isset($_POST['id']) && (isset($_POST["img"]))){
        $img = $_POST['img'];
        $name = $_POST["name"];
        $_SESSION["exname"] = $name;
        $id = $_POST["id"];
      }else{
        header("Location: groups");
        exit();
      }
  }else{
      header("Location: groups");
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
            <td id="about">EDIT GROUP</td>
            <td id="friends"><a href="groups">View Groups</a></td>
            <td id="empty">
                  <form action="gmanage" method="post">
                      <input type="hidden" name="name" value="<?php echo $_SESSION["exname"];?>">
                      <input type="hidden" name="img" value="<?php echo $img;?>">
                      <input type="hidden" name="id" value="<?php echo $id;?>">
                      <input type="hidden" name="token" value="<?php echo $token;?>">
                      <input type="submit" class="btn btn-link" value="Add Participants">
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
              <?php if($save !== ""){echo $save;}?>
          <form class="form" role="form" method="post" enctype="multipart/form-data" action="">
              <div class="form-group" >
                  <label for="inputfile">Group Photo</label>
                  <input type="file" id="inputfile" name="img" >
              </div>
              <div class="form-group">
                <label for="name">Group Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Group Name" value="<?php echo $name; ?>">
              </div>
              <div class="form-group">
                <label for="details">Group Details</label>
                <textarea type="text" class="form-control" id="details" name="details"  rows="3" ></textarea>
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="hidden" name="token" value="<?php echo $token;?>">
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-xm btn-block" name="update" value="Update">Update</button>
              </div>
          </form>
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
