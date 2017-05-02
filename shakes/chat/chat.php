<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$token = $john->token_session();
	$username = $john->get_username();
	$enroll = $john->get_enroll();

	$_SESSION['from'] = "chat";

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

<div class="message">

<noscript>
		<h3 style="text-align:center;">JAVASCRIPT DISABLED</h3>
		<h4 style="text-align:center;">If you are seeing this it means your javascript is disabled.</h4>
    <p style="text-align:justify;">This website is based on javascript, to help us serve you better, Please turn on or allow javascript on your browser to help us on our side serve you better, we promise to keep and not invade your privacy, Thank you. from fleetmoment.</p>
</noscript>
</div>

<div class="message">
<div class="user-post">
		<form method="post" action="upload_photos.php" enctype="multipart/form-data">
    <div class="user-post-head">
        <p>Status</p>
        <div class='clearfixe'>
                <input title="What's happening?" class="Textareauser" name="usr_message" placeholder="What's happening?" />
        </div>
    </div>

    <div class="user-post-content">
            <div class="form-group post-form-group">
								<div>
									<label class="button btn-xm dropzone feeds_dropzone">
										<input type="file" name="file" placeholder="Add file" class="drop-john" accept="image/*;capture=camera" onchange="$('#preview_imgs').attr('src', window.URL.createObjectURL(this.files[0]));$('#preview_imgs').css('visibility','visible');$('#preview_imgs').css('height','auto');"/>Click Here To Select Photo/Video to upload
									</label>
										<img src="" id="preview_imgs" class="dropzone" height="0px">
								</div>
                <div class="link_p">
                    <input type="text" placeholder=" type your video link here" class="Textareauser" name="video"/>
                </div>
                <div class="location_p">
                    <input type="text" placeholder="type your location here" class="Textareauser" name="location" disabled="disabled"/>
                </div>
            </div>
    </div>
    <div id="control">
        <table>
        <tr>
            <td id="photo"><a href="#"><img src="../icons/post/photo_p.png"></a></td>
            <td id="video"><a href="#"><img src="../icons/post/video_p.png"></a></td>
            <td id="location"><a href="#"><img src="../icons/post/location_p.png"></a></td>
						<td id="v"><select name='privacy'>
												<option value='' selected>Privacy</option>"
												<option value='private'>private</option>
												<option value='public'>public</option>
											</select>
						</td>
            <td id="post"><input class='send btn btn-sm' type="submit" value="Post"></td>
        </tr>
        </table>
    </div>
	</form>
</div>

<div class="post" id="john_carter_feeds">
	<?php
	$id = null;
	//call the news feeds function from chatfunction
	$john->news_feeds($enroll, $username, $id);
	?>
</div>
<div class="post">
	<button class="btn btn-default btn-xm btn-block data-last-id" onclick="loadold(<?php echo $john->last_id; ?>)" > More...</button>
</div>
</div>
<script>
$(document).ready(function(){
	//scroll to refresh
	$(document).scroll(function(event){
		var sc = $(document).scrollTop();
		if ($(window).scrollTop() + window.innerHeight >= $(document).height()) {
			$(".data-last-id").click();
		}
	})
})
</script>



<div class="mini-fied_chat">
	<div id="online_box" class="online">
		<audio controls="controls" style="display:none;" id="soundHandle"></audio>  <!--this tag is for chat sound	-->
		<div id="online_users_box" class="online">
		</div>
		<div id="online_search_box" class="online" >
			<input type="text" name="user_search" onKeyDown="searchUsersOnline()" placeholder="search"/>
		</div>
	</div>
	<div id='chatbox' name="chatbox">
        </div>
</div>

<?php
//get the footer
include("../extra/footer.php");
}
?>
