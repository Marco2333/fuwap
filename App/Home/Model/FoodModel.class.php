<?php

namespace Home\Model;
use Think\Model;

/**
 * 订单管理模型
 * 
 * @package     app
 * @subpackage  Home
 * @category    MODEL
 * @author      Tony<879833043@qq.com>
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
			'sale_number'
			);
		$goodInfo = $this->where('food_id='.$foodId.' and campus_id='.$campusId)
						 ->field($field)
						 ->find();
						 
		if ($goodInfo['is_discount'] == 0) {
			$goodInfo['discount_price'] = $goodInfo['price'];
		}

		return $goodInfo; 
	}

	public function getHomeSaleFood($campusId = 1) {

		$homeFood = $this->field('food_id,home_image')
						->where('to_home = 1 and campus_id = %d',$campusId )
						->select();

		return $homeFood;
	}


};


?>