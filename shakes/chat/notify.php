<?php
require_once('../includes/init.php');
include('chatFunctions.php');
if(!$john -> check_login())
    header('location: ../index.php');
else {
    include('header.php');
    $username = $john -> get_username();
    $enroll = $john -> get_enroll();
?>

<body onload="checkNotification(); Notification(); post(); " onredo="me();">

<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
    <div class="user-post">
        <div class="notification_box">
            <div class="friends_re">
                <p><img src="../icons/addfriend.png"/>Friend's Requests</p>
                <table id="not_112" class="table table-condensed">
                <!--This is Where the notification list will be displayed-->
                </table>
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
        <h1>WELCOME</h1>
        <div class="post"></div>

        <input type="button" class="close-dialog" value="Close" />
    </div>
</div>

<?php
//get the footer
include("../extra/footer.php");
}
?>
