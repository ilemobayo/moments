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

<div class="thisis_true">
    <div id="name" style="display: none; "><?php echo $name = $_REQUEST['chat_name']; ?></div>
    <div id="enroll" style="display: none; "><?php echo $enrollment = $_REQUEST['enrollment']; ?></div>
    <?php
        $john->startChatSession($enrollment,$enroll);
    ?>
</div>
<div class="inbox_section">
  <div class="john">
    <div class="chat_layer">
        <div class="chat_msg_box">
            <div class="chat-msg-title">
                <table width="100%">
                    <tr>
                        <td><?php echo $john->getimgdata($enrollment);?></td>
                        <td><p><strong><?php echo $name; ?></strong></p></td>
                        <td><em id="status"></em></td>
                    </tr>
                </table>
            </div>
            <div class="chat_msg_box_block">
                    <div class="chat_msg_box_bay">
                    </div>
            </div>
            <div id="chat-msg-input" class="chat-msg-input">
                <input name="lastmsg" id="lastmsg" type="hidden" value="" />
                <input name="name" id="name" type="hidden" value="<?php echo $name; ?>" />
                <input name="roll" id="enroll" type="hidden" value="<?php echo $enrollment; ?>" />
                <textarea title="Click On This Box To Send Messages" class="Textareauserm"  name="msg" placeholder="Enter Your Message Here" id="msg" onkeyup="WritingStatus(<?php echo $enroll;?>);"></textarea>
                <button onclick="sendYChat()" title="Send" class="button btn-sm"></button>
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
        <h1>WELCOME</h1>
        <input type="button" class="close-dialog" value="Close" />
    </div>
</div>


<?php
//get the footer
include("../extra/footer.php");
}
?>
