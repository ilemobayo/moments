<?php
require('includes/init.php');
include('chat/chatFunctions.php');

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
        default:$err_msg = "";
            break;
    }
}

include("reg_css.php");
?>

<div id="reg">
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
//get the footer
include("extra/footer.php");
?>
