<?php
class main{
  var $con;

function __construct()
{
  $this->con = mysqli_connect("localhost","root","", "john_carter");
}

function login($uname,$pass){
  $sql = "select * from customer where  UserName='{$uname}' and Pass='{$pass}' limit 1";
  $result = $this->select($sql);
  while($who = $result->fetch_array()){
    if(empty($who)){
      header('Location: login.php');
      exit();
    }
    header('Location: admin.php');
    exit();
  }
}

function check_login() {
  if((isset($_SESSION['username']) && isset($_SESSION['enroll'])) && (($_SESSION['username'] != "") && ($_SESSION['enroll'] != ""))){
    return true;
  }
  else{
    return false;
  }
}


function user_details($username,$enroll){
  global $con;
    $sql = "SELECT uimg FROM stud_data WHERE usr_name='{$username}' AND usr_roll='{$enroll}'";
  $result = mysqli_query($con,$sql);
  $count = mysqli_num_rows($result);
  if($count>0){
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_row($result)) {
                if ($row[0] == '' || $row[0] == 'usr_photo/') {
                      echo "<div class=\"navbar-brand collapse navbar-collapse wxp\">"
                          ."<img src='../icons/nop/shakes_no_pic.png' width='30px' height='30px' class=\"view-img\" /> "
                          ."</div>"
                          ."<div class=\"navbar-brand collapse navbar-collapse wxp\" >".$username ."</div>";
                  } else {
                      echo "<div class=\"navbar-brand collapse navbar-collapse wxp\">"
                          ."<img src='../{$row[0]}' width='30px' height='30px' class=\"view-img img-rounded\" > "
                          ."</div>"
                          ."<div class=\"navbar-brand collapse navbar-collapse wxp\">".$username ."</div>";
                  }
            }
      }
      mysqli_free_result($result);
  //echo ("<span>".$username."</span>");
}


function select($query){
  $result = $this->con->query($query);
  return $result;
}

function update($query){
  $result = $this->con->query($query);
  return $result;
}


function insert($query){
  $result = $this->con->query($query);
  if($result){
    return $result;
  }
  //return $result;
}


function insertdata(){
  $sql = "insert into data
        ()
        value()
        ";
  $this->insert($sql);
  header('Location: ../home.php');
  exit();
}

//register customer
function register($uname,$pass,$fname,$mname,$lname,$sex,$address,$city,$pincode,$state,$email,$mobile){
  $sql = "insert into customer
        (id,UserName,Pass,Fname,Mname,Lname,Gender,Address,City,Pincode,State,Email,Mobile)
        values(null, '{$uname}','{$pass}','{$fname}','{$mname}','{$lname}','{$sex}','{$address}','{$city}','{$pincode}','{$state}','{$email}','{$mobile}')
        ";
  $this->insert($sql);
  header('Location: index.php');
  exit();
}

function inshow($movie,$theatre,$screen,$stime,$etime,$date,$plat,$gold,$sil)
{
  $sql = "insert into shows
          (id,movieid,theatreid,screenid,starttime,endtime,sdate,pr,gr,sr)
          values(null,
          '{$movie}','{$theatre}','{$screen}','{$stime}','{$etime}','{$date}','{$plat}','{$gold}','{$sil}')
          ";
  $this->insert($sql);
  header('Location: show.php');
  exit();
}

function mydata($uname){
  $sql = "select * from data where  username='{$uname}' limit 1";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    print_r("");
  }
}

function getcity(){
  $sql = "select * from city";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    print_r("<option value=\"". $dat['CityName'] ."\">". $dat['CityName']. "</option>");
  }
}

function insertmoviedata($name,$path,$director,$producer,$cast,$dur,$str,$mtype){
  $sql = "insert into movie
        (id,MovieName,ImagePath,Director,Producer,Cast,Duration,Story,Type)
        values(null, '{$name}','{$path}','{$director}','{$producer}','{$cast}','{$dur}','{$str}','{$mtype}')";
  $this->insert($sql);
  header('Location: admin.php');
  exit();
}

function insertcitydata($city,$state){
  $sql = "insert into city
        (id,CityName,State)
        values(null, '{$city}','{$state}')";
  $this->insert($sql);
  header('Location: admin.php');
  exit();
}

function insertfeedbackdata($uname,$email,$text){
  $sql = "insert into feedback
        (id,UserName,EmailId,Feedback)
        values(null, '{$uname}','{$email}','{$text}')";
  $this->insert($sql);
  header('Location: admin.php');
  exit();
}

function getshows(){
  $sql = "select * from shows";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("<option value=\"". $dat['id'] ."\">". $dat['starttime'] ."</option>");
  }
}

function getshows1($data,$date){
  $sql = "select * from shows where theatreid='{$data}' and sdate='{$date}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("<option value=\"". $dat['id'] ."\">". $dat['starttime'] ."</option>");
  }
}

function moviename($show){
  $sql = "select * from shows where id='{$show}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    $movieid = $dat['movieid'];
    $sql = "select * from movie where id='{$movieid}'";
    $result = $this->select($sql);
    while($data = $result->fetch_assoc()){
      return $movieid = $data['MovieName'];
      exit();
    }
  }
}

function getshowsstime($data,$date){
  $sql = "select * from shows where theatreid='{$data}' and sdate='{$date}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    return($dat['starttime']);
  }
}

function getshowsetime($data,$date){
  $sql = "select * from shows where theatreid='{$data}' and sdate='{$date}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    return($dat['endtime']);
  }
}

function comp($date,$data){
  $sql="select * from shows where sdata='{$date}' and theatreid='{$data}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
        echo("<tr><td>Platinum</td><td>". $dat['pr'] ."</td></tr>");
        echo("<tr><td>Gold</td><td>". $dat['gr'] ."</td></tr>");
        echo("<tr><td>Silver</td><td>". $dat['sr'] ."</td></tr>");
  }
}


function getmoviesid(){
  $sql = "select * from movie";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("<option value=\"". $dat['id'] ."\">". $dat['MovieName'] ."</option>");
  }
}


function getmovies(){
  $sql = "select * from movie";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    print_r("<option value=\"". $dat['CityName'] ."\">". $dat['CityName']. "</option>");
    echo("<td>
      <div class=\"movies\">
          <a href=\"review.php?movie=". $dat['MovieName'] ."\">
            <img class=\"logo\" src=\"". $dat['ImagePath'] ."\" width=\"120px\" height=\"120px\"/>
          </a>
          <hr/>
          <p class=\"mtitle\"><a href=\"theatredetails.php\">". $dat['MovieName']."</a></p>
      </div>
    </td>");
  }
}

function getmoviedata($movie){
  $sql = "select * from movie where MovieName='{$movie}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("
    <tr>
      <td><strong>Movie:</strong></td><td><strong>{$dat['MovieName']} </strong></td>
    </tr>
    <tr>
      <td><strong>Director:</strong></td><td><strong> {$dat['Director']} </strong></td>
    </tr>
    <tr>
      <td><strong>Producer:</strong></td><td><strong> {$dat['Producer']} </strong></td>
    </tr>
    <tr>
      <td><strong>Cast:</strong></td><td><strong> {$dat['Cast']} </strong></td>
    </tr>
    <tr>
      <td><strong>Duration:</strong></td><td><strong> {$dat['Duration']} </strong></td>
    </tr>
    <tr>
      <td><strong>Story:</strong></td>
    </tr>
    <tr>
      <td colspan=\"2\"><strong> {$dat['Story']} .</strong></td>
    </tr>
    ");
  }
}

function getcityiddata(){
  $sql = "select * from city";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("<option value=\"". $dat['id'] ."\">". $dat['CityName'] ."</option>");
  }
}

function gettheatresiddata(){
  $sql = "select * from theatre";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    echo("<option value=\"". $dat['id'] ."\">". $dat['TheatreName'] ."</option>");
  }
}

function updatetheatre($theatre,$cityid){
  $sql = "update theatre set cityid = '{$cityid}'
        where id = '{$theatre}'";
  $this->update($sql);
  header('Location: theatre.php');
  exit();
}

function updatetheatre1($theatrename,$cityid,$address,$pincode,$scr){
  $sql = "update theatre set
        CityId = '{$cityid}',Address = '{$address}',Pincode = '{$pincode}',Nos = '{$scr}' where id = '{$theatrename}'";
  $this->update($sql);
  header('Location: updatetheatre.php');
  exit();
}

function inserttheatre($theatrename,$cityid,$address,$pincode,$scr){
  $sql = "insert into theatre
        (id,TheatreName,CityId,Address,Pincode,Nos)
        values(null, '{$theatrename}', '{$cityid}','{$address}', '{$pincode}', '{$scr}')";
  $this->insert($sql);
  header("Location: screen.php?theatrename={$theatrename}");
  exit();
}

function gettheatreid($theatrename){
  $sql = "select * from theatre where TheatreName= '{$theatrename}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
      return $t_id = $dat['id'];
      exit();
  }
}

function gettheatrename($theatreid){
  $sql = "select * from theatre where id= '{$theatreid}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
      return $t_id = $dat['TheatreName'];
      exit();
  }
}

function gettheatreaddress($theatreid){
  $sql = "select * from theatre where id= '{$theatreid}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
      return $t_id = $dat['Address'];
      exit();
  }
}

function gettheatrecity($theatreid){
  $sql = "select * from theatre where id= '{$theatreid}'";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
    $id = $dat['CityId'];
    $sql = "select * from city where id='{$id}'";
    $result = $this->select($sql);
    while($data = $result->fetch_assoc()){
      return $movieid = $data['CityName'];
      exit();
    }
  }
}

function seats($numberofseats,$theatrename,$type){
  $data_exist = 0;
  $t_id = $this->gettheatreid($theatrename);

  $sql = "select theatreid,type from seats";
  $result = $this->select($sql);
  while($dat = $result->fetch_assoc()){
        if(($dat['theatreid'] == $t_id) AND ($dat['type'] == $type)){
            $data_exist = 1;
            break;
        }
  }
  if($data_exist == 0){
  $sql = "insert into seats(id,seat,theatreid,type) values(null,'{$numberofseats}','{$t_id}','{$type}')";
  $this->insert($sql);
    header("Location: screen.php?theatrename=".$theatrename."&".$t_id."&".$type);
    exit();
  }else{
    header("Location: screen.php?theatrename=".$theatrename."&existing"."&".$t_id."&".$type);
    exit();
  }
}

function bookme($show,$seats,$seatType,$nseat,$totalpriceforseat,$paid,$mobile,$email){
  $sql = "insert into ticket(id,ShowId,Seats,SeatType,NoSeats,Amount,IsPaid,Mobile,Email) values(null,'{$show}','{$seats}','{$nseat}','{$seatType}','{$totalpriceforseat}','{$paid}','{$mobile}','{$email}')";
  $this->insert($sql);
    header('Location: index.php');
    exit();
}


}

$class = new phpclass();
$read = new phpclass();
