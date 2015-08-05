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

	public function getAddressInfo($limit = ''){
		$where = array(
			'phone'  => $_SESSION['username'],
			'is_out' => 0
			);
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
		$info = $this->where('phone='.$_SESSION['username'].' and '.'is_out=0')
					 ->field($field)
					 ->order($order)
					 ->limit($limit)
					 ->select();

		return $info;
	}

	public function addressConnect($address){
		for ($i = 0; $i < count($address); $i++) 
		{ 
			$addressList = explode('^',$address[$i]['address']);
			$address[$i]['address'] = '';

			for ($j = 0; $j < count($addressList); $j++) 
			{ 
				$address[$i]['address'] .= $addressList[$j];
			}
		}

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

		if (!$this->addressIsEmpty())
		{	
			$tag = 1;
		}
		else
		{
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
		dump($data);

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
        $address  = $Receiver->where($where)
                             ->field()
                             ->select();

        if (count($address) != 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

}
//1

?>