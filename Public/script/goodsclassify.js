$(document).ready(function(){
	$(".moveleft").click(function(){
		var lef=$(".goodsclassify-header ul").css("left");
		if(parseInt(lef)<0){
		$(".goodsclassify-header ul").css( "left", function(index, value) {return parseFloat(value)+1*$(".goodsclassify-header li").width();});
		}
	})
	$(".moveright").click(function(){
		var lef=$(".goodsclassify-header ul").css("left");
		var cou=$("#classifynavi>li").length;
		var wid=(cou-4)*$(".goodsclassify-header li").width();
		if(-parseInt(lef)<parseInt(wid)){
		$(".goodsclassify-header ul").css("left", function(index, value) {return parseFloat(value)-1*$(".goodsclassify-header li").width();});
		}
	})
	
	$("#classifynavi li").click(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	});
		
})
