$(document).ready(function(){
	var activeele = $(".nav-top ul").attr("data-active");
	$(".nav-top li").eq(activeele).addClass("active");

	// $(".nav-top li").click(function(){
	// 	$(this).siblings().removeClass("active");
	// 	$(this).addClass("active");
	// });
});