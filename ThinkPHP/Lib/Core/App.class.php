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
// $Id: App.class.php 2587 2012-01-13 16:04:28Z zuojiazi.cn@gmail.com $

/**
 +------------------------------------------------------------------------------
 * ThinkPHP 应用程序类 执行应用过程管理
 * 可以在模式扩展中重新定义 但是必须具有Run方法接口
 +------------------------------------------------------------------------------
 * @category   Think
 * @package  Think
 * @subpackage  Core
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: App.class.php 2587 2012-01-13 16:04:28Z zuojiazi.cn@gmail.com $
 +------------------------------------------------------------------------------
 */
class App {

    /**
     +----------------------------------------------------------
     * 应用程序初始化
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function init() {

        // 设置系统时区
        date_default_timezone_set(C('DEFAULT_TIMEZONE'));
        // 加载动态项目公共文件和配置
        load_ext_file();
        // URL调度
        Dispatcher::dispatch();

        if(defined('GROUP_NAME')) {
            // 加载分组配置文件
            if(is_file(CONF_PATH.GROUP_NAME.'/config.php'))
                C(include CONF_PATH.GROUP_NAME.'/config.php');
            // 加载分组函数文件
            if(is_file(COMMON_PATH.GROUP_NAME.'/function.php'))
                include COMMON_PATH.GROUP_NAME.'/function.php';
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 执行应用程序
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws ThinkExecption
     +----------------------------------------------------------
     */
    static public function exec() {
        // 安全检测
        if(!preg_match('/^[A-Za-z_0-9]+$/',MODULE_NAME)){
            throw_exception(L('_MODULE_NOT_EXIST_'));
        }
        //创建Action控制器实例
        $group =  defined('GROUP_NAME') ? GROUP_NAME.'/' : '';
        $module  =  A($group.MODULE_NAME);
        if(!$module) {
            if(function_exists('__hack_module')) {
                // hack 方式定义扩展模块 返回Action对象
                $module = __hack_module();
                if(!is_object($module)) {
                    // 不再继续执行 直接返回
                    return ;
                }
            }else{
                // 是否定义Empty模块
                $module = A("Empty");
                if(!$module){
                    $msg =  L('_MODULE_NOT_EXIST_').MODULE_NAME;
                    if(APP_DEBUG) {
                        // 模块不存在 抛出异常
                        throw_exception($msg);
                    }else{
                        if(C('LOG_EXCEPTION_RECORD')) Log::write($msg);
                        send_http_status(404);
                        exit;
                    }
                }
            }
        }
        //获取当前操作名
        $action = ACTION_NAME;
        if (method_exists($module,'_before_'.$action)) {
            // 执行前置操作
            call_user_func(array(&$module,'_before_'.$action));
        }
        //执行当前操作
        call_user_func(array(&$module,$action));
        if (method_exists($module,'_after_'.$action)) {
            //  执行后缀操作
            call_user_func(array(&$module,'_after_'.$action));
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 运行应用实例 入口文件使用的快捷方法
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    static public function run() {
        // 项目初始化标签
        tag('app_init');
        App::init();
        // 项目开始标签
        tag('app_begin');
         // Session初始化 支持其他客户端
        if(isset($_REQUEST[C("VAR_SESSION_ID")]))
            session_id($_REQUEST[C("VAR_SESSION_ID")]);
        if(C('SESSION_AUTO_START'))  session_start();
        // 记录应用初始化时间
        if(C('SHOW_RUN_TIME')) G('initTime');
        App::exec();
        // 项目结束标签
        tag('app_end');
        // 保存日志记录
        if(C('LOG_RECORD')) Log::save();
        return ;
    }

}