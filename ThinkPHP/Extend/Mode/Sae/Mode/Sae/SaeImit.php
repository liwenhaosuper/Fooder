<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <www.3g4k.com>
// +----------------------------------------------------------------------
// $Id: SaeImit.php 2504 2011-12-28 07:35:29Z liu21st $
/**
 * 模拟了SAE特有常量。
 * 模拟了SAE特有函数。
 * 模拟了SAE特有类库。
 * 在使用之前，你需要先配置数据库的config信息，模拟器会为你自动建表
 */
//sea常量
// settings
define('SAE_FETCHURL_SERVICE_ADDRESS','http://fetchurl.sae.sina.com.cn');

// storage
define( 'SAE_STOREHOST', 'http://stor.sae.sina.com.cn/storageApi.php' );
define( 'SAE_S3HOST', 'http://s3.sae.sina.com.cn/s3Api.php' );

// saetmp constant
define( 'SAE_TMP_PATH' , '');


// define AccessKey and SecretKey
define( 'SAE_ACCESSKEY', '');
define( 'SAE_SECRETKEY', '');
//unset( $_SERVER['HTTP_ACCESSKEY'] );
//unset( $_SERVER['HTTP_SECRETKEY'] );

define( 'SAE_MYSQL_HOST_M', 'w.rdc.sae.sina.com.cn' );
define( 'SAE_MYSQL_HOST_S', 'r.rdc.sae.sina.com.cn' );
define( 'SAE_MYSQL_PORT', 3307 );
define( 'SAE_MYSQL_USER', '' );
define( 'SAE_MYSQL_PASS', '' );
define( 'SAE_MYSQL_DB', 'app_');

// gravity define
define("SAE_NorthWest", 1);
define("SAE_North", 2);
define("SAE_NorthEast",3);
define("SAE_East",6);
define("SAE_SouthEast",9);
define("SAE_South",8);
define("SAE_SouthWest",7);
define("SAE_West",4);
define("SAE_Static",10);
define("SAE_Center",5);

// font stretch
define("SAE_Undefined",0);
define("SAE_Normal",1);
define("SAE_UltraCondensed",2);
define("SAE_ExtraCondensed",3);
define("SAE_Condensed",4);
define("SAE_SemiCondensed",5);
define("SAE_SemiExpanded",6);
define("SAE_Expanded",7);
define("SAE_ExtraExpanded",8);
define("SAE_UltraExpanded",9);

// font style
define("SAE_Italic",2);
define("SAE_Oblique",3);

// font name
define("SAE_SimSun",1);
define("SAE_SimKai",2);
define("SAE_SimHei",3);
define("SAE_Arial",4);
define("SAE_MicroHei",5);

// anchor postion
define("SAE_TOP_LEFT","tl");
define("SAE_TOP_CENTER","tc");
define("SAE_TOP_RIGHT","tr");
define("SAE_CENTER_LEFT","cl");
define("SAE_CENTER_CENTER","cc");
define("SAE_CENTER_RIGHT","cr");
define("SAE_BOTTOM_LEFT","bl");
define("SAE_BOTTOM_CENTER","bc");
define("SAE_BOTTOM_RIGHT","br");

// errno define
define("SAE_Success", 0); // OK
define("SAE_ErrKey", 1); // invalid accesskey or secretkey
define("SAE_ErrForbidden", 2); // access fibidden for quota limit
define("SAE_ErrParameter", 3); // parameter not exist or invalid
define("SAE_ErrInternal", 500); // internal Error
define("SAE_ErrUnknown", 999); // unknown error

// fonts for gd
define("SAE_Font_Sun", "/usr/share/fonts/chinese/TrueType/uming.ttf");
define("SAE_Font_Kai", "/usr/share/fonts/chinese/TrueType/ukai.ttf");
define("SAE_Font_Hei", "/usr/share/fonts/chinese/TrueType/wqy-zenhei.ttc");
define("SAE_Font_MicroHei", "/usr/share/fonts/chinese/TrueType/wqy-microhei.ttc");
/**
 * 定义SAE类库别名。
 * 如果实例化这些类的时候类不存在时、自动导入对应的地址。
 */
alias_import(array(
    'SaeObject'=>MODE_PATH.'Sae/SaeImit/SaeObject.class.php',
    'SaeCounter'         => MODE_PATH.'Sae/SaeImit/SaeCounter.class.php',
    'SaeRank'=>MODE_PATH.'Sae/SaeImit/SaeRank.class.php',
    'SaeTaskQueue'=>MODE_PATH.'Sae/SaeImit/SaeTaskQueue.class.php',
    'SaeStorage'=>MODE_PATH.'Sae/SaeImit/SaeStorage.class.php',
    'SaeKVClient'=>MODE_PATH.'Sae/SaeImit/SaeKVClient.class.php',
    'Memcache'=>MODE_PATH.'Sae/SaeImit/Memcache.class.php',
    'CacheFile'=>THINK_PATH.'Lib/Think/Util/Cache/CacheFile.class.php',
	'SaeMail'=>MODE_PATH.'Sae/SaeImit/SaeMail.class.php'
    )
);
//以下是SAE专有函数。
function sae_debug($log){
	error_log(date("[c]")." ".$log."\r\n",3,LOG_PATH."/sae_debug.log");
	echo $log;
}
//初始化memcache
function memcache_init(){
	static $handler;
	if(is_object($handler)) return $handler;
    $handler=new Memcache;
    $handler->connect('127.0.0.1',11211);
    return $handler;
}


?>