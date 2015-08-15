<?php

namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class CommodityController extends Controller {

	public function _initialize(){
		if (!isset($_SESSION['username'])) {
			$this->redirect('Home/Login/homePage');
		}
	}

    public function index(){
        $this->display();
    }

    public function comment(){
    	$Orders = D('Orders');

    	$orderIds = I('orderIds');
        $goodsInfo   = $Orders->getGoodsInfo($orderIds);
        $ordersList  = $Orders->orderIdsSplit($orderIds);

        for ($i = 0;$i < count($goodsInfo);$i++) {
        	$goodsInfo[$i]['order_id'] = $ordersList[$i];
        }

        if ($goodsInfo !== false) {
        	$this->assign('goodsInfo',$goodsInfo);
    		$this->display('comment');
    	}
    	else {
    		$this->redirect('Home/OrderManage/orderManage',array('status'=>'4'));
    	}
    }

    public function postComment(){
    	$FoodComment = D('FoodComment');
    	$Orders      = D('Orders');

    	$food_id     = I('food_id');
    	$comment     = I('comment');
    	$grade       = I('grade');
    	$is_hidden   = I('is_hidden');
    	$order_id    = I('order_id');
    	$together_id = I('together_id');

    	$result    = $FoodComment->postComment($food_id,$comment,$grade,$is_hidden,$order_id);
    	$setStatus = $Orders->setStatus($together_id);

    	if ($result !== false) {
			$res['result'] = 1;
			$this->ajaxReturn($res);
		}
		else {
			$res['result'] = 0;
			$this->ajaxReturn($res);
		}
    }
	
}