<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: sae.php 2504 2011-12-28 07:35:29Z liu21st $

// 系统默认的核心列表文件
return array(
    MODE_PATH.'Sae/functions.php',   // 系统函数库
    THINK_PATH.'Lib/Think/Core/Think.class.php',
    THINK_PATH.'Lib/Think/Exception/ThinkException.class.php',  // 异常处理类
    THINK_PATH.'Lib/Think/Core/Dispatcher.class.php', // URL调度和路由类
    MODE_PATH.'Sae/App.class.php',   // 应用程序类
    THINK_PATH.'Lib/Think/Core/Action.class.php', // 控制器类
    MODE_PATH.'Sae/Log.class.php',    // 日志处理类
    //THINK_PATH.'/Lib/Think/Core/Model.class.php', // 模型类
    MODE_PATH.'Sae/View.class.php',  // 视图类
    MODE_PATH.'Sae/alias.php',  // 加载别名
);
?>