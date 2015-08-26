$(document).ready(function(){

	$("#classify-navi").css("width",""+($("#classify-navi li").length*90+6)+"px");

	$(".goodsclassify-header").swipeRight(function(){
	  	var left=$(".goodsclassify-header ul").css("left");
	  	var left = left.substr(0,left.length-2);
	  	
  		if(parseInt(left)<0){
  			var newleft = parseFloat(left)+90+"px";
  			$(".goodsclassify-header ul").css( "left",newleft);
  		}
	});

	$(".goodsclassify-header").swipeLeft(function(){

	  	var left=$(".goodsclassify-header ul").css("left");
  		var width = $("#classify-navi").css("width");
  		var width = width.substr(0,width.length-2);

	  	if(-parseInt(left) < parseInt(width)-document.body.clientWidth){
	  		var newleft = parseFloat(left)-90+"px";
	  		$(".goodsclassify-header ul").css("left",newleft);
	  	}
	});

	// $("#classify-navi li").click(function(){

	// 	$(this).siblings().removeClass("active");
	// 	$(this).addClass("active");
	// 	$.ajax({
	// 		type:"POST",
	// 		url:"/fuwebapp/index.php/Home/Commodity/getGatGoods",
	// 		data:{
	// 			categoryId:$(this).attr("data-id")
	// 		},
	// 		success:function(data) {
	// 			if(data.result != 0){
					
	// 				var goodsList = data['goodsList'];

	// 				$(".body-y").empty();
	// 				for(var i = 0; i<goodsList.length;i++){
	// 					var $goodsdetail = $("<div class='goodsclassify-goodsdetail clearfix'></div>");
	// 					$("<div class='goodsclassify-goodsimg'></div>")
	// 						.append($("<img src="+goodsList[i].img_url+">"))
	// 						.appendTo($goodsdetail);

	// 					var $goodtxt = $("<div class='goodsclassify-goods-txt'></div>");
	// 					$goodtxt.append($("<div class='goods-txt-name'>"+goodsList[i].name+"</div>"))
	// 						.append($("<div class='goods-txt-intro'>"+goodsList[i].message+"</div>"));
						
	// 					var htmlString = "<div class='fl'>"
	// 							+ "<div class='goodsclassify-price fl discount-price'>"
	// 							+ goodsList[i].discount_price
	// 							+ "</div> "
	// 							+ "<span class='orgin-price fl bef-price'> ￥"
	// 							+ goodsList[i].price
	// 							+ "</span>"
	// 							+ "</div> <div class='ri'> <div class='goodsclassify-sales'> 销量："
	// 							+ goodsList[i].sale_number
	// 							+ "</div> </div>";
	// 					$("<div></div>").html(htmlString)
	// 						.appendTo($goodtxt);
	// 					var $awrapper = $("<a href='../../Home/Commodity/goodsinfo/food_id/"+goodsList[i].food_id+"'></a>");
	// 					$goodsdetail.append($goodtxt)
	// 					.appendTo($awrapper);
	// 					$(".body-y").append($awrapper);
	// 				}
	// 			}
	// 			else {
	// 				alert("刷新失败！");
	// 			}	
	// 		},
	// 		error:function(){
	// 			alert("刷新失败！");
	// 		}
	// 	});
		
	// });
		
})
