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
// $Id: SaeCounter.class.php 2504 2011-12-28 07:35:29Z liu21st $
/**
*SaeCounter模拟器
*使用了数据库存储统计器信息，
*相关数据表：think_sae_counter
*/
class SaeCounter extends SaeObject{
	//创建统计器
	public function create($name,$value=0){
		//判断是否存在
		if($this->exists($name)) return false;
		$setarr=array(
		'name'=>$name,
		'val'=>$value
		);
		if(M("SaeCounter")->add($setarr)){
			return true;
		}
	}
	//减法
	public function decr($name,$value=1){
		if(!$this->exists($name)) return false;
		M("SaeCounter")->where("name='$name'")->setField('val',array('exp','val-'.$value));
		return M("SaeCounter")->where("name='$name'")->getField("val");
	}
	//是否存在
	public function exists($name){
		$num=M("SaeCounter")->where("name='$name'")->count();
		return $num!=0?true:false;
	}
	public function get($name){
		if(!$this->exists($name)) return false;
		return M("SaeCounter")->where("name='$name'")->getField("val");
	}
	public function getall(){
		return M("SaeCounter")->getField("name,val");
	}
	//加法
	public function incr($name,$value=1){
		if(!$this->exists($name)) return false;
		M("SaeCounter")->where("name='$name'")->setField('val',array('exp','val+'.$value));
		return M("SaeCounter")->where("name='$name'")->getField("val");
	}
	public function length(){
		return M("SaeCounter")->count();
	}
	//获得多个统计器，names为数组
	public function mget($names){
		$where=array(
		'name'=>array('in',$names)
		);
		return M("SaeCounter")->where($where)->getField("name,val");
	}
	public function remove($name){
		if(!$this->exists($name)) return false;
		return M("SaeCounter")->where("name='$name'")->delete();
	}
	//设置值
	public function set($name,$value){
		return M("SaeCounter")->where("name='$name'")->setField('val',$value);
	}
}


?>