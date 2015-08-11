$(document).ready(function(){

	$("#shoppingcart-body a.sub-goods").click(function(){
		var $order_count = $(this).next("input").val();
		var $order_id    = $(this).attr("data-orderId");
		alert($count);
		alert($order_id);
		$.ajax({
	        type:"POST",
	        url:'../../Home/ShoppingCart/saveOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	

       		}
       	});
	});



});