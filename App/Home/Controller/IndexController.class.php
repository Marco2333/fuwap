<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {

    public function index(){

    	$campusId = I('campus_id');

    	if($campusId == null) {
    		$campusId = $_SESSION['campusId'];    
    	}
        else {
        	$_SESSION['campusId'] = $campusId;
        }    

	    if($campusId == null){
	        $campusId = 1;   
	    }
	    
    	$newsImage=M('news')
        ->field('news_id,img_url')
        ->where('campus_id=%d',$campusId)
        ->select();    

        // dump($_SESSION['campusId']);
        $campusName = D('Campus')->getNameByCampusId($campusId);
        $goodsSale = D('Food')->getHomeSaleFood($campusId);
        $this->assign('newsimage',$newsImage)
        	->assign('goodsSale',$goodsSale)
        	->assign('campusName',$campusName);

        $this->display();
    }
	
	public function selectCampus() {

		$city = M('city');
		$cityList = $city->select();
		
		$campusList = D('Campus')->getCampusByCity($cityList[0]['city_id']);
		$this->assign("cityList",$cityList)
			 ->assign("campusList",$campusList);
			 
		$this->display("selectcampus");
	}

	public function getCampusByid($city_id) {
		$campusList = D('Campus')->getCampusByCity($city_id);

		if($campusList !== false) {
			$res['status'] = 1;
			$res['campusList'] = $campusList;
		}
		else {
			$res['status'] = 0;
		}

		$this->ajaxReturn($res);
	}

    //获取微信支付平台
	public function getOpenId(){
        require(VENDOR_PATH . '/pingplusplus/lib/WxpubOAuth.php');
		$wxpubOAuth = new \pingpp\WxpubOAuth();
		$url=$wxpubOAuth->createOauthUrlForCode("wx9f37078a33527060","http://www.enjoyfu.com.cn/fuwebapp/index.php/Home/Index/getCode");
		header('Location: ' . $url);
	}

    //获取微信公众平台code
	public function getCode(){
       require(VENDOR_PATH . '/pingplusplus/lib/WxpubOAuth.php');
       $wxpubOAuth = new \pingpp\WxpubOAuth();
       $code=I("code");
       dump($code);    //$app_id, $app_secret, $cod
       $openId=$wxpubOAuth->getOpenid("wx9f37078a33527060","fd86e8e6135973fbee6fd6204e322984",$code);
       dump($openId);
	}

	 public function pay(){
	 	$phone=I('phone');
	 	if($phone!=null){
	 		session('username',$phone);
	 	}
	 
        $this->display();
    }
}