<?php
namespace Home\Model;
use Think\Model;

class FoodCategoryModel extends Model {

	public function getCategory($limit,$campusId) {

		$category=M("food_category");      //获取左侧导航栏的分类
        $classes=$category
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
			$goodList = $good->where('category_id=%d and campus_id=%d',$categoryId,$campusId)
			->select();
		}

		return $goodList;
	}

	public function getGoodsBySerial($flag,$campusId = 1,$limit = 5) {
		$cateid = M('food_category')->field('category_id')
					->where('serial = %d and campus_id = %d',$flag,$campusId)
					->select();
		$goodList = M('food')->where("category_id = %d and campus_id = %d",$cateid,$campusId)
					->limit($limit)
					->select();
		// dump($cateid);
		// dump($campusId);
		return $goodList;
	}
}