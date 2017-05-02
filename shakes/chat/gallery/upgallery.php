<?php
require_once("../../includes/init.php");
require_once('../chatFunctions.php');
if(!$john->check_login())
  header('location: ../../index.php');
else {
  $username = $john->get_username();
  $enroll = $john->get_enroll();
}
?>

<?php
  $token = $john->token_session();

  //update snippet
  if(($_POST["token"] == $john->token_session())){
          if (!empty($_FILES)) {
              $img = $_FILES['img']['name'];
              $tempFile = $_FILES['img']['tmp_name'];
              $temp = explode(".", $img);
              $new = round(microtime(true)).".".end($temp);
              $targetPath = "../../shakes_user_data/{$username}/photos/$new";
              if(move_uploaded_file($tempFile, $targetPath)){
                header("Location: ../upgallery?success=true");
                exit();
              }else{
                header("Location: ../upgallery?success=false");
                exit();
              }
          }else{
                header("Location: ../upgallery?success=false&emptyfile=true");
                exit();
          }
  }else{
    header("Location: ../upgallery?success=false&falseupload=true");
    exit();
  }

 ?>
