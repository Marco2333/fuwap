<?php

namespace Home\Model;
use Think\Model;

/**
 * 订单管理模型
 * 
 * @package     app
 * @subpackage  Home
 * @category    MODEL
 * @author     
 *
 */ 


class FoodModel extends Model{

	protected $fields = array(
		'food' => array(
			'food_id',		//key
			'campus_id',	//key
			'name',
			'price',
			'discount_price',
			'img_url',
			'info',
			'modify_time',
			'status',
			'grade',
			'food_flag',
			'is_discount',
			'category_id',
			'prime_cost',
			'sale_number',
			'tag',
			'food_count',
			'to_home',
			'message',
			'home_image'
			)
		);

	/**
     * 模型函数
     * 通过食品号获取单个物品信息
     * @access public
     * @param  String $foodId   食品号
     * @param  String $campusId 校区ID
     * @return array() 单个物品信息
     */
	public function getGoodInfo($foodId,$campusId){
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
			'sale_number',
			'is_full_discount',
			);
		$goodInfo = $this->where('food_id=%s and campus_id=%s',$foodId,$campusId)
						 ->cache(true)
						 ->field($field)
						 ->find();
						 
		if ($goodInfo['is_discount'] == 0) {
			$goodInfo['discount_price'] = $goodInfo['price'];
		}

		return $goodInfo; 
	}

	public function getHomeSaleFood($campusId = 1) {

		$homeFood = $this->field('food_id,home_image')
						->cache(true)
						->where('to_home = 1 and campus_id = %d and tag=1 and status=1',$campusId )
						->select();

		return $homeFood;
	}

	public function getsearchList($campusId,$key,$flag) {
		$data['campus_id'] = $campusId;
		$data['name|food_flag']=array('like',"%".$key."%");
		$count    = M('food')->where($data)->count();

		$Page = pageProduct($count,8,2);
		$show = $Page->show();// 分页显示输出

		switch ($flag) {
            case 0:
                $goodlist = M('food')->where($data)
                   ->order('modify_time desc')
                   ->cache(true)
                   ->limit($Page->firstRow.','.$Page->listRows)
                   ->select();
                break;
            case 1:
                $goodlist = M('food')->where($data)
                    ->order('sale_number desc')
                    ->cache(true)
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
                break;
            case 2:
                $goodlist = M('food')->where($data)
                	->cache(true)
                    ->order('case when is_discount=1 then discount_price else price end')
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
                break;
            default:
                 $goodlist = M('food')->where($data)
                    ->order('modify_time desc')
                    ->cache(true)
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
                break;
        }
		
		$res['show'] = $show;
		$res['goodlist'] = $goodlist;

		return $res;
	}

	public function getFoodByCatId($campusId,$categoryId) {

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
			'sale_number',
			'is_full_discount'
		);

		$count = M('food')
				->cache(true)
				->where("category_id=%d and campus_id=%d and tag=1 and status=1",$categoryId,$campusId)
				->count();

		$Page = pageProduct($count,8,2);
		$show = $Page->show();// 分页显示输出

		$goodList = M('food')
					->cache(true)
		            ->where("category_id=%d and campus_id=%d and tag=1 and status=1",$categoryId,$campusId)
					->field($field)
					->limit($Page->firstRow.','.$Page->listRows)
					->select();
				
		$res['show'] = $show;
		$res['goodList'] = $goodList;


		return $res;
	}
};


?>