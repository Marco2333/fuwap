<?php
namespace Home\Model;
use Think\Model\ViewModel;

class CategoryModel extends Model {

	public function getCategory($limit,$campusId) {

		$category=M("food_category");      //获取左侧导航栏的分类
        $classes=$category
        ->where('campus_id=%d and tag=1',$campusId)
        ->limit($limit)
        ->select();

        return $classes;    
	}
}