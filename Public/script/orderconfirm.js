$(document).ready(function(){

    $(".orderconfirm-btn-pay").on('click',function(){

    	var $rank = $("#order-confirm-location").attr("data-rank");
    	var $reserveTime = $(".arrive-time").text();
    	var $message =　$(".orderconfirm-message>textarea").val();
    	var data={
    		rank:$rank,
    		orderIds:$orderIds,
    		channel:$("input[type='radio'][name='pay_way']").val(),
    		reserveTime:$reserveTime,
    		message:$message
    	}
    	$("#loader-wrapper").removeClass('none');
    	$.ajax({
    		url:$payUrl,
    		type:"post",
    		data:data,
    		success:function(data){
    			if(data.status == 2){
    			    pingpp.createPayment(data.charge, function(result, err) {
    			      
    			    });
    			}else if(data.status == -1){
    			   $("#loader-wrapper").addClass('none');
    			   alert("支付失败，请重试");
    			}else if(data.status == 1) {
    			   $("#loader-wrapper").addClass('none');
    			   alert("亲,收货地址超出配送范围哦");
    			}else if(data.status == 0) {
    			   $("#loader-wrapper").addClass('none');
    			   alert("亲，休息喽，下次再来");
    			}else if(data.status ==3){
    			   $("#loader-wrapper").addClass('none');
    			   alert("该笔订单已经支付过，请不要重复支付");
    			}
    		}
    	});
    });

	$(".orderconfirm-arrivetime").click(function(){
		$("body").addClass("over-hidden");
		$("#arr-time-mask").fadeIn(100);
		$("#arr-time li").remove();

		var colseTime = "24:00";
		$.ajax({
			url:"/fuwebapp/index.php/Home/Shoppingcart/getCloseTime",
			type:'POST',
			success:function(data) {
				if(data.status == 1) {
					colseTime = data.colseTime;

					for(i=0;i<50;i++) {
						var t = curentTime(30*i);
						if(parseInt(t.substr(0,2))>parseInt(colseTime.substr(0,2))){
							break;
						}
						else if(parseInt(t.substr(0,2))==parseInt(colseTime.substr(0,2))&&parseInt(t.substr(3,5))>=parseInt(colseTime.substr(3,5))) {
							break;
						}
						else {
							$("#arr-time ul").append($("<li>"+t+"</li>"));
						}
					}

					$("#arr-time-mask li").eq(0).replaceWith("<li class='active'>立即送达</li>");

					$("#arr-time-mask li").click(function(){
						$("body").removeClass("over-hidden");
						$(this).siblings().removeClass("active");
						$(this).addClass("active");
						var t = $(this).text();
						var now = new Date();    
			   			
			   			var bh = t.substr(0,2);
			   			var bm = t.substr(3,5);
			   			var nh = now.getHours();
			   			var nm = now.getMinutes();

			   			var flag = false;

			   			if(bh < nh){
			   				var flag = true;
			   			}
			   			else if(bh==nh&&bm<nm){
			   				var flag = true;
			   			}
			   			if(flag) {
	   						if(parseInt(nm)<10){
			   					t = nh+":0"+nm;
			   				}
			   				else {
			   					t = nh+":"+nm;
			   				}	
			   			}
			    
						$(".orderconfirm-arrivetime .arrive-time").text(t);
						$("#arr-time-mask").fadeOut(100);
					});
				}
			},
			error:function() {
				alert("刷新失败");
			}
		});
	});
	
	$("#order-confirm-location").click(function(){
		$("#select-location-body").animate({"left":0});
		$("body").addClass("over-hidden");
	});

	$("#select-location-body li").click(function(){
		$("#order-confirm-location").attr("data-rank",$(this).attr("id"));
		$("#order-confirm-location .consumer-name").text($(this).find(".location-name").text());
		$("#order-confirm-location .consumer-phone").text($(this).find(".location-phone").text());
		$("#order-confirm-location .consumer-address").text($(this).find(".location-address").text());
		$("#select-location-body").animate({"left":"100%"});
		$("body").removeClass("over-hidden");
	});

	$(".history-back-temp").click(function(){
		$("#select-location-body").animate({"left":"100%"});
		$("body").removeClass("over-hidden");
	});

	$("#arr-time-mask").click(function(){
		$(".orderconfirm-arrivetime .arrive-time").text(t);
		$("#arr-time-mask").fadeOut(100);

		var t = $("#arr-time-mask li.active").text();

			var now = new Date();    	
   			var bh = t.substr(0,2);
   			var bm = t.substr(3,5);
   			var nh = now.getHours();
   			var nm = now.getMinutes();
   			var flag = false;

   			if(bh < nh){
   				var flag = true;
   			}
   			else if(bh==nh&&bm<nm){
   				var flag = true;
   			}
   			if(flag) {
   				if(parseInt(nm)<10){
   					t = nh+":0"+nm;
   				}
   				else {
   					t = nh+":"+nm;
   				}	
   			}
    
			$(".orderconfirm-arrivetime .arrive-time").text(t);
			$("body").removeClass("over-hidden");
			$("#arr-time-mask").fadeOut(100);
	});
	
	/*=================增减商品=======================*/
	$(".orderconfirm-goods-txt a.sub-goods").click(function(){
		var $together_id = $(".together-id-none").val();
		var $order_count = parseInt($(this).next("input").val())-1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		if ($order_count > 0) {
			$.ajax({
		        type:"POST",
		        url:'/fuwebapp/index.php/Home/Shoppingcart/updateSettleAccounts',
		        data:{order_count:$order_count,order_id:$order_id,together_id:$together_id},
		        success:function(price){
		        	if (price['result'] != 0) {
		        		document.getElementById($order_id).value = $order_count;
		        		$("#settle-dprice").text(price['dPrice']);
		        		$("#settle-price").text(price['Price']);
		        		$("#settle-save").text((price['Price']-price['dPrice']).toFixed(2));
		        	}
		        	else {
		        		// alert('物品增加或减少购买失败，请稍后重试！');
		        	}
	       		}
	       	});
		}
	});
	
	$(".orderconfirm-goods-txt a.add-goods").click(function(){
		var $together_id = $(".together-id-none").val();
	    var $order_count = parseInt($(this).prev("input").val())+1;
	    var $order_id    = $(this).attr("data-orderId");
	    var $this        = $(this);

	    $.ajax({
	    	type:"POST",
		    url:'/fuwebapp/index.php/Home/Shoppingcart/updateSettleAccounts',
		    data:{order_count:$order_count,order_id:$order_id,together_id:$together_id},
	        success:function(price){
	        	if (price['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;	
		        	$("#settle-dprice").text(price['dPrice']);
		        	$("#settle-price").text(price['Price']);
		        	$("#settle-save").text((price['Price']-price['dPrice']).toFixed(2));
		        }
		       	else {
		      		// alert('亲~物品增加或减少购买失败，请稍后重试！');
		       	}
	       	}
	    });	    
	});								
});

function curentTime(addtime)   
{   
    var now = new Date();    
    var hh = now.getHours(); //时
    var mm = (now.getMinutes() + addtime) % 60;  //分

    if ((now.getMinutes() + addtime) / 60 > 1) {
        hh += Math.floor((now.getMinutes() + addtime) / 60);
    }
    
    var clock="";
    if(hh < 10) {
    	clock += "0";
    }            
    clock += hh + ":";   
    if (mm < 10) {
    	clock += '0';  
    } 
    clock += mm; 

    return(clock);
} 

function pricecalculate(){
	var $together_id = $(".together-id-none").val();
	$.ajax({
		type:"POST",
		url:"/fuwebapp/index.php/Home/Shoppingcart/settleAccounts",
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
		}
	});
}
