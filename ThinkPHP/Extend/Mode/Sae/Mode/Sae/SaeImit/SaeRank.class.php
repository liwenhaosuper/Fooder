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
// $Id: SaeRank.class.php 2504 2011-12-28 07:35:29Z liu21st $
class SaeRank extends SaeObject{
	public function __construct(){
	parent::__construct();
	}
	public function clear($namespace){
		if($this->emptyName($namespace)) return false;
		M("SaeRank")->where("namespace='$namespace'")->delete();
		M("SaeRankList")->where("namespace='$namespace'")->delete();
		return true;
	}
	//创建
	//expire过期时间的单位为分钟
	public function create($namespace,$number,$expire=0){
		//判断是否存在
		if(!$this->emptyName($namespace)){
			$this->errno=-10;
			$this->errmsg=L("_SAE_THE_RANK_IS_EXISTED_");
			return false;
		}
		$setarr=array(
		'namespace'=>$namespace,
		'num'=>$number,
		'expire'=>$expire,
		'createtime'=>time()
		);
		$ret=M("SaeRank")->add($setarr);
		if($ret===false){
			$this->errno=-6;
			$this->errmsg=L("_SAE_ERR_");
			return false;
		}else{
		return true;
		}
	
	}
	//减去
	public function decrease($namespace,$key,$value,$renkReurn=false){
		if($this->emptyName($namespace)) return false;
		$this->check($namespace);
		if(M("SaeRankList")->where("namespace='$namespace' and k='$key'")->count()==0){
			//如果不存在
			$this->errno=-3;
			$this->errmsg=L("_SAE_NOT_IN_BILLBOARD_");
			return false;
		}else{
			$ret=M("SaeRankList")->where("namespace='$namespace' and k='$key'")->setField("v",array("exp","v-".$value));
			if($ret===false) return false;
			if(rankReturn){
			return $this->getRank($namespace,$key);
			}
			return true;
		}
	}
	//删除键
	public function delete($namespace,$key,$rankReturn=false){
		if($this->emptyName($namespace)) return false;
		if($rankReturn) $r=$this->getRank($namespace,$key);
		$ret=M("SaeRankList")->where("namespace='$namespace' and k='$key'")->delete();
		if($ret===false){
			$this->errno=-6;
			$this->errmsg=L("_SAE_ERR_");
			return false;
		}else{
			if($rankReturn) return $r;
			return true;
		}
	}
	//获得排行榜
	public function getList($namespace,$order=false,$offsetFrom=0,$offsetTo=PHP_INT_MAX){
		//判断是否存在
		if($this->emptyName($namespace)) return false;
		//获得列表
		if($order) $ord="v desc";
		//判断是否有长度限制
		$num=M("SaeRank")->where("namespace='$namespace'")->getField("num");
		if($num!=0){
		$ord="v desc";//todu，完善和sae数据一致。
		if($offsetTo>$num) $offsetTo=$num;
		}
		$ret=M("SaeRankList")->where("namespace='$namespace'")->order($ord)->limit("$offsetFrom,$offsetTo")->getField("k,v");
		$this->check($namespace);//检查过期
		if($ret===false){
			$this->errno=-6;
			$this->errmsg=L("_SAE_ERR_");
			return false;
		}else{
		return $ret;
		}
	}
	//获得某个键的排名
	//注意排名是从0开始的
	public function getRank($namespace,$key){
		if($this->emptyName($namespace)) return false;
		$v=M("SaeRankList")->where("namespace='$namespace' and k='$key'")->getField("v");
		$ret=M("SaeRankList")->where("namespace='$namespace' and v>=$v")->count();
		if(!$ret){
		$this->errno=-3;
		$this->errmsg=L("_SAE_NOT_IN_BILLBOARD_");	
		return false;
		}
		return $ret-1;
	}
	//增加值
	public function increase($namespace,$key,$value,$rankReturn=false){
		if($this->emptyName($namespace)) return false;
		$this->check($namespace);
		if(M("SaeRankList")->where("namespace='$namespace' and k='$key'")->count()==0){
			//如果不存在
			$this->errno=-3;
			$this->errmsg=L("_SAE_NOT_IN_BILLBOARD_");
			return false;
		}else{
			$ret=M("SaeRankList")->where("namespace='$namespace' and k='$key'")->setField("v",array("exp","v+".$value));
			if($ret===false) return false;
			if(rankReturn){
			return $this->getRank($namespace,$key);
			}
			return true;
		}
	}
	//设置值
	public function set($namespace,$key,$value,$rankReturn=false){
		//判断是否存在
		if($this->emptyName($namespace)) return false;
		//检查是否过期
		$this->check($namespace);
		//设置值
		//判断是否有此key
		if(M("SaeRankList")->where("namespace='$namespace' and k='$key'")->count()==0){
			$setarr=array(
			'namespace'=>$namespace,
			'k'=>$key,
			'v'=>$value
			);
			$ret=M("SaeRankList")->add($setarr);
		}else{
		$ret=M("SaeRankList")->where("namespace='$namespace' and k='$key'")->setField('v',$value);
		}
	   if($ret===false) return false;
		if($rankReturn){
			//返回排名
			return $this->getRank($namespace,$key);
		}
		return true;
	}
	//判断是否为空
	private function emptyName($name){
		$num=M("SaeRank")->where("namespace='$name'")->count();
		if($num==0){
		return true;
		}else{
		$this->errno=-4;
		$this->errmsg=L("_SAE_BILLBOARD_NOT_EXISTS_");
		return false;
		}
	}
	//检查是否过期
	private function check($name){
		$data=M("SaeRank")->getByNamespace($name);
		if($data['expire'] && $data['createtime']+$data['expire']*60<=time()){
		M("SaeRankList")->where("namespace='$name'")->delete();
		//重新设置创建时间
		M("SaeRank")->where("namespace='$name'")->setField("createtime",time());
		}
		}
		
	}



?>