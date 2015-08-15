$(document).ready(function(){
	$(".moveleft").click(function(){
		var lef=$(".goodsclassify-header ul").css("left");
		if(parseInt(lef)<0){
		$(".goodsclassify-header ul").css( "left", function(index, value) {return parseFloat(value)+1*$(".goodsclassify-header li").width();});
		}
	});

	$(".moveright").click(function(){
		var lef=$(".goodsclassify-header ul").css("left");
		var cou=$("#classifynavi>li").length;
		var wid=(cou-4)*$(".goodsclassify-header li").width();
		if(-parseInt(lef)<parseInt(wid)){
		$(".goodsclassify-header ul").css("left", function(index, value) {return parseFloat(value)-1*$(".goodsclassify-header li").width();});
		}
	});
	
	$(".goodsclassify-header").on("swiperight",function(){
	  	var lef=$(".goodsclassify-header ul").css("left");
  			if(parseInt(lef)<0){
  			$(".goodsclassify-header ul").css( "left", function(index, value) {return parseFloat(value)+1*$(".goodsclassify-header li").width();});
	  	}
	});

	$(".goodsclassify-header").on("swipeleft",function(){
	  	var lef=$(".goodsclassify-header ul").css("left");
  		var cou=$("#classifynavi>li").length;
  		var wid=(cou-4)*$(".goodsclassify-header li").width();
	  	if(-parseInt(lef)<parseInt(wid)){
	  		$(".goodsclassify-header ul").css("left", function(index, value) {return parseFloat(value)-1*$(".goodsclassify-header li").width();});
	  	}
	});

	$("#classifynavi li").click(function(){

		$(this).siblings().removeClass("active");
		$(this).addClass("active");
		$.ajax({
			type:"POST",
			url:"../../Home/Commodity/getGatGoods",
			data:{
				categoryId:$(this).attr("data-id")
			},
			success:function(data) {
				console.log(data);
				if(data.result != 0){
					
					var goodsList = data['goodsList'];
					console.log(goodsList);
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
						$goodsdetail.append($goodtxt).appendTo($(".body-y"));
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
		
})
