<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<title>For优选择学校</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		
		<link href="/fuwebapp/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/commonstyle.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style.css" />
	</head>
	<body>
		<div id="selectcampus-head">
			<div class="head-top background-special">
				<span class="fl history-back glyphicon glyphicon-circle-arrow-left"></span>
				<span class="head-title">选择学校</span>
			</div>
		</div>
		<div id="selectcampus-body" class="w">
			<div id="selectcampus-body-search">
				<div>
					<span class="glyphicon glyphicon-search"></span>
					<input type="text" placeholder="请输入您的学校名称 ">	
				</div>	
			</div>
			<div id="city-campus-nav" class="clearfix">
				<div id="city-nav">
					<ul>
						<li><a>上海</a></li>
						<li><a>北京</a></li>
						<li><a>广州</a></li>
						<li><a>武汉</a></li>
						<li><a>成都</a></li>
						<li><a>西安</a></li>
						<li><a>南京</a></li>
						<li><a>长沙</a></li>
						<li><a>郑州</a></li>
						<li><a>沈阳</a></li>
						<li class="active"><a href="">苏州</a></li>
					</ul>
				</div>
				<div id="campus-nav">
					<ul>
						<li><a href="">苏州职业大学北校区 </a></li>
						<li class="active"><a href="">苏州大学独墅湖校区</a></li>
						<li><a>苏州大学</a></li>
						<li><a>武汉</a></li>
						<li><a>成都</a></li>
						<li><a>西安</a></li>
						<li><a>南京</a></li>
						<li><a>长沙</a></li>
						<li><a>郑州</a></li>
						<li><a>沈阳</a></li>
						<li><a>苏州</a></li>
					</ul>
				</div>
			</div>
		</div>

		<!-- <div id="common-nav">
	<div class="row">
	   <div class="col-xs-4  active">
	   		<a href="<?php echo U('Index/index');?>">
	   			<dl>
	   				<dt>
	   					<span class="glyphicon glyphicon-home"></span>
	   				</dt>
	   				<dd>首页</dd>
	   			</dl>
	   		</a> 		
	   </div>
	   <div class="col-xs-4">
	   		<a href="<?php echo U('ShoppingCart/shoppingcart');?>">
		   		<dl>
		   			<dt>
		   				<span class="glyphicon glyphicon-shopping-cart"></span>
		   			</dt>
		   			<dd>购物车</dd>
		   		</dl>
	   		</a>
	   </div>
	    <div class="col-xs-4">
	    	<a href="<?php echo U('Login/homepage');?>">
		   		<dl>
		   			<dt>
		   				<span class="glyphicon glyphicon-user"></span>
		   			</dt>
		   			<dd>个人中心</dd>
		   		</dl>
	   		</a>
	   </div>
	</div>
</div> -->
		
		<script type="text/javascript" src="/fuwebapp/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/fuwebapp/Public/script/selectcampus.js"></script>
		<script src="/fuwebapp/Public/script/common.js"></script>
	</body>
</html>