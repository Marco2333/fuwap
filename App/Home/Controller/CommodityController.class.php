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

	    if($categoryId == null){
	        $categoryId = 1; 
	    }
	    if($campusId == null){
	        $campusId = 1;   
	    }

		$category = D('FoodCategory');
		$classes = $category->getCategory(8,$campusId);
	   
	    $goodList = $category -> getGoodsByCatId($classes[0]['category_id'],$campusId);
	    
	    // dump($classes);
	    $this->assign('goodlist',$goodList)
	         ->assign("category",$classes); 
	   
	    $this->display("goodsclassify");
    }

    public function goodscategory() {
        $campusId = $_SESSION['campusId'];          
        $flag = I('flag');

        if($campusId == null) {
            $campusId = 1;
        }
        
        $goodList = D('FoodCategory')->getGoodsBySerial($flag,$campusId);

        $this->assign('flag',$flag)
            ->assign('goodList',$goodList);

        
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

    public function goodsInfo(){
        $Users       = D('Users');
        $Orders      = D('Orders');
        $Food        = D('Food');
        $FoodComment = D('FoodComment');

        $food_id = I('food_id');
        // $food_id   = '40313';
        $campus_id = $_SESSION['campus_id'];

        $userInfo    = $Users->getUserInfo();
        $goodsInfo   = $Food->getGoodInfo($food_id,$campus_id);
        $commentInfo = $FoodComment->getGoodComment($food_id,$campus_id);

        $commentCount = count($commentInfo);

        for ($i = 0;$i < $commentCount;$i++) {
            $commentInfo[$i]['order_count'] = $Orders->getOrderCount($commentInfo[$i]['order_id']);
            $commentInfo[$i]['nickname']    = $userInfo['nickname'];

            if ($commentInfo[$i]['is_hidden'] != 0) {
                $commentInfo[$i]['img_url']     = '/fuwebapp/Public/img/userhead.png';
            }
            else {
                $commentInfo[$i]['img_url']     = $userInfo['img_url'];
            }     
        }

        $avgGrade = substr($FoodComment->getAvgGrade($commentInfo),0,3);

        if($avgGrade == false){
            $avgGrade = 0;
        }

        if ($goodsInfo) {
            $this->assign('goodsInfo',$goodsInfo)
                 ->assign('commentInfo',$commentInfo)
                 ->assign('commentCount',$commentCount)
                 ->assign('avgGrade',$avgGrade);
            $this->display('goodsInfo');
        }
        else {
            $this->redirect('Home/Commodity/goodsclassify');
        }
    }

    public function buyNowButton(){
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

    public function searchoutcome($key) {
        $campus_id = $_SESSION['campus_id'];

        if($campus_id == null) {
            $campus_id = 1;
        }

        $data['campus_id'] = $campus_id;
        $data['name|food_flag']=array('like',"%".$key."%");
        $goodlist = M('food')->where($data)
            ->order('modify_time desc')
            ->select();
        // dump($goodlist);
        $this->assign("goodlist",$goodlist)
            ->assign("key",$key);
       
        $this->display("searchoutcome");
    }

    public function getgoodlist($key) {
        $std=(int)I('std');
        $campus_id = $_SESSION['campus_id'];

        if($campus_id == null) {
            $campus_id = 1;
        }

        $data['campus_id'] = $campus_id;
        $data['name|food_flag']=array('like',"%".$key."%");

        switch ($std) {
            case 0:
                $goodlist = M('food')->where($data)
                   ->order('modify_time desc')
                   ->select();
                break;
            case 1:
                $goodlist = M('food')->where($data)
                    ->order('sale_number desc')
                    ->select();
                break;
            case 2:
                $goodlist = M('food')->where($data)
                    ->order('price')
                    ->select();
                break;
            default:
                 $goodlist = M('food')->where($data)
                    ->order('modify_time desc')
                    ->select();
                break;
        }
        // dump($goodlist);
       if($goodlist !== false) {
            $res['status'] = 1;
            $res['goodList'] = $goodlist;
        }
        else {
            $res['status'] = 0;
        }

        $this->ajaxReturn($res);
    }
	
}