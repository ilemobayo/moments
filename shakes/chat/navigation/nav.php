
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="navbar-header">
        <a class="navbar-brand" href="#"><strong class="success"><?php echo APP_NAME ?></strong></a>

      <?php
        //check for the profile picture of the dataa passed
        $john->user_details($username,$enroll);
        ?>

  <div class="navbar-brand dropdown collapse navbar-collapse large_xi">
        <div class="btn-group btn-group-xs" style="margin-top: -2%"> 
          <a class="btn btn-default inbox" title="Home Page" href="messages">Messages<span class="badge" id="inbox_msg"></span></a> 
          <a class="btn btn-default" href="chat">Posts</a> 
          <a class="btn btn-default" href="notify"><div id="notify" title="View Notification" onclick="Notification();">Notification<span class="badge pull-right" id="notification"></span></div></a> 
          <a class="btn btn-default" href="profile">Profile</a>
          <a class="btn btn-default" href="friends">Friends</a>
          <a class="btn btn-default" href="search1">Search</a>
          <a class="btn btn-default" href="groups">Groups</a>
          <a class="btn btn-danger" href='../logout' role='button' id='log_name' >Logout</a>
        </div>
  </div>

  <div class="nav-sect">
      <div class="nav navbar-nav">
      <div class="dropdown">
        <a type="button btn-xm" class="dropdown-toggle navbar-toggle home-btn" data-toggle="dropdown">
          <i class="icon-home icon-large"> <!--Home--></i>
        </a>
        <br/>
        <br/>
        <ul class="dropdown-menu">
          <li> <a class="inbox" title="Home Page" href="messages">Messages<span class="badge" id="inbox_msg"></span></a> </li>
          <li> <a href="chat">Posts</a> </li>
          <li> <a href="notify"><div id="notify" title="View Notification" onclick="Notification();">Notification<span class="badge" id="notification"></span></div></a> </li>
          <li> <a href="profile">Profile</a> </li>
          <li> <a href="friends">Friends</a> </li>
          <li> <a href="search1">Search</a> </li>
          <li> <a href="groups">Groups</a> </li>
          <li class="divider"></li>
          <li class="dropdown-header"> Settings</li>
          <!--li role="presentation" > <a href="#" class="Minified_o" title="mini_side_chat">On MiniChat</a> </li>
          <li role="presentation"> <a href="#" class="Minified_c" title="mini_side_chat">Off MiniChat</a> </li-->
          <li> <a href='../logout' role='button' id='log_name' >Logout</a> </li>
        </ul>
      </div>
    </div>
  </div>

</div>
</nav>
<!-- header -->


<div class="shakes_apps" id="apps">
  <div class="span3">

      <div class="hero-unit">
        <div>
          <!-- Carousel items -->
          <img src="../usr_photo/img1.jpg" alt="First slide" height="150px" width="100%" />
          <div>
            <a class="btn btn-default btn-xm btn-block" target="_blank" href="#">Subscribe</a>
            <a class="btn btn-success btn-xm btn-block" target="_blank" href="#">Like</a>
          </div>
        </div>
      </div>
      <div class="hero-unit">
        <div>
          <!-- Carousel items -->
          <img src="../usr_photo/img1.jpg" alt="First slide" height="150px" width="100%" />
          <div>
            <a class="btn btn-default btn-xm btn-block" target="_blank" href="#">Subscribe</a>
            <a class="btn btn-success btn-xm btn-block" target="_blank" href="#">Like</a>
          </div>
        </div>
      </div>
      <div class="hero-unit">
        <div>
          <!-- Carousel items -->
          <img src="../usr_photo/img1.jpg" alt="First slide" height="150px" width="100%" />
          <div>
            <a class="btn btn-default btn-xm btn-block" target="_blank" href="#">Subscribe</a>
            <a class="btn btn-success btn-xm btn-block" target="_blank" href="#">Like</a>
          </div>
        </div>
      </div>
  </div>
</div>
