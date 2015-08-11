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


class OrdersModel extends Model{

	protected $fields = array(
		'orders' => array(
			'order_id',
			'phone',
			'campus_id',
			'together_id',
			'create_time',
			'status',
			'price',
			'order_count',
			'is_remarked',
			'food_id',
			'rank',
			'together_date',
			'admin_phone',
			'reserve_time',
			'message',
			'tag'
			)
		);

	/**
     * 模型函数
     * 取得用户购物车信息
     * @access public
     * @param  null
     * @return array(array()) 购物车数据
     */
	public function getShoppingCart(){
		$join  = 'food On orders.food_id = food.food_id and orders.campus_id = food.campus_id';
		$field = array(
			'orders.order_id',
			'orders.campus_id',
			'orders.order_count',
			'food.food_id',
			'food.name',
			'food.price',
			'food.discount_price',
			'food.is_discount',
			'food.message',
			'food.img_url'
			);
		$order = 'create_time desc';

		$cart  = $this->join($join)
					  ->where('phone='.$_SESSION['username'].' and orders.status=0 and orders.tag=1 and food.tag=1')
					  ->field($field)
					  ->order($order)
					  ->select();

		for ($i = 0;$i < count($cart);$i++) {
			$cart[$i]['Price'] = $cart[$i]['price']*$cart[$i]['order_count'];
			if ($cart[$i]['is_discount'] != 0) {
				$cart[$i]['dPrice'] = $cart[$i]['discount_price']*$cart[$i]['order_count'];
			}
			else {
				$cart[$i]['dPrice'] = $cart[$i]['Price'];
			}
		}

		return $cart;
	}

	/**
     * 模型函数
     * 计算购物车所选货物的总价
     * @access public
     * @param  array(array()) 购物车数据
     * @return array() 价格状况：原价Price，折扣价dPrice，节省save
     */
	public function settleAccounts($cart){
		for ($i = 0;$i < count($cart);$i++) {
			$price['Price']  += $cart[$i]['Price'];
			$price['dPrice'] += $cart[$i]['dPrice'];
		}
		$price['save'] = $price['Price'] - $price['dPrice'];

		return $price;
	}

	public function updateOrderCount($order_count){
		$Orders = M('orders');
		
	}
}









?>