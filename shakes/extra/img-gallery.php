<?php
require('../includes/init.php');

//this code check if the login requirement is meet
if(!check_login())
    //if not it takes you back to the login page
    header('location: ../index.php');
else {
    //include the header file
    include('../chat/header.php');
?>

<body>
<header>
<div class="global-nav">
    <ul class="nav nav-pills nav-justified">
         <li><a href="../chat/index.php">Resposelite</a></li> 
         <li><a href="../chat/chat.php">Messages</a></li>
         <li><a href="#">notification</a></li>
         <li class="active"><a href="../chat/profile.php">Profile</a></li> 
         <li><a href="../chat/friends.php">Friends List</a></li> 
         <li><a href="../chat/searchpeople.php">Search</a></li>
          <li><a href="#">Pages</a></li>
    </ul>
</div>
</header>
<div style="background: #4682B4;">
<h3><?php
    //it gets the username and the enrollment number
    $username = get_username();
    $enroll = get_enroll();

    $sql = "SELECT uimg FROM stud_data WHERE usr_name='".$username."' AND usr_roll='".$enroll."'";
    $result = mysql_query($sql, $con);
    $count = mysql_num_rows($result);
    if($count>0){
        $result2 = mysql_query($sql, $con);
        while($row = mysql_fetch_row($result2))
        if ($row[0]=='') {
            echo "Your have no profile picture. ";
        }
        else{
        ////////////////////////////////////////////
        echo "<img src='../$row[0]' alt='' class='' width='50px' height='50px' text-align='center' id='profile-pic'>";
    }
    }
    echo $username.", ";
        
?>
</h3>
    <!-- it works the same with all jquery version from 1.x to 2.x -->
    <script type="text/javascript" src="../js/img-js/jquery-1.9.1.min.js"></script>
    <!-- use jssor.slider.mini.js (40KB) instead for release -->
    <!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="../js/img-js/jssor.js"></script>
    <script type="text/javascript" src="../js/img-js/jssor.slider.js"></script>
    <script type="text/javascript" src="img-gallery.js"></script>
    <!-- Jssor Slider Begin -->
    <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
    <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 800px;
        height: 400px; background: #191919; overflow: hidden; margin: auto;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 356px; overflow: hidden;">
            <div>
                <img u="image" src="../img/alila/01.jpg" />
                <img u="thumb" src="../img/alila/thumb-01.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/02.jpg" />
                <img u="thumb" src="../img/alila/thumb-02.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/03.jpg" />
                <img u="thumb" src="../img/alila/thumb-03.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/04.jpg" />
                <img u="thumb" src="../img/alila/thumb-04.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/05.jpg" />
                <img u="thumb" src="../img/alila/thumb-05.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/06.jpg" />
                <img u="thumb" src="../img/alila/thumb-06.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/07.jpg" />
                <img u="thumb" src="../img/alila/thumb-07.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/08.jpg" />
                <img u="thumb" src="../img/alila/thumb-08.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/09.jpg" />
                <img u="thumb" src="../img/alila/thumb-09.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/10.jpg" />
                <img u="thumb" src="../img/alila/thumb-10.jpg" />
            </div>
            
            <div>
                <img u="image" src="../img/alila/11.jpg" />
                <img u="thumb" src="../img/alila/thumb-11.jpg" />
            </div>
            <div>
                <img u="image" src="../img/alila/12.jpg" />
                <img u="thumb" src="../img/alila/thumb-12.jpg" />
            </div>
        </div>
        
        <!--#region Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 05 css */
            /*
            .jssora05l                  (normal)
            .jssora05r                  (normal)
            .jssora05l:hover            (normal mouseover)
            .jssora05r:hover            (normal mouseover)
            .jssora05l.jssora05ldn      (mousedown)
            .jssora05r.jssora05rdn      (mousedown)
            */
            .jssora05l, .jssora05r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 40px;
                height: 40px;
                cursor: pointer;
                background: url(../img/a17.png) no-repeat;
                overflow: hidden;
            }
            .jssora05l { background-position: -10px -40px; }
            .jssora05r { background-position: -70px -40px; }
            .jssora05l:hover { background-position: -130px -40px; }
            .jssora05r:hover { background-position: -190px -40px; }
            .jssora05l.jssora05ldn { background-position: -250px -40px; }
            .jssora05r.jssora05rdn { background-position: -310px -40px; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="top: 158px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="top: 158px; right: 8px">
        </span>
        <!--#endregion Arrow Navigator Skin End -->
        <!--#region Thumbnail Navigator Skin Begin -->
        <!-- Help: http://www.jssor.com/development/slider-with-thumbnail-navigator-jquery.html -->
        <link href="img-style1.css" type="text/css" rel="stylesheet" />

        <!-- thumbnail navigator container -->
        <div u="thumbnavigator" class="jssort01" style="left: 0px; bottom: 0px;">
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides" style="cursor: default;">
                <div u="prototype" class="p">
                    <div class=w><div u="thumbnailtemplate" class="t"></div></div>
                    <div class=c></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!--#endregion Thumbnail Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
    </div>
<!--#set the status on if this page is active-->
<div id="online-status">
<div id="online_box" class="online" class="pro-hide">
        <audio controls="controls" style="display:none;" id="soundHandle"></audio>  <!--this tag is for chat sound  -->
        <div id="online_title_box" class="online" >
            <div id="online_title" onClick="goOnline()">Who's Online</div>
            <div id="min" class="opt" onClick="goOffline()" title="Go offline">-</div>
        </div>
        
        <div id="online_users_box" class="online">
        </div>
            
        <div id="online_search_box" class="online" >
            <input type="text" name="user_search" value="Search" onKeyDown="searchUsersOnline()"/>
        </div>
    </div>
    
    <div id='chatbox'>
    </div>
</div>
</div>
    <!-- Jssor Slider End -->
<?php 
//get footer
include("footer.php");
}
?>
