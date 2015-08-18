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
		$field = array(
			'food_id',
			'campus_id',
			'name',
			'price',
			'discount_price',
			'img_url',
			'is_discount',
			'message',
			'grade',
			'info',
			'sale_number'
		);

		$good=M('food');

		if($limit !== '') {
			$goodList = $good->where('category_id=%d and campus_id=%d and tag=1 and status=1',$categoryId,$campusId)
			->field($field)
			->limit($limit)
			->select();
		}
		else {
			$goodList = $good->where('category_id=%d and campus_id=%d and tag=1 and status=1',$categoryId,$campusId)
				->field($field)
				->select();
		}

		return $goodList;
	}

	public function getGoodsBySerial($flag,$campusId = 1,$limit = 8) {
		
		$field = array(
			'food_id',
			'campus_id',
			'name',
			'price',
			'discount_price',
			'img_url',
			'is_discount',
			'message',
			'grade',
			'info',
			'sale_number'
		);

		$cateid = M('food_category')
		            ->scope('nomal')
					->where('serial = %d and campus_id = %d',$flag,$campusId)
					->find();

		$goodList = M('food')
		            ->where("category_id=%d and campus_id=%d and tag=1 and status=1",$cateid['category_id'],$campusId)
					->field($field)
					->limit($limit)
					->select();

		return $goodList;
	}
}