$(document).ready(function () {
    if ($.cookie("rmbUser") == "true") {
        $("#ck_rmbUser").prop("checked", true);
        $("#username").val($.cookie("username"));
        $("#password").val($.cookie("password"));
        // window.location.href = "../Index/index";
    }
});

function login() {
	var username = $("#username").val();
	var password = $("#password").val();
	 
	if (document.getElementById("ck_rmbUser").checked) {
	    $.cookie("rmbUser", "true", { expires: 7 }); 
	    $.cookie("username", username, { expires: 7 });
	    $.cookie("password", password, { expires: 7 });	   
	}
	else {
	    $.cookie("rmbUser", "false", { expire: -1 });
	    $.cookie("username", "", { expires: -1 });
	    $.cookie("password", "", { expires: -1 });
	}

	$.ajax({
		type: "POST",
		url: "../Login/tologin",
		data:{
			username : username,
			password: password,
		},
		success : function(data) {		
			if(data.status=='success'){
                    window.location.href="/fuwebapp/index.php";
         		}else{
                  $('#error-message').text(data.message)
                  .slideDown(150);
         	}
		}
	});
}


