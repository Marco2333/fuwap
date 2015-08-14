<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>For优 商品分类</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1" />	
		<link href="/fuwebapp/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/commonstyle.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style.css" />
		<link type="text/css" rel="stylesheet" href="/fuwebapp/Public/css/style-y.css" />
		<style>
			body{
				background-color: #FAFAFA;
			}
		</style>
	</head>
	<body>
		<div class="goodsclassify-head w" id="gch">
			<span class="glyphicon glyphicon-circle-arrow-left fl history-back"></span>
			<span>分类</span>
		</div><!--register-head-->
		
		<div class="goodsclassify-header w">
			<a class="move moveleft">
				&lt;
			</a>
			    <div class="goodsclassify-slide">
					<ul id="classifynavi">
						<?php if(is_array($category)): foreach($category as $key=>$vo): if($key == 0): ?><li class="active" data-id="<?php echo ($vo["category"]); ?>">
						 	<?php else: ?><li><?php endif; ?>				     
					     		<?php echo ($vo["category"]); ?>
					     	</li><?php endforeach; endif; ?>		
					</ul>
				</div>
			<a class="move moveright"  >&gt;</a>
		</div>
			
		<div class="body-y">	
			<!--<div class="goodsclassify-item w">-->

			<?php if(is_array($goodlist)): foreach($goodlist as $key=>$vi): ?><div class="goodsclassify-goodsdetail clearfix">
					<div class="goodsclassify-goodsimg">
						<img src="<?php echo ($vi["img_url"]); ?>" />
					</div>

					<div class="goodsclassify-goods-txt">
						<div> 
							<div class="goods-txt-name">
								<?php echo ($vi["name"]); ?>
							</div>
							<div class=" goods-txt-intro">
								<?php echo ($vi["message"]); ?>
							</div>
						</div>
						<div>
							<div class="fl">
								<div class="goodsclassify-price fl discount-price">
									<?php echo ($vi["discount_price"]); ?>
								</div> 
								<span class="orgin-price fl bef-price"> 	<?php echo ($vi["price"]); ?>
								</span>
							</div>
							<div class="ri">
								<div class="goodsclassify-sales">	
									销量：<?php echo ($vi["sale_number"]); ?>
								</div>
							</div>
						</div>
					</div>
				</div><?php endforeach; endif; ?>		
		</div>	
		
		<div id="common-nav">
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
</div>
		
		<script type="text/javascript" src="/fuwebapp/Public/script/plugins/jquery-1.11.2.js"></script>
		<script src="/fuwebapp/Public/script/common.js"></script>
		<script src="/fuwebapp/Public/script/goodsclassify.js"></script>
	</body>
</html>