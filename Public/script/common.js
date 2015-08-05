$(document).ready(function(){
	$(".history-back").click(function(){
		window.history.go(-1);
	});
	// $("input[type='text'],input[type='password']").focus(function(){
	// 	$("#common-nav").addClass("none");
	// });
	// $("input[type='text'],input[type='password']").blur(function(){
	// 	$("#common-nav").removeClass("none");
	// });
});

String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}
