$(document).ready(function(){

	$("#shoppingcart-body .sub-goods").on("click",function(){
		var $order_count = parseInt($(this).next("input").val())-1;
		var $order_id    = $(this).attr("data-orderId");

		$.ajax({
	        type:"POST",
	        url:'../../Home/ShoppingCart/updateOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	if (result['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;
	        	}
	        	else {
	        		// alert('物品增加或减少购买失败，请重试！');
	        	}
       		}
       	});
	});

	$("#shoppingcart-body .add-goods").on("click",function(){
		var $order_count = parseInt($(this).prev("input").val())+1;
		var $order_id    = $(this).attr("data-orderId");

		$.ajax({
	        type:"POST",
	        url:'../../Home/ShoppingCart/updateOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	if (result['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;
	        	}
	        	else {
	        		// alert('物品增加或减少购买失败，请重试！');
	        	}
       		}
       	});
	});

	$("#shoppingcart-body .input-locate").on("click",function(){
		var checkedList = $(".input-locate");
		var $Price  = 0;
		var $dPrice = 0;

		for (i = 0;i < checkedList.length;i++) {

			if ($(checkedList[i]).prop("checked")) {		
				var $order_count    = parseInt($(this).nextAll(".order-count-none").val());
				var $price          = parseFloat($(this).nextAll(".price-none").val());
				var $discount_price = parseFloat($(this).nextAll(".discount-price-none").val());
				var $is_discount    = parseInt($(this).nextAll(".is-discount-none").val());

				$Price += $price * $order_count;

				if ($is_discount != 0) {
					$dPrice += $discount_price * $order_count;
				}
				else {
					$dPrice += $price * $order_count;
				}
			}
		}

		var $save = $Price - $dPrice;
		document.getElementById("Price").innerHTML  = "￥"+$dPrice+"元";
		document.getElementById("dPrice").innerHTML = "原价："+$Price+"元";
		document.getElementById("save").innerHTML   = "(已节省"+$save+"元)";
	});


});