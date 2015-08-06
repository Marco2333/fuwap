$(document).ready(function(){
	$("#index-head .glyphicon-search").click(function(){
		$("#search-wrapper").slideDown(500);
		$("#common-nav").addClass("none");
		$("#search-input").focus();
	});

	$("#searchgoods-head .glyphicon-circle-arrow-left").click(function(){
		$("#search-wrapper").slideUp(500);
		setTimeout("$('#common-nav').removeClass('none')",250);
		// $("#common-nav").removeClass("none");
	});

});