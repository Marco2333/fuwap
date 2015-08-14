<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<title>For优个人中心</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		
		<link href="/fuwebapp/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/commonstyle.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style.css" />

	</head>
	<body>
		<div id="homepage-head">
			<div class="head-top">
				<span class="fl history-back glyphicon glyphicon-circle-arrow-left"></span>
				<span class="head-title">个人中心</span>
			</div>
			<div class="head-bottom">
				<dl>
					<dt>
						<img src="<?php echo ($info["img_url"]); ?>" alt="">
					</dt>

					<dd>
					<?php if($info['nickname'] != '点击登陆'): echo ($info["nickname"]); ?>
					<?php else: ?><a href="<?php echo U('Login/login');?>">点击登陆</a><?php endif; ?>
					</dd>
				</dl>
			</div>
		</div>
		<div id="homepage-nav">
			<div class="row">
				<?php if($info['nickname'] != '点击登陆'): ?><a href="<?php echo U('Person/addressmanage');?>">
				<?php else: ?><a href="<?php echo U('Login/login');?>"><?php endif; ?>
				
				   <div class="col-xs-3">
				   		<dl>
				   			<dt>
				   				<img src="/fuwebapp/Public/img/icon/locationmanage.png" alt="">
				   			</dt>
				   			<dd>地址管理</dd>
				   		</dl>
				   </div>
			    </a>
			    <?php if($info['nickname'] != '点击登陆'): ?><a href="<?php echo U('OrderManage/orderManage',array('status'=>1));?>">
			    <?php else: ?><a href="<?php echo U('Login/login');?>"><?php endif; ?>
				   <div class="col-xs-3">
				   		<dl>
				   			<dt>
				   				<img src="/fuwebapp/Public/img/icon/ordermanage.png" alt="">
				   			</dt>
				   			<dd>订单管理</dd>
				   		</dl>
				   </div>
			   	</a>
			   	<?php if($info['nickname'] != '点击登陆'): ?><a href="<?php echo U('Person/userinfo');?>">
			    <?php else: ?><a href="<?php echo U('Login/login');?>"><?php endif; ?>
				   <div class="col-xs-3">
				   		<dl>
				   			<dt>
				   				<img src="/fuwebapp/Public/img/icon/userinfo.png" alt="">
				   			</dt>
				   			<dd>个人信息</dd>
				   		</dl>
				   </div>
			   </a>
			   <?php if($info['nickname'] != '点击登陆'): ?><a href="<?php echo U('Person/settings');?>">
			    <?php else: ?><a href="<?php echo U('Login/login');?>"><?php endif; ?>
				    <div class="col-xs-3">
				   		<dl>
				   			<dt>
				   				<img src="/fuwebapp/Public/img/icon/settings.png" alt="">
				   			</dt>
				   			<dd>设置</dd>
				   		</dl>
				   </div>
			   </a>
			</div>
		</div>

		<div id="common-nav">
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
	   		<a href="<?php echo U('ShoppingCart/shoppingcart');?>">
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
</div>

		<script type="text/javascript" src="/fuwebapp/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/fuwebapp/Public/bootstrap/js/bootstrap.min.js"></script>
		<script src="/fuwebapp/Public/script/common.js" type="text/javascript"></script>
	</body>
</html>