$(document).ready(function(){

	/*=================计算价格的函数=======================*/
	function pricecalculate(){
		var $together_id = $(".together-id-none").val();

		$.ajax({
			type:"POST",
			url:"/fuwebapp/index.php/Home/ShoppingCart/settleAccounts",
			data:{together_id:$together_id},
			success:function(price){
				if (price['result'] != 0) {
					document.getElementById("settle-dprice").innerHTML = price['dPrice'];
					document.getElementById("settle-price").innerHTML = price['Price'];
					document.getElementById("settle-save").innerHTML = price['save'];
				}
				else {
					// alert("亲~抱歉，获取总价格失败，请稍后重试！");
				}
			},
			error:function(){
				alert("o");
			}
		});
	}
	/*=================增减商品=======================*/
	$(".orderconfirm-goods-txt a.sub-goods").click(function(){
		var $order_count = parseInt($(this).next("input").val())-1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		if ($order_count >= 0) {
			$.ajax({
		        type:"POST",
		        url:'/fuwebapp/index.php/Home/ShoppingCart/updateSettleAccounts',
		        data:{order_count:$order_count,order_id:$order_id},
		        success:function(price){
		        	if (price['result'] != 0) {
		        		document.getElementById($order_id).value = $order_count;

		        		var $text = "￥"+price['dPrice']+"元";
		        		$this.parent().prev().children(".orderconfirm-price").text($text);

		        		var $text = "原价:￥"+price['Price']+"元";
		        		$this.parent().prev().children(".orgin-price").text($text);

		        		pricecalculate();
		        	}
		        	else {
		        		// alert('物品增加或减少购买失败，请稍后重试！');
		        	}
	       		}
	       	});
		}
	});
	
	$(".orderconfirm-goods-txt a.add-goods").click(function(){
	    var $order_count = parseInt($(this).prev("input").val())+1;
	    var $order_id    = $(this).attr("data-orderId");
	    var $this        = $(this);

	    $.ajax({
	    	type:"POST",
		    url:'/fuwebapp/index.php/Home/ShoppingCart/updateSettleAccounts',
		    data:{order_count:$order_count,order_id:$order_id},
	        success:function(price){
	        	if (price['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;
	        		
	        		var $text = "￥"+price['dPrice']+"元";
	        		$this.parent().prev().children(".orderconfirm-price").text($text);

		        	var $text = "原价:￥"+price['Price']+"元";
		        	$this.parent().prev().children(".orgin-price").text($text);

		        	pricecalculate();
		        }
		       	else {
		      		// alert('亲~物品增加或减少购买失败，请稍后重试！');
		       	}
	       	}
	    });	    
	});								
});

