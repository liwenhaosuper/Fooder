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
// $Id: runtime.php 2587 2012-01-13 16:04:28Z zuojiazi.cn@gmail.com $

// 加载模式列表文件
load_think_mode();

// 加载模式列表文件
function load_think_mode() {
    // 加载常量定义文件
    require THINK_PATH.'Common/defines.php';
    // 加载路径定义文件
    require defined('PATH_DEFINE_FILE')?PATH_DEFINE_FILE:THINK_PATH.'Common/paths.php';
    // 读取核心编译文件列表
    if(is_file(CONF_PATH.'core.php')) {
        // 加载项目自定义的核心编译文件列表
        $list   =  include CONF_PATH.'core.php';
    }elseif(defined('THINK_MODE')) {
        // 根据设置的运行模式加载不同的核心编译文件
        $list   =  include MODE_PATH.''.strtolower(THINK_MODE).'.php';
    }else{
        // 默认核心
        $list = include THINK_PATH.'Common/core.php';
    }
     // 加载兼容函数
    if(version_compare(PHP_VERSION,'5.2.0','<') )
        $list[]	= THINK_PATH.'Common/compat.php';
    // 加载模式文件列表
    foreach ($list as $key=>$file){
        if(is_file($file))  require $file;
    }
    // 检查项目目录结构 如果不存在则自动创建(sae下不检查目录结构)
}

// 创建编译缓存
function build_runtime_cache($append='') {
    // 读取核心编译文件列表
    if(is_file(CONF_PATH.'core.php')) {
        // 加载项目自定义的核心编译文件列表
        $list   =  include CONF_PATH.'core.php';
    }elseif(defined('THINK_MODE')) {
        // 根据设置的运行模式加载不同的核心编译文件
        $list   =  include MODE_PATH.''.strtolower(THINK_MODE).'.php';
    }else{
        // 默认核心
        $list = include THINK_PATH.'Common/core.php';
    }
     // 加载兼容函数
    if(version_compare(PHP_VERSION,'5.2.0','<') )
        $list[]	= THINK_PATH.'Common/compat.php';

    // 生成编译文件
    $defs = get_defined_constants(TRUE);
    $content  = array_define($defs['user']);
    foreach ($list as $file){
        $content .= compile($file);
    }
    $content .= $append."\nC(".var_export(C(),true).');';
    $runtime = defined('THINK_MODE')?'~'.strtolower(THINK_MODE).'_runtime.php':'~runtime.php';
    $cache=  Tplcache::getInstance();
    $cache->set($runtime,strip_whitespace('<?php '.$content));//sae下生成核心缓存
}


?>