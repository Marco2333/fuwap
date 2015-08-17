$(document).ready(function(){
	$("#search-standard li").click(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	});

	$("#search-standard li").click(function(){
        console.log($(this).attr("data-key"));
		$.ajax({
			url:'../../Home/Commodity/getgoodlist',
			type:'POST',
			data:{
				std:$(this).attr("data-key"),
				key:$(".body-y").attr("data-key")
			},
			success:function(data) {
				if(data.result != 0){				
					var goodsList = data['goodList'];
					// console.log(goodsList);
					$(".body-y").empty();
					for(var i = 0; i<goodsList.length;i++){
						var $goodsdetail = $("<div class='goodsclassify-goodsdetail clearfix'></div>");
						$("<div class='goodsclassify-goodsimg'></div>")
							.append($("<img src="+goodsList[i].img_url+">"))
							.appendTo($goodsdetail);

						var $goodtxt = $("<div class='goodsclassify-goods-txt'></div>");
						$goodtxt.append($("<div class='goods-txt-name'>"+goodsList[i].name+"</div>"))
							.append($("<div class='goods-txt-intro'>"+goodsList[i].message+"</div>"));
						
						var htmlString = "<div class='fl'>"
								+ "<div class='goodsclassify-price fl discount-price'>"
								+ goodsList[i].discount_price
								+ "</div> "
								+ "<span class='orgin-price fl bef-price'> ￥"
								+ goodsList[i].price
								+ "</span>"
								+ "</div> <div class='ri'> <div class='goodsclassify-sales'> 销量："
								+ goodsList[i].sale_number
								+ "</div> </div>";
						$("<div></div>").html(htmlString)
							.appendTo($goodtxt);
						var $awrapper = $("<a href='../../Home/Commodity/goodsinfo/food_id/"+goodsList[i].food_id+"'></a>");
						$goodsdetail.append($goodtxt)
						.appendTo($awrapper);
						$(".body-y").append($awrapper);
					}
				}
				else {
					alert("刷新失败！");
				}	
			},
			error:function(){
				alert("刷新失败！");
			}

		});
	});
});