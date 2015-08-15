<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {

    public function index(){

        $campusId = $_SESSION['campusId'];          

	    if($campusId == null){
	        $campusId = 1;   
	    }
    	$newsImage=M('news')
        ->field('news_id,img_url')
        ->where('campus_id=%d',$campusId)
        ->select();               //获取主页头

        $this->assign('newsimage',$newsImage);

        $this->display();
    }
	
}