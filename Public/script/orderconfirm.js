$(document).ready(function(){
				pricecalculate();
				/*=================计算价格的函数=======================*/
				function pricecalculate(){
					var ocnprice=$("#ocnprice").text();
					var length=$("#orderconfirm-goods>li").length;
					var sum=0;
					var orginsum=0;
					for(var i=0;i<length;i++)
					{
						var count = $("#orderconfirm-goods li input.goods-count")[i].value;  
				        var price = $("#orderconfirm-goods li input.ocnprice-item")[i].value; 
				        var orginprice=$("#orderconfirm-goods li input.ocoprice-item")[i].value;       
				        sum+=parseInt(price)*count;
				        orginsum+=parseInt( orginprice )*count;
					}
					$("#ocnprice").text(sum);
					$("#ocoprice").text(orginsum);
					$("#ocsavemoney").text(orginsum-sum);
				}
				/*=================增减商品=======================*/
				$(".orderconfirm-goods-txt a.sub-goods").click(function(){
		
					  var v=$(this).next("input").val();
				      if(parseInt(v)!=0){
				          $(this).next("input").val(parseInt(v)-1);
				       	$(this).next("input").attr('value',parseInt(v)-1);
				       	pricecalculate();
				      }    
				      
				      /*caltotalCost();*/
				  });
				
				  $(".orderconfirm-goods-txt a.add-goods").click(function(){
			      var v=$(this).prev("input").val();
				      $(this).prev("input").val(parseInt(v)+1); 
				      $(this).prev("input").attr('value',parseInt(v)+1); 
				     pricecalculate();
				     
				      /*caltotalCost();*/
				  });
});

