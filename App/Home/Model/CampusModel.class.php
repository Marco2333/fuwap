<?php
namespace Home\Model;
use Think\Model;

class CampusModel extends Model {
	protected $viewFields=array(
		'city'=>array('city_id','city_name','_type'=>'LEFT'),
		'campus' =>array('campus_id','campus_name','open_time','close_time','status','close_reason','_on'=>'campus.city_id=city.city_id') 
	);

	protected $_scope=array(
	);

	public function getAllCity(){
		$city=M('city')->select();
		return $city;
	}

	public function getCampusByCity($cityId){
       $campus=M('campus')->field('campus_id,campus_name')->where('city_id=%d',$cityId)->select();
       
       return $campus;
	}

	public function getNameByCampusId($campusId) {
		$campus_name = M('campus')->field('campus_name')
							->where("campus_id=%d",$campusId)
							->select();

		return $campus_name;
	}

	public function getCloseTime($campusId) {
		$close_time = M('campus')->field('close_time')
					->where('campus_id=%d',$campusId)
					->find();
		return $close_time['close_time'];
	}

	public function getServicePhone($campusId){
		$phone=M('campus')->getFieldByCampusId($campusId,'custom_service');
		return $phone;
	}
}
