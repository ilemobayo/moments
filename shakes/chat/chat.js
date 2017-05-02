//setting variables to be used by the application
var onlineTimer;
var popUpTimer;
var noOfUsers;
var username;
var enroll;
var chatRefreshTimer;
var newmsg="yes";
var browserTitle = "MOMENTS";
var soundHandle;
var soundFile;
var soundFile1 = "../sound/notify.ogg";
var soundFile41 = "../sound/Unlock.ogg";
var id = "";
var user = "";
var msg = "";
var when = "";
var myObj;
var img;

//set document for action
$(document).ready(function(){
	onlineTimer = setInterval("Notification()",2000);
  	onlineTimer = setInterval("checkNotification()",1000);
	//onlineTimer = setInterval("get_group()", 1000);
	//when window loads show chat or online status
  	$(window).load(showOnline(),popUpChat());
 		//set the search box of input by
  	$("div#online_search_box input").bind("click",function() {
      	if($("div#online_search_box input").val()==""){
			$("div#online_search_box input").val("");
		}
	});
});

//function for show if online to refresh the online status using ajax technology
function showOnline(){
	var str = "action=checkMyOnlineStatus";
	$.ajax({url:"processRequest.php", type:"POST", dataType:"xml", data:""+str+"", success:function(result){
				var onlineStatus = $(result).find("root").attr("online");
				if(onlineStatus=="yes") {
					$("div#online_users_box").html("Loading Friends...");
					//status refresh
					//call the online status refresh function
					//$.ajaxSetup({cache:false});
					refreshOnline();
					onlineTimer = setInterval("refreshOnline()",5000);
          			//call the check notification
          			checkNotification();
          			onlineTimer = setInterval("checkNotification()",2500);
				}else{
					//call the go offline status function
					$("div#online_users_box").html("Friends are offline...");
				}
			}
		});
}

//this is the refresh online status function
function refreshOnline() {
	//get the value in the search box
	var search = $("div#online_search_box input").val();
  if(search.length!==0 && search!==""&&search!=="search"&&search!=="Find friends or groups") {
        var str = "search="+search;
        $.ajax({url:"show_online.php", type:"POST", data:""+str+"", success:function(result){
            $("div#online_users_box").html(result);
                noOfUsers = $("div#user").toArray();
            }
        });
  }else {
        $.ajax({url:"show_online.php", success:function(result){
            $("div#online_users_box").html(result);
                noOfUsers = $("div#user").toArray();
        }});
  }

}

function goOffline() {
	setOnlineStatus("no");
	clearInterval(onlineTimer);
	clearInterval(chatRefreshTimer);
	clearInterval(popUpTimer);
	$("div.me_online").css("background-color", "#ffffff");
	//playSound(soundFile = "../sound/two (14).MP3");
}

function goOnline() {
	setOnlineStatus("yes");
	$("div.me_online").css("background-color", "#ff0000");
	showOnline();
	popUpChat();
	playSound(soundFile = "../sound/two (11).MP3");
}

function setOnlineStatus(onlineStatus) {
		var str = "action=setOnlineStatus&status="+onlineStatus;
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
}

function chatWith(username,enroll) {
	closeAllChats();
	if($("div#chatbox_"+enroll).length === 0) {
		constructChatbox(enroll,username);
		startChatSession(enroll);
		clearInterval(chatRefreshTimer);
		newmsg="yes";
		getChat(enroll,username);
		chatRefreshTimer = setInterval("getChat("+enroll+","+username+")",1500);
	}
	else {
		restructChatbox(enroll,username);
	}
  $("div#chatbox_"+enroll+" div.chatbox_title").text(username);
}

function closeChat(roll) {
	$("div#chatbox_"+roll).empty();
	$("div#chatbox").empty();
}

function closeAllChats() {
	$("div#chatbox").empty();
}

function constructChatbox(enroll,username) {
		$("div#chatbox").empty();
		$("div#chatbox").append("<div id='chatbox_"+enroll+"' class='chatbox_user' ></div>");
		$("div#chatbox_"+enroll).append("<div><div class='chatbox_title' onclick='javascript:restructChatbox("+enroll+",&#39;"+username+"&#39;)'>"+username+"</div><div id='closeChat' class='opt' onClick='javascript:closeChat("+enroll+")'>X</div></div>");
		$("div#chatbox_"+enroll).append("<div class='chatbox_msg'></div>");
		$("div#chatbox_"+enroll).append("<div class='chatbox_status'></div>");
		$("div#chatbox_"+enroll).append("<div class='chatbox_text' ><form onSubmit='return sendChat("+enroll+",&#39;"+username+"&#39;)'><input type='text' name='msg' autocomplete='off' onKeyDown='javascript:setWritingStatus("+enroll+",&#39;"+username+"&#39;)'/></form></div>");
		$("div#chatbox_"+enroll+" div.chatbox_text input").focus();
		$("div#chatbox_"+enroll+" div.chatbox_msg").html("<div class='err_msg'>Loading previous messages...</div>");
		//set writing status
		setInterval("setWritingStatus("+enroll+")",1500);
}

function restructChatbox(roll,name) {
	$("div#chatbox_"+roll).show();
  $("div#chatbox_"+roll+" div.chatbox_title").text(name);
	$("div#chatbox_"+roll+" div.chatbox_msg").show();
	$("div#chatbox_"+roll+" div.chatbox_text").show();
	$("div#chatbox_"+roll).css({"position":"relative","top":"0px"});
	$("div#chatbox_"+roll+" div.chatbox_text input").focus();
	clearInterval(chatRefreshTimer);
	newmsg="yes";
	getChat(roll,name);
	chatRefershTimer = setInterval("getChat("+roll+","+name+")",1500);
	//set writing status
	setInterval("setWritingStatus("+roll+")",1500);
}

function startChatSession(roll) {
	var str = "action=startChatSession&roll="+roll;
	$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
}

function sendChat(roll,name) {
	var msg = $("div#chatbox_"+roll+" div.chatbox_text input").val();
	var str = "action=sendChat&msg="+msg+"&roll="+roll+"&name="+name;
	if(msg.length!=0) {
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+"", dataType:"xml", success:function(result) {
				var check = $(result).find("root").attr("success");
				if(check=="no") {

					clearInterval(chatRefreshTimer);
					$("div#chatbox_"+roll+" div.chatbox_msg").empty();
					$("div#chatbox_"+roll+" div.chatbox_msg").html("<div class='err_msg'>"+name+" is currently unavailable </div>");
				}
				else{
					playSound(soundFile = "../sound/two (86).MP3");
					newmsg="yes";
					getChat(roll,name);
				}
			}
		});
	}
	$("div#chatbox_"+roll+" div.chatbox_text input").val("");
	return false;
}

function getChat(roll,name){
	var str = "action=getChat&roll="+roll;
	var user;

	$.ajax({url:"processRequest.php", type:"POST", data:""+str+"", dataType:"xml",success:function(result){
	var count = $(result).find("root").attr("count");
	var sta = $(result).find("root").attr("status");
	if(count!=0) {
  	if(sta=="yes"){
             $("div#chatbox_"+roll+" div.chatbox_status").text($("div#chatbox_"+roll+" div.chatbox_title").text()+" is typing...");
    }else{
             $("div#chatbox_"+roll+" div.chatbox_status").text("");
    }

	$("div#chatbox_"+roll+" div.chatbox_msg").empty();
	$(result).find("messages").each(function(){
	user = $(this).find("user").text();
	msg = $(this).find("msg").text();
    when = $(this).find("when").text();
    //emojis
    var input = msg;
    var output = emojione.toImage(input);
    msg = output;

	if(user == "Me"){
		$("div#chatbox_"+roll+" div.chatbox_msg").prepend(
			"<div class='msg_container'> <div id='sender_me'>"+
			msg+"</div><div class='clear_fix'></div><div id='sender_time_me'>"+
			when+"</div></br><div class='clear_fix'></div></div>");
	}else{
			$("div#chatbox_"+roll+" div.chatbox_msg").prepend(
				"<div class='msg_container'><div id='sender'>"+
				msg+"</div><div class='clear_fix'></div><div id='sender_time_me'>"+
				when+"</div></br><div class='clear_fix'></div></div>");
	}
		});
	if(newmsg=="yes") {
			$("div#chatbox_"+roll+" div.chatbox_msg").scrollTop($("div#chatbox_"+roll+" div.chatbox_msg")[0].scrollHeight);
			if($("div#chatbox_"+roll+" div.chatbox_text input").is(":focus")==false) {
					setBrowserTitle(name);
	             	$("div#chatbox_"+roll+" div.chatbox_text input").focus();
				}
			newmsg="yes";   //set to no for repetition of chat sound
			}
		}else {
			$("div#chatbox_"+roll+" div.chatbox_msg").empty();
			$("div#chatbox_"+roll+" div.chatbox_msg").html("<div class='err_msg'>Start chat</div>");
		}
	}});
}

function popUpChat() {
	refreshPopUpChat();
	popUpTimer = setInterval("refreshPopUpChat()",1000);
}

function refreshPopUpChat() {
	var str = "action=popUpChat";
	$.ajax({url:"processRequest.php", type:"POST", data:""+str+"", dataType:"xml", success:function(result){
		var c = $(result).find("root").attr("count");
		if($("div.chat-msg-title").text().length >= 1){
			//chatmsg_box();
		}else{
			if(c>0) {
				$(result).find("users").each(function(){
					var name = $(this).find("name").text();
					var roll = $(this).find("roll").text();
					chatmsg_box();

					if($("div#chatbox_"+roll).length==0) {
						setBrowserTitle(name);
						playSound(soundFile = "../sound/two (93).MP3");
						chatWith(name,roll);
            inbox_msg();
					}
					else
					if($("div#chatbox_"+roll).css("top")=="205px"){
						setBrowserTitle(name);
						playSound(soundFile = "../sound/two (93).MP3");
            inbox_msg();
						$("div#chatbox_"+roll).show();
						$("div#chatbox_"+roll+" div.chatbox_title").css("background-color","#99C");
						$("div#chatbox_"+roll+" div.chatbox_title").text(name+" says...");
					}
					else{
            inbox_msg();
						$("div#chatbox_"+roll).show();
						newmsg="yes";
						playSound(soundFile = "../sound/two (93).MP3");
						getChat(roll,name);
						chatmsg_box();
					}

				});
			}
			else
				newmsg="no";
			}

		}

		});
}

function startShakeschat(){
	$("div.chat_msg_box_bay").empty();
	chatmsg_box();
	$.ajaxSetup({cache:false});
	setInterval("newmsgs()",1000);
}


function sendYChat() {
	var roll = $("div#chat-msg-input input#enroll").val();
	var name = $("div#chat-msg-input input#name").val();
	var msg=$("div.chat-msg-input textarea#msg").val() ;
	var str = "action=sendMChat&msg="+msg+"&roll="+roll+"&name="+name;

	if(msg.length!=0) {
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+"", dataType:"xml", success:function(result) {
				var check = $(result).find("root").attr("success");
					playSound(soundFile = "../sound/notify.ogg");
					//newmsgs();
					$("div.chat_msg_box_bay").scrollTop($("div.chat_msg_box_bay")[0].scrollHeight);
			}
		});
	}
	$("div.chat-msg-input textarea#msg").val("");
	return false;
}


function chatmsg_box(){
	var roll = $("div.thisis_true div#enroll").text();
	var rname = $("div.thisis_true div#name").text();
	var str = "action=startChatbox&roll="+roll+"&rname="+rname;
	$.ajax({url:'message/message_moments.php', type:'POST', data: str,success:function(data) {
			$("div.chat_msg_box_bay").empty();
			//save on local machice
			//savedatatolocal(rname,data);
			var i = 0;
			for(var key in data){
				id = data[key].message.id;
				user = data[key].message.user;
				msg = data[key].message.msg;
    			when = data[key].message.when;
    			//emojis
    			msg = emojione.toImage(msg);

					if(user === "Me"){
							$("div.chat_msg_box_bay").prepend("<div id='sender_me'>"+msg+"</div><div class='clear_fix'></div><div id='sender_time_me'>"+when+"</div></br><div class='clear_fix'></div>");
					}else{
							$("div.chat_msg_box_bay").prepend("<div id='sender'>"+msg+"</div><div class='clear_fix'></div><p id='sender_time'>"+when+"</p></br><div class='clear_fix'></div>");
					}
					$("div.chat_msg_box_bay").scrollTop($("div.chat_msg_box_bay")[0].scrollHeight);
					$("input#lastmsg").val(id);
		}
	}});
	//return false;
}

function newmsgs(){
	var roll = $("div.thisis_true div#enroll").text();
	var rname = $("div.thisis_true div#name").text();
	var str = "action=getnewChats&roll="+roll+"&rname="+rname;
	$.ajax({url:"message/message_moments.php", type:"POST", data: str, success:function(data) {
	$("div.chat_msg_box_bay").empty();
		var i = 0;
		for(var key in data){
			id = data[key].message.id;
			user = data[key].message.user;
			msg = data[key].message.msg;
    			when = data[key].message.when;
    		status = data[key].message.status;
    		//emojis
    		msg = emojione.toImage(msg);
    		if (status === "yes") {
    			$("#status").html(" is typing...");
    		}else{
    			$("#status").html("");
    		}

			if(user === "Me"){
				$("div.chat_msg_box_bay").prepend(
					"<div id='sender_me'>"+msg+"</div><div class='clear_fix'></div><div id='sender_time_me'>"+
					when+"</div></br><div class='clear_fix'></div>");
			}else{
				$("div.chat_msg_box_bay").prepend(
					"<div id='sender'>"+msg+"</div><div class='clear_fix'></div><p id='sender_time'>"+
					when+"</p></br><div class='clear_fix'></div>");
			}
			$("input#lastmsg").val(id);
		}
	}});
}

function WritingStatus(roll) {
	var len = $("div.chat_msg_box div.chat-msg-input textarea").val().length;
	if(len >=1) {
		var str = "action=setWritingStatus";
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
	}else{
		var str = "action=unsetWritingStatus";
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
	}
}


function setWritingStatus(roll) {
	var len = $("div#chatbox_"+roll+" div.chatbox_text input").val().length;
	if(len >=1) {
		var str = "action=setWritingStatus";
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
	}else{
		var str = "action=unsetWritingStatus";
		$.ajax({url:"processRequest.php", type:"POST", data:""+str+""});
	}
}

function playSound(soundFile) {
  soundHandle = document.getElementById('soundHandle');
  soundHandle.src = soundFile;
  soundHandle.play();
}

function setBrowserTitle(name) {
	document.title=name+" says...";
}

//this function automatically update the notification box
function checkNotification(){
    $.ajax({url:"notification_check.php", success:function(output){
                $("#notification").html(output);
                }});
}

//noyify
function Notification(){
    $.ajax({url:"notification.php", success:function(output){
                $("#not_112").html(output);
                }});
}

//the the notifications for the dropdown list on the bar
function not_1_bar(){
	$.ajax({url:"note_bar.php", success:function(output){
		if(output == ""){
			$("#not_113").html("<tr><td></td><td> No friend request. </td><td></td><td></td></tr>");
		}else{
			$("#not_113").html(output);
		}
	}});
}

//like session
function like(enroll,post_id){
	var str = "Like=Like&user_enroll="+enroll+"&post_id="+post_id;
	$.ajax({url:"post_likes.php", type:"POST", data:""+str+"",success:function(result) {
			$.ajax({url:"posts_set/likes.php", type:"POST", data:""+str+"",success:function(output){
				$(".nums_like"+post_id).html(output);
			}});
			$("#see"+post_id).html(result);
	}});
}

//update search result
function searchUsersOnline(){
    var search = $("#searchm").val();
		if(search == 0){
			emptysearch();
		}else{
    	$.post("search.php", {user_search: search}, function(output){
                $("#friends_list").html(output);
    			});
		}
}

function emptysearch(){
	$("#friends_list").html("");
}

//this function automatically update the inbox msg counter
function inbox_msg(){
    $.ajax({url:"inbox_msg.php", success:function(output){
                $("#inbox_msg").html(output);
                }});
}


function settings(){
    $('.setting').toggle(hide);
}

function json(goTo){
	var contents = "";
	var page = goTo;
	$.ajax({url: file, dataType:"json", type:"post", data: contents,success:function(result) {
		if(result.success){
			//
		}else{
			//
		}
	}});
}

function get(arr){
	var myObj = JSON.parse(arr);
	document.getElementById(toelement).innerHTML=myObj.name;
}

function send(){
	var x = {"name":"","enroll":"","message":"","time":""};
	var json = JSON.stringify(x);
	window.location = "demo.php?user="+json;
}

function savedatatolocal(name,arr){
	var myObj = JSON.stringify(arr);
	localStorage.setItem(name, myObj);
}

function getdatafromlocal(name){
	var arr = localStorage.getItem(name);
	var myObj = JSON.parse(arr);
	return myObj;
}

$(function(){
	$("img.viewimg").click(
		function(){
			//console.log("Entering src:", this.getAttribute("src"));
			img = this.getAttribute("src");
			$("#mission").modal("show");
			$("#john_wick_the_hacker").attr("src", this.getAttribute("src"));
			$("#downloadimg").attr("href", this.src);
			//photo likes
			var str = "checkimg=true&img="+img+"&token=";
			$.ajax({url:"post_likes", type:"POST", data:""+str+"",success:function(result) {
				$(".likes").html(result);
			}});
		}
	);
})

function likeimg(id){
	var str = "likeimg=true&enroll="+id+"&img="+img+"&token=";
	$.ajax({url:"post_likes", type:"POST", data:""+str+"",success:function(result) {
		$(".likes").html(result);
	}});
}

//this function loads old posts when you scroll to the bottom of the page
function loadold(lastid){
	var str = "lastid="+lastid;
	//console.log(str);
	$.ajax({url:"loadold", type:"POST", data:""+str+"",success:function(result) {
		$("#john_carter_feeds").append(result);
		var str = "getnewlastid="+true;
		$.ajax({url:"loadold", type:"POST", data:""+str+"",success:function(result) {
			//console.log(result);
			$(".data-last-id").attr("onclick",result);
		}});
	}});
}

function me(){
	checkNotification();
	Notification();
	startShakeschat();
}

function loadstart(){
	checkNotification();
	Notification();
}
