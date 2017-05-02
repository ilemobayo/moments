<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$username = $john -> get_username();
	$enroll = $john -> get_enroll();
?>

<body onload="me();">


<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
	<div class="body_inner">
		<!--Profile-->
		<?php
			global $con;
			$sql="SELECT * FROM stud_data WHERE usr_name='".$username."' AND usr_roll='".$enroll."'";
			$rows = mysqli_query($con,$sql);
			if (mysqli_num_rows($rows)>0){
					$row = mysqli_fetch_array ($rows);
					if($row["uimg"] == "" || $row["uimg"] == "../usr_photo"){
								echo "<div id=\"default\" class=\"wall\" style=\"background: url(&quot;../$row[uimg]&quot;)  0px 0px; background-size: 100% 100%; background-repeat: no-repeat;\" >"
										."<div class='wall-head'><h2>{$username}</h2><img src='../icons/nop/shakes_no_pic_larg.png' class='profile-pic pull-right' /></div>";
					}else{
								echo "<div id=\"x\" class=\"wall\" style=\"background: url(&quot;../$row[uimg]&quot;) 0px 0px; background-size: 100% 100%; background-repeat: no-repeat;\">"
										."<div class='wall-head' ><h2>{$username}</h2><img src='../$row[uimg]' class='profile-pic pull-right' /></div>";
					}
				}
		?>
		</div>
		<div id="control_profile">
				<table>
				<tr>
						<td id="about"><a href="profile">Profile</a></td>
						<td id="friends" class="friendl"></td>
						<td id="post"></td>
						<td id="gallery"></td>
						<td id="empty"></td>
				</tr>
				</table>
		</div>
</div>

	<div class="body_inner">
	    <div class="profile_container">
					<div class="status_prof_qt">
			<form action='update_profile.php' method="POST" enctype="multipart/form-data">
<?php
	$sql="SELECT * FROM stud_data WHERE usr_name='".$username."' AND usr_roll='".$enroll."'";

	$rows = mysqli_query($con,$sql);

	if (mysqli_num_rows($rows)>0)
	{
		$row = mysqli_fetch_array ($rows);
		echo "<table class='profile_tle_fpt_body'>";
		echo "<tr><td><h4>Edit Profile</h4>";
		echo "<table class='profile_tle_fpt'><tbody>";
		echo "<tr><td>Username: </td><td>{$row["usr_name"]}<input type=\"hidden\" name='username'  value='$row[usr_name]' /></td></tr>";
		echo "<tr><td>E-mail: </td><td><input type='email' name='email' value='$row[user_email]' /></td></tr>";
		echo "<tr><td>Country:</td><td><input type='text' name='country' value='$row[country]' /></td></tr>";
		echo "<tr><td>State:</td><td><input type='text' name='state' value='$row[state]' /></td></tr>";
		echo "<tr><td>Address:</td><td><input type='text' name='address' value='$row[address]' /></td></tr>";
		echo "<tr><td>Date of Birth:</td><td><input type='date' name='dob' value='{$row["date_of_birth"]}' /></td></tr>";
		echo "<tr><td>Gender:</td><td><input type='text' name='gender' value='$row[gender]' /></td></tr>";
		echo "<tr><td>Relationship:</td><td><select name='relationship'>"
                        . "<option value='$row[relationship]' selected>$row[relationship] </option>"
                        . "<option value='single'>single</option><option value='engaged'>engaged</option>"
                        . "<option value='married'>married</option></td></tr>";
		echo "<tr><td>School One:</td><td><input type='text' name='school_one' value='$row[school_one]' /></td></tr>";
		echo "<tr><td>School Two:</td><td><input type='text' name='school_two' value='$row[school_two]' /></td></tr>";
		echo "<tr><td>School Three:</td><td><input type='text' name='school_three' value='$row[school_three]' /></td></tr>";
		echo "<tr><td>Profession:</td><td><input type='text' name='profession' value='$row[profession]' /></td></tr>";
		echo "<tr><td>Phone Number:</td><td><input type='text' name='phone' value=\"$row[phone]\" /></td></tr>";
		echo "<tr><td>Profile Picture:</td><td><input type='file' name='ima' value='../$row[uimg]'/></td></tr>";
		echo "<tr><td> </td> <td><input type='submit' value='Update' class='btn btn-sm' /></td></tr>";
		echo "</tbody></table>";
		echo "</td></tr>";
		echo "</table>";
	}
?>
				</form>
			</br>
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
</div>
<?php
//get footer
include("../extra/footer.php");
}
?>
