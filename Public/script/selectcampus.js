$(document).ready(function(){
	$("#city-campus-nav li").click(function(){
		$(this).siblings().removeClass("active");
		$(this).addClass("active");
	});
});