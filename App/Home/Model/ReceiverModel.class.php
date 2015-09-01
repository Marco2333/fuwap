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
			'phone_id',   //key
			'phone',     
			'name',
			'address',
			'tag',
			'rank',      //key
			'is_out',
			'campus_id'
			)
		);

    public function getAddressList() {
        $field = array(
            'phone_id',
            'rank',
            'name',
            'phone',
            'concat(campus_name,address) as address',    //连接两个字段作为地址
            'phone',
            'tag',
            'receiver.campus_id'
        );

        $order = array(
            'tag asc'
        );

         $info=$this->join('campus on receiver.campus_id=campus.campus_id')
                    ->field($field)
                    ->where('phone_id= %s and is_out=0',$_SESSION['username'])
                    ->order($order)
                    ->select();

        return $info;
    }

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
			'phone_id',
			'rank',
			'name',
			'phone',
			'address',
            'phone',
			'tag',
            'campus_id'
			);
		$order = array(
			'tag asc'
			);

		if ($rank != '') {
			$info = $this->where('phone_id= %s and is_out=0 and rank= %s',$_SESSION['username'],$rank)
						 ->field($field)
						 ->order($order)
						 ->limit($limit)
						 ->select();
		}
		else {
			$info = $this->where('phone_id= %s and is_out=0',$_SESSION['username'])
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
			    ->where('phone_id=%s and is_out=0',$_SESSION['username'])
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
			'phone_id' 	=> $_SESSION['username'],
			'rank' 	 	=> $rank,
			'name'  	=> I('new-receiver'),
			'phone'  => I('new-phone'),
			'address'   => I('new-deLocation'),
			'tag'       => $tag,
			'is_out'    => 0,
			'campus_id' => I('campusId')
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
            'phone_id' => $_SESSION['username'],
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
    	$count = $this->where('phone_id= %s and is_out=0 and tag=0',$_SESSION['username'])
    				  ->count();

    	if ($count != 0) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    public function deleteAddress($phone_id,$rank) {
          $where = array(
             'phone_id' => $phone_id,
             'rank'=>$rank
         );
        $defaultAdd = $this->getDefaultAddress();

        if($defaultAdd['rank'] === $rank) {
            return -1;
        }

        $res = M('receiver')->where($where)->delete();

        if($res === false) {
            return 0;
        }
        else {
            return 1;
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
     public function setDefaultAdd($phone,$rank) {
         $where = array(
             'phone_id' => $phone,
             'rank'=>$rank
         );
        
         $where1 = array(
            'phone_id' => $phone
         );

         $data1['tag'] = 1;
         $data['tag'] = 0;

         $res = M('receiver')->where($where1)->save($data1);
         $res = M('receiver')->where($where)->save($data);

         if ($res !== false) {
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
            'phone_id' => $_SESSION['username'],
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
     * 获取用户默认收货地址
     * @access public
     * @param  null
     * @return array() 用户默认收货地址信息
     */
    public function getDefaultAddress(){
        $field = array(
            'phone_id',
            'name',
            'address',
            'rank'
            );
        $defaultAddress = $this->where("phone_id=%s and tag = 0",$_SESSION['username'])
                               ->field($field)
                               ->select();

        $defaultAddress = $this->addressConnect($defaultAddress);

        return $defaultAddress[0];
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
            'phone_id' => $_SESSION['username'],
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