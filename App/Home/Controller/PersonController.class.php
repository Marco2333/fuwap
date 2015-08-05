<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class PersonController extends Controller {

	public function _initialize(){
		if (!isset($_SESSION['username']))
		{
			$this->redirect('Home/Login/index');
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

    public function infoRevise($field){
        $Users = D('Users');
        $Users->reviseInfo($field);

        $this->redirect('Home/Person/userinfo');
    }

    public function addressManage(){
    	$Receiver = D('Receiver');

        $row     = 9;
        $count   = $Receiver->count();
    	$page    = $Receiver->pageProduce($count,$row);
        $show    = $page->show();
        $limit   = $page->firstRow.','.$page->listRows;

        $address = $Receiver->getAddressInfo($limit);
        $address = $Receiver->addressConnect($address);

    	$this->assign('address',$address)
             ->assign('addressPage',$show);
    	$this->display('addressManage');
    }

    public function saveNewAddress(){
        $Receiver = D('Receiver');

        $res = $Receiver->saveAddress();

        if ($res !== false)
        {
            $this->redirect('Home/Person/addressManage');
        }
        else
        {
            // 新地址保存失败
        }
    }

//

}