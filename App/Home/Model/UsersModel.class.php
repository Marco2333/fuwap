<?php

namespace Home\Model;
use Think\Model;

/**
 * 用户管理模型
 * 
 * @package     app
 * @subpackage  Home
 * @category    MODEL
 * @author      Tony<879833043@qq.com>
 *
 */ 


class UsersModel extends Model{
	protected $fields = array(
		'users' => array(
			'phone',	//key
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

	/**
     * 模型函数
     * 取得用户基本信息
     * @access public
     * @param  null
     * @return array(array()) 用户数据
     */
	public function getUserInfo(){
		if (!isset($_SESSION['username'])) {
			$info = array(
				'nickname' => '点击登陆',
				'img_url'  => '/fuwebapp/Public/img/userhead.png'
				);
		}
		else {
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
				$info['img_url'] = '/fuwebapp/Public/img/userhead.png';
			}

		}

		return $info;
	}

	/**
     * 模型函数
     * 修改用户基本信息
     * @access public
     * @param  null
     * @return null
     */
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

	/**
     * 模型函数
     * 修改密码
     * @access public
     * @param  String $pword 新密码
     */
	public function changePWord($pword){

		$data = $this->where('phone=%d',$_SESSION['username'])
					 ->field('password')
					 ->find();

		if (md5($pword) != $data['password']) {
			$data['password'] = md5($pword);
			$res = M('users')->where('phone=%s',$_SESSION['username'])
							 ->save($data);
			if($res === false) {
				return -1;
			}
			else {
				return 1;
			}
		}
		else {
			return 0;
		}
	}

	public function getOldPassword() {
		$data = M('users')->where('phone=%s',$_SESSION['username'])
					 ->field('password')
					 ->find();
		return $data['password'];

	}

}





?>