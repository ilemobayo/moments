//javascript functions for responsive actions
$(document).ready(function(){ $(".shakes_setting_title_box").click(function(){
        $(".apps_settings_y").fadeToggle("fast"); }); });


$(document).ready(function(){ $("#tray").click(function(){ $(".setting").fadeToggle("slow"); }); });


$(document).ready(function(){
    /////////////minified chat////////////////////
    $(".Minified_c").click(function(){
        $(".mini-fied_chat").css({"visibility": "hidden"});
    });
    $(".Minified_o").click(function(){
        $(".mini-fied_chat").css({"visibility": "visible"});
    });
});
