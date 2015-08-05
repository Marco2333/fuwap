<?php

namespace Home\Model;
use Think\Model;

class UsersModel extends Model{
	protected $fields = array(
		'users' => array(
			'phone',
			'password',
			'type',
			'create_time',
			'nickname',
			'img_url',
			'last_login',
			'token',
			'sex',
			'academy',
			'qq',
			'weixin',
			'mail',
			'campus_id'
			)
		);

	public function getUserInfo(){
		$field = array(
			'phone',
			'nickname',
			'img_url',
			'sex',
			'academy',
			'qq',
			'weixin'
			);
		$info = $this->where("phone=".$_SESSION['username'])//写成where($where)就不对了。。。。坑。。。
					 ->field($field)
					 ->find();

		if ($info['img_url'] == null) {
			$info['img_url'] = '\foru\Public\Uploads\2015-08-01\ForUForUForUForUForUForUForUForUForUForUForUForU.jpg';//默认forU灰色图标
		}

		return $info;
	}

	public function reviseInfo($field){
		$Users = M('users');

		$where = array(
			'phone'	=> $_SESSION['username'],
			);

		if ($field != 'sex') {
			$data[$field] = I('revise-'.$field);
		}
		else {
			$data = $Users->where($where)
						  ->find();

			if ($data['sex'] != 0) {
				$data['sex'] = 0;
			}
			else {
				$data['sex'] = 1;
			}
		}

		$res = $Users->where($where)
					 ->save($data);
	}

	

}





?>