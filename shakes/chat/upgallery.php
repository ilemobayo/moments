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

 ?>

<?php include("navigation/nav.php"); ?>

<?php
if((isset($_REQUEST["enroll"]))){
        $enroll = $_REQUEST["enroll"];
}

?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="body_inner">
    <?php
    global $con;
      $sql="SELECT * FROM stud_data WHERE usr_roll='{$enroll}'";
      $rows = mysqli_query($con,$sql);
      if (mysqli_num_rows($rows)>0){
          $row = mysqli_fetch_array ($rows);
            if($row["uimg"] == "" || $row["uimg"] == "../usr_photo"){
                echo "<div id=\"default\" class=\"wall\" style=\"background: url(&quot;../icons/nop/shakes_no_pic_larg.png&quot;)  0px 0px; background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed; background-position: center; \" >"
                ."<div class='wall-head'><img src='../icons/nop/shakes_no_pic_larg.png' class='profile-pic pull-right' /></div>";
            }else{
                echo "<div id=\"x\" class=\"wall\" style=\"background: url(&quot;../{$row['uimg']}&quot;) 0px 0px; background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed; background-position: center; backdrop-filter: blur(5px);\">"
                  ."<div class='wall-head' ><img src='../{$row['uimg']}' class='profile-pic pull-right viewimg'/></div>";
            }
      }
    ?>
    </div>
    <div id="control_profile">
        <table>
        <tr>
            <td id="about"><a href="profile">About</a></td>
            <td id="friends" class="friendl"><a href="friends">Friends</a></td>
            <td id="post"><a href="<?php echo "timeline?enroll={$enroll}&username={$username}"; ?>">Timeline</a></td>
            <td id="empty"></td>
        <td id="empty"></td>
        </tr>
        </table>
    </div>
</div>


<div class="body_inner_2">
    <div class="profile_container">
        <div class="profile" >
            <div>
              <?php
                  $files = glob("../shakes_user_data/{$username}/photos/*.*");
                  echo "<table class=\"table table-bordered\" width=\"100%\"><tr>";
                  $countims = 0;
                  for ($i=0; $i < count($files); $i++) { 
                    $countims++;
                    $image = $files[$i];
                    echo "<td><img src=\"{$image}\" alt=\"Random image\" width=\"100%\" class=\"viewimg\" /></td>";
                    if($countims == 3){
                      echo "</tr><tr>";
                      $countims = 0;
                    }
                  }
                  echo "</tr></table>";

              ?>
            </div>
    <?php
        if ($enroll == $john->get_enroll()) {
    ?>
    <div>
          <?php echo "<h2 class=\"btn btn-default btn-xm btn-block\">Upload image.</h2>";?>
          <form class="form" role="form" method="post" enctype="multipart/form-data" action="gallery/upgallery">
              <div class="form-group" >
                  <label class="button btn-xm">
                    <input type="file" name="img" placeholder="Add file" class="drop-john" accept="image/*;capture=camera" onchange="$('#preview_imgs').attr('src', window.URL.createObjectURL(this.files[0]));$('#preview_imgs').css('visibility','visible');$('#preview_imgs').css('height','auto');"/>Click Here To Select Photo/Video to upload
                  </label>
                    <img src="" id="preview_imgs"  height="0px">
                    <input type="hidden" name="id" value="<?php echo $enroll;?>">
                    <input type="hidden" name="token" value="<?php echo $token;?>">
                    <input type="hidden" name="name" value="<?php echo $username;?>">
                </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-xm btn-block" name="update" value="Update">Upload image to my gallery</button>
              </div>
          </form>
    </div>
    <?php
      }?>

          </div>
      </div>
</div>

</div>



<div class="mini-fied_chat">
  <div id="online_box" class="online">
    <audio controls="controls" style="display:none;" id="soundHandle"></audio>  <!--this tag is for chat sound  -->
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
