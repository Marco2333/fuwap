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

class ShoppingcartController extends Controller{

	public function _initialize(){
		if (!isset($_SESSION['username'])) {
			$this->redirect('Home/Login/login');
		}
	}

	public function index(){
        $this->Shoppingcart();
    }

    public function Shoppingcart(){
        $campusId = $_SESSION['campusId'];
        if($campusId == null){
            $campusId = 1;
        }
    	$Orders = D('Orders');
    	$cart   = $Orders->getShoppingcart();

       
        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campusId); 

    	if (count($cart) != 0) {
    		$this->assign('isEmpty','0')
                 ->assign('preferential',$preferential)
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
        $campusId = $_SESSION['campusId'];
        if($campusId == null){
            $campusId = 1;
        }

        $phone=$_SESSION['username'];

        $Receiver = D('Receiver');
        $Orders   = D('Orders');
        $Preferential = D('Preferential');
        $orderIds = I('orderIds');

        $defaultAddress = $Receiver->getDefaultAddress();              //获取默认地址
        $goodsInfo      = $Orders->getGoodsInfo($orderIds);
        $price          = $Orders->settleAccounts($goodsInfo,$campusId);
        $together_id    = $Orders->setTogether($orderIds,$phone);
        $preferential   = $Preferential->getPreferentialList($campusId); 
        $Receiver = D('Receiver');
        $address = $Receiver->getAddressList();   //获取地址

        if($defaultAddress == false) {
            $this->redirect('Home/Person/addressManage');
        }
        else if ($goodsInfo != false && $result !== false) {
            $this->assign('defaultAddress',$defaultAddress)
                 ->assign('goodsInfo',$goodsInfo)
                 ->assign('price',$price)
                 ->assign('orderIds',$orderIds)
                 ->assign('together_id',$together_id)
                 ->assign('preferential',$preferential)
                 ->assign('address',$address);
            $this->display('orderconfirm');
        }
        else {
            $this->redirect('Home/Shoppingcart/Shoppingcart');
        }
    }

    /**
     * 删除订单
     * @return [type] [description]
     */
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

    /**
     * 重新设置订单数目
     * @return [type] [description]
     */
    public function updateSettleAccounts(){

        $campusId = $_SESSION['campusId'];
        if($campusId == null){
            $campusId = 1;
        }

        $Orders = D('Orders');

        $order_id    = I('order_id');
        $order_count = I('order_count');
        $together_id = I('together_id');
        $result      = $Orders->updateOrderCount($order_id,$order_count);
        
        $orderIds    = $Orders->getOrderIds($together_id);
        $goodsInfo   = $Orders->getGoodsInfo($orderIds);
        $price       = $Orders->settleAccounts($goodsInfo,$campusId);

        
        if ($orderIds !== false && $goodsInfo !== false && $price !== false) {
            $price['result'] = 1;
            $this->ajaxReturn($price);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }

        if ($result !== false && $priceInfo !== false) {
            $priceInfo['result'] = 1;
            $this->ajaxReturn($priceInfo);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }

    /**
     * 
     * @return [type] [description]
     */
    public function settleAccounts(){

        $campusId = $_SESSION['campusId'];
        if($campusId == null){
            $campusId = 1;
        }

        $Orders = D('Orders');

        $together_id = I('together_id');
        $orderIds    = $Orders->getOrderIds($together_id,$campusId);

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

    /**
     * 获取关闭时间
     * @return 
     */
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

    /**
     * 立即支付
     * @param  [type] $rank     [description]
     * @param  [type] $orderIds [description]
     * @param  [type] $channel  [description]
     * @return [type]           [description]
     */
    public function payAtOnce($rank,$orderIds,$channel){
        $order=D('Orders');
        $phone=session('username');
        $reserveTime=I('reserveTime');
        $message=I('message');

        if(!isset($_SESSION['campusId'])) {
            $campusId = 1;
        }else {
            $campusId = $_SESSION['campusId'];
        }
        
        $orderIdSingle=split(",", $orderIds);
        
        $where['order_id']=$orderIdSingle[0];
        $where['phone']=$_SESSION['username'];
        $ifHasPaid=M('orders')->where($where)->find();
        if($ifHasPaid['status']!=0&&$ifHasPaid['status']!=1){           //确认这笔订单是否已经支付过
            $res['status'] = 3;
            $this->ajaxReturn($res);
            return;
        }
        $togetherId=$order->setTogetherId($orderIds,$phone);
        $totalPrice=$order->calculatePriceByOrderIds($togetherId,$campusId);        //获取总价

        $flag=$order->updateOrder($togetherId,$phone,$rank,$reserveTime,$message,$totalPrice);  //$togetherId,$phone,$rank,$reserveTime,$message,$totalPrice
       
        if($togetherId != null&&$flag!=0){

            $out = $this->checkLegal($togetherId,$rank,$phone);

            if($out==0) {
                $res['status'] = 0;
                $this->ajaxReturn($res);
            }
            else if($out==1) {
                $res['status'] = 1;
                $this->ajaxReturn($res);
            }
            else {
                $charge=D('Users')->pay($channel,$totalPrice,$togetherId);
                $res['status'] = 2;
                $res['charge'] = $charge."";
                $this->ajaxReturn($res);
            } 
        }
    }

    /**
     * 校验校区配送范围
     * @param  [type] $togetherId [description]
     * @param  [type] $rank       [description]
     * @param  [type] $phone      [description]
     * @return [type]             [description]
     */
    public function checkLegal($togetherId,$rank,$phone) {
        $status = D('Orders')->getCampusStateByTogeId($togetherId);

        if($status != 1) 
        { 
            return 0;
        }

        $campus_id1 = D('Orders')->getCampusIdByRank($phone,$rank);

        $campus_id2 = D('Orders')->getCampusIdByTog($phone,$togetherId);
 
        if($campus_id1 !== $campus_id2) {
            return 1;
        }
        return  2;
    }

}







?>