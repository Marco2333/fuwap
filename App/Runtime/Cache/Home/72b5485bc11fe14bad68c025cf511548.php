<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
	<head>
		<title>For优个人中心</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<link rel="icon" href="/fuwebapp/favicon.ico" type="image/x-icon" />
		<link href="/fuwebapp/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/commonstyle.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style.css" />

	</head>
	<body>
		<div id="userinfo-head" class="pos-relative">
			<div class="back-image">
				<img class="vertical-center" src="<?php echo ($info["img_url"]); ?>" alt="">
			</div>
			<div class="head-top bground-special">
				<span class="fl z-99 pos-relative history-back glyphicon glyphicon-circle-arrow-left"></span>
			</div>
			<div class="head-bottom">
				<dl>
					<dt>
						<img src="<?php echo ($info["img_url"]); ?>" alt="">
					</dt>
					<dd>
						<?php echo ($info["nickname"]); ?>
					</dd>
				</dl>
			</div>
		</div>
		<div id="userinfo-body">
		   <form action="">
		   		<a href="<?php echo U('/Home/Person/cname');?>">
			   		<div class="user-info-input">
			   			<span class="fl">昵称</span>
						<img class="forward-arrow fr"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			<span class="fr">
			   				<?php echo ($info["nickname"]); ?>			
			   			</span>
			   		</div>
			   	</a>
			   	<a class="revise-sex">
			   		<div class="user-info-input">
			   			<span class="fl">性别</span>
			   			<span class="fr">
			   			<?php
 if ($info['sex'] != 0) { echo "女"; } else { echo "男"; } ?>
			   			<img class="forward-arrow"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt=""> 			
			   			</span>
			   		<input type="text" class="sex-none none" value="<?php echo ($info["sex"]); ?>"/>
			   		</div>
			   	</a>
		   		<a href="<?php echo U('/Home/Person/cacademy');?>">
		   			<div class="user-info-input">
			   			<span class="fl">学院</span>
			   			<img class="forward-arrow fr"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			<span class="fr">
			   					<?php echo ($info["academy"]); ?> 	
			   			</span>
		   			</div>
		   		</a>
		   		<a href="<?php echo U('/Home/Person/cqq');?>">
			   		<div class="user-info-input">
			   			<span class="fl">QQ号</span>
			   			<img class="forward-arrow fr"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			<span class="fr">
			   				<?php echo ($info["qq"]); ?>	
			   			</span>
			   		</div>
			   	</a>
			   	<a href="<?php echo U('/Home/Person/cwechat');?>">
			   		<div class="user-info-input">
			   			<span class="fl">微信号</span>
			   			<img class="forward-arrow fr"  src="/fuwebapp/Public/img/icon/forwardarrow.jpg" alt="">
			   			<span class="fr">
			   				<?php echo ($info["weixin"]); ?>
			   			</span>
			   		</div>
			   	</a>
		   </form>
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
</div>

		<script type="text/javascript" src="/fuwebapp/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/fuwebapp/Public/bootstrap/js/bootstrap.min.js"></script>
		<script src="/fuwebapp/Public/script/common.js" type="text/javascript"></script>
		<script type="text/javascript" src="/fuwebapp/Public/script/userinfo.js"></script>
	</body>
</html>