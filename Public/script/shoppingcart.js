$(document).ready(function(){

	$("#shoppingcart-body .sub-goods").on("click",function(){
		var $order_count = parseInt($(this).next("input").val())-1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		if ($order_count >= 0) {
			$.ajax({
		        type:"POST",
		        url:'../../Home/ShoppingCart/updateOrderCount',
		        data:{order_count:$order_count,order_id:$order_id},
		        success:function(result){
		        	if (result['result'] != 0) {
		        		document.getElementById($order_id).value = $order_count;

		        		var $div_check_goods = $this.parent().parent().prevAll(".check-goods");
		        		$div_check_goods.children(".order-count-none").val($order_count);
		        		var $Price  = parseFloat($div_check_goods.children(".price-none").val());
		        		var $dPrice = parseFloat($div_check_goods.children(".discount-price-none").val());
		        		var $is_discount = parseInt($div_check_goods.children(".is-discount-none").val());

		        		if ($is_discount != 0) {
		        			var $text = "￥"+$dPrice*$order_count+"元";
		        			$this.prevAll(".discount-price").html($text);
		        		}
		        		else {
		        			var $text = "￥"+$Price*$order_count+"元";
		        			$this.prevAll(".discount-price").html($text);
		        		}
		        		var $text = "原价：￥"+$Price*$order_count+"元";
		        		$this.prevAll(".bef-price").html($text);

		        		settleAccounts();
		        	}
		        	else {
		        		// alert('物品增加或减少购买失败，请重试！');
		        	}
	       		}
	       	});
		}
	});

	$("#shoppingcart-body .add-goods").on("click",function(){
		var $order_count = parseInt($(this).prev("input").val())+1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		$.ajax({
	        type:"POST",
	        url:'../../Home/ShoppingCart/updateOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	if (result['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;

	        		var $div_check_goods = $this.parent().parent().prevAll(".check-goods");
	        		$div_check_goods.children(".order-count-none").val($order_count);
	        		var $Price  = parseFloat($div_check_goods.children(".price-none").val());
	        		var $dPrice = parseFloat($div_check_goods.children(".discount-price-none").val());
	        		var $is_discount = parseInt($div_check_goods.children(".is-discount-none").val());

	        		if ($is_discount != 0) {
	        			var $text = "￥"+$dPrice*$order_count+"元";
	        			$this.prevAll(".discount-price").html($text);
	        		}
	        		else {
	        			var $text = "￥"+$Price*$order_count+"元";
	        			$this.prevAll(".discount-price").html($text);
	        		}
	        		var $text = "原价：￥"+$Price*$order_count+"元";
	        		$this.prevAll(".bef-price").html($text);

	        		settleAccounts();
	        	}
	        	else {
	        		// alert('物品增加或减少购买失败，请重试！');
	        	}
       		}
       	});
	});

	$("#shoppingcart-body .input-locate").on("click",function(){
		if (!$("#shoppingcart-body .input-locate").prop("checked")) {
			$("#settle-accounts #check-all").prop("checked",false);
		}
		else {
			var checkBoxs  = $("#shoppingcart-body .input-locate");
			var allChecked = true;

			for (i = 0;i < checkBoxs.length;i++) {
				if (!$(checkBoxs[i]).prop("checked")) {
					allChecked = false;
					break;
				}
			}

			if (!allChecked) {
				$("#settle-accounts #check-all").prop("checked",false);
			}
			else {
				$("#settle-accounts #check-all").prop("checked",true);
			}
		}

		settleAccounts();
	});

	$("#settle-accounts #check-all").on("click",function(){
		if ($("#settle-accounts #check-all").prop("checked")) {
			$("#shoppingcart-body .input-locate").prop("checked",true);
		}
		else {
			$("#shoppingcart-body .input-locate").prop("checked",false);
		}

		settleAccounts();
	});

	$("#settle-accounts #check-button").on("click",function(){
		var checks = $(".input-locate");
		var $orderIds = "";
		for (i = 0;i < checks.length;i++) {

			if ($(checks[i]).prop("checked")) {
				var order_id = $(checks[i]).nextAll(".order-id-none").val();

				if ($orderIds != "") {
					$orderIds += ",";
					$orderIds += order_id;
				}
				else {
					$orderIds += order_id;
				}
			}
		}

		if ($orderIds != "") {
			var $href = "/fuwebapp/index.php/Home/ShoppingCart/orderConfirm?orderIds="+$orderIds;
			window.location.href = $href;
		}
		else {
			// alert("亲~请勾选您想要购买的物品！");
		}
	});


});

function settleAccounts(){
	var checkedList = $(".input-locate");
	var $Price  = 0;
	var $dPrice = 0;

	for (i = 0;i < checkedList.length;i++) {

		if ($(checkedList[i]).prop("checked")) {		
			var $order_count    = parseInt($(checkedList[i]).nextAll(".order-count-none").val());
			var $price          = parseFloat($(checkedList[i]).nextAll(".price-none").val());
			var $discount_price = parseFloat($(checkedList[i]).nextAll(".discount-price-none").val());
			var $is_discount    = parseInt($(checkedList[i]).nextAll(".is-discount-none").val());

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
	document.getElementById("Price").innerHTML  = "合计：￥"+$dPrice+"元";
	document.getElementById("dPrice").innerHTML = "原价：￥"+$Price+"元";
	document.getElementById("save").innerHTML   = "(已节省"+$save+"元)";
}