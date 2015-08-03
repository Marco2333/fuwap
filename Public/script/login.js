$(document).ready(function () {
    if ($.cookie("rmbUser") == "true") {
        $("#ck_rmbUser").attr("checked", true);
        // $("#username").val($.cookie("username"));
        $("#username").attr("value",$.cookie("username"));
        // $("#userpassword").val($.cookie("password"));
        $("#password").attr("value",$.cookie("password"));
        
        // window.location.href = "../Index/index";
    }
});

// function changeImgCode(){
// 	var imgCode=$("#imgCode");
// 	imgCode.attr("src",imgCode.attr("src") + '?' + Math.floor(Math.random()*100));
// }

function login() {
	var username = $("#username").val();
	var password = $("#password").val();
	var verify = $("#security-code input[name='verify']").val();
	//var token = $("#security-code").val();
     
  //    var xz=document.getElementById("ck_rmbUser"); 
	 // alert(xz.checked); 
	 
	/*if (document.getElementById("ck_rmbUser").checked) {
	    $.cookie("rmbUser", "true", { expires: 7 }); 
	    $.cookie("username", username, { expires: 7 });
	    $.cookie("password", password, { expires: 7 });	   
	}
	else {
	    $.cookie("rmbUser", "false", { expire: -1 });
	    $.cookie("username", "", { expires: -1 });
	    $.cookie("password", "", { expires: -1 });
	}*/

	$.ajax({
		type: "POST",
		url: "../Login/tologin",
		data:{
			username : username,
			password: password,
			//verify:verify
            //token: token
		},
		success : function(data) {		
			if(data.status=='success'){
                    window.location.href="/fuwebapp/index.php";
         		}else{
                  $('#error-message').text(data.message);
         	}
		}
	    
	});
}


