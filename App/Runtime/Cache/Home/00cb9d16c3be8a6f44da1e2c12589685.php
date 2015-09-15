<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<title>For设置</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<link rel="icon" href="/fuwebapp/favicon.ico" type="image/x-icon" />
		<link href="/fuwebapp/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/commonstyle.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style.css" />
	</head>
	<body>
		<div class="head-top">
			<span class="fl history-back glyphicon glyphicon-circle-arrow-left text-special"></span>
			<span class="head-title">设置</span>
		</div>
		<div id="settings-body">
		   <form action="">
		   		<div id="call-service" class="user-info-input">
		   			<span class="fl">
		   				<a href="tel:<?php echo ($telphone); ?>">联系客服</a>
		   			</span>
		   		</div>
		   		<a href="<?php echo U('Person/aboutforu');?>">
			   		<div class="user-info-input">
			   			<span class="fl">关于我们</span>
			   			<span class="fr">
							<img class="forward-arrow"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			</span>
			   		</div>
			   	</a>	
		   		<a href="<?php echo U('Person/changepword');?>">
			   		<div class="user-info-input">
			   			<span class="fl">修改密码</span>
			   			<span class="fr">
			   				<img class="forward-arrow"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			</span>
			   		</div>
			   	</a>
			   	<a href="<?php echo U('Login/logout');?>">
		   			<input type="button" id="quitlog-button" value="退出登陆">
		   		</a>
		   </form>
		</div>
		
		<!-- <div id="common-nav">
	<div class="row">
	   <div class="col-xs-4">
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
	   		<a href="<?php echo U('Shoppingcart/shoppingCart');?>">
		   		<dl>
		   			<dt>
		   				<span class="glyphicon glyphicon-shopping-cart"></span>
		   			</dt>
		   			<dd>购物车</dd>
		   		</dl>
	   		</a>
	   </div>
	    <div class="col-xs-4 active">
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
		<script src="/fuwebapp/Public/bootstrap/js/bootstrap.min.js"></script>
		<script src="/fuwebapp/Public/script/common.js"></script>
	</body>
</html>