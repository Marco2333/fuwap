<?php

namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=UTF-8');

/**
 * 资料管理控制器
 * 
 * @package     app
 * @subpackage  core
 * @category    controller
 * @author      Tony<879833043@qq.com>
 *
 */ 

class PersonController extends Controller {

	public function _initialize(){
		if (!isset($_SESSION['username'])) {
			$this->redirect('Home/Login/login');
		}
	}

    public function index(){
        $this->userInfo();
    }

    public function userInfo(){
    	$Users = D('Users');
    	$info  = $Users->getUserInfo();

    	$this->assign('info',$info);
    	$this->display('userinfo');
    }

    public function getUserInfo($field){
        $Users = D('Users');
        $info  = $Users->getUserInfo();

        if ($info !== flase) {
            $res = array(
                $field   => $info[$field],
                'result' => 1
                );
            $this->ajaxReturn($res);
        }
        else {
            $res = array(
                'result' => 0
                );
            $this->ajaxReturn($res);
        }
    }

    public function infoRevise($field){
        $Users = D('Users');
        $Users->reviseInfo($field);

        $this->redirect('Home/Person/userinfo');
    }

    public function infoSexRevise($sex){
        $Users = D('Users');
        $res   = $Users->reviseInfo($sex);

        if ($res !== false) {
            $res['result'] = 1;
            $this->ajaxReturn($res);
        }
        else {
            $res['result'] = 0;
            $this->ajaxReturn($res);
        }
    }

    public function addressManage(){
    	$Receiver = D('Receiver');
     
        $address = $Receiver->getAddressList();   //获取地址
       
    	$this->assign('address',$address);
           
    	$this->display('addressManage');
    }

    public function newAddress(){

        $city = M('city');
        $cityList = $city->select();
        
        $campusList = D('Campus')->getCampusByCity($cityList[0]['city_id']);
        $this->assign("cityList",$cityList)
             ->assign("campusList",$campusList);

        $this->display('newAddress');
    }

    public function saveNewAddress(){
        $Receiver = D('Receiver');

        $res = $Receiver->saveAddress();

        if ($res !== false) {
            $this->redirect('Home/Person/addressManage');
        }
        else {
            // 新地址保存失败
        }
    }

    public function deleteAdress() {

        $rank = I('rank');
        $phone = $_SESSION['username'];
        $out = D('Receiver')->deleteAddress($phone,$rank);

        $this->ajaxReturn($out);
    }

    public function getAddress($rank){
        $Receiver = D('Receiver');
        $address  = $Receiver->getAddressInfo('',$rank);   //获取地址信息

        $campusName = D('Campus')->getNameByCampusId($address[0]['campus_id']);

        $city = M('city');
        $cityList = $city->select();
        
        $campusList = D('Campus')->getCampusByCity($cityList[0]['city_id']);
        $this->assign("cityList",$cityList)
             ->assign("campusList",$campusList)
             ->assign('addressInfo',$address[0])
             ->assign('campusName',$campusName[0]['campus_name']);
       
        $this->display('reviseaddress');
    }

    public function reviseAddress(){
        $Receiver = D('Receiver');

        $res = $Receiver->removeAddress();

        if ($res !== false) {
            $this->saveNewAddress();
        }
        else {
            // 修改地址失败
        }
    }

    public function changePWord(){
        $this->display('changepword');
    }

    public function resetPassword(){
        $oldpword = D('Users')->getOldPassword();
        
        if(md5(I('pre-password')) != $oldpword) {
            echo "false";
        }else {
             echo "true";
        }
    }

    public function saveNewPWord(){
        
        $pword = I('new-password');
        
        $Users  = D('Users');
        $result = $Users->changePWord($pword);

        if($result == -1) {
            $this->redirect('Home/Person/changepword');
        }
        else {
            unset($_SESSION['username']);
            $this->redirect('Home/Login/login');
        } 
    }

    public function setDefaultAddress($rank) {
       
        $phone = $_SESSION['username'];
        $out = D('Receiver')->setDefaultAdd($phone,$rank);         //设置默认地址
        
        if($out == false) {
            $res['status'] = 0;
        }
        else {
             $res['status'] = 1;
        }

        $this->ajaxReturn($res);
    }

   //设置页面
   public function settings(){
       $campusId=session('campusId');

       $telphone=D('Campus')->getServicePhone($campusId);
       $this->assign('telphone',$telphone);
       $this->display();
   }

   public function cqq(){
      $this->display("Cqq");
   }

   public function cname(){
      $this->display("Cname");
   }
   
   public function cwechat(){
      $this->display("Cwechat");
   }

   public function cacademy(){
     $this->display("Cacademy");
   }
}