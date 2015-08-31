$(document).ready(function(){
	
	$("#index-head .img-search").click(function(){
		$("#search-wrapper").animate({left:0});
		$("#common-nav").addClass("none");
		$("#search-input").focus();
	});

	$("#searchgoods-head .glyphicon-circle-arrow-left").click(function(){
		$("#search-wrapper").animate({left:"100%"},180);;
		setTimeout("$('#common-nav').removeClass('none')",250);
	});

	$("#search-input").prev().click(function(){
		var searchkey = $("#search-input").val();

		if(searchkey != ""){
		    record = $.cookie("record");

		    if(record == null) {
		        var record = searchkey;
		        $.cookie("record", record,{ expires: 14 });
		    }
		    else {     
		        var recordList = record.split(",");
		        var newrecord = "";
		        for(var i=0;i<recordList.length;i++){
		            if(recordList[i] != searchkey.trim()){
		                newrecord += recordList[i] + ",";
		            }
		        }
		        newrecord += searchkey.trim();

		        recordList = newrecord.split(",");
		        if(recordList.length > 6){                  
		            newrecord = newrecord.substr(newrecord.indexOf(",")+1);
		        }
		        $.cookie("record", newrecord,{ expires: 14 });    
		    } 
		}

		window.location.href = "/fuwebapp/index.php/Home/Commodity/searchoutcome/key/"+searchkey;
	});

	$("#search-input").focus(function(){

		$("#search-history-container").removeClass("none");
		$("#search-history-list li").remove();
		record = $.cookie("record");
		if(record == null) {
			$("#clear-history-list p").removeClass("none");
			$("#clear-history-list h1").addClass("none");
			return;
		}
		else {
			$("#clear-history-list p").addClass("none");
			$("#clear-history-list h1").removeClass("none");
		}
		var recordList = record.split(",");

		for(var i=recordList.length-1;i>=0;i--) {
			$("#search-history-list ul").append($("<li class='search-history-item'>"+recordList[i]+"</li>"))
		}

		$(".search-history-item").click(function(){
			$("#search-input").val($(this).text());
			window.location.href = "/fuwebapp/index.php/Home/Commodity/searchoutcome/key/"+$(this).text();
		});
	});

	$("#clear-history-list h1").click(function(){

		$("#search-history-list li").remove();
		// $.cookie("record", "", { expires: -1 });
		delCookie("record");
		$("#clear-history-list p").removeClass("none");
		$("#clear-history-list h1").addClass("none"); 
	});

	$(".search-history-item").click(function(){
		$("#search-input").val($(this).text());
		window.location.href = "/fuwebapp/index.php/Home/Commodity/searchoutcome/key/"+$(this).text();
	});
});

function delCookie(name) 
{ 
    var exp = new Date(); 
    exp.setTime(exp.getTime() - 1); 
    var cval=getCookie(name); 
    if(cval!=null) 
        document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
} 

function getCookie(name) 
{ 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg)){
        return unescape(arr[2]); 
 	}
    else {
        return null; 
    }
} 