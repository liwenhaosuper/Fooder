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
// $Id: SaeObject.class.php 2504 2011-12-28 07:35:29Z liu21st $
class SaeObject extends Think {
    protected $errno=SAE_Success;
    protected $errmsg;
    //实现自动建表
    public function __construct() {
    	static $inited=false;
    	//只初始化一次
    	if($inited) return;
    	//载入语言包
    	L(include(MODE_PATH.'Sae/SaeImit/Lang.php'));
    	$this->errmsg=L("_SAE_OK_");
        if (C("DB_NAME") == '') {
            //如果没有配置数据库，抛出异常
            throw_exception(L('_SAE_DATABASE_NOT_EXIST_'));
        }
        if (!defined(SAE_AUTO_CREATE))
            define(SAE_AUTO_CREATE, true);
        //如果入口文件定义了SAE_AUTO_CREATE常量为false时，将不自动建表
        if (SAE_AUTO_CREATE) {
            //自动建表
            $sql = <<<SQL
-- ----------------------------
-- sae_counter表，用于模拟SaeCounter
-- ----------------------------
CREATE TABLE IF NOT EXISTS `think_sae_counter_suf` (
  `name` varchar(255) DEFAULT NULL,
  `val` varchar(255) DEFAULT NULL,
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;
-- ----------------------------
-- sae_kv表，用于模拟KVDB
-- ----------------------------
CREATE TABLE IF NOT EXISTS `think_sae_kv` (
  `k` varchar(30) DEFAULT NULL,
  `v` text,
  `isobj` int(11) DEFAULT '0',
  UNIQUE KEY `k` (`k`)
) TYPE=MyISAM;
-- ----------------------------
-- sae_rank表，用于模拟SaeRank
-- ----------------------------
CREATE TABLE IF NOT EXISTS `think_sae_rank_suf` (
  `namespace` varchar(30) DEFAULT NULL,
  `num` int(11) DEFAULT '0',
  `expire` int(11) DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  KEY `namespace` (`namespace`)
) TYPE=MyISAM;
-- ----------------------------
-- sae_rank_list表，用于模拟SaeRank
-- ----------------------------
CREATE TABLE IF NOT EXISTS `think_sae_rank_list_suf` (
  `namespace` varchar(30) DEFAULT NULL,
  `k` varchar(30) DEFAULT NULL,
  `v` int(11) DEFAULT '0',
  KEY `namespace` (`namespace`,`k`)
) TYPE=MyISAM;
SQL;
            $this->runsql($sql);
        }
       $inited=true;
    }

    //获得错误代码
    public function errno() {
        return $this->errno;
    }

    //获得错误信息
    public function errmsg() {
        return $this->errmsg;
    }

    //运行sql语句
    protected function runsql($sql) {
        $tablepre = C('DB_PREFIX');
        $tablesuf = C('DB_SUFFIX');
        $dbcharset = C('DB_CHARSET');
        $sql = str_replace(array(' think_', ' `think_', '_suf'), array(' {tablepre}', ' `{tablepre}', '{tablesuf}'), $sql);
        $sql = str_replace("\r", "\n", str_replace(array(' {tablepre}', ' `{tablepre}', '{tablesuf}'), array(' ' . $tablepre, ' `' . $tablepre, $tablesuf), $sql));
        $ret = array();
        $num = 0;
        foreach (explode(";\n", trim($sql)) as $query) {
            $queries = explode("\n", trim($query));
            foreach ($queries as $query) {
                $ret[$num] .= $query[0] == '#' || $query[0] . $query[1] == '--' ? '' : $query;
            }
            $num++;
        }
        unset($sql);
        foreach ($ret as $query) {
            $query = trim($query);
            if ($query) {
                if (substr($query, 0, 12) == 'CREATE TABLE') {
                    $name = preg_replace("/CREATE TABLE ([a-z0-9_]+) .*/is", "\\1", $query);
                    $type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $query));
                    $type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
                    $query = preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $query) .
                            (mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=$dbcharset" : " TYPE=$type");
                }
                M()->query($query);
            }
        }
    }
    
public function setAuth($accesskey,$secretkey){

}

}

?>