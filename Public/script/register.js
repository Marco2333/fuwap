$(document).ready(function(){
	$("#register-form").validate({
		rules:{
			nickname:{
				required:true,
				maxlength:10
				// remote:"../Login/checkUserExist"
			},
			password:{
				required:true,
				minlength:8,
				maxlength:20
			},
			"confirm-password": {
				equalTo:".register-info-input input[name='password']"
			},
			phone: {
				digits:true,
				maxlength:11,
				minlength:11,
				required:true
			},
			mail: {
				email:true
			}
		},
		messages:{
			nickname:{
				required:"用户名不能为空",
				maxlength:"用户名长度不能超过10位"
			},
			password:{
				required:"密码不能为空",
				minlength:"密码长度不能低于8位",
				maxlength:"密码长度不能超过20位"
			},
			"confirm-password": {
				equalTo:"两次输入的密码不一致"
			},
			phone: {
				digits:"请输入11位中国大陆手机号",
				maxlength:"请输入11位中国大陆手机号",
				minlength:"请输入11位中国大陆手机号",
				required:"手机号不能为空"
			},
			mail: {
				email:"请输入正确的邮箱"
			}
		},
		errorPlacement:function(error, element) {
	        //error是错误提示元素span对象  element是触发错误的input对象
	        //发现即使通过验证 本方法仍被触发
	        //当通过验证时 error是一个内容为空的span元素
	        element.parent().next(".error-message-wrapper").empty();
	        error.appendTo(element.parent().next(".error-message-wrapper"));
	        // element.parent().next(".error-message").removeClass("none");
    	},
    	errorClass:"error-message"
	});

	$(".register-info-input input[name='phone']").blur(function(){
		checkUserExist();
	});
})

function checkUserExist(){
	$(".register-info-input input[name='phone']")
				.parent().next().empty();
	var phone = $(".register-info-input input[name='phone']").val();
	$.ajax({
		type:"POST",
		url: "/fuwebapp/index.php/Home/Login/checkUserExist",
		data: {
			phone:phone
		},
		success: function(data){
			var json = eval(data);
			if(json.status==0){
				$(".register-info-input input[name='phone']")
				.parent().next()
				.append("<label class='error-message'>该手机号已被注册</label>");
				// $("#register-info input[name='phone']").attr("value","");
				$(".register-info-input input[name='phone']").val("");
			}
		}
	})
}