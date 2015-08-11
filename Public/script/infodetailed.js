$(function(){
	orderNumber();
});
function orderNumber(){
	$("#ordernumber").val(1);
	$(".righta").click(function(){
		var $number=$("#ordernumber").val();
		if($number == 1){
			
		}else{
			$number=parseInt($number) - 1;
			$("#ordernumber").val($number)
		}
	});
	$(".lefta").click(function(){
		var $number=$("#ordernumber").val();
		$number=parseInt($number) + 1;
		$("#ordernumber").val($number)
	});
}
