<?php

namespace Home\Model;
use Think\Model;

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

	public function getAddressInfo($limit = '',$rank = ''){
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

	public function addressSplit($address){
		$addressList = explode('^',$address['address']);

		$address['address'] = $addressList[0];
		$address['block']   = $addressList[1];
		$address['detail']  = $addressList[2];
		
		return $address;
	}

	public function count(){
		$count = M('receiver')
			    ->where('phone='.$_SESSION['username'].' and '.'is_out=0')
				->count();

		return $count;

	}

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