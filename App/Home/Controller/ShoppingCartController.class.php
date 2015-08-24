<?php 

namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=UTF-8');

/**
 * 购物车管理控制器
 * 
 * @package     app
 * @subpackage  core
 * @category    controller
 * @author      Tony<879833043@qq.com>
 *
 */ 


class ShoppingCartController extends Controller{

	public function _initialize(){
		if (!isset($_SESSION['username'])) {
			$this->redirect('Home/Login/login');
		}
	}

	public function index(){
        $this->ShoppingCart();
    }

    public function ShoppingCart(){
    	$Orders = D('Orders');
    	$cart   = $Orders->getShoppingCart();

    	if (count($cart) != 0) {
    		$this->assign('isEmpty','0')
    			 ->assign('cart',$cart);
    	}
    	else {
    		$this->assign('isEmpty','1');
    	}
    	
    	$this->display('shoppingcart');
    }

    public function updateOrderCount(){
    	$Orders = D('Orders');

        $order_id    = I('order_id');
        $order_count = I('order_count');
    	$result      = $Orders->updateOrderCount($order_id,$order_count);

    	if ($result !== false) {
            $res['result'] = 1;
            $this->ajaxReturn($res);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }

    public function orderConfirm(){
        $Receiver = D('Receiver');
        $Orders   = D('Orders');

        $orderIds = I('orderIds');
        $defaultAddress = $Receiver->getDefaultAddress();
        $goodsInfo      = $Orders->getGoodsInfo($orderIds);
        $price          = $Orders->settleAccounts($goodsInfo);
        $together_id    = $Orders->setTogether($orderIds);

        $Receiver = D('Receiver');
        $address = $Receiver->getAddressList();   //获取地址

        if ($defaultAddress != false && $goodsInfo != false && $result !== false) {
            $this->assign('defaultAddress',$defaultAddress)
                 ->assign('goodsInfo',$goodsInfo)
                 ->assign('price',$price)
                 ->assign('orderIds',$orderIds)
                 ->assign('together_id',$together_id)
                 ->assign('address',$address);
            $this->display('orderconfirm');
        }
        else {
            $this->redirect('Home/ShoppingCart/ShoppingCart');
        }
    }

    public function deleteOrders(){
         $phone = $_SESSION['username'];
         $orderIds = I('orderIds');
         $out = D('Orders')->deleteOrders($orderIds,$phone);

         if($out === 1) {
            $res['status'] = 1;
         }   
         else {
            $res['status'] = 0;
         }
         $this->ajaxReturn($res);
    }

    public function updateSettleAccounts(){
        $Orders = D('Orders');

        $order_id    = I('order_id');
        $order_count = I('order_count');
        $result      = $Orders->updateOrderCount($order_id,$order_count);
        $goodInfo    = $Orders->getGoodsInfo($order_id);
        $priceInfo   = $Orders->settleAccounts($goodInfo);

        if ($result !== false && $priceInfo !== false) {
            $priceInfo['result'] = 1;
            $this->ajaxReturn($priceInfo);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }

    public function settleAccounts(){
        $Orders = D('Orders');

        $together_id = I('together_id');
        $orderIds    = $Orders->getOrderIds($together_id);
        $goodsInfo   = $Orders->getGoodsInfo($orderIds);
        $price       = $Orders->settleAccounts($goodsInfo);

        if ($orderIds !== false && $goodsInfo !== false && $price !== false) {
            $price['result'] = 1;
            $this->ajaxReturn($price);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }


    public function getCloseTime() {
        if(!isset($_SESSION['campusId'])) {
            $campusId = 1;
        }
        else {
            $campusId = $_SESSION['campusId'];
        }
        
        $close_time = D('Campus')->getCloseTime($campusId);
        if($close_time === false){
            $res['status'] = 0;
        }
        else if($close_time === null) {
            $res['status'] = 1;
            $res['colseTime'] = "24:00";
        }
        else {
            $res['status'] = 1;
            $res['colseTime'] = $close_time;
        }
        $this->ajaxReturn($res);
    }

    public function payAtOnce(/*$rank,*/$orderIds,$channel){
        $order=D('Orders');
        $phone=session('username');
        $campusId=session('campus_id');
        if($campusId==null){
            $campusId=1;
        }
        $togetherId=$order->setTogetherId($orderIds,$phone);
        $totalPrice=$order->calculatePriceByOrderIds($togetherId,$campusId);        //获取总价
        
        if($togetherId!=null){
            $charge=D('Users')->pay($channel,$totalPrice,$togetherId);
            echo $charge;
        }else{
            echo "null";
        }
     
    }

}







?>