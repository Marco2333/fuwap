$(document).ready(function(){

	$("#add-location-body li").swipeLeft(function(){
		$(this).siblings().animate({left:"0%"},200);
	  	$(this).animate({left:"-30%"},200);
	});

	$("#add-location-body li").swipeRight(function(){
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
});