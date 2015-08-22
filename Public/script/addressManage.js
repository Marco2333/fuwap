$(document).ready(function(){

	$("#add-location-body li").on("swipeleft",function(){
		$(this).siblings().animate({left:"0%"},200);
	  	$(this).animate({left:"-20%"},200);
	});

	$("#add-location-body li").on("swiperight",function(){
	  	$(this).animate({left:"0%"},200);
	});

	$(".slide-delete").click(function(){
		var rank = $(this).attr("data-rank");

		$.ajax({
			url:'/fuwebapp/index.php/Home/Person/deleteAdress',
			type:'POST',
			data:{
				rank:rank
			},
			success:function(data) {
				if(data == 1) {
					$("#"+rank).remove();
				}
				else if(data == -1){
					alert("默认地址不能删除");
				}
				else {
					alert("删除失败");
				}
			},
			error:function(){
				alert("删除失败");
			}

		});
	});

	$("#revise-form").validate({
		rules:{
			"new-receiver":{
				required:true,
				maxlength:15
			},
			"new-location":{
				required:true
			},
			"new-phone": {
				digits:true,
				maxlength:11,
				minlength:11,
				required:true
			},
			"new-deLocation": {
				required:true
			}
		},
		messages:{
			"new-receiver":{
				required:"联系人不能为空",
				maxlength:"联系人长度不能超过15位"
			},
			"new-location":{
				required:"请选择校区"
			},
			"new-phone": {
				digits:"请输入11位中国大陆手机号",
				maxlength:"请输入11位中国大陆手机号",
				minlength:"请输入11位中国大陆手机号",
				required:"手机号不能为空"
			},
			"new-deLocation": {
				required:"详细地址不能为空"
			}
		},
		errorPlacement:function(error, element) {
	        //error是错误提示元素span对象  element是触发错误的input对象
	        //发现即使通过验证 本方法仍被触发
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
	        //当通过验证时 error是一个内容为空的span元素
	       
    	}
    	// errorClass:"error-message"
	});

	$("#revise-select-campus").click(function(){
		$("#revise-wrapper").animate({left:0});
	});

	$(".history-back-temp").click(function(){
		$("#revise-wrapper").animate({left:'100%'});
	});

	$("#city-campus-nav li").click(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	});

	$("#campus-nav li").click(function(){
		$("#revise-wrapper").animate({left:"100%"});
		$("#revise-select-campus input[name='new-location']").val($(this).children().text().trim());
		$("#revise-select-campus input[name='campusId']").val($(this).attr("data-id"));
	});

	$("#city-nav li").click(function(){
		$.ajax({
			url:"/fuwebapp/index.php/Home/Index/getCampusByid",
			type:"POST",
			data:{
				city_id:$(this).attr('data-id')
			},
			success:function(data){
				$("#campus-nav ul").empty();
				if(data['status'] == 1) {
					var camList = data['campusList'];

					for(var i = 0; i<camList.length;i++){
						
						$("<li></li>").attr("data-id",camList[i].campus_id)
							.append($("<a>"+camList[i].campus_name+"</a>"))
							.appendTo($("#campus-nav ul"));
					}

					$("#campus-nav li").click(function(){
						$(this).siblings().removeClass("active");
						$(this).addClass("active");
					});

					$("#campus-nav li").click(function(){
						$("#revise-wrapper").animate({left:"100%"});
						$("#revise-select-campus input[name='new-location']").val($(this).children().text().trim());
						$("#revise-select-campus input[name='campusId']").val($(this).attr("data-id"));
					});
				}
				else {
					alert("刷新失败！");
				}
			},
			error:function(){
				alert("刷新失败！");
			}
		});
	});

	$(".set-default-address").click(function(){
		var rank = $(this).attr("data-rank");
        
		$.ajax({
			url:"/fuwebapp/index.php/Home/Person/setDefaultAddress",
			type:'POST',
			data:{
				rank:rank
			},
			success:function(data){
				if(data.status == 1){
					alert("修改成功");
				}
				else {
					alert("修改失败");
				}
			},
			error:function(){
				alert("修改失败");
			}
		});
	});
});