<?php
return array(
    'DB_TYPE' =>  'mysql',
    'DB_HOST' =>  '127.0.0.1',
    'DB_NAME' =>  'foru',
    'DB_USER' =>  'root',
    'DB_PWD'  =>  'zc0829',
    'DB_PORT'  =>  '3306',
    'SHOW_PAGE_TRACE' => true,  //开启调试模式

    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

    'view_filter' => array('Behavior\TokenBuild'),    //开启表单令牌功能，防止表单的重复提交
);