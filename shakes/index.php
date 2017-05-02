<?php
require('includes/init.php');
include('chat/chatFunctions.php');
if((isset($_COOKIE['email'])) and (isset($_COOKIE['password'])) and (isset($_COOKIE['enroll'])) and (isset($_COOKIE['username']))){
	$_SESSION['username'] = $_COOKIE['username'];
	$_SESSION['enroll'] = $_COOKIE['enroll'];
}
if($john->check_login() == true){
	//if true it takes you to the chat page
	header('location: chat/chat');
	exit();
}

//get registration errors
if(isset($_GET["err"])){
	$err = $_GET["err"];
}else{
	$err = "";
}
$err_msg = "";
if($err!="") {
    switch($err) {
        case 0: $err_msg = "Incomplete form";
            break;
        case 1: $err_msg = "Passwords do not match";
            break;
        case 2: $err_msg = "Already registered or try different username";
            break;
        case 3: $err_msg = "Your account has been created.";
            break;
        case 4: $err_msg = "Your account was not created, please try again.";
            break;
        default:$err_msg = "";
            break;
    }
}

include("header_main.php");
?>




<header>

</header>
<!-- LOGIN FORM -->
    <form action="login" method="POST" class="form_box">
        <h2>MOMENTS</h2>
        <div class="form_inner_box">
        <?php
                    if(isset($_SESSION['errorLogin'])) print $error = $_SESSION['errorLogin'];
                    unset($_SESSION['errorLogin']);
        ?>

        <?php
        if($err_msg != ""){
        echo ("<p class='err_submit'><em>{$err_msg}</em></p>");
        }
        ?>
            <div class="fn"><div class="placeholder"></div>
            <input type="email" name="user" placeholder="E-mail address" class="form_email_box_control" autocomplete="off" autofocus="1" tabindex="1" id="n_usr" /></div><br/><br/>

            <div class="fn"><div class="placeholder"></div>
            <input type="password" name="pass" placeholder="Password" class="form_password_box_control" autocomplete="off" id="n_usr" />
						</div>
						<br/><br/>

            <button type="submit" name="login" value="login" class="welogin i" data-loading-text="Verifying..." id="fat-btn">login</button><br/>
            <a href="reg" id="Sign" class="welogin i">Signup</a>
						<script>
			        $(function() {
			            $(".i").click(function(){
			              $(this).button('loading').delay(1000).queue(function() {
			                $(this).button('reset');
			              });
			            });
			        });
			      </script>
						<br/>
						<label class="btn btn-primary " >
							<input type="checkbox" name="keeploggedin" value="1" />Keep me logged in
						</label><br/>

            <a href="#" class="forgot_password" id="for_a" title="Popover title" data-container="body" data-toggle="popover" data-placement="top" data-content="Some content in Popover on top"> forgotten my account?</a>

						<script>$(function () { $("[data-toggle='popover']").popover(); }); </script>
            
            </div>
    </form>
<!-- END OF LOGIN FORM -->


<!-- REGISTRATION BAR -->
    <div id="reg_shakes">
			<div class="toreg_vbiH"><h5>Register</h5></div>
    <h4>Register To Shakes</h4>
    <p class="free">it's free for all to use</p>
    <table>
        <form action='submit.php' method="POST" enctype="multipart/form-data">
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type='text' name='firstname' placeholder="First name" id="n_usr" required="1" /></div></td>
        </tr>
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type="type" name="surname" id="n_usr" placeholder="Surname" required="1" /></div></td>
        </tr>
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type='email' name='email' id="n_usr" placeholder="Email address" required="1" /></div></td>
        </tr>
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type="date" name="dob" id="n_usr" required="1" /></div></td>
        </tr>
        <tr>
        <td><div class="fn"><input type="radio" name="gender" value="male" id="rad_gen"/><span>Male</span><input type="radio" name="gender" value="female" id="rad_gen" class="tw_shk" /><span>Female</span></div></td>
        </tr>
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type='password' name='passw' id="n_usr" required="1" placeholder="Password" /></div></td>
        </tr>
        <tr>
        <td><div class="fn"><div class="placeholder"></div><input type='password' name='re-passw' id="n_usr" required="1" placeholder="Re-Password" /></div></td>
        </tr>
        <tr>
        <td><p class="youshakes_terms">By Clicking Create my handle, you agree to our <a href="terms/Terms.html" target="_blank" rel="nofollow">Terms</a> and that you have read our <a href="#" target="_blank" rel="nofollow">Data</a> Policy.
        </tr>
        <tr>
        <td><button type='submit' name="submit" value='Register' class="wesubmit">Create my handle</button></td>
        </tr>
        <tr>
        <td>
        </td>
        </tr>
        </form>
    </table>
</div>
<?php
include("extra/footer.php");
?>
