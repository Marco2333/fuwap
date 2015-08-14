$(document).ready(function(){
	var activeele = $(".nav-top ul").attr("data-active");
	$(".nav-top li").eq(parseInt(activeele)-1).addClass("active");

	// $(".nav-top li").click(function(){
	// 	$(this).siblings().removeClass("active");
	// 	$(this).addClass("active");
	// });
});