<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class ShoppingController extends Controller {
    public function thing(){

        $this->display();
    }
	public function category(){
		$this->display();
	}
}