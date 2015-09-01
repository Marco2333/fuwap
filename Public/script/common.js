$(document).ready(function(){
	$(".history-back").click(function(){
		window.history.go(-1);
	});
});

String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, '');
}
