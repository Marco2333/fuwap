$(document).ready(function(){
	var activeele = $(".nav-top ul").attr("data-active");
	$(".nav-top li").eq(parseInt(activeele)-1).addClass("active");

	// $(".nav-top li").click(function(){
	// 	$(this).siblings().removeClass("active");
	// 	$(this).addClass("active");
	// });
	
	// 1 取消订单  2 立即支付  3 确认收货  4删除订单  5 评价订单
	$(".manage-button-1").on("click",function(){
		var $together_id = $(this).nextAll(".together-id-none").val();
		var $this = $(this);

		$.ajax({
			type:"POST",
			url:"../../../../Home/OrderManage/deleteOrCancel",
			data:{together_id:$together_id},
			success:function(result){
				if (result['result'] != 0) {
					$this.parent().parent().parent().parent().parent().remove();
				}
				else {
					// alert("亲~您的订单取消失败，请重试！");
				}
			}
		});
	});

	$(".manage-button-2").on("click",function(){
		var $together_id = $(this).nextAll(".together-id-none").val();

	});

	$(".manage-button-3").on("click",function(){
		var $together_id = $(this).nextAll(".together-id-none").val();
		var $this = $(this);

		$.ajax({
			type:"POST",
			url:"../../../../Home/OrderManage/confirmOrder",
			data:{together_id:$together_id},
			success:function(result){
				if (result['result'] != 0) {
					$this.parent().parent().parent().parent().parent().remove();
				}
				else {
					// alert("亲~您的订单确认失败，请重试！");
				}
			}
		});

	});

	$(".manage-button-4").on("click",function(){
		var $together_id = $(this).nextAll(".together-id-none").val();
		var $this = $(this);

		$.ajax({
			type:"POST",
			url:"../../../../Home/OrderManage/deleteOrCancel",
			data:{together_id:$together_id},
			success:function(result){
				if (result['result'] != 0) {
					$this.parent().parent().parent().parent().parent().remove();
				}
				else {
					// alert("亲~您的订单删除失败，请重试！");
				}
			}
		});

	});

	$(".manage-button-5").on("click",function(){
		var $together_id = $(this).nextAll(".together-id-none").val();

		$.ajax({
			type:"POST",
			url:"../../../../Home/OrderManage/commentOrder",
			data:{together_id:$together_id},
			success:function(result){
				if (result['result'] != 0) {
					var $href = "../../../../Home/Commodity/comment?orderIds="+result['orderIds'];
					window.location.href = $href;
				}
				else {
					// alert("亲~网络不给力哦，请重试！");
				}
			}

		});
	});

});