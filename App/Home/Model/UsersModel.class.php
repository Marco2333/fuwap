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

	 /**
    * 调用支付
    * @param  [type] $channel 
    * @param  [type] $amount  [description]
    * @param  [type] $orderNo [description]
    * @return [type]          [description]
    */
   public function pay($channel,$amount,$orderNo){
        require_once(dirname(__FILE__) . '/../init.php');
       
        $extra = array();
        switch ($channel) {
            case 'alipay_wap':
            $extra = array(
                /*'success_url' => C('IPUrl').'/index.php',
                'cancel_url' => C('IPUrl').'/index.php/Home/Login/toLogin'*/
                'success_url'=>'http://we.com:8000/fuwebapp/index.php',
                'cancel_url'=>'http://we.com:8000/fuwebapp/index.php'
                );
            break;
        }

        \Pingpp\Pingpp::setApiKey('sk_live_vBNcIdIOKPBJEU9YOq3C02PU');

        try {
            $ch = \Pingpp\Charge::create(
                array(
                    'subject'   => 'For优商品',
                    'body'      => '通过wap网页支付',
                    'amount'    => $amount*100,
                    'order_no'  => $orderNo,
                    'currency'  => 'cny',
                    'extra'     => $extra,
                    'channel'   => $channel,
                    'client_ip' => $_SERVER['REMOTE_ADDR'],
                    'app'       => array('id' => 'app_La1y14yrPa10SeHS')
                    )
                );
            return $ch;
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo $e;
            $e->getHttpBody();
        }

    }


}





?>