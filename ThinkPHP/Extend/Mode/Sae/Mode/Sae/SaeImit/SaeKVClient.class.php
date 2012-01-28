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
// $Id: SaeKVClient.class.php 2504 2011-12-28 07:35:29Z liu21st $
/**
*KVDB模拟器
*使用到数据库表think_sae_kv
*/
class SaeKvClient extends SaeObject{

public function delete($key){
	$ret=M("SaeKv")->where("k='$key'")->delete();
	return $ret?true:false;
}

public function get($key){
	$data=M("SaeKv")->where("k='$key'")->find();
	$value=$this->output(array($data));
	$ret=$value[$key];
	return $ret?$ret:false;
}
public function get_info(){
//todu
}
public function init(){
	return true;
}
public function mget($ary){
	if(empty($ary)) return null;
	$map['k']=array('in',$ary);
	$data=M("SaeKv")->where($map)->select();
	return $this->output($data);
}
public function pkrget($prefix_key,$count,$start_key){
//todu
}
public function set($key,$value){
	if(!is_string($value)){
		//如果不是字符串序列化
		$value=serialize($value);
		$isobj=1;
	}else{
		$isobj=0;
	}
	//判断是否存在键
	if(M("SaeKv")->where("k='$key'")->count()>0){
		$ret=M("SaeKv")->where("k='$key'")->save(array(
		'v'=>$value,
		'isobj'=>$isobj
		));
	}else{
		$ret=M("SaeKv")->add(array(
		'k'=>$key,
		'v'=>$value,
		'isobj'=>$isobj
		));
	}
	return $ret?true:false;
}

private function output($arr){
	$ret=array();
	foreach($arr as $k=>$ary){
		$ret[$ary['k']]=$ary['isobj']?unserialize($ary['v']):$ary['v'];
	}
	return $ret;
}

}


?>