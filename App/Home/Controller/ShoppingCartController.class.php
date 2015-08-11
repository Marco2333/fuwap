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
			$this->redirect('Home/Login/personHomePage');
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
    	$Orders->D('Orders');
    	$result = $Orders->updateOrderCount();

    	
    }




}







?>