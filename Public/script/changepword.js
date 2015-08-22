$(document).ready(function(){
	$("#change-password-form").validate({
		rules:{
			"pre-password":{
				required:true,
				maxlength:10,
				remote:"/fuwebapp/index.php/Home/Person/resetPassword"
			},
			"new-password":{
				required:true,
				minlength:8,
				maxlength:20
			},
			"confirm-password": {
				equalTo:".user-info-input input[name='new-password']"
			}
		},
		messages:{
			"pre-password":{
				required:"原密码不能为空",
				remote:"原密码输入错误"
			},
			"new-password":{
				required:"密码不能为空",
				minlength:"密码长度不能低于8位",
				maxlength:"密码长度不能超过20位"
			},
			"confirm-password": {
				equalTo:"两次输入的密码不一致"
			}
		},
		errorPlacement:function(error, element) {
	        //error是错误提示元素span对象  element是触发错误的input对象
	        //发现即使通过验证 本方法仍被触发
	        //当通过验证时 error是一个内容为空的span元素
            var label = $(".info-tips label");
    	        if(label.length == 0) {
    	        	error.appendTo($(".info-tips"));
    	        	$(".info-tips").fadeIn(500);
    	        	setTimeout(function(){
    	        		$(".info-tips").fadeOut(500);
    	        		setTimeout(function(){
    	        			$(".info-tips").empty();
    	        		},500);
    	        	},1500);
    	    }
    	}
	});
	
})
