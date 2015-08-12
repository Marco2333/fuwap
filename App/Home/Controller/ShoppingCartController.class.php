<?php 

namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=UTF-8");

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
    	$price  = $Orders->settleAccounts($cart);

    	if (count($cart) != 0) {
    		$this->assign('isEmpty','0')
    			 ->assign('cart',$cart)
    			 ->assign('price',$price);
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
        echo I('orderIds');
    }


}







?>