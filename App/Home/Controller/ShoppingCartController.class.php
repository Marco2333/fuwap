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
			$this->redirect('Home/Login/homePage');
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

        // dump($goodsInfo);
        if ($defaultAddress != false && $goodsInfo != false && $result !== false) {
            $this->assign('defaultAddress',$defaultAddress)
                 ->assign('goodsInfo',$goodsInfo)
                 ->assign('price',$price)
                 ->assign('together_id',$together_id);
            $this->display('orderconfirm');
        }
        else {
            $this->redirect('Home/ShoppingCart/ShoppingCart');
        }
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

}







?>