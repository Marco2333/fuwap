<?php

namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset:UTF-8');

/**
 * 资料管理控制器
 * 
 * @package     app
 * @subpackage  core
 * @category    controller
 * @author      Tony<879833043@qq.com>
 *
 */ 

class OrderManageController extends Controller{

	public function _initialize(){
		if (!isset($_SESSION['username'])) {
			$this->redirect('Home/Login/login');
		}
	}

	public function index(){
		
	}
    
    /**
     * 订单管理
     * @return [type] [description]
     */
	public function orderManage(){

		$campusId=session('campusID');
        if($campusId==null){
            $campusId=1;
        }
		$Orders = D('Orders');

		$status 		= I('status');
		$togetherIds 	= $Orders->getTogetherIds($status);
		
		//dump($togetherIds);
		for ($i = 0;$i < count($togetherIds);$i++) {
			$orderIds      = $Orders->getOrderIds($togetherIds[$i]['together_id']);
            //dump($orderIds);
			if($orderIds != null) {
				$goodsInfo[$i] = $Orders->getGoodsInfo($orderIds);
				$price[$i]     = $Orders->settleAccounts($goodsInfo[$i],$campusId);


				for ($j = 0;$j < count($goodsInfo[$i]);$j++) {
					$goodsInfo[$i][0]['goodsCount'] += $goodsInfo[$i][$j]['order_count'];
				}
				
				$goodsInfo[$i][0]['totaldPrice'] = $price[$i]['dPrice'];
				$goodsInfo[$i][0]['totalPrice']  = $price[$i]['Price'];
				$goodsInfo[$i][0]['totalSave']   = $price[$i]['save'];
			}
			
		}

		if ($togetherIds !== false) {
			$this->assign('status',$status)
				 ->assign('goodsInfo',$goodsInfo)
				 ->assign('price',$price);

			$this->display('ordermanage');
		}
		else {
			$this->redirect('Home/Login/login');
		}
	}

    /**
     * 删除订单
     * @return [type] [description]
     */
	public function deleteOrCancel(){
		$Orders = D('Orders');

		$together_id = I('together_id');
		$result = $Orders->deleteOrCancel($together_id);

		if ($result !== false) {
			$res['result'] = 1;
			$this->ajaxReturn($res);
		}
		else {
			$res['result'] = 0;
			$this->ajaxReturn($res);
		}
	}

     /**
     * 取消订单并退款
     * @return [type] [description]
     */
	public function refundOrder(){
		$Orders = D('Orders');

		$together_id = I('together_id');
		$result = $Orders->refundOrder($together_id);

		if ($result) {
			$res['result'] = 1;
			$this->ajaxReturn($res);			
		}
		else {	
			$res['result'] = 0;
			$this->ajaxReturn($res);
		}
	}

    /**
     * 确定订单
     * @return [type] [description]
     */
	public function confirmOrder(){
		$Orders = D('Orders');

		$together_id = I('together_id');
		$result = $Orders->confirmOrder($together_id);

		if ($result !== false) {
			$res['result'] = 1;
			$this->ajaxReturn($res);
		}
		else {
			$res['result'] = 0;
			$this->ajaxReturn($res);
		}
	}

    /**
     * 评论订单
     * @return [type] [description]
     */
	public function commentOrder(){
		$Orders = D('Orders');

		$together_id = I('together_id');
		$orderIds    = $Orders->getOrderIds($together_id,'isNotRemarked');

		if ($orderIds !== false) {
			$res['orderIds'] = $orderIds;
			$res['result']   = 1;
			$this->ajaxReturn($res);
		}
		else {
			$res['result'] = 0;
			$this->ajaxReturn($res);
		}
	}

}





?>