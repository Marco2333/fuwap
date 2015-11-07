<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class LoginController extends Controller {
    public function index(){
        $this->display('login');
    }

    public function register() {
		    $this->display("register");
	  }
	//生成验证码
    public function verify(){
        // 行为验证码
        $Verify = new \Think\Verify();
        $Verify->fontSize = 23;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }

      public function toRegisterCheck() {


         $verify = I('param.verify','');

         // dump( $verify);
         
         if(check_verify($verify)) {
            $result['status']=1;
            $this->ajaxReturn($result);
         }
         else {
            $result['status']=0;
            $this->ajaxReturn($result);
         }
    }

     public function tologin()
     {
          $username = I('username');                        //获取用户手机号
          $pwd = I('password', '', 'md5');
          $user = M('users')->where(array('phone' => $username))->find();
          
          if (!$user || $user['password'] != $pwd) 
          {
              $result['status']='failure';
              $result['message']="用户名或者密码错误";
              $this->ajaxReturn($result);
          };
          session('username', $user['phone']);
          session('nickname', $user['nickname']);
          session('img_url', $user['img_url']);
          session('campusId',$user['last_campus']);
          if($_SESSION['campusId']==null) {
            $_SESSION['campusId']==1;
          }
          $result['status']='success';
          $this->ajaxReturn($result);
      }

    public function toRegister()
    {        
        $verify=I('confirmcode');
        if($verify==session('phone_security')){
              $data["nickname"] = I("nickname");
              $data["password"] = I("password",'','md5');
              $data["phone"] = I("phone");
              $data["type"] = 2;
              $data['create_time']=date('Y-m-d',I('register_time'));
              $data['last_campus']= 1;
              //校验是否已经注册过
              $result=M("users")->where("phone = '%s'",$data['phone'])->find();
            
              if($result!=null){
                  $this->error("该用户已经注册,请不要重复注册，快前往登陆吧",U('/Home/Login/index'),3);
              }
              $status=M("users")->data($data)->add();
              
              if($status==false){
                 $this->error("注册失败！");
              }
              else{
                  $this->success("恭喜您，注册成功了哦！正在为你转向登陆页面",U('/Home/Login/index'),3);
              }  
            }else{
                 $this->error("短信验证码错误！");
            }
    }

    public function checkUserExist(){
        $phone = I('phone');
        $map['phone'] = $phone;
        $user = M('users')->where($map)->find();
        if(!isset($user)&&empty($user)){
            $result['status']=1;
            $this->ajaxReturn($result);
        }
        else {
             $result['status']=0;
             $this->ajaxReturn($result);
        }
    }


    // @author Tony
    public function logout(){
      unset($_SESSION['username']);
      $this->redirect('Home/Login/homePage');
    }

    // @author Tony
    public function homePage(){

        $Users = D('Users');
        $info  = $Users->getUserInfo();
        
        $this->assign('info',$info);
        $this->display('homepage');
    }
     
     /**
      * 校验邮箱是否存在
      * @return [type] [description]
      */
     public function checkMailExist(){
        $mail = I('mail');
        $map['mail'] = $mail;
        $user = M('users')->where($map)->find();
        if(!isset($user)&&empty($user)){
            $result['status']=1;
            $this->ajaxReturn($result);
        }
        else {
             $result['status']=0;
             $this->ajaxReturn($result);
        }
    }

    /**
    **发送短信验证码
    */
    public function sendPhoneSecurity(){
        $phone=I("code");
        require_once(dirname(__FILE__) . '/../Model/SendSMS.php');
        $securitycode=rand(1000,9999);
        session("phone_security",$securitycode);
        sendTemplateSMS($phone,array($securitycode,'10'),"1");//手机号码，替换内容数组，
    }
}