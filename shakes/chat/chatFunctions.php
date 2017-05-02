<?php
include_once("security/encrypt.php");
ob_start();
define("DBSEVER", "localhost",true);
define("DBUSER", "root", true);
define("DBPASS", "", true);
define("DBASE", "john_carter", true);
define("APP_NAME", "MOMENTS", true);

class john_carter extends enc
{
	var $conn = "";
	var $second_feeds = "";
	var $feeds_out = "";
	var $posted_file = "";
	var $page_buffer_from = "";
	var $user_id = "";
	var $user_name = "";
	var $json = array();
	var $last_id = null;

	function __construct()
  	{
  		/* activate reporting */
		//$driver = new mysqli_driver();
		//$driver->report_mode = MYSQLI_REPORT_ALL;
     	$this->conn = mysqli_connect(DBSEVER,DBUSER,DBPASS, DBASE);
  	}

	function select($query){
	 	$result = $this->conn->query($query);
	 	return $result;
 	}

	function delete($query){
		$result = $this->conn->query($query);
		return $result;
	}

 	function insert($query){
	 	$result = $this->conn->query($query);
	 	return $result;
 	}

	function update($query){
	 	$result = $this->conn->query($query);
	 	return $result;
 	}

	function logout_user(){
    	unset($_SESSION['mat']);
    	unset($_SESSION['img']);
    	header('location: index.php');
    	exit();
  	}

  	function redirect($location){
    	header("location: {$location}");
    	exit();
  	}

	function user_details($username,$enroll){
  		$sql = "SELECT uimg FROM stud_data WHERE usr_name='{$username}' AND usr_roll='{$enroll}'";
		$result = $this->select($sql);
		$count = $result->num_rows;
		if($count>0){
			while ($row = $result->fetch_row()) {
           		if ($row[0] == '' || $row[0] == 'usr_photo/') {
                	echo "<div class=\"navbar-brand collapse navbar-collapse wxp\">"
						."<img src='../icons/nop/shakes_no_pic.png' width='30px' height='30px' class=\"view-img\" /> "
						."</div>"
						."<div class=\"navbar-brand collapse navbar-collapse wxp\" >".$username ."</div>";
            	} else {
                	echo "<div class=\"navbar-brand collapse navbar-collapse wxp\">"
						."<img src='../{$row[0]}' width='30px' height='30px' class=\"view-img img-rounded viewimg\" > "
						."</div>"
						."<div class=\"navbar-brand collapse navbar-collapse wxp\">".$username ."</div>";
            	}
        	}
    	}
    	mysqli_free_result($result);
	}


	function check_login() {
		if((isset($_SESSION['username']) && isset($_SESSION['enroll'])) && (($_SESSION['username'] != "") && ($_SESSION['enroll'] != ""))){
			return true;
		}else{
			return false;
		}
	}

	function get_username(){
		return $_SESSION['username'];
	}


	function get_enroll() {
		return $_SESSION['enroll'];
	}


	function back_to_login() {
		header('Location: index');
		exit();
	}


	function send_to_chat() {
		header('Location: chat/chat');
		exit();
	}

	
	function get_timeago( $ptime ){
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
	}


	//time ago function
	function time_ago($date){
    	$periods = array("Sec", "Min", "Hr", "Day", "Week", "Mon", "Year");
    	$lengths = array(60,60,12,7,4.35,12,365);
    	$now = time();
    	$unix_date = $date;
    	// check validity of date
    	if( empty( $unix_date ) ){
        	//return "Bad date";
    	}
    	
        $difference = $now - $unix_date;
        $e = $difference;
        $tense = "Ago";

    	for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ ){
        	$difference /= $lengths[$j];
    	}
    		$difference = round($difference);
    		if( $difference != 1 ){
        		$periods[$j].= "s";
    		}

    		if($periods[$j] == "Year" || $periods[$j] == "Years"){
        		return date('d', strtotime($unix_date))." ".date('M', strtotime($unix_date))." ".date('Y', strtotime($unix_date))." at ".date('h:ia', strtotime($unix_date));
    		}elseif($periods[$j] == "Days" || $periods[$j] == "Week" || $periods[$j] == "Weeks" || $periods[$j] == "Mon" || $periods[$j] == "Mons"){
				//test for same year
				if(date('Y', $unix_date) == date('Y', time())){
					return date('d', $unix_date)." ".date('M', $unix_date)." at ".date('h:ia', $unix_date);
				}else{
        			return date('d', $unix_date)." ".date('M', $unix_date)." ".date('Y', $unix_date)." at ".date('h:ia', $unix_date);
				}
    		}elseif($difference == 1 && $periods[$j] == "Day"){
        		return "yesterday at ".date('h:ia', $unix_date);
    		}elseif($difference < 60 && ($periods[$j] == "Sec" || $periods[$j] == "Secs")){
        		return "now";
    		}else{
        		return "$difference $periods[$j] {$tense}";
    		}
    	//}
	}

	//validate user
	function validate_login($user, $pass, $keep){
		if(isset($user) && isset($pass)) {
			$enrollemail = htmlentities($user);
			$enrollemail = $this->conn->real_escape_string($enrollemail);
			$password = htmlentities($pass);
			$password = $this->conn->real_escape_string($password);
			$password = md5("5".$password."@");
			//check the email address
			$sql = "SELECT * FROM stud_data WHERE user_email='{$enrollemail}' AND usr_pass='{$password}' LIMIT 1";
			$result = $this->select($sql);
			$row = $result->fetch_assoc();
				$enroll = $row['usr_roll'];
				$sql = "SELECT usr_name FROM stud_data WHERE usr_roll='{$enroll}' AND usr_pass='{$password}' LIMIT 1";
				$result = $this->select($sql);
				$count = $result->num_rows;
				if($count==0) {
					$sql = "SELECT * FROM stud_data WHERE user_email='".$enrollemail."' LIMIT 1";
					$result = $this->select($sql);
					$usercount = $result->fetch_row();
					if($usercount != ""){
						$_SESSION['errorLogin'] = "<div class=\"errorpassword errL\"><p class=\"cont\">Incorrect password</div>";
					}else{
						$_SESSION['errorLogin'] = "<div class=\"errorusername errL\"><p class=\"cont\">Incorrect username</div>";
					}
					$this->back_to_login();
				}else{
						$row = $result->fetch_array();
						parent::__construct($enrollemail,$pass);
						$username = $row['usr_name'];
						//$username = parent::decrypt($username);
						$_SESSION['username'] = $username;
						$_SESSION['enroll'] = $enroll;

    					$time = time();
    					$status = "yes";
  						$sql = "UPDATE stud_data SET online='{$status}', time='{$time}' WHERE usr_roll='{$enroll}'";
						$this->update($sql);
						$sql = "UPDATE user_friend SET online='{$status}', time='{$time}' WHERE friend_enroll='{$enroll}'";
						$this->update($sql);
						//setting cookies for 7days
						setcookie("username","{$username}",time()+(60*60*24*365*10),"/","",0);
						setcookie("enroll","{$enroll}",time()+(60*60*24*365*10),"/","",0);
						setcookie("email","{$enrollemail}",time()+(60*60*24*365*10),"/","",0);
						setcookie("password","{$password}",time()+(60*60*24*365*10),"/","",0);
						$this->send_to_chat();
				}
				mysqli_free_result($result);
		}else{
			$this->back_to_login();
		}
	}

	//this function set the chat session
	function startChatSession($to_roll,$enroll) {
		$t = time();
		$sql = "INSERT INTO chat_session (to_enroll,from_enroll) VALUES (".$to_roll.", ".$enroll.")";
		$this->insert($sql);
		return null;
	}

	//this function check for the user online status
	function checkMyOnlineStatus($enroll) {
		$sql = "SELECT online FROM stud_data WHERE usr_roll='{$enroll}' LIMIT 1";
		//$sql = "SELECT online FROM user_friend WHERE friend_enroll=".$enroll." LIMIT 1";
		$result = $this->select($sql);
		$row = $result->fetch_assoc();
			echo "<root online='".$row['online']."'><roll>".$enroll."</roll></root>";
	}

	//this function check for the user data main imade
	function getimgdata($enroll){
		global $con;
		$sql = "SELECT * FROM stud_data WHERE usr_roll=".$enroll."";
		$result = $this->select($sql);
		while($row = $result->fetch_assoc()){
			return "<img src=\"../$row[uimg]\"/ class=\"posterimg img-circle viewimg\">";
		}
	}

	//this function set the online status by updating the database
	function setOnlineStatus($enroll,$status) {
  		$time = time();
  		$sql = "UPDATE stud_data SET online='{$status}', time='{$time}' WHERE usr_roll='{$enroll}'";
		$this->update($sql);
		$sql = "UPDATE user_friend SET online='{$status}', time='{$time}' WHERE friend_enroll='{$enroll}'";
		$this->update($sql);
	}

	//this function handles the message sent
	function sendChat($to_enroll,$to_user,$msg,$enroll,$username) {
		$t=time()-180;   // time to be used to check if the message can be concatinated.
		$i=0;
        //date and time function
        $msg_status = "unread";
        $sdate = date("d M Y");
        $stime = time();
		//security measure form attacks
		//$msg = nl2br($msg);
		$msg = htmlentities($msg);
		$msg = $this->conn->real_escape_string($msg);

		$sql = "SELECT null FROM user_friend WHERE user_enroll=".$enroll." AND online='yes' LIMIT 1";
		$result = $this->select($sql);
		$count = $result->num_rows;
		if($count==0){
			return;
		}
		$sql = "SELECT *  FROM chat_messages WHERE ((to_enroll='".$to_enroll."' AND from_enroll='".$enroll."') OR (to_enroll='".$enroll."' AND from_enroll='".$to_enroll."')) AND time>=".$t." ORDER BY msg_id DESC LIMIT 1";
        $result = $this->select($sql);
        $count = 1;
        while($row = $result->fetch_assoc()) {
        	//check if the sent message is from the user then it add the newer
        	//message with the later sent by updating the former message column
            if($row['from_enroll']==$enroll) {
                $msg_id = $row['msg_id'];
                $newmsg = "<br>".$msg;
	            $sql = "UPDATE chat_messages SET msg=concat(msg,'".$newmsg."'), msg_status='".$msg_status."',sdate='".$sdate."',stime='".$stime."',time=".time()." WHERE msg_id=".$msg_id."";
        	    $this->update($sql);
			}else {
       			//if not from the same user then insert the new message into
       			//new row
   				$chat_id = $this->getLastChatId($to_enroll);
				$newsql = "INSERT INTO chat_messages (chat_id,to_enroll,to_user,from_enroll,from_user,msg,msg_status,time,sdate,stime) VALUES (".$chat_id.", ".$to_enroll.", '".$to_user."', ".$enroll.", '".$username."', '".$msg."','".$msg_status."', ".time().", '".$sdate."', '".$stime."')";
				$this->insert($newsql);
			}
			$count=0;
		}
		if($count) {
			$chat_id = $this->getLastChatId($to_enroll);
            $newsql = "INSERT INTO chat_messages (chat_id,to_enroll,to_user,from_enroll,from_user,msg,msg_status,time,sdate,stime) VALUES (".$chat_id.", ".$to_enroll.", '".$to_user."', ".$enroll.", '".$username."', '".$msg."', '".$msg_status."', '".time()."', '".$sdate."', '".$stime."')";
            $this->insert($newsql);
		}
		$this->setWritingStatus($enroll,"no");
		echo "<root success='yes'><user>".$to_user."</user></root>";
	}

	//this function gets the message sent from other user and user
	function getChat($to_enroll,$enroll) {
		$index = 0;
		//$t = time()-3;
		$t = time()-3;
		//select the writing status of your friend
		$sql = "SELECT * FROM user_status WHERE enroll= {$to_enroll} ";
		$result = $this->select($sql);
		while($r = $result->fetch_assoc()) {
			if($r['writing'] == "yes"){
				$status = "yes";
			}else{
				$status = "no";
			}
		}
		//this will get the whole chat details
		$sql = "SELECT from_user,from_enroll,msg,stime,sdate FROM chat_messages WHERE ((to_enroll='".$to_enroll."' AND from_enroll='".$enroll."') OR (to_enroll='".$enroll."' AND from_enroll='".$to_enroll."')) ORDER BY msg_id DESC LIMIT 50";
        $result = $this->select($sql);
        $count = $result->num_rows;
		echo "<root count='". $count."' status='". $status ."'>";
        while($row = $result->fetch_assoc()) {
			if($row['from_enroll']==$enroll){
				$row['from_user']="Me";
			}
			$msg = $row['msg'];
			$i=0;
			$msg = nl2br($msg);
			$msg = htmlentities($msg);
			$msg = stripslashes($msg);
    		//time and date message was sent
    		$time = date('Y-m-d h:i:s a',$row['stime']);
    		//update the chat message that the message has been read
    		$msg_status = "read";
    		$sqlread = "UPDATE chat_messages SET msg_status='".$msg_status."' WHERE to_enroll='".$enroll."' AND from_enroll='".$to_enroll."'";
			$this->update($sqlread);
			//display the message and its details
			if($row['from_user'] == "Me"){
				echo "<messages><user>".$row['from_user']."</user><msg>".$msg."</msg><when>".$this->time_ago($time)."</when></messages>";
			}else{
				echo "<messages><user>".$row['from_user']."</user><msg>".$msg."</msg><when>".$this->time_ago($time)."</when></messages>";
			}
		}
		echo "</root>";
	}

	function getLastChatId($to_enroll) {
		$sql = "SELECT * FROM chat_session WHERE to_enroll='".$to_enroll."' ORDER BY chat_id DESC LIMIT 1";
        $result = $this->select($sql);
        while($row = $result->fetch_assoc()) {
            $chat_id = $row['chat_id'];
        }
		return $chat_id;
	}

	function setWritingStatus($enroll,$s) {
		$time = time();
		$sql = "SELECT * FROM user_status WHERE enroll='".$enroll."' LIMIT 1";
		$result = $this->select($sql);
		$count = $result->num_rows;
		if($count == 1) {
			$sql1 = "UPDATE user_status SET writing='".$s."', stime='".$time."' WHERE enroll='".$enroll."'";
			$this->update($sql1);
		}else{
			$sql2 = "INSERT INTO user_status (id,enroll,writing,stime) VALUES (null,'".$enroll."', '".$s."', '".$time."')";
			$this->insert($sql2);
		}
	}

	//popupchat
	function popUpChat($enroll) {
		$t = time()-3;
        $sql = "SELECT from_enroll,from_user,msg FROM chat_messages WHERE to_enroll=".$enroll." AND time>=".$t." ORDER BY msg_id DESC";
        $result = $this->select($sql);
        $c = $result->num_rows;
        echo "<root count='".$c."'>";
        while($r = $result->fetch_assoc()) {
                echo "<users><name>".$r['from_user']."</name><roll>".$r['from_enroll']."</roll></users>";
        }
        echo "</root>";
	}

	//inbox
	function inbox_s($msg_id,$enrollment,$enroll){
		$xy = 0;
  		//$sql = "select * from chat_messages where from_enroll='".$enrollment."' and to_enroll='".$enroll."' and //msg_status='".$msg_status."' ORDER BY  time desc limit 0,5";
		$sql = "select * from chat_messages where msg_id='".$msg_id."' ORDER BY  1 desc limit 0,100";
  		$result = $this->select($sql);
  		$row = $result->fetch_row();
  		if($row[5] ==''){
                        //
  		}else{
        	$message ="<tr class=\"msg-detail\">";
        	$sql1 = "SELECT * FROM stud_data where usr_roll='".$enrollment."'";
        	$result = $this->select($sql1);
        	$rowimg = $result->fetch_assoc();
			if($rowimg['uimg'] == '' || $rowimg['uimg'] == 'usr_photo/'){
				$rowimg['uimg'] = 'icons/nop/shakes_no_pic.png';
			}
			$msg = $row[6];
			if(strlen($msg) > 25){
				$msg = substr($msg,0,25).".....";
			}else{
				$msg .= "..";
			}
       		$message .="<td class=\"tab-img-msg\">"
					."<img src='../{$rowimg['uimg']}' class='inbox_img img-circle viewimg'/>"
					."</td>"
            		."<td class='msg-sender'>"
					."<a href='message_chat?chat_name={$rowimg['usr_name']}&enrollment=$enrollment'><p><strong>"
					.$rowimg["usr_name"]."</p></strong><p class=\"mssg\">"
					.$msg."</p></a>"
					."</td>"
            		."<td class='msg-time'>"
					."<a href='message_chat?chat_name=$row[5]&enrollment=$enrollment'>"
					.$this->time_ago($row[9])
					."</a>"
					."</td>"
            		."</tr>";
        	echo $message;
  		}
        mysqli_free_result($result);
	}

	function inbox($enroll){
		$contact_list = $this->contactlist($enroll);
		$lenghtoflist = sizeof($contact_list);
		$latestchat = array();
		$sql2 = "SELECT * FROM chat_messages WHERE from_enroll='".$enroll."' or to_enroll='".$enroll."' ORDER BY 1 desc LIMIT 0, 1000";
        $result = $this->select($sql2);
        while($row = $result->fetch_assoc()){
			foreach ($contact_list as $value) {
				if(($value == $row['to_enroll']) && (!in_array($row['to_enroll'],$latestchat))){
                	$this->inbox_s($row['msg_id'],$value,$enroll);
									$latestchat[] = $row['to_enroll'];
				}elseif(($value == $row['from_enroll']) && (!in_array($row['from_enroll'],$latestchat))){
                	$this->inbox_s($row['msg_id'],$value,$enroll);
									$latestchat[] = $row['from_enroll'];
				}
			}
			unset($value);
		}
        mysqli_free_result($result);
	}

	function notification_frnd($enroll, $username){
        $sql = "SELECT user_enroll FROM friend_request where friend_enroll='$enroll'";
        $result = $this->select($sql);
        while ($rows = $result->fetch_row()) {
            ///////////////////// code to get each user using their enroll number  /////////////////////////////
            for($i=0; $i < $result->field_count; $i++){
                $enrollment = $rows[$i];
                $sql = "SELECT * FROM stud_data where usr_roll='$enrollment'";
                $resulta = $this->select($sql);
                $row = $resulta->fetch_assoc();
				if($row['uimg'] == '' || $row['uimg'] == 'usr_photo/'){
					$row['uimg'] = 'icons/nop/shakes_no_pic.png';
				}

                echo "<tr><td>"
                    . "<div class='addfriend_form'>"
					. "<img src='../{$row['uimg']}' width='40px' height='30px' text-align='center' id='profile-pic' class=\"viewimg\"/>"
					. "</td><td>"
                    . "{$row['usr_name']}"
					. "</td><td>"
					. "<form method='POST' action='addremovefriend.php' class='form_add'>"
                    . "<input name='friend_name' type='hidden' value='{$row['usr_name']}' />"
                    . "<input name='friend_id' type='hidden' value='$enrollment' />"
                    . "<input name='user_id' type='hidden' value='$enroll' />"
                    . "<input name='user_name' type='hidden' value='$username' />"
                    . "<input name='type' type='hidden' value='accept' />"
                    . "<input type='submit' value='Accept ' class=\"btn btn-sm\" /></form></td>"
                    . "</td><td>"
					. "<form method='POST' action='addremovefriend.php' class='form_add'>"
                    . "<input name='friend_name' type='hidden' value='{$row['usr_name']}' />"
                    . "<input name='friend_id' type='hidden' value='$enrollment' />"
                    . "<input name='user_id' type='hidden' value='$enroll' />"
                    . "<input name='user_name' type='hidden' value='$username' />"
                    . "<input name='type' type='hidden' value='decline' />"
                    . "<input type='submit' value='Decline' class=\"btn btn-sm\" /></form></td></tr>";
				mysqli_free_result($resulta);
              }
        }
        mysqli_free_result($result);
	}

	function not_1_bar($enroll, $username){
        $sql = "SELECT user_enroll FROM friend_request where friend_enroll='$enroll'";
        $result = $this->select($sql);
        while ($rows = $result->fetch_row()) {
			///////////////////// code to get each user using their enroll number  /////////////////////////////
			for($i=0; $i < $result->field_count; $i++){
                $enrollment = $rows[$i];
                $sql = "SELECT * FROM stud_data where usr_roll='$enrollment'";
                $resulta = $this->select($sql);
                $row = $resulta->fetch_assoc();
				if($row['uimg'] == '' || $row['uimg'] == 'usr_photo/'){
					$row['uimg'] = 'icons/nop/shakes_no_pic.png';
				}
                echo "<tr><a href=\"#\" width='100%'><td>"
					."<div class='addfriend_form'>"
					."<img src='../{$row['uimg']}' width='30px' height='30px' id='profile-pic' class=\"viewimg\" /></td><td>"
                    ."{$row['usr_name']}"
					."</td><td>"
					."<form method='POST' action='addremovefriend.php' class='form_add'>"
                    ."<input name='friend_name' type='hidden' value='{$row['usr_name']}' class='friend_name' />"
                    ."<input name='friend_id' type='hidden' value='$enrollment' />"
                    ."<input name='user_id' type='hidden' value='$enroll' />"
                    ."<input name='user_name' type='hidden' value='$username' />"
                    ."<input name='type' type='hidden' value='accept' />"
                    ."<input type='submit' value='Accept' class=\"btn btn-xm\" /></form></div></td></a></tr>";
				mysqli_free_result($resulta);
			}
        }
        mysqli_free_result($result);
	}

	function chatSendfrnd($to_enroll,$to_user,$msg,$enroll,$username){
		$t=time()-180;   // time to be used to check if the message can be concatinated.
		$i=0;
    	//date and time function
    	$msg_status = "unread";
    	$sdate = date("d M Y");
    	$stime = time();
		//security measure form attacks
		$msg = htmlentities($msg);
		$msg = $this->conn->real_escape_string($msg);

    	$chat_id = $this->getLastChatId($to_enroll);
    	$newsql = "INSERT INTO chat_messages (chat_id,to_enroll,to_user,from_enroll,from_user,msg,msg_status,time,sdate,stime) VALUES (".$chat_id.", ".$to_enroll.", '".$to_user."', ".$enroll.", '".$username."', '".$msg."', '".$msg_status."', '".time()."', '".$sdate."', '".$stime."')";
    	$this->insert($newsql);

		$this->setWritingStatus($enroll,"no");
		echo "<root success='yes'><user>".$to_user."</user></root>";
	}

	//this function is for the main block or larger message block
	//it get the older messages
	function chatwithfrnd($name,$enrollment,$enroll){
    	$index = 0;
    	$t = time()-8;
    	//select the writing status of your friend
    	$sql = "SELECT * FROM user_status WHERE enroll={$enrollment}";
    	$query = $this->select($sql);
    	$row = $query->fetch_assoc();
        if($row["writing"]=="yes"){
            	$status = "yes";
        }else{
            	$status = "no";
        }
    	mysqli_free_result($query);

			//this will get the whole chat details
            $sql = "SELECT * FROM chat_messages WHERE ((to_enroll='".$enroll."' AND from_enroll='".$enrollment."') OR (to_enroll='".$enrollment."' AND from_enroll='".$enroll."')) ORDER BY msg_id DESC";
            $result = $this->select($sql);
            $count = $result->num_rows;
            $i = 0;
            while($row = $result->fetch_assoc()) {
            	if($row['from_enroll']==$enroll){
                    $row['from_user']="Me";
            	}
            	$msg_id = $row['msg_id'];
            	$msg = $row['msg'];

				$msg = nl2br($msg);
            	//$msg = htmlentities($msg);
            	$msg = stripslashes($msg);

				//time and date message was sent
                $time = $row['stime'];
				//update the chat message that the message has been read
             	$msg_status = "read";
             	$sqlread = "UPDATE chat_messages SET msg_status='".$msg_status."' WHERE msg_id='".$msg_id."' AND (to_enroll='".$enroll."' AND from_enroll='".$enrollment."'";
            	$this->update($sqlread);
				//display the message and its details
				$json[$i] = array("message"=>array('id' => $msg_id, 'count' => $count, 'status' => $status, 'user' => $row['from_user'], 'msg' => $msg, 'when' => $this->time_ago($time)));
				$i++;
    		}
          echo json_encode($json);
	}


	//this function gets the newer messages
	//for the bigger message block
	function newchatwithfrnd($name,$enrollment,$enroll,$id){
    	$index = 0;
    	$t = time()-8;
    	//select the writing status of your friend
    	$sql = "SELECT * FROM user_status WHERE enroll={$enrollment}";
    	$query = $this->select($sql);
    	$row = $query->fetch_assoc();
        if($row["writing"]=="yes"){
            	$status = "yes";
        }else{
            	$status = "no";
        }
    	mysqli_free_result($query);
		//this will get the new chat sent
        $sql = "SELECT * FROM chat_messages WHERE msg_id > {$id} AND ((to_enroll='".$enrollment."' AND from_enroll='".$enroll."') OR (to_enroll='".$enroll."' AND from_enroll='".$enrollment."')) ORDER BY msg_id DESC";
        $result = $this->select($sql);
        $count = $result->num_rows;
        $i = 0;
        while($row = $result->fetch_assoc()) {
            if($row['from_enroll']==$enroll){
                    $row['from_user']="Me";
            }
           	$msg_id = $row['msg_id'];
            $msg = $row['msg'];
			$msg = nl2br($msg);
            //$msg = htmlentities($msg);
            $msg = stripslashes($msg);
			//time and date message was sent
            $time = $row['stime'];
			//update the chat message that the message has been read
            $msg_status = "read";
            $sqlread = "UPDATE chat_messages SET msg_status='".$msg_status."' WHERE msg_id='".$msg_id."' AND (to_enroll='".$enroll."' AND from_enroll='".$enrollment."')";
            $this->update($sqlread);
			//display the message and its details
            $json[$i] = array("message"=>array('id' => $msg_id, 'count' => $count, 'status' => $status, 'user' => $row['from_user'], 'msg' => $msg, 'when' => $this->time_ago($time)));
			$i++;
    	}
    	echo json_encode($json, true);
	}

	//this function gets the friends list of a logged in user
	function friends($enroll,$friend = NULL){
		$token= $this->token();
		$sql = "SELECT friend_enroll FROM user_friend where user_enroll='{$enroll}'";
        $result = $this->select($sql);
        $friends_count = $result->num_rows;
        echo "<tr><td colspan='3' align='center'> Friends (".$friends_count.")<td></tr>";
        while ($row = $result->fetch_row()) {
            ///////////////////// code to get each user using their enroll number  /////////////////////////////
            for($i=0; $i < $result->field_count; $i++){
                $enrollment = $row[$i];
                $sql1 = "SELECT * FROM stud_data where usr_roll='{$enrollment}'";
                $resulta = $this->select($sql1);
                $rowim = $resulta->fetch_assoc();
                //friends with no profile picture
                if($rowim["uimg"] =='' || $rowim["uimg"] =='usr_photo/') {
                	$rowim["uimg"] = "icons/nop/shakes_no_pic.png";
				}
                //image and name of friend
                $data = "<tr>"
						."<td><img src='../{$rowim["uimg"]}' width='40px' height='40px' class=\"viewimg\" /></td>"
						."<td><a href='profile?fr_name={$rowim["usr_name"]}&enroll={$enrollment}&token={$this->token_session()}' class=\"btn btn-link\" >"
                        ."{$rowim["usr_name"]}</a>"
						."<td>"
                        ."<a href='message_chat?chat_name={$rowim['usr_name']}&enrollment=$enrollment' role='button' class=\"label label-info\" title='chat with {$rowim['usr_name']}'>"
						."Chat</a>"
						."</tr>";
                echo $data;
                mysqli_free_result($resulta);
            }
        }
        mysqli_free_result($result);
	}

	//thios function gets the friends list of a logged in user in the profile view
	function profile_friends($enroll,$friend = NULL,$user = NULL){
		if($enroll == $user){
			$friend = false;
		}
		$sql = "SELECT friend_enroll FROM user_friend where user_enroll='$enroll'";
        $result = $this->select($sql);
        $friends_count = $result->num_rows;
        echo "<tr><td colspan='3' align='left'> Friends (".$friends_count.").<td></tr>";
        while ($row = $result->fetch_row()) {
            ///////////////////// code to get each user using their enroll number  /////////////////////////////
            for($i=0; $i < $result->field_count;$i++){
                $enrollment = $row[$i];
                ////////////////////
                $sql1 = "SELECT * FROM stud_data where usr_roll='$enrollment'";
                $resulta = $this->select($sql1);
                $rowim = $resulta->fetch_assoc();
                //friends with no profile picture
                if ($rowim["uimg"] =='' || $rowim["uimg"] =='usr_photo/') {
                	$rowim["uimg"] = "icons/nop/shakes_no_pic.png";
				}
                //image and name of friend
                $data = "<tr>"
						."<td><img src='../{$rowim["uimg"]}' width='30px' height='30px' class=\"viewimg\" /></td>"
						."<td><form action='profile' method='post'>"
                        ."<input type='hidden' value='{$rowim["usr_name"]}' name='fr_name' />"
                        ."<input type='hidden' value='$enrollment' name='enroll' />"
                        ."<input type='submit' value='{$rowim["usr_name"]}' class=\"btn btn-link\" /></form>"
						."</td><td>"
                        ."<a href='message_chat?chat_name={$rowim["usr_name"]}&enrollment=$enrollment' role='button' class=\"label label-info\" title='chat with {$rowim["usr_name"]}'>"
						."Chat</a></td></tr>";
				echo $data;
                mysqli_free_result($resulta);
            }
        }
        mysqli_free_result($result);
	}

	//check the notification
	function checkNotification(){
    	$enroll = $this->get_enroll();
    	$sqlquery1 = "select null from friend_request where friend_enroll='{$enroll}'";
    	$result = $this->select($sqlquery1);
    	$row = $result->num_rows;
    	echo $row;
    	mysqli_free_result($result);
	}


	//numbers of friends a user has
	function no_of_friends($enroll){
        $sql = "SELECT friend_enroll FROM user_friend where user_enroll='$enroll'";
        $result = $this->select($sql);
        $friends_count = $result->num_rows;
        mysqli_free_result($result);
        return $friends_count;
	}

	//this function gets the friends list of a logged in user
	function contactlist($enroll = NULL){
		$sql = "SELECT friend_enroll FROM user_friend where user_enroll='$enroll'";
      	$result = $this->select($sql);
      	$friends_count = $result->num_rows;
		$send = array();
      	while($row = $result->fetch_row()){
			//puch the contact enroll list into the array
			array_push($send,$row[0]);
		};
		return $send;
      	mysqli_free_result($result);
	}

	//get the user profile picture
	function user_picture($the_user_name, $the_user_enroll){
		$sql = "SELECT uimg FROM stud_data WHERE usr_name='{$the_user_name}' AND usr_roll='{$the_user_enroll}'";
		$result = $this->select($sql);
		$count = $result->num_rows;
		if($count>0){
			while($row = $result->fetch_row()){
				if ($row[0] =='' || $row[0] =='usr_photo/') {
                	return $user_image= "icons/nop/shakes_no_pic.png";
				}else{
                	return $user_image = $row[0];
            	}
        	}
		}
		mysqli_free_result($result);
	}

	//this function gets the numbers of likes
	function likes($post_id,$enroll){
		$like = 1;
		$sqllike = "SELECT l_like FROM likes WHERE post_id ='".$post_id."' AND l_like = '".$like."'";
		$result = $this->select($sqllike);
		$c_likes = $result->num_rows;

		$sqlcom = "SELECT id FROM post_comments WHERE post_id ='".$post_id."'";
		$result = $this->select($sqlcom);
		$c_post = $result->num_rows;
		//check if user liked post
		$sql = "SELECT * FROM likes WHERE post_id ='".$post_id."' AND user_enroll = '".$enroll."'";
		$query = $this->select($sql);
		$check = $query->fetch_row();
		if($check >= 1){
			if($c_likes == 1){
				echo $c_likes ." like";
			}else{
				echo $c_likes ." likes";
			}
		}else{
			if($c_likes == 0){
				echo $c_likes ." like";
			}else{
				echo $c_likes ." likes";
			}
		}
	}


	//this function is all about the like button
	function like_post_button($post_id, $enroll){
        $like = 1;
        $sqllike = "SELECT l_like FROM likes WHERE post_id ='".$post_id."' AND l_like = '".$like."'";
        $result = $this->select($sqllike);
        $c_likes = $result->num_rows;

        $sqlcom = "SELECT id FROM post_comments WHERE post_id ='".$post_id."'";
        $result = $this->select($sqlcom);
        $c_post = $result->num_rows;
		//check if user liked post
		$sql = "SELECT * FROM likes WHERE post_id ='".$post_id."' AND user_enroll = '".$enroll."'";
		$query = $this->select($sql);
		$check = $query->fetch_row();
		if($check >= 1){
			$like = "<img src=\"../icons/postaction/liked_32.png\">";
			if($c_likes == 1){
				$c_likes =  $c_likes ." like";
			}else{
				$c_likes =  $c_likes ." likes";
			}
		}else{
			$like = "<img src=\"../icons/postaction/like_32.jpg\">";
			if($c_likes == 0){
				$c_likes =  $c_likes ." like";
			}else{
				$c_likes =  $c_likes ." likes";
			}
		}
        echo "<br/><div id=\"post_actions\">"
            . "<input type='hidden' value='$post_id' id=\"post_id$post_id\" />"
            . "<input type='hidden' value='$enroll' id=\"user_enroll$enroll\" />"
			. "<p id=\"nums_like\" class=\"nums_like$post_id\"> $c_likes </p><p>"."   "."$c_post comments</p>"
            . "</div>"
			."</div>"
			."<div id=\"post_action\"><table><tr>"
			."<td id=\"like\"><p onclick=\"like(document.getElementById('user_enroll$enroll').value,document.getElementById('post_id$post_id').value)\" id=\"see$post_id\">{$like}</p></td>"
			."<td id=\"comment\"><p data-toggle=\"collapse\" data-target=\"#comments_unit$post_id\" ><img src=\"../icons/postaction/comm_32.jpg\"></p></td>"
			."<td id=\"share\"><p><img src=\"../icons/postaction/share_32.jpg\"></p></td>"
			."</tr></table></div>"
			. "<div id=\"comments_unit$post_id\" class=\"collapse\">"
            . "<div id=\"post_line_shakes\"><div id='p_l_s_table'>";
        mysqli_free_result($result);
	}

	//this is for the post_section
	function post_section($post_id, $enroll){
        $like = 1;
        $sqllike = "SELECT l_like FROM likes WHERE post_id ='".$post_id."' AND l_like = '".$like."'";
        $result = $this->select($sqllike);
        $c_likes = $result->num_rows;
		$sqlcom = "SELECT id FROM post_comments WHERE post_id ='".$post_id."'";
        $result = $this->select($sqlcom);
        $c_post = $result->num_rows;
		//check if user liked post
		$sql = "SELECT * FROM likes WHERE post_id ='".$post_id."' AND user_enroll = '".$enroll."'";
		$query = $this->select($sql);
		$check = $query->fetch_row();
		if($check >= 1){
			$like = "<img src=\"../icons/postaction/liked_32.png\">";
			if($c_likes == 1){
				$c_likes =  $c_likes ." like";
			}else{
				$c_likes =  $c_likes ." likes";
			}
		}else{
			$like = "<img src=\"../icons/postaction/like_32.jpg\">";
			if($c_likes == 0){
				$c_likes =  $c_likes ." like";
			}else{
				$c_likes =  $c_likes ." likes";
			}
		}
        echo "<br/><div id=\"post_actions\">"
            ."<input type='hidden' value='$post_id' id=\"post_id$post_id\" />"
            ."<input type='hidden' value='$enroll' id=\"user_enroll$enroll\" />"
			."<p id=\"nums_like\" class=\"nums_like$post_id\"> $c_likes </p><p>"."   "."$c_post comments</p>"
            ."</div>"
			."</div>"
			."<div id=\"post_action\"><table><tr>"
			."<td id=\"like\"><p onclick=\"like(document.getElementById('user_enroll$enroll').value,document.getElementById('post_id$post_id').value)\" id=\"see$post_id\">{$like}</p></td>"
			."<td id=\"comment\"><p data-toggle=\"\" data-target=\"#comments_unit$post_id\" ><img src=\"../icons/postaction/comm_32.jpg\"></p></td>"
			."<td id=\"share\"><p><img src=\"../icons/postaction/share_32.jpg\"></p></td>"
			."</tr></table></div>"
			."<div id=\"comments_unit$post_id\" class=\"\">"
            ."<div><div id='p_l_s_table'>";
        mysqli_free_result($result);
	}


	//this function talks about the comment button for a post
	function comment_post($post_id,$enroll,$username){
        $user_image = $this->user_picture($username, $enroll);
        echo "</div><div class='logged_com' >"
            ."<form action='#{$post_id}' method='post'>"
            ."<input type='hidden' value='$post_id' name='post_id' />"
            ."<input type='hidden' value='$enroll' name='user_enroll' />"
            ."<input type='hidden' name='comment' class='comment' value='comment' />"
            ."<img src='../$user_image' width='30px' height='30px' text-align='center' class='comment_photo img-circle posterimg' />"
            ."<div class='msg_com'><input type='text' width='80%' placeholder='Throw comment.....' class='msg_comm'  name='com' maxlength=\"1024\" />"
            ."<span class='rule _petc'>Press Enter to Comment</span><input class='select-frnd' type='submit' value='Comment' />"
            ."</div></form></div></div></div></div>";
	}

	//this functionk talks ablout the people who have post comment on the post the looged kin user or his or her friends has post
	function people_who_comment($post_id){
        $sqlcom = "SELECT * FROM post_comments WHERE post_id ='".$post_id."' ORDER BY id DESC";
        $result = $this->select($sqlcom);
		echo "<div class=\"comments-s\" >";
        while ($comments = $result->fetch_row()){
            $sql="SELECT * FROM stud_data WHERE usr_roll={$comments[2]}";
            $resulta = $this->select($sql);
            $data = $resulta->fetch_assoc();
            //commenter who has no profile picture
            if ($data['uimg'] == 'usr_photo/' || $data['uimg'] == '') {
                $data['uimg'] = "icons/nop/shakes_no_pic.png";
            }
            echo "<div class=\"media\"> <div class=\"pull-left\" >"
                ."<img src=\"../{$data['uimg']}\" class=\"viewimg comm-img img-circle\" alt=\"Media Object\"> </div>"
				."<div class=\"media-body\">"
                ."<strong class=\"media-heading\">"
				."<form action='profile' method='post'>"
				."<input type='hidden' value=\"{$data['usr_name']}\" name='fr_name' />"
				."<input type='hidden' value=\"{$data['usr_roll']}\" name='enroll' />"
				."<button type='submit' class=\"btn-link\">"
				."{$data['usr_name']}</button></form></strong>"."   "
                ."commented on ".$comments[5]." at ".date('h:ia',$comments[4])
				."<div><p id=\"comm-txt\">{$comments[3]}</p></div>"
				."</div>"
				."</div>";
        }
		echo "</div>";
        mysqli_free_result($result);
	}

	//this funoction talks about the post content
	function post_cont($user_roll_test, $post_id, $user_enroll, $posted_content, $posted_file, $time_posted, $date){
    	$result= $this->select("SELECT * FROM stud_data WHERE usr_roll='$user_roll_test'");
    	$row4 = $result->fetch_assoc();
    	$user_namee = $row4["usr_name"];
    	$ppic = $row4["uimg"];
    	//this talks about those who post content but have no profile picture
    	if ($ppic == 'usr_photo/' || $ppic == '') {
        	$ppic = "icons/nop/shakes_no_pic.png";
    	}

    	if($posted_file == 'usr_photo/'){
        	$this->second_feeds ="";
    	}else{
        	if(stristr($posted_file, ".mp4") or stristr($posted_file, ".mpeg")){
            	$this->second_feeds = "<video src=\"../$posted_file\"  width='100%' height='auto' controls=\"controls\ class=\"post_vid\" ></video>";
        	}elseif(stristr($posted_file, ".mp3")){
            	$this->second_feeds = "<br/><audio width='100%' height='auto' controls=\"controls\" class=\"post_vid\" ><source src=\"../$posted_file\" type=\"audio/mpeg\"></audio>";
        	}elseif((stristr($posted_file, ".jpg")) or(stristr($posted_file, ".png")) ){
            	$this->second_feeds = "<img src='../$posted_file' class='imgposted' />";
        	}elseif(stristr($posted_file, ".pdf") ){
            	$this->second_feeds = "<label class=\"ftypelabel btn btn-default\"><a href='../$posted_file' class='imgposted' download=\"$user_namee\"><span class=\"ftype\">PDF</span>Download Attached document</a></label>";
        	}elseif((stristr($posted_file, ".doc")) or (stristr($posted_file, ".docx"))){
            	$this->second_feeds = "<label class=\"ftypelabel btn btn-default\"><a href='../$posted_file' class='imgposted' download=\"$user_namee\"><span class=\"ftype\">DOC</span>Attached Word document</a></label>";
        	}
			$posted_file = "../".$posted_file;
    	}
		//the next line talks about user that post content
    	$this->feeds_out = "<div class='post_contain_poster' >"
            ."<div class='poster dropdown' id='{$post_id}' name='{$post_id}'>"
			."<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">"
			."<img src='../$ppic' class='posterimg img-circle' />"
			."</a>"
            ."<div class='p_snd_details'>"
			."<strong><a href=\"post_section?id=$post_id\">".$user_namee."</a></strong><br>".$this->time_ago($date)
			."</div>"
			."<div class=\"pull-right dropdown\">"
			."<p class=\"dropdown-toggle\" data-toggle=\"dropdown\">option</p>"
			."<ul class=\"dropdown-menu\">"
			."<li><a href=\"\" >Delete this Post</a> </li>"
			."<li><a href=\"\" >Hide this Post</a> </li>"
			."<li><a href=\"\" >Report this Post</a> </li>"
			."</ul>"
			."</div>"
			."<ul class=\"dropdown-menu\">"
			."<div class=\"span3 dp\"><div class=\"hero-unit\"><img src='../$ppic' width='100%' height='200px' /></div></div>"
			."<li><a href=\"../$ppic\" download=\"$user_namee\">Download Display Picture</a> </li>";
		if($posted_file != 'usr_photo/'){
			$this->feeds_out .= "<li><a href=\"$posted_file\" download=\"$user_namee\" >Download Post's Content</a> </li>";
		}
		$this->feeds_out .="</ul>"
				."</div>"
                ."<div class='main_text'><p>$posted_content</p>";
		$this->feeds_out .= $this->second_feeds;
		echo $this->feeds_out;
    	mysqli_free_result($result);
	}


	//this function talks about the posst region
	function post_region($enrollment, $enroll, $username,$from_profile=NULL){
        //save the friend enroll into a variable
        $result = $this->select("SELECT * FROM user_post WHERE user_enroll='$enrollment' ORDER BY id desc");
        while($row3 = $result->fetch_row()){
        	if($row3[1] == ""){
                        //do nothing
        	}else{
         		$this->posted_file = $row3[3];
            	$this->post_cont($row3[1], $row3[0], $row3[1], $row3[2], $this->posted_file, $row3[4], $row3[4]);
            	////get the  numbers of likes
            	$this->like_post_button($post_id = $row3[0], $enroll);
            	/////people who comment
            	//check if this function is called from the profile page
            	if(!empty($from_profile)){
                	$this->people_who_comment($post_id = $row3[0]);
            	}else{
                	$this->people_who_comment($post_id = $row3[0]);
            	}
            	//user comment post
            	$this->comment_post($post_id,$enroll,$username);
        	}
        }
        mysqli_free_result($result);
	}

	//this function talks about the posst region
	function news_feed_region($id, $enroll, $username,$from_profile=NULL){
        //save the friend enroll into a variable
        $result = $this->select("SELECT * FROM user_post WHERE id='$id'");
        $row3 = $result->fetch_row();
        $this->post_cont($row3[1], $row3[0], $row3[1], $row3[2], $row3[3], $row3[4], $row3[4]);
        //get the  numbers of likes
        $this->like_post_button($post_id = $row3[0], $enroll);
        //people who comment
        $this->people_who_comment($post_id = $row3[0]);
        //user comment post
        $this->comment_post($post_id,$enroll,$username);
        mysqli_free_result($result);
	}

	//this function talks about the posst region
	function news_feed_region_post_section($id, $enroll, $username,$from_profile=NULL){
        //save the friend enroll into a variable
        $result = $this->select("SELECT * FROM user_post WHERE id='$id'");
        $row3 = $result->fetch_row();
        $this->post_cont($row3[1], $row3[0], $row3[1], $row3[2], $row3[3], $row3[4], $row3[4]);
        //get the  numbers of likes
        $this->post_section($post_id = $row3[0], $enroll);
        //people who comment
        $this->people_who_comment($post_id = $row3[0]);
        //user comment post
        $this->comment_post($post_id,$enroll,$username);
        mysqli_free_result($result);
	}

	//this funtion get the whole news feed from friends who have thier privacy set to public or friends or customized
	function news_feeds($enroll, $username, $lastid){
		$contact_list = $this->contactlist($enroll);
		$lenghtoflist = sizeof($contact_list);
		if($lastid == null and $lastid < 1){
			$sql2 = "SELECT * FROM user_post ORDER BY id desc LIMIT 10";
        	$result = $this->select($sql2);
        	while($row = $result->fetch_assoc()){
				foreach ($contact_list as $value) {
					if($row['user_enroll'] == $value){
						$id = $row['id'];
                		$this->news_feed_region($id, $enroll, $username);
					}
					unset($value);
				}
				$this->last_id = $row['id'];
			}
        	mysqli_free_result($result);
		}elseif($lastid != 1){
			$this->last_id = 0;
			$sql2 = "SELECT * FROM user_post WHERE id < {$lastid} ORDER BY id desc LIMIT 10";
        	$result = $this->select($sql2);
        	while($row = $result->fetch_assoc()){
				foreach ($contact_list as $value) {
					if($row['user_enroll'] == $value){
						$id = $row['id'];
                		$this->news_feed_region($id, $enroll, $username);
					}
					unset($value);
				}
				$_SESSION['last_id'] = $row['id'];
			}
        	mysqli_free_result($result);
		}
	}

	//this function get the post of the user whos profile is been viewed
	function user_feeds($enroll, $username){
    	$this->post_region($enroll, $enroll, $username,"yes");
	}

	//this functiono get the number of friend requests
	function num_frn_request($enroll){
    	$sqlquery1 = "select null from friend_request where friend_enroll='$enroll'";
    	$result = $this->select($sqlquery1);
    	$row = $result->num_rows;
    	echo ($row);
    	mysqli_free_result($result);
	}

	//this functiono get the number of friend requests
	function if_frn($enroll,$friend_enroll){
		global $con;
    	$sqlquery1 = "select null from user_friend where user_enroll='$enroll' and friend_enroll='$friend_enroll'";
    	$result = mysqli_query($con,$sqlquery1);
    	$row = mysqli_num_rows($result);
			if($row != 0){
				return true;
			}else{
				return false;
			}
    	mysqli_free_result($result);
	}

	//this function search for the users who are ono shakes network
	function search_users($enroll,$searchu){
		global $con;
		if(isset($searchu)){
			$searchq = $this->securitytextinput($searchu);
			$result = mysqli_query($con,"SELECT usr_name,usr_roll FROM stud_data WHERE usr_name LIKE '%$searchq%' AND usr_roll<>'$enroll'");
			echo ("<table>");
			$count = $result->num_rows;
			if ($count == 0) {
                echo ("<tr><td>There was no search result</td></tr>");
			}else{
				while ($row = mysqli_fetch_assoc($result)) {
					$fname = $row['usr_name'];
          			$usr_enroll = $row['usr_roll'];
                    $sql1 = "SELECT uimg FROM stud_data where usr_roll='".$usr_enroll."'";
                    $resulta = $this->select($sql1);
                    $row2 = $resulta->fetch_array();
                    mysqli_free_result($resulta);
                    $img = $row2[0];
                    if ($img == 'usr_photo/' || $img == '') {
                		$img = "icons/nop/shakes_no_pic.png";
            		}
					$output = "<tr>"
							."<td><img src='../$img' width='40px' height='40px' /></td>"
							."<td><form action='profile' method='post'>"
							."<input type='hidden' value='$fname' name='fr_name' />"
							."<input type='hidden' value='$usr_enroll' name='enroll' />"
							."<input type='submit' value='$fname' class=\"btn btn-link\" /></form>"
							."</td><td>";
                    //get if the user that display are on your friends list
                    //if not show the send friend request button
                    $sql="SELECT * FROM user_friend WHERE friend_enroll='$usr_enroll' && user_enroll='$enroll'";
                    $resultb = $this->select($sql);
                    $count = $resultb->num_rows;
                    if($count < 1){
						$output .= "<form method='POST' action='addremovefriend.php' class='form_add'>"
		                        . "<input name='friend_name' type='hidden' value='$fname' />"
		                        . "<input name='friend_id' type='hidden' value='$usr_enroll' />"
								. "<input name='user_id' type='hidden' value='$enroll' />"
								. "<input name='type' type='hidden' value='send' />"
                                . "<input type='submit' value='Add Contact' class='btn btn-primary btn-xm'/>"
		                        . "</form></td></tr>";
                    }else{
						$output .= "<a href='message_chat?chat_name=$fname&enrollment=$usr_enroll' role='button' class=\"label label-info\" title='chat with $fname'>"
								."Chat</a></td></tr>";
                    }
                    echo $output;
                }
            }
		}
		echo ("</table>");
		mysqli_free_result($result);
		//mysqli_close($con);
	}

	//groups get sql
	function getsql($result){
		$token = $this->token();
		while ($row = $result->fetch_assoc()) {
			$name = $row['name'];
			$id = $row['id'];
			$details = $row['details'];
			echo "<tr>"
				."<td><img src=\"{$row['img']}\" width=\"50px\" height=\"40px\" class=\"viewimg\" ></td>"
				."<td><a href=\"group_chat?id={$id}&token={$this->token_session()}\">{$row['name']}<br></a></td>"
				."</tr>";
		}
	}


	function getgroups($enroll){
		$token = $this->token();
		//get my group first
		$sql = "SELECT * FROM groups WHERE creator={$enroll} ORDER BY name asc";
		$result = $this->select($sql);
		echo "<thead><tr><td></td><td></td><td></td></tr></thead>";
		$this->getsql($result);
		mysqli_free_result($result);
		//get other groups you are member
		$sql = "SELECT * FROM groups_users WHERE user_id={$enroll}";
		$result = $this->select($sql);
		$count = $result->num_rows;
		if ($count !== 0) {
			$token = $this->token_session();
			while ($row = $result->fetch_assoc()) {
				$resql = "SELECT * FROM groups WHERE id={$row['groups_id']}";
				$resultre = $this->select($resql);
				$row = $resultre->fetch_assoc();
				$name = $row['name'];
				$id = $row['id'];
				$details = $row['details'];
				echo "<tr>"
					."<td><img src=\"{$row['img']}\" width=\"50px\" height=\"40px\" class=\"viewimg\"></td>"
					."<td><a href=\"group_chat?id={$id}&token={$this->token_session()}\">{$row['name']}<br></a></td>"
					."</tr>";
			}
		}
		mysqli_free_result($result);
	}

	//this function gets your friends you like to add to group
	function group_add_friends($enroll,$id){
		$token = $this->token_session();
		$sql = "SELECT friend_enroll FROM user_friend where user_enroll='{$enroll}'";
        $result = $this->select($sql);
        $friends_count = $result->num_rows;
        echo "<form action='groupsmanager/addmember' method='post'>";
        echo "<input type=\"hidden\" value=\"{$id}\" name=\"id\" >";
        echo "<input type=\"hidden\" value=\"{$token}\" name=\"token\" ><table class=\"table\">";
        $select_name = 0;
        while ($row = $result->fetch_row()) {
            ///////////////////// code to get each user using their enroll number  /////////////////////////////
            for($i=0; $i < $result->field_count; $i++){
                $enrollment = $row[$i];
                $sql1 = "SELECT * FROM stud_data where usr_roll='{$enrollment}'";
                $resulta = $this->select($sql1);
                $rowim = $resulta->fetch_assoc();
                //friends with no profile picture
                if($rowim["uimg"] =='' || $rowim["uimg"] =='usr_photo/') {
                	$rowim["uimg"] = "icons/nop/shakes_no_pic.png";
				}
                //image and name of friend
                $data = "<tr>"
						."<td><img src='../{$rowim["uimg"]}' width='40px' height='40px' /></td>"
                        ."<td>{$rowim["usr_name"]}</td>"
						."<td><input type='checkbox' value='{$enrollment}' name='{$select_name}' /></td>"
						."</tr>";
                echo $data;
                mysqli_free_result($resulta);
            }
            $select_name++;
        }
        echo "</table>";
        echo "<input type=\"hidden\" value=\"{$select_name}\" name=\"len\" >";
        echo "<input type='submit' value='Add participants' class=\"btn btn-primary btn-xm btn-block\" /></form>";
        mysqli_free_result($result);
	}

	//group create_function
	function creategroup($name,$details,$private,$enroll,$imga,$imgup){
		$sql = "INSERT INTO groups (id,name,details,creator,privacy) VALUES (null,'".$name."', '".$details."', ".$enroll.", '".$private."')";
		$seed = $this->insert($sql);
		if($seed){
			if(!(is_dir("groupsmanager/groups/{$name}/"))){
				mkdir("groupsmanager/groups/{$name}/", 0777, true);//create users folder
			}
			if(($imga !== "") and ($imgup !== "")){
					$path="groupsmanager/groups/{$name}/$imga";
					move_uploaded_file($imgup, $path);
					$path="groupsmanager/groups/{$name}/$imga";
					$sql = "UPDATE groups SET img='{$path}' WHERE name='{$name}'";
					$this->update($sql);
			}
			return true;
		}else {
			return false;
		}
		
	}

	//group create_function
	function updategroup($name,$details,$id,$imga,$imgup){
		if(($name !== "") and ($details !== "")){
			$sql = "UPDATE groups SET name='{$name}', details='{$details}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}elseif(($name !== "") and ($details == "")){
			$sql = "UPDATE groups SET name='{$name}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}elseif(($name == "") and ($details !== "")){
			$sql = "UPDATE groups SET details='{$details}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}
		
		if($seed){
			if(!(is_dir("groupsmanager/groups/{$name}/"))){
				mkdir("groupsmanager/groups/{$name}/", 0777, true);//create users folder
			}
			if(($imga !== "") and ($imgup !== "")){
					$path="groupsmanager/groups/{$name}/$imga";
					move_uploaded_file($imgup, $path);
					$_SESSION["imgpath"] = $path;
					$sql = "UPDATE groups SET img='{$path}' WHERE id='{$id}'";
					$this->update($sql);
			}
			return true;
		}else {
			return false;
		}
		
	}


	//users photos_function
	function myphoto($name,$details,$id,$imga,$imgup){
		if(($name !== "") and ($details !== "")){
			$sql = "UPDATE groups SET name='{$name}', details='{$details}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}elseif(($name !== "") and ($details == "")){
			$sql = "UPDATE groups SET name='{$name}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}elseif(($name == "") and ($details !== "")){
			$sql = "UPDATE groups SET details='{$details}' WHERE id='{$id}'";
			$seed = $this->update($sql);
		}
		
		if($seed){
			if(!(is_dir("groupsmanager/groups/{$name}/"))){
				mkdir("groupsmanager/groups/{$name}/", 0777, true);//create users folder
			}
			if(($imga !== "") and ($imgup !== "")){
					$path="groupsmanager/groups/{$name}/$imga";
					move_uploaded_file($imgup, $path);
					$_SESSION["imgpath"] = $path;
					$sql = "UPDATE groups SET img='{$path}' WHERE id='{$id}'";
					$this->update($sql);
			}
			return true;
		}else {
			return false;
		}
		
	}


	function securitytextinput($text){
		if(isset($text)){
			$text = $text;
  			$text = htmlentities($text);
			$text = preg_replace("#[^0-9a-z]#i", " ", $text);
			$text = preg_replace('/<\?(php)/i', "&lt;?\\1", $text);
			$text = $this->conn->real_escape_string($text);
			return $text;
		}else{
			return $text;
		}
	}

	//generate tokens
	function token(){
		$_SESSION['token'] = uniqid(md5(microtime()), true);
	}

	//get token session
	function token_session(){
		if (isset($_SESSION["token"])) {
			return $_SESSION["token"];
		}
	}

	//logout function
	function logout(){
		$enroll = $this->get_enroll();
		unset($_SESSION['mat']);
    	unset($_SESSION['img']);
  		$status = "no";
  		$this->setOnlineStatus($enroll,$status);
		session_destroy();
		setcookie("username","",time()-1000,"/","",0);
		setcookie("enroll","",time()-1000,"/","",0);
		setcookie("email","",time()-1000,"/","",0);
		setcookie("password","",time()-1000,"/","",0);
  		header('location: index');
  		exit();
	}

}
ob_end_flush();
//end of class
$john = new john_carter();
?>
