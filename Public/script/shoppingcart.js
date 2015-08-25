$(document).ready(function(){

	calTotalCost();
	$("#select-goods").click(function(){
		if($(this).hasClass("text-subspecial")) {
			 $(".shopcart-goods-list .mask,.shopcart-goods-list input[type='checkbox']").addClass("none");
			 $(this).removeClass("text-subspecial");

			 $(".shopcart-goods-list input[type='checkbox']").prop("checked",true);
			 $("#settle-accounts .glyphicon,#settle-accounts .spliter").addClass("none");
			 $("#settle-accounts-confirm > div.fl").addClass("none");
			 $("#check-button").addClass("w").removeClass("col-8");
			 $("body").css("background","#fafafa");
			 calTotalCost();
		}
		else {
			$(this).addClass("text-subspecial");
			$("#settle-accounts-confirm > div.fl").removeClass("none");
			$("#check-button").addClass("col-8").removeClass("w");
			$(".shopcart-goods-list input[type='checkbox']").prop("checked",false);
			$(".shopcart-goods-list .mask,.shopcart-goods-list input[type='checkbox']").removeClass("none");
			$("#settle-accounts .glyphicon,#settle-accounts .spliter").removeClass("none");
			$("body").css("background","rgb(244,244,244)");
			calTotalCost();
		}
	});
	
	$("#settle-accounts .glyphicon-trash").click(function(){
		var checks = $(".input-locate");
		var $orderIds = "";
		for (i = 0;i < checks.length;i++) {

			if ($(checks[i]).prop("checked")) {
				var order_id = $(checks[i]).nextAll(".order-id-none").val();

				if ($orderIds != "") {
					$orderIds += ",";
					$orderIds += order_id;
				}
				else {
					$orderIds += order_id;
				}
			}
		}

		if ($orderIds != "") {
			$.ajax({
				url:"/fuwebapp/index.php/Home/ShoppingCart/deleteOrders",
				type:"POST",
				data:{
					orderIds:$orderIds
				},
				success:function(data){
					if(data.status==1){
						$(".input-locate:checked").parents(".shopcart-goods-list").remove();
					}
					else {
						alert("删除失败");
					}
				},
				error:function(){
					alert("删除失败");
				}
			});
		}
		else {
			alert("亲~请勾选您想要购买的物品！");
		}
	});

	$("#shoppingcart-body .sub-goods").on("click",function(){
		var $order_count = parseInt($(this).next("input").val())-1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		if($order_count <= 0 ){
			return;
		}
		$.ajax({
	        type:"POST",
	        url:'/fuwebapp/index.php/Home/ShoppingCart/updateOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	if (result['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;
	        		var $div_check_goods = $this.parent().parent().prevAll(".check-goods");
	        		var $is_discount = parseInt($div_check_goods.children(".is-discount-none").val());
	        		calTotalCost();
	        	}
	        	else {
	        		
	        	}
       		}
       	});
	});

	$("#shoppingcart-body .add-goods").on("click",function(){
		var $order_count = parseInt($(this).prev("input").val())+1;
		var $order_id    = $(this).attr("data-orderId");
		var $this        = $(this);

		$.ajax({
	        type:"POST",
	        url:'/fuwebapp/index.php/Home/ShoppingCart/updateOrderCount',
	        data:{order_count:$order_count,order_id:$order_id},
	        success:function(result){
	        	if (result['result'] != 0) {
	        		document.getElementById($order_id).value = $order_count;
	        		var $div_check_goods = $this.parent().parent().prevAll(".check-goods");
	        		var $is_discount = parseInt($div_check_goods.children(".is-discount-none").val());
	        		calTotalCost();
	        	}
	        	else {
	        		// alert('物品增加或减少购买失败，请重试！');
	        	}
       		}
       	});
	});

	$("#shoppingcart-body .input-locate").on("click",function(){
		if (!$("#shoppingcart-body .input-locate").prop("checked")) {
			$("#settle-accounts #check-all").prop("checked",false);
		}
		else {
			var checkBoxs  = $("#shoppingcart-body .input-locate");
			var allChecked = true;

			for (i = 0;i < checkBoxs.length;i++) {
				if (!$(checkBoxs[i]).prop("checked")) {
					allChecked = false;
					break;
				}
			}

			if (!allChecked) {
				$("#settle-accounts #check-all").prop("checked",false);
			}
			else {
				$("#settle-accounts #check-all").prop("checked",true);
			}
		}
		calTotalCost();
	});

	$("#settle-accounts #check-all").on("click",function(){
		if ($("#settle-accounts #check-all").prop("checked")) {
			$("#shoppingcart-body .input-locate").prop("checked",true);
		}
		else {
			$("#shoppingcart-body .input-locate").prop("checked",false);
		}
		calTotalCost();
	});

	$("#check-button").on("click",function(){
		var checks = $(".input-locate");
		var $orderIds = "";
		for (i = 0;i < checks.length;i++) {

			if ($(checks[i]).prop("checked")) {
				var order_id = $(checks[i]).nextAll(".order-id-none").val();

				if ($orderIds != "") {
					$orderIds += ",";
					$orderIds += order_id;
				}
				else {
					$orderIds += order_id;
				}
			}
		}

		if ($orderIds != "") {
			var $href = "/fuwebapp/index.php/Home/ShoppingCart/orderConfirm?orderIds="+$orderIds;
			window.location.href = $href;
		}
		else {
			alert("亲~请勾选您想要购买的物品！");
		}
	});


});

function calTotalCost() {
	var fulldiscountList = $("#full-discount-price li");
	var discountPrice=new Array();
	for(var i=0;i<fulldiscountList.length;i++) {
		discountPrice[i] = $(fulldiscountList[i]).children("span").text()+","+$(fulldiscountList[i]).children("p").text();
	}
	// discountPrice.sort(sortNumber);
	var goodsList = $(".shopcart-goods-list");
	var totalCost = 0;
    var totalCostBef = 0;
    var fullDiscoutCount = 0;

    for(var i=0;i<goodsList.length;i++){
    	var isFulldiscount = $(goodsList[i]).attr("data-fulldiscount");

    	if($(goodsList[i]).children(".check-goods").children(".input-locate").prop("checked")) {
    			
    		var pricePer = parseFloat($(goodsList[i]).find(".discount-price").text().substr(1));
    		var pricePerBef = parseFloat($(goodsList[i]).find(".bef-price").text().substr(1));
    		var coutPer = parseInt($(goodsList[i]).find(".goods-count").val());
    		var sumPer = pricePer*coutPer;
    		var sumPerBef = pricePerBef*coutPer;

    		if(isFulldiscount) {
    			fullDiscoutCount += sumPer;
    		}
    		
    		totalCost += sumPer;
    		totalCostBef += sumPerBef;
    	}
    }

    var subprice = 0;
    for(var i=0;i<discountPrice.length;i++) {
    	if(fullDiscoutCount >= parseFloat(discountPrice[i].split(",")[0])) {
    		subprice = parseFloat(discountPrice[i].split(",")[1]);
    		break;
    	}
    }

    totalCost -= subprice;
    save = totalCostBef - totalCost;

    $("#Price").text("合计:￥"+totalCost.toFixed(2));
    $("#dPrice").text("￥"+totalCostBef.toFixed(2));
    $("#save").text("(已节省"+save.toFixed(2)+"元)");
}

function settleAccounts(){
	var checkedList = $(".input-locate");
	var $Price  = 0;
	var $dPrice = 0;

	for (i = 0;i < checkedList.length;i++) {

		if ($(checkedList[i]).prop("checked")) {		
			var $order_count    = parseInt($(checkedList[i]).nextAll(".order-count-none").val());
			var $price          = parseFloat($(checkedList[i]).nextAll(".price-none").val());
			var $discount_price = parseFloat($(checkedList[i]).nextAll(".discount-price-none").val());
			var $is_discount    = parseInt($(checkedList[i]).nextAll(".is-discount-none").val());

			$Price += $price * $order_count;

			if ($is_discount != 0) {
				$dPrice += $discount_price * $order_count;
			}
			else {
				$dPrice += $price * $order_count;
			}
		}
	}

	var $save = $Price - $dPrice;
	document.getElementById("Price").innerHTML  = "合计:￥"+$dPrice.toFixed(2)+"元";
	document.getElementById("dPrice").innerHTML = "原价:￥"+$Price.toFixed(2)+"元";
	document.getElementById("save").innerHTML   = "(已节省"+$save.toFixed(2)+"元)";
}

// function sortNumber(a, b)
// {
// 	return -(parseFloat(a.split(",")[0]) - parseFloat(b.split(",")[0]));
// }