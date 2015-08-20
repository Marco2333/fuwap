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
			$this->redirect('Home/Login/homePage');
		}
	}

    public function index(){
        $this->userInfo();
    }

    public function userInfo(){
    	$Users = D('Users');
    	$info  = $Users->getUserInfo();

    	$this->assign('info',$info);
    	$this->display('userInfo');
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
        $row     = 9;
        $count   = $Receiver->count();
    	$page    = $Receiver->pageProduce($count,$row);    //分页
        $show    = $page->show();
        $limit   = $page->firstRow.','.$page->listRows;

        $address = $Receiver->getAddressInfo($limit);   //获取地址
        $address = $Receiver->addressConnect($address);

        // dump($address);
    	$this->assign('address',$address)
             ->assign('addressPage',$show);
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

    public function deleteAdress($rank) {

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

    public function verify(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 23;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet  = '0123456789';
        $Verify->imageW = 150;
        $Verify->imageH = 53;
        $Verify->entry();
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

    public function saveNewPWord($phone,$verify,$pVerify,$pword){
        if ($phone != $_SESSION['username']) {
            $res =  array(
                'result'  => 0,
                'message' => '手机号与账户不匹配！'
                );
            $this->ajaxReturn($res);
        }

        if (!check_verify($verify)) {
            $res =  array(
                'result'  => 0,
                'message' => '验证码输入不正确！'
                );
            $this->ajaxReturn($res);
        }

        $Users  = D('Users');
        $result = $Users->changePWord($pword);

        if ($result == -1) {
            $res =  array(
                'result'  => 0,
                'message' => '重置密码不能与先前密码相同！'
                );
            $this->ajaxReturn($res);
        }
        else if ($result == -2) {
            $res =  array(
                'result'  => 0,
                'message' => '密码不能少于8位！'
                );
            $this->ajaxReturn($res);
        }
        else if ($result !== false) {
            $res =  array(
                'result'  => 1,
                'message' => '密码修改成功！'
                );
            $this->ajaxReturn($res);
        }
        else {
            $res =  array(
                'result'  => 0,
                'message' => '密码修改失败，请重试！'
                );
            $this->ajaxReturn($res);
        }
    }

}