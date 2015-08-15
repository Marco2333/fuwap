$(document).ready(function(){

	$(".glyphicon-star").on("click",function(){
		$(this).parent().find('.glyphicon-star').removeClass('colorFF573A');
		$(this).addClass('colorFF573A').prevAll().addClass('colorFF573A');
		$number=$(this).parent().find('.colorFF573A').length;
		$(this).nextAll('.specialgrade').text($number);
	});

	$(".special-button").on("click",function(){
		var $grade       = $(this).parent().parent().prevAll(".grade-star").find(".specialgrade").html();
		var $comment     = $(this).parent().parent().prev().find(".food-comment-text").val();
		var $is_hidden   = $(this).parent().prev().find(".is-hidden-checked").prop("checked");
		var $food_id     = $(this).nextAll(".food-id-none").val();
		var $order_id    = $(this).nextAll(".order-id-none").val();
		var $together_id = $(this).nextAll(".together-id-none").val();
		var $this = $(this);

		if (!$is_hidden) {
			$is_hidden = 0;
		}
		else {
			$is_hidden = 1;
		}

		$.ajax({
			type:"POST",
			url:"../../Home/Commodity/postComment",
			data:{food_id:$food_id,comment:$comment,grade:$grade,is_hidden:$is_hidden,order_id:$order_id,together_id:$together_id},
			success:function(result){
				if (result['result'] != 0) {
					$this.parent().parent().parent().remove();
				}
				else {
					// alert("亲~网速不给力哦，亲重试一次！");
				}
			}
		});
	});

});