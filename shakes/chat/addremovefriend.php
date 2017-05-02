<?php
require('../includes/init.php');
include('chatFunctions.php');
global $con;

//this code check if the login requirement is meet
if(!$john->check_login()){
	//if not it takes you back to the login page
	header('location:../index.php');
}
else {

//get user enrollment number
//$enroll = get_enroll();
/////////////////////////////////////////////////////////////////////////////////////////////
///////////////    this code get the command to add or remove    ////////////////////////////
/////////   collecting data on the friend to add or to remove   ////////////////////////////
	if(!empty($_POST)){
		if($_POST['type'] == 'send'){
                        //get the data sent
			$enroll = $_POST['user_id'];
			$friend_enroll = $_POST['friend_id'];
			$friend_name = $_POST['friend_name'];
      if($enroll == $friend_enroll){
          //IF the passed data is the same as the loggged in user
          //then go to friends page
          header('Location:friends.php');
          exit();
      }else{
          //check if user has been inserted into the user_friend table
          $sqlfr = "select * from friend_request where user_enroll='$enroll' and friend_enroll='".$friend_enroll."'";
          $queryfr = $john->select($sqlfr);

          //check if user has been inserted into the user_friend table
          $sql = "select * from user_friend where user_enroll='$enroll' and friend_enroll='".$friend_enroll."'";
          $query = $john->select($sql);
          if(($query->num_rows >= 1) || ($queryfr->num_rows >= 1)){
                            //do nothing
          }else{
              //if not insert into the database
							$sql="INSERT into friend_request(id,user_enroll, friend_enroll, friend_name) VALUES(NULL,'".$enroll."', '".$friend_enroll."', '".$friend_name."')";
							$query = $john->select($sql);
          }
      header('Location: friends');
      exit();
      }
		}


    if($_POST['type'] == 'accept'){
        //get the data sent
			  $enroll = $_POST['user_id'];
        $username = $_POST['user_name'];
			  $friend_enroll = $_POST['friend_id'];
			  $friend_name = $_POST['friend_name'];
        if($enroll == $friend_enroll){
        	//IF the passed data is the same as the loggged in user
        	//then go to friends page
        	header('Location: friends');
        	exit();
        }else{
          //check if user has been inserted into the database
          $sql = "select * from user_friend where user_enroll=$friend_enroll and friend_enroll=$enroll";
          $query = $john->select($sql);
          if($quer->num_rows>0){
              //do nothing
          }else{
              //if not insert into the database
              //relation with you
							$sql="INSERT into user_friend (id,user_enroll, friend_enroll, friend_name,online) VALUES(NULL,'$enroll', '$friend_enroll', '$friend_name','yes') ";
							$query = $john->insert($sql);
              //relation with them
              $sql="INSERT into user_friend (id,user_enroll, friend_enroll, friend_name, online) VALUES(NULL,'$friend_enroll', '$enroll', '$username','yes')";
			        $query = $john->insert($sql);
          }
      }
      $sql="DELETE from friend_request WHERE user_enroll = '$friend_enroll' AND friend_enroll = '$enroll' or user_enroll = '$enroll' AND friend_enroll = '$friend_enroll'";
			$query = $john->delete($sql);
		}

    if($_POST['type'] == 'decline'){
        //get the data sent
        $enroll = $_POST['user_id'];
        $username = $_POST['user_name'];
        $friend_enroll = $_POST['friend_id'];
        $friend_name = $_POST['friend_name'];
      $sql="DELETE from friend_request WHERE user_enroll = '$friend_enroll' AND friend_enroll = '$enroll' or user_enroll = '$enroll' AND friend_enroll = '$friend_enroll'";
      $query = $john->delete($sql);
    }


      if($_POST['type'] == 'remove'){
      //get the data sent
			$enroll = $_POST['user_id'];
			$friend_enroll = $_POST['friend_id'];
			$friend_name = $_POST['friend_name'];
                        if($enroll == $friend_enroll){
                            //IF the passed data is the same as the loggged in user
                            //then go to friends page
                            header('Location: friends');
                            exit();
                        }else{
                            //if not delete from the database
                            //relation with you
			$sql="DELETE from user_friend WHERE user_enroll = '$enroll' AND friend_enroll = '$friend_enroll'";
			$query = $john->delete($sql);
      //relation with them
      $sql="DELETE from user_friend WHERE user_enroll = '$friend_enroll' AND friend_enroll = '$enroll'";
			$query = $john->delete($sql);
      header('Location: friends');
      exit();
      }
		}


    if($_POST['type'] == 'post'){
                        //get the data sent
			  $enroll = $_POST['name'];
			  $post_content = $_POST['content'];
			  $privacy = $_POST['privacy'];
        $time = time();
        $date = date("d M Y");
        //image files
        $ima = $_FILES['ima']['name'];
        $imup=$_FILES['ima']['tmp_name'];

        $path="../usr_photo/$ima";
        if(move_uploaded_file($imup,$path)){
            $path="usr_photo/$ima";
            //if not insert into the database
			     $sql="INSERT into user_post(id,user_enroll,p_content,time_s,file_path,privacy,pdate) VALUES(null,'".$enroll."', '".$post_content."', '".$time."', '".$path."', '".$privacy."', '".$date."')";
			        $query = $john->insert($sql);
        }else{
          $path="usr_photo/";
          //if not insert into the database
          $sql="INSERT into user_post(id,user_enroll,p_content,time_s,file_path,privacy,pdate) VALUES(null,'".$enroll."', '".$post_content."', '".$time."', '".$path."', '".$privacy."', '".$date."')";
            $query = $john->insert($sql);
        }
        header('Location:chat');
        exit();
		}
	}
        header('Location:chat');
        exit();
}
?>
