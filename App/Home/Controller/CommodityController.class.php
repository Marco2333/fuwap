<?php

namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class CommodityController extends Controller {

    public function index(){
    }

    public function goodsclassify() {
      
	    $campusId = $_SESSION['campusId'];          
	  	$categoryId = I('categoryId');

	    if($campusId == null){
	        $campusId = 1;   
	    }

		$category = D('FoodCategory');
		$classes = $category->getCategory($campusId);

        if($categoryId == null){
            $categoryId = $classes[0]['category_id']; 
        }
	   
        $res = D('Food')->getFoodByCatId($campusId,$categoryId);

        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campusId); 

	    $this->assign('goodlist',$res['goodList'])
             ->assign('page',$res['show'])
             ->assign('categoryId',$categoryId)
             ->assign('preferential',$preferential)
	         ->assign("category",$classes); 
	   
	    $this->display("goodsclassify");
    }

    public function goodscategory() {
        $campusId = $_SESSION['campusId'];          
        $flag = I('flag');

        if($campusId == null) {
            $campusId = 1;
        }
        
        $res = D('FoodCategory')->getGoodsBySerial($flag,$campusId);

        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campusId); 

        $this->assign('flag',$flag)
            ->assign('page',$res['show'])
            ->assign('preferential',$preferential)
            ->assign('goodList',$res['goodList']);
        
        $this->display('goodscategory');
    }
    
    public function getGatGoods($categoryId){
        
    	$campusId = $_SESSION['campusId'];

    	if($campusId == null){
	        $campusId = 1;   
	    }

    	$category = D('FoodCategory');
    	$goodList = $category -> getGoodsByCatId($categoryId,$campusId);

    	if($goodList !== false) {
    		$res['result'] = 1;
    		$res['goodsList'] = $goodList; 
    	}      
    	else {
    		$res['result'] = 0;  
    	}
    	$this->ajaxReturn($res); 
    }
     /**
     * @access public
     * @param 
     * @param 
     * @return
     */
    
     public function getCampusName($campusId, $cityId){
       
        if($campusId==null){
            $campusId=1;
        }

        $campus_name=M("campus")
        ->field('campus_name')
        ->where('campus_id=%d',$campusId)
        ->select();

        if($cityId==null){
            $cityId=1;
        }

        $city=D('CampusView')->getAllCity();   //获取所有的城市 
        $campus=D('CampusView')->getCampusByCity($cityId);

        $this->assign('campus',$campus)
             ->assign('city',$cityId)
             ->assign("cities",$city)
             ->assign("campus_name",$campus_name[0]);
    }

    public function comment(){

        if (!isset($_SESSION['username'])) {
            $this->redirect('Home/Login/login');
        }

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
    		$this->redirect('Home/Ordermanage/orderManage',array('status'=>'4'));
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

    public function goodsInfo(){
        $Users       = D('Users');
        $Orders      = D('Orders');
        $Food        = D('Food');
        $FoodComment = D('FoodComment');

        $food_id = I('food_id');
        $campus_id = $_SESSION['campusId'];

        if($campus_id==null){
            $campus_id = 1;
        }

        $goodsInfo   = $Food->getGoodInfo($food_id,$campus_id);
        $commentInfo = $FoodComment->getGoodComment($food_id,$campus_id);

        $commentCount = count($commentInfo);

        for ($i = 0;$i < $commentCount;$i++) {
            $commentInfo[$i]['order_count'] = $Orders->getOrderCount($commentInfo[$i]['order_id']);
            $userInfo    = $Users->getUserInfoById($commentInfo[$i]['phone']);
            $commentInfo[$i]['nickname']    = $userInfo['nickname'];

            if ($commentInfo[$i]['is_hidden'] != 0) {
                $commentInfo[$i]['img_url']     = '/fuwebapp/Public/img/userhead.png';
            }
            else {
                $commentInfo[$i]['img_url']     = $userInfo['img_url'];
            }     
        }

        $avgGrade = substr($FoodComment->getAvgGrade($commentInfo),0,3);

        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campus_id); 

        if($avgGrade == false){
            $avgGrade = 0;
        }

        if ($goodsInfo) {
            $this->assign('goodsInfo',$goodsInfo)
                 ->assign('commentInfo',$commentInfo)
                 ->assign('commentCount',$commentCount)
                 ->assign('preferential',$preferential)
                 ->assign('avgGrade',$avgGrade);
            $this->display('goodsinfo');
        }
        else {
            $this->redirect('Home/Commodity/goodsclassify');
        }
    }

    public function buyNowButton(){

        if (!isset($_SESSION['username'])) {
            $this->redirect('Home/Login/login');
        }
        $Orders = D('Orders');

        $food_id = I('food_id');
        $order_count = I('order_count');

        $result = $Orders->buyNowAction($food_id,$order_count);
        
        if ($result !== false) {
            $res['result']   = 1;
            $res['order_id'] = $result['order_id'];
            $this->ajaxReturn($res);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }

     public function addToShopCart(){

        if (!isset($_SESSION['username'])) {
            $res['result'] = 2;
            $this->ajaxReturn($res);
        }
        $Orders = D('Orders');

        $food_id = I('food_id');
        $order_count = I('order_count');

        $where = array(
            'phone'       => $_SESSION['username'],
            'status'      => 0,
           'order_count' => array('gt',0),
        );
     
        $field = array(
            'order_id',
            'food_id',
            'order_count'
        );
        $preOrders = M('orders')->where($where)
                           ->field($field)
                           ->select();

        $have = 0;
        for ($i = 0; $i < count($preOrders); $i++) 
        { 
            if ($preOrders[$i]['food_id'] != $food_id)
            {
                continue;
            }
            else
            {
                $order_count = $preOrders[$i]['order_count'] + $order_count;
                $have = 1;
                break;
            }
        }



        if ($have != 1)
        {
            $result = $Orders->buyNowAction($food_id,$order_count);

            $res['order_id'] = $result['order_id'];
        }
        else
        {
            $wherefood = array(
                'phone'     => $_SESSION['username'],
                'food_id'   => $food_id
                );

            $data = array(
                'order_count' => $order_count
                );
            $result = M('orders')->where($wherefood)
                             ->save($data);
        }   
        if ($result !== false) {
            $res['result']   = 1;
            $this->ajaxReturn($res);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }
    
    public function searchoutcome() {
        $key = I('key');
        $campus_id = $_SESSION['campusId'];

        if($campus_id == null) {
            $campus_id = 1;
        }

        $std=(int)I('std');

        if($std==null) {
            $std = 0;
        }

        switch ($std) {
            case 0:
                $out = D('Food')->getsearchList($campus_id,$key,0);
                break;
            case 1:
                $out = D('Food')->getsearchList($campus_id,$key,1);
                break;
            case 2:
                $out = D('Food')->getsearchList($campus_id,$key,2);
                break;
            default:
                $out = D('Food')->getsearchList($campus_id,$key,0);
                break;
        }
        
        $Preferential = D('Preferential');
        $preferential   = $Preferential->getPreferentialList($campus_id); 

        $this->assign("goodlist",$out['goodlist'])
            ->assign('page',$out['show'])
            ->assign('std',$std)
            ->assign('preferential',$preferential)
            ->assign("key",$key);
       
        $this->display("searchoutcome");
    }
	
}