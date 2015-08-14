<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class CommodityController extends Controller {

    public function index(){
    	$campusId=I('campusId');        
        $cityId=I('cityId');          
        $this-> getCampusName($campusId,$cityId);

        if($campusId==null){
            $campusId=1;
        }
        if($cityId==null){
            $cityId=1;
        }

    	$category = D('Category');
    	$classes = getCategory(8,$campusId);
        
        $good=M('food');
        
        foreach ($classes as $key => $cate) {
            $goods=$good->where('category_id=%d',$cate['category_id'])
            ->limit(5)
            ->select();

            $goodList[$key]=$goods;
        }

        $module=M('food_category')                 //获取首页八个某块的
        ->where('campus_id=%d and serial is not null',$campusId)
        ->order('serial')
        ->select();

        $this->assign('goodlist',$goodList)
             ->assign('main_image',$newsImage)
             ->assign("category",$classes)  
             ->assign('module',$module)
             ->assign('campusList',$campusList)
             ->assign('cartGood',$cartGood)
             ->assign('hiddenLocation',0)/*设置padding-top的值为0*/
             ->assign('categoryHidden',0);

        $this->display();

        $this->display("goodsclassify");
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

	
}