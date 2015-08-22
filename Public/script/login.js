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
	 
	if(username.trim() == ""){
		 $('.error-message').text("用户名不能为空！");
		 $(".error-message-wrapper").slideDown(150); 
          return;
	}
	if(password.trim() == "") {
		 $('.error-message').text("密码不能为空！");
		 $(".error-message-wrapper").slideDown(150); 
          return;
	}
	$('.error-message').text("");
	$(".error-message-wrapper").slideUp(150); 
                  
	if (document.getElementById("ck_rmbUser").checked) {
	    $.cookie("rmbUser", "true", { expires: 7 }); 
	    $.cookie("username", username, { expires: 7 });
	    $.cookie("password", password, { expires: 7 });	   
	}
	else {
	    $.cookie("rmbUser", "", { expires: -1 });
	    $.cookie("username", "", { expires: -1 });
	    $.cookie("password", "", { expires: -1 });
	}

	$.ajax({
		type: "POST",
		url: "../Login/tologin",
		data:{
			username : username,
			password: password
		},
		success : function(data) {		
			if(data.status=='success'){
                    window.location.href="/fuwebapp/index.php";
         		}else{
         			 $('.error-message').text(data.message);
		 			 $(".error-message-wrapper") .slideDown(150);  
         	}
		}
	});
}


