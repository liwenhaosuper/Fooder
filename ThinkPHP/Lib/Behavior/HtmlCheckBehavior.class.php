<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: HtmlCheckBehavior.class.php 2544 2012-01-05 01:30:15Z tdweb2u@gmail.com $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 静态缓存URL检测
 +------------------------------------------------------------------------------
 */
class HtmlCheckBehavior extends Behavior {
    protected $options   =  array(
            'HTML_CACHE_ON'    => false, // 开启静态缓存
            'HTML_FILE_SUFFIX' => '.shtml', // 静态URL后缀
            'HTML_CACHE_TIME' => 60,   // 静态缓存有效期 秒 仅在动态访问有效
        );
    public function run(&$params) {
        if(C('HTML_CACHE_ON')) {
            // 检测静态规则  '模块:操作'=>array('缓存有效期','缓存方法')
            $rules   =  C('HTML_CACHE_RULES');
            if(isset($rules[MODULE_NAME.':'.ACTION_NAME])) {
                $htmlRule   =  $rules[MODULE_NAME.':'.ACTION_NAME];
            }elseif(isset($rules[MODULE_NAME.':'])) {
                $htmlRule   =  $rules[MODULE_NAME.':'];
            }elseif(isset($rules[ACTION_NAME])) {
                $htmlRule   =  $rules[ACTION_NAME];
            }elseif(isset($rules['*'])) {
                $htmlRule   =  $rules['*'];
            }

            if(isset($htmlRule)) {
                // 获取缓存数据
                $value   =  S(md5($_SERVER['REQUEST_URI']));
                if($value) {
                    echo $value;
                    exit;
                }else{
                    C('think_html_rule',$htmlRule);
                }
            }
        }
    }
}