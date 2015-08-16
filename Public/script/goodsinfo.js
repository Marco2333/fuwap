$(document).ready(function(){
	$("#changenumber").click(function(){
		$(".containchangenumber").show(200);
	});

	$(".colorblack").click(function(){
		$(".containchangenumber").hide(200);
	});

	$("#ordernumber").val(1);

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

	$(".add-to-shopping-cart").on("click",function(){
		var $cDefault = $(this).attr("data-default");
		var $food_id  = $(this).attr("data-food-id");
		var $this     = $(this);

		if ($cDefault != 0) {
			var $count = 1;
		}
		else {
			var $count = $this.parent().parent().prev().find("#ordernumber").val();
		}

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

});
