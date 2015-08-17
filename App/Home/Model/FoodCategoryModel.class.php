<?php
namespace Home\Model;
use Think\Model;

class FoodCategoryModel extends Model {
    protected $_scope=array(
        'nomal'=>array(
          'field'=>array('category_id,name,serial'),
        ),
    );

	public function getCategory($limit,$campusId) {

		$category=M("food_category");      //获取左侧导航栏的分类
        $classes=$category->scope('nomal')
        ->where('campus_id=%d and tag=1',$campusId)
        ->limit($limit)
        ->select();

        return $classes;    
	}

	public function getGoodsByCatId($categoryId,$campusId,$limit = '') {

		$good=M('food');

		if($limit !== '') {
			$goodList = $good->where('category_id=%d and campus_id=%d',$categoryId,$campusId)
			->limit($limit)
			->select();
		}
		else {
			$goodList = $good->where('category_id=%d and campus_id=%d and tag=1 and status=1',$categoryId,$campusId)
			->select();
		}

		return $goodList;
	}

	public function getGoodsBySerial($flag,$campusId = 1,$limit = 8) {
		
		$cateid = M('food_category')
		            ->scope('nomal')
					->where('serial = %d and campus_id = %d',$flag,$campusId)
					->find();

		$goodList = M('food')
		            ->where("category_id=%d and campus_id=%d",$cateid['category_id'],$campusId)
					->limit($limit)
					->select();

		return $goodList;
	}
}