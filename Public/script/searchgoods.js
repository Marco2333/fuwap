$(document).ready(function(){
	 
	 $("#search-input,#search-history-container").focus(function(){
	 	  // $(".searchgoods-search span.glyphicon-search").css("width","8%");
	 	  // $(".searchgoods-search input").css("width","88%"); 	  
	 	  record = $.cookie("record");
	 	  if(record == null) {
	 	  	  return;
	 	  }
	 	  var recordList = record.split(",");
	 	  $(".search-history-item").remove();
          for(var i = recordList.length-1; i >= 0; i--){
          	  $("<li class='search-history-item'></li>")
          	   .append($("<a>"+recordList[i]+"</a>"))
          	   .appendTo($("#search-history-list ul"));
          } 
          $("#search-history-container li a").click(function(){
          	  $("#search-input").val($(this).text());
          });
          $("#search-history-container").slideDown(250);
	 });

	 $("#search-input").blur(function(){
	 	  // $(".searchgoods-search span.glyphicon-search").css("width","42%");
	 	  // $(".searchgoods-search input").css("width","55%");
	 	  $("#search-history-container").slideUp(250);
	 });

	 $("#search-history-container li a").click(function(){
	 	  $("#search-input").val($(this).text());
	 });

	 $("#clear-history-list").click(function(){
	 	  $.cookie("record", "",{ expires: -1 });  
	 });

	 $(".searchgoods-search span.glyphicon-search").on('click',function(){
	     var search = $("#search-input").val();
	     if(search != ""){
	         record = $.cookie("record");

	         if(record == null) {
	             var record = search;
	             $.cookie("record", record,{ expires: 14 });
	         }
	         else {     
	             var recordList = record.split(",");
	             var newrecord = "";
	             for(var i=0;i<recordList.length;i++){
	                 if(recordList[i] != search.trim()){
	                     newrecord += recordList[i] + ",";
	                 }
	             }
	             newrecord += search.trim();
	             recordList = newrecord.split(",");
	             if(recordList.length > 5){                  
	                 newrecord = newrecord.substr(newrecord.indexOf(",")+1);
	             }
	             $.cookie("record", newrecord,{ expires: 14});    
	         } 
	     }
	     window.location.href="/foru/index.php/Home/Index/goodslist?search="+search;
	 });

});