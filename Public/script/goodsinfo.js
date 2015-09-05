$(document).ready(function(){
	$("#goods-info-number").click(function(){
		$("body").addClass("over-hidden");
		$(".mask").fadeIn(50);
		$("#goods-info-number-select").slideDown(340);
	});

	$(".addcart-buynow,.mask").click(function(){
		$("body").removeClass("over-hidden");
		
		$("#goods-info-number-select").slideUp(340);
		$(".mask").fadeOut(340);
	});

	$(".addcart-buynow .glyphicon-shopping-cart").click(function(){
		var $food_id  = $(this).attr("data-food-id");
		var $this     = $(this);
		var $count = $(".goods-count").val();

		$.ajax({
			type:"POST",
			url:"/fuwebapp/index.php/Home/Commodity/addToShopCart",
			data:{order_count:$count,food_id:$food_id},
			success:function(result){
				if (result['result'] == 2) {
					location.href=$loginUrl;
				}else if(result['result']==0 ){
					alert("亲~网速不给力哦，请稍后重试！");
				}else {
					alert("加入购物车成功");
				}
			}
		});
	});

	$(".buy-now").on("click",function(){

		var $food_id  = $(this).attr("data-food-id");
		var $this     = $(this);
		var $count = $(".goods-count").val();

		$.ajax({
			type:"POST",
			url:"/fuwebapp/index.php/Home/Commodity/buyNowButton",
			data:{order_count:$count,food_id:$food_id},
			success:function(result){
				if (result['result'] != 0) {
				
					var $href = "/fuwebapp/index.php/Home/ShoppingCart/orderConfirm?orderIds="+result['order_id'];
					window.location.href=$href;
				}
				else {
					// alert("亲~网速不给力哦，请稍后重试！");
				}
			}
		});
	});

	$(".sub-goods").click(function(){
		var v = $(this).next("input").val();
		if(parseInt(v)>1) {
			$(this).next("input").val(parseInt(v)-1);
		}
	});

	$(".add-goods").click(function(){
		var v = $(this).prev("input").val();
		$(this).prev("input").val(parseInt(v)+1);
	});

	$(".sub-button").click(function(){
		var $number=$("#ordernumber").val();
		if($number == 1){
			
		}else{
			$number=parseInt($number) - 1;
			$("#ordernumber").val($number);

			var $dPrice = parseInt($(".discount-dPrice-none").attr("data-price"));
			var $Price  = parseFloat($(".Price-none").attr("data-price"));

			$(".discount-dPrice-none").html($dPrice*$number);
			$(".Price-none").html($Price*$number);
			$(".save-none").html($Price*$number-$dPrice*$number)
		}
	});

	$(".add-button").click(function(){
		var $number=$("#ordernumber").val();
		$number=parseInt($number) + 1;
		$("#ordernumber").val($number);

		var $dPrice = parseInt($(".discount-dPrice-none").attr("data-price"));
		var $Price  = parseFloat($(".Price-none").attr("data-price"));

		$(".discount-dPrice-none").html($dPrice*$number);
		$(".Price-none").html($Price*$number);
		$(".save-none").html($Price*$number-$dPrice*$number)
	});




});
