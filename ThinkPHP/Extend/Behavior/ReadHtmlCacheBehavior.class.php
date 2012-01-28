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
// $Id: ReadHtmlCacheBehavior.class.php 2616 2012-01-16 08:36:46Z liu21st $

/**
 +------------------------------------------------------------------------------
 * 系统行为扩展 静态缓存读取
 * 增加配置参数如下：
 *  HTML_CACHE_ON
 *
 +------------------------------------------------------------------------------
 */
class ReadHtmlCacheBehavior extends Behavior {
    protected $options   =  array(
            'HTML_CACHE_ON'=>true,
        );
    // 行为扩展的执行入口必须是run
    public function run(&$params){
        // 开启静态缓存
        if(C('HTML_CACHE_ON'))  {
            import('ORG.Util.HtmlCache');
            HtmlCache::readHTMLCache();
        }
    }
}