$(document).ready(function(){

    $(".orderconfirm-btn-pay").on('click',function(){
    	var data={
    		//rank:$rank,
    		orderIds:$orderIds,
    		channel:$("input[type='radio'][name='pay_way']").val()
    	}

    	console.log(data);
    	$.ajax({
    		url:$payUrl,
    		type:"post",
    		data:data,
    		success:function(data){
    			 pingpp.createPayment(data, function(result, err) {
                      console.log(result);
                      console.log(err);
                    });
    		}
    	});
    });

	$(".orderconfirm-arrivetime").click(function(){
		$("body").addClass("over-hidden");
		$("#arr-time-mask").fadeIn(100);
		$("#arr-time li").remove();

		var colseTime = "24:00";
		$.ajax({
			url:"/fuwebapp/index.php/Home/ShoppingCart/getCloseTime",
			type:'POST',
			success:function(data) {
				if(data.status == 1) {
					colseTime = data.colseTime;

					console.log(colseTime);
					for(i=0;i<50;i++) {
						var t = curentTime(30*i+2);
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

					$("#arr-time-mask li").eq(0).addClass("active");

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
			   				t = nh+":"+nm;
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

		        		// var $text = "￥"+price['dPrice'];
		        		// $this.parent().prev().children(".orderconfirm-price").text($text);
		        		// var $text = "原价:￥"+price['Price'];
		        		// $this.parent().prev().children(".orgin-price").text($text);
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
		        	pricecalculate();
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
