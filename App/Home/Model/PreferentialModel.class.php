<?php

namespace Home\Model;
use Think\Model;

class PreferentialModel extends Model{

    public function getPreferentialList($campusId) {
        $where['campus_id']=$campusId;
        $res = $this->field("preferential_id,need_number,discount_num")
        		->cache(true)
                ->where($where)
                ->order('need_number DESC')
                ->select();
        return $res;
    }


}

?>