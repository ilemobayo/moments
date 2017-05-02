<?php
require_once('../includes/init.php');
require_once('chatFunctions.php');
if(!$john -> check_login())
	header('location: ../index.php');
else {
	include('header.php');
	$username = $john -> get_username();
	$enroll = $john -> get_enroll();

	$id = $_GET['id'];
?>

<body onload="me();">
<?php include("navigation/nav.php"); ?>

<noscript>
    <h3>Please turn on your browser's javascrit to allow us serve you better, Thank you.</h3>
</noscript>

<div class="message">
				<a href="<?php echo $_SESSION['from']."#".$id ?>" class="ftypelabel btn btn-default">Go back to <?php echo $_SESSION['from']; ?></a><br/><br/>
				<!-- it works the same with all jquery version from 1.x to 2.x -->
    <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
    <!-- use jssor.slider.mini.js (40KB) instead for release -->
    <!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="../js/jssor.js"></script>
    <script type="text/javascript" src="../js/jssor.slider.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
        });
    </script>
    <!-- Jssor Slider Begin -->
    <!-- To move inline styles to css file/block, please specify a class name for each element. -->
    <div class="ally" id="slider1_container" style="position: relative; top: 0px; left: 0px;">

        <!-- Slides Container -->
        <div class="allyin" u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; overflow: hidden;">
            <div><img u="image" src="../img/photography/002.jpg" /></div>
            <div><img u="image" src="../img/photography/003.jpg" /></div>
            <div><img u="image" src="../img/photography/004.jpg" /></div>
            <div><img u="image" src="../img/photography/005.jpg" /></div>
            <div><img u="image" src="../img/photography/006.jpg" /></div>
            <div><img u="image" src="../img/photography/007.jpg" /></div>
            <div><img u="image" src="../img/photography/008.jpg" /></div>
        </div>

        <!--#region Arrow Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
        <style>
						.ally{width: 100% !important; height: 450px !important; max-height: 550px !important;}
						.allyin{width: 100% !important; min-height: 100% !important; max-height: 100% !important;}
            /* jssor slider arrow navigator skin 03 css */
            /*
            .jssora03l                  (normal)
            .jssora03r                  (normal)
            .jssora03l:hover            (normal mouseover)
            .jssora03r:hover            (normal mouseover)
            .jssora03l.jssora03ldn      (mousedown)
            .jssora03r.jssora03rdn      (mousedown)
            */
            .jssora03l, .jssora03r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 55px;
                height: 55px;
                cursor: pointer;
                background: url(../img/a03.png) no-repeat;
                overflow: hidden;
            }
            .jssora03l { background-position: -3px -33px; }
            .jssora03r { background-position: -63px -33px; }
            .jssora03l:hover { background-position: -123px -33px; }
            .jssora03r:hover { background-position: -183px -33px; }
            .jssora03l.jssora03ldn { background-position: -243px -33px; }
            .jssora03r.jssora03rdn { background-position: -303px -33px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora03l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora03r" style="top: 123px; right: 8px;">
        </span>
        <!--#endregion Arrow Navigator Skin End -->
    </div>
    <!-- Jssor Slider End -->

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
