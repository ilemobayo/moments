<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$username = $john -> get_username();
	$enroll = $john -> get_enroll();
    $token = $john->token_session();
?>

<body onload="loadstart();">


<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
	<div class="body_inner">
		<!--Profile-->
    <?php
    global $con;
	//it gets the username and the enrollment number passed
        //the following code get the name and number passed from the friend list
		if(isset($_REQUEST['fr_name']) && isset($_REQUEST['enroll'])){
        	$friend_name = $_REQUEST['fr_name'];
        	$friend_enroll = $_REQUEST['enroll'];
		}else{
					$friend_name = "";
        	$friend_enroll ="";
		}
        //check if the fields are not empty, if not run the logged in user data
        if($friend_name !="" && $friend_enroll !=""){
            $username = $friend_name;
            $enroll = $friend_enroll;
						$friend = true;
        }else{
	           $username = $john -> get_username();
	           $enroll = $john -> get_enroll();
						 $friend = false;
        }

            $sql="SELECT * FROM stud_data WHERE usr_roll='{$enroll}'";

	$rows = mysqli_query($con,$sql);

	if (mysqli_num_rows($rows)>0)
	{
		$row = mysqli_fetch_array ($rows);
            if($row["uimg"] == "" || $row["uimg"] == "../usr_photo"){
                echo "<div id=\"default\" class=\"wall\" style=\"background: url(&quot;../icons/nop/shakes_no_pic_larg.png&quot;)  0px 0px; background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed; background-position: center; \" >"
				."<div class='wall-head'><img src='../icons/nop/shakes_no_pic_larg.png' class='profile-pic pull-right' /></div>";
            }else{
                echo "<div id=\"x\" class=\"wall\" style=\"background: url(&quot;../{$row['uimg']}&quot;) 0px 0px; background-size: 100% 100%; background-repeat: no-repeat; background-attachment: fixed; background-position: center; backdrop-filter: blur(5px);\">"
				."<div class='wall-head' ><img src='../{$row['uimg']}' class='profile-pic pull-right viewimg'/></div>";
            }
    ?>
    </div>
		<div id="control_profile">
        <table>
        <tr>
            <td id="about"><a href="#">About</a></td>
            <td id="friends" class="friendl"><a href="friends">Friends</a></td>
            <td id="post"><a href="<?php echo "timeline?enroll={$enroll}&username={$username}"; ?>">Timeline</a></td>
            <td id="gallery"><a href="upgallery">Media</a></td>
		    <td id="empty"></td>
        </tr>
        </table>
    </div>
</div>

<div class="body_inner">
    <div class="profile profile_area">
    <div class="user_panel_title_box zwq">
        <div class="setting_title">
					About | Friends <?php echo $nom = $john->no_of_friends($enroll); ?>
					<!--remove button-->
					<?php
					$user_name = $john -> get_username();
					$user_enroll = $john -> get_enroll();
					//check if he/she is a friend_id
					$isfriend = $john -> if_frn($user_enroll,$enroll);
					if(($user_name != $username && $user_enroll != $enroll) && $isfriend == true){
							//perform nothing
							echo "<form method='POST' action='addremovefriend'>"
							. "<input name='friend_name' type='hidden' value='$username' />"
							. "<input name='friend_id' type='hidden' value='$enroll' />"
							. "<input name='user_id' type='hidden' value='$user_enroll' />"
							. "<input name='type' type='hidden' value='remove' />"
							. "<input type='submit' value='Remove Contact' class=\"btn-link remove\" /></form>";
					}elseif(($user_name != $username && $user_enroll != $enroll) && $isfriend == false){
							echo  "<form method='POST' action='addremovefriend.php'>"
									. "<input name='friend_name' type='hidden' value='$username' />"
									. "<input name='friend_id' type='hidden' value='$enroll' />"
									. "<input name='user_id' type='hidden' value='$user_enroll' />"
									. "<input name='from' type='hidden' value='profile' />"
									. "<input name='type' type='hidden' value='send' />"
									. "<input type='submit' value='Add Contact' class=\"btn-link remove\" /></form>";
					}
					?>
				</div>
    </div>
    <div class="about-rule-1x"></div>
    <div class="status_prof_qt">
        <h5>Status</h5>
        <p>Welcome to Shakes Social Network</p>
    </div>
                <?php
                        echo "<table class='profile_tle_fpt_body'>";
                        echo "<tr><td>";
                        echo "<table class='profile_tle_fpt'><tbody>";
                        echo "<tr><td colspan='2'><div class='about-rule-1x'></div></td></tr>";
                        echo "<tr><td>Name: <td>{$row['usr_name']}</td></tr>";
                        echo "<tr><td>E-mail: <td>{$row['user_email']}</td></tr>";
                        echo "<tr><td>Date of Birth:<td>".$row['day']." ".$row['month']." ".$row['year']."</td></tr>";
                        echo "<tr><td>Gender:<td>{$row['gender']}</td></tr>";
                        echo "<tr><td>Relationship:<td>{$row['relationship']}</td></tr>";
                        echo "<tr><td>Works In: <td></td></tr>";
                        echo "<tr><td colspan='2'><div class='about-rule-1x'></div></td></tr>";
                        echo "<tr><td>Country:<td>{$row['country']}</td></tr>";
                        echo "<tr><td>State:<td>{$row['state']}</td></tr>";
                        echo "<tr><td>Address:<td>{$row['address']}</td></tr>";
                        echo "<tr><td>Profession:<td>{$row['profession']}</td></tr>";
                        echo "<tr><td>Phone Number:<td>{$row['phone']}</td></tr>";
                        echo "<tr><td>School:<td>{$row['phone']}</td></tr>";
                        echo "</tbody></table>";
                        echo "</td></tr>";

        								echo "</table>";
											}
		?>
        <br/>
            <a href="upgallery?enroll=<?php echo $enroll;?>&username=<?php echo $username;?>&token=<?php echo $token;?>" role="button" class="btn btn-sm" id="log_name" ><img src="../icons/photo1.png"/>Photo Gallery</a>

    <?php
        $user_name = $john -> get_username();
		$user_enroll = $john -> get_enroll();
        if($user_name != $username && $user_enroll != $enroll){
            //perform nothing
        }else{
            echo "<a href=\"profileedit\" role=\"button\" class=\"btn btn-sm\" id=\"log_name\"><img src=\"../icons/editprofile1.png\" />Edit Profile</a><br/>";
        }
    ?>
    </div>

    <div >

    </div>
</div>


<!--
Google map
<div class="body_inner">
    <div id="floating-panel">
      <input id="address" type="textbox" value="Sydney, NSW">
      <input id="submit" type="button" value="Geocode">
    </div>
    <div id="map" style="width:100%;height:200px;"></div>
    <div id="googleMap" style="width:100%;height:200px;"></div>
    <script>
        
        function myMap() {
            var lat;
            var log;
        navigator.geolocation.watchPosition(function(position) {
            lat = position.coords.latitude;
            log = position.coords.longitude;
            console.log(position.coords.accuracy);
        });
        var mapProp= {
            center:new google.maps.LatLng(6.36967,4.78469),
            zoom:5,
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true,
            rotateControl: true 
        };
        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        }

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    //my key is == AIzaSyA1-zrwHSUaROelGiPBeOuUh9e8j94VpWo
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1-zrwHSUaROelGiPBeOuUh9e8j94VpWo&callback=myMap"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi9iACaSJH4q3MBVP8ODUp-KiV3SoBJgY&callback=initMap"></script>
</div>
-->



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
