<?php

namespace Home\Model;
use Think\Model;

/**
 * 收货地址管理模型
 * 
 * @package     app
 * @subpackage  Home
 * @category    MODEL
 * @author      Tony<879833043@qq.com>
 *
 */ 


class ReceiverModel extends Model{
	protected $fields = array(
		'receiver' => array(
			'phone_id',
			'phone',
			'name',
			'address',
			'tag',
			'rank',
			'is_out',
			'campus_id'
			)
		);

	/**
     * 模型函数
     * 取得用户收货地址信息
     * @access public
     * @param  String $limit 分页条件
     * @param  String $rank  时间戳
     * @return array(array()) 购物车数据
     */
	public function getAddressInfo($limit = '0,9',$rank = ''){
		$field = array(
			'phone',
			'rank',
			'name',
			'phone_id',
			'address',
			'tag'
			);
		$order = array(
			'tag asc'
			);

		if ($rank != '') {
			$info = $this->where('phone='.$_SESSION['username'].' and '.'is_out=0'.' and '.'rank='.$rank)
						 ->field($field)
						 ->order($order)
						 ->limit($limit)
						 ->select();
		}
		else {
			$info = $this->where('phone='.$_SESSION['username'].' and '.'is_out=0')
						 ->field($field)
						 ->order($order)
						 ->limit($limit)
						 ->select();
		}
		
		return $info;
	}

	/**
     * 模型函数
     * 用户收货地址拆分粘结
     * @access public
     * @param  array(array()) $address 用户收货地址
     * @return array(array()) 地址粘接后的用户收货地址
     */
	public function addressConnect($address){
		for ($i = 0; $i < count($address); $i++) { 
			$addressList = explode('^',$address[$i]['address']);
			$address[$i]['address'] = '';

			for ($j = 0; $j < count($addressList); $j++) { 
				$address[$i]['address'] .= $addressList[$j];
			}
		}

		return $address;
	}

	/**
     * 模型函数
     * 用户收货地址拆分
     * @access public
     * @param  array(array()) $address 用户收货地址
     * @return array(array()) 地址拆分后的用户收货地址
     */
	public function addressSplit($address){
		$addressList = explode('^',$address['address']);

		$address['address'] = $addressList[0];
		$address['block']   = $addressList[1];
		$address['detail']  = $addressList[2];
		
		return $address;
	}

	/**
     * 模型函数
     * 取得用户收货地址数量
     * @access public
     * @param  null
     * @return int  用户收货地址数量
     */
	public function count(){
		$count = M('receiver')
			    ->where('phone='.$_SESSION['username'].' and '.'is_out=0')
				->count();

		return $count;

	}

	/**
     * 模型函数
     * 制作分页模块
     * @access public
     * @param  int $count 总行数
     * @param  int $row   一页几行
     * @return Page 分页模块
     */
	public function pageProduce($count,$row){
		$page = new \Think\Page($count,$row);
        $page->setConfig('header','条数据');
        $page->setConfig('prev','<');
        $page->setConfig('next','>');
        $page->setConfig('first','<<');
        $page->setConfig('last','>>');
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共 %TOTAL_ROW% %HEADER%</span>');
        $page->rollPage = $row; 
        
        return $page;
	}

	/**
     * 模型函数
     * 存储新增用户收货地址
     * @access public
     * @param  null
     * @return null
     */
	public function saveAddress(){
		$Receiver = M('receiver');

		if (!$this->addressIsEmpty()) {	
			$tag = 1;
		}
		else {
			$tag = 0;
		}

		$rank = time();
		$campus_id = 1;

		$data = array(
			'phone' 	=> $_SESSION['username'],
			'rank' 	 	=> $rank,
			'name'  	=> I('new-receiver'),
			'phone_id'  => I('new-phone'),
			'address'   => I('new-location').'^'.
						   I('new-block').'^'.
						   I('new-deLocation'),
			'tag'       => $tag,
			'is_out'    => 0,
			'campus_id' => $campus_id
			);

		$res = $Receiver->data($data)
					 	->add();
							
	}

	/**
     * 模型函数
     * 判断用户收货地址数量是否为零
     * @access public
     * @param  null
     * @return boolean 用户收货地址数量为零true
     *                 用户收货地址数量不为零false
     */
	public function addressIsEmpty(){
        $Receiver = M('receiver');
        $where    = array(
            'phone' => $_SESSION['username'],
            'tag'   => 0,
            'is_out'=> 0,
            '_logic'=> 'and'
            );
        $count = $Receiver->where($where)
                          ->count();

        if ($count != 0) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * 模型函数
     * 判断用户是否具有默认收货地址
     * @access public
     * @param  null
     * @return boolean 用户具有默认收货地址true
     *                 用户不具有默认收货地址false
     */
    public function hasDefaultAddress(){
    	$count = $this->where('phone='.$_SESSION['username'].' and '.'is_out=0'.' and '.'tag=0')
    				  ->count();

    	if ($count != 0) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    /**
     * 模型函数
     * 设置用户默认收货地址
     * @access public
     * @param  null
     * @return boolean 设置成功true
     *                 设置失败false
     */
    public function setDefaultAddress(){
    	$Receiver = M('receiver');
    	$where    = array(
            'phone' => $_SESSION['username'],
            'is_out'=> 0,
            '_logic'=> 'and'
            );
    	$data     = $Receiver->where($where)
    						 ->find();

    	$data['tag'] = 0;
    	$res = $Receiver->where($where)
    					->save($date);

    	if ($res !== false) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    /**
     * 模型函数
     * 删除用户收货地址
     * @access public
     * @param  null
     * @return boolean 用户收货地址删除成功true
     *                 用户收货地址删除失败false
     */
    public function removeAddress(){
    	$Receiver = M('receiver');
        $where    = array(
            'phone' => $_SESSION['username'],
            'rank'  => I('rank'),
            'is_out'=> 0,
            '_logic'=> 'and'
            );
        $data     = array(
        	'is_out'=> 1
        	);
        $res = $Receiver->where($where)
        				->save($data);

        if ($res !== false) {
	        if(!$this->hasDefaultAddress() && !$this->addressIsEmpty()) {
	        	$res = $this->setDefaultAddress();

	        	if ($res !== false) {
	        		return true;
	        	}
	        	else {
	        		return false;
	        	}
	        }
	        else {
	        	return true;
	        }
	    }
	    else {
	    	return false;
	    }
    }


}


?>