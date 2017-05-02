$(document).ready(function(){
    //special dialogs
    $(".dialog-body").css({"visibility": "hidden"});
    $(".dialog-body").hide();

    $(".show-dialog").click(function(){
        $(".dialog-body").css({"visibility": "visible"});
        $(".dialog-body").show();
        $(".dialog-body").css({"width" : "100%"});
        $(".dialog-body").css({"height": "100%"});
        $(".dialog-body").css({"padding": "5%"});
        $(".dialog-body").css({"padding-left": "22%"});
        $(".dialog-body").css({"padding-right": "22%"});
        $(".dialog-body").css({"background-color" : "rgba(005, 005, 005, .3)"});
        $(".dialog-body").css({"position": "fixed"});
        $(".dialog-body").css({"top": "0px"});
        $(".dialog-body").css({"left": "0px"});
        $(".dialog-body").css({"z-index": "110"});


        $(".dialog-content").css({"width" : "100%"});
        $(".dialog-content").css({"height": "100%"});
        $(".dialog-content").css({"overflow": "auto"});
        $(".dialog-content").css({"direction": "ltr"});
        $(".dialog-content").css({"border-radius" : "5px"});
        $(".dialog-content").css({"margin": "auto"});
        $(".dialog-content").css({"padding": "2%"});
        $(".dialog-content").css({"padding-left": "15%"});
        $(".dialog-content").css({"padding-right": "15%"});
        $(".dialog-content").css({"background-color" : "rgb(255, 255, 255)"});


        $(".close-dialog").css({"right": "-94%"});
        $(".close-dialog").css({"position": "relative"});
    });

    //the close dialog function
    $(".close-dialog").click(function(){
        $(".dialog-body").css({"visibility": "hidden"});
    });


    //img dialog-body
    $(".img-dialog-body").css({"visibility": "hidden"});
    $(".img-dialog-body").hide();

    $(".view-img").click(function(){
        $(".img-dialog-body").css({"visibility": "visible"});
        $(".img-dialog-body").show();
        $(".img-dialog-body").css({"width" : "100%"});
        $(".img-dialog-body").css({"height": "100%"});
        $(".img-dialog-body").css({"padding": "5%"});
        $(".img-dialog-body").css({"padding-left": "22%"});
        $(".img-dialog-body").css({"padding-right": "22%"});
        $(".img-dialog-body").css({"background-color" : "rgba(005, 005, 005, .3)"});
        $(".img-dialog-body").css({"position": "fixed"});
        $(".img-dialog-body").css({"top": "0px"});
        $(".img-dialog-body").css({"left": "0px"});
        $(".img-dialog-body").css({"z-index": "110"});


        $(".img-dialog-content").css({"width" : "100%"});
        $(".img-dialog-content").css({"height": "100%"});
        $(".img-dialog-content").css({"overflow": "auto"});
        $(".img-dialog-content").css({"direction": "ltr"});
        $(".img-dialog-content").css({"border-radius" : "5px"});
        $(".img-dialog-content").css({"margin": "auto"});
        $(".img-dialog-content").css({"padding": "2%"});
        $(".img-dialog-content").css({"padding-left": "15%"});
        $(".img-dialog-content").css({"padding-right": "15%"});
        $(".img-dialog-content").css({"background-color" : "rgb(255, 255, 255)"});


        $(".close-img-dialog").css({"right": "-94%"});
        $(".close-img-dialog").css({"position": "relative"});
    });

    //the close dialog function
    $(".close-img-dialog").click(function(){
        $(".img-dialog-body").css({"visibility": "hidden"});
    });

});

$(document).ready(function(){
    $("#video").click(function(){
        $(".dropzone").css({"display": "none"});
        $(".link_p").css({"display": "block"});
        $(".location_p").css({"display": "none"});
    });
    $("#photo").click(function(){
        $(".dropzone").css({"display": "block"});
        $(".link_p").css({"display": "none"});
        $(".location_p").css({"display": "none"});
    });
    $("#location").click(function(){
        $(".dropzone").css({"display": "none"});
        $(".link_p").css({"display": "none"});
        $(".location_p").css({"display": "block"});
    });
});
