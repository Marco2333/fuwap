$(document).ready(function(){

	$(".comment-star .glyphicon").on("click",function(){

		$(this).removeClass("glyphicon-star-empty").addClass("glyphicon-star")
			.addClass("text-subspecial").prevAll().removeClass("glyphicon-star-empty").addClass("glyphicon-star")
			.addClass("text-subspecial");
	
		$(this).nextAll().removeClass("glyphicon-star").addClass("glyphicon-star-empty")
			.addClass("text-light").removeClass("text-subspecial");

		var grade =$(this).prevAll().length+1;
		$(this).parents(".comment-tr-star").attr("data-grade",grade);
	});

	$(".positive-button").on("click",function(){

		var grade = $(this).parents(".comment-tr-submit")
			.prevAll(".comment-tr-star").attr("data-grade");
		if(grade=='0') {
			alert("请先为商品打分");
			return;
		}

		var mark = $(this).parents(".comment-tr-submit")
			.prevAll(".comment-tr-mark").find("textarea").val();

		var hide = $(this).prev().find("input").prop("checked");
		
		var food_id     = $(this).attr("data-food");
		var order_id    = $(this).attr("data-goods");
		var together_id = $(this).attr("data-together");

		var $commentListItem = $(this).parents(".comment-list-item");
		if (!hide) {
			hide = 0;
		}
		else {
			hide = 1;
		}

		$.ajax({
			type:"POST",
			url:"/fuwebapp/index.php/Home/Commodity/postComment",
			data:{
				food_id:food_id,
				comment:mark,
				grade:grade,
				is_hidden:hide,
				order_id:order_id,
				together_id:together_id
			},
			success:function(result){
				if (result['result'] != 0) {
					$commentListItem.remove();
				}
				else {
					alert("亲~网速不给力哦，亲重试一次！");
				}
			}
		});
	});

});