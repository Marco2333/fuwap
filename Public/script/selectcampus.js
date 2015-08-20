$(document).ready(function(){
	$("#city-campus-nav li").click(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	});

	$("#city-nav li").click(function(){
		$.ajax({
			url:"../../Home/Index/getCampusByid",
			type:"POST",
			data:{
				city_id:$(this).attr('data-id')
			},
			success:function(data){
				$("#campus-nav ul").empty();
				if(data['status'] == 1) {
					var camList = data['campusList'];

					for(var i = 0; i<camList.length;i++){
						// $("<li></li>").append($("<a href='../../Home/Index/index/campus_id/"+camList[i].campus_id"'>"+camList[i].campus_name+"</a>"))
						// 	.appendTo($("#campus-nav ul"));
						$("<li></li>").append($("<a href='../../Home/Index/index/campus_id/"+camList[i].campus_id+"'>"+camList[i].campus_name+"</a>"))
							.appendTo($("#campus-nav ul"));
					}

					$("#campus-nav li").click(function(){
						$(this).siblings().removeClass("active");
						$(this).addClass("active");
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
});