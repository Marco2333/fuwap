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
}