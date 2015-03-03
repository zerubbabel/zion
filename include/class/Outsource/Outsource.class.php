<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Outsource extends Base {

	public static function insertOsMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'os_unit'=>$mst_data['os_unit'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('os_order_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'os order mst fail!';
		}
		return $ans;
	}	

	public static function insertOsOrder($mst_data,$dtl_data) {
		$db=self::__instance();		
		$ans=array();		
		$result=Outsource::insertOsMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Baseinfo::insertDtl($dtl_data,'os_order',$mst_id,null);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true					
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Baseinfo::deleteMst($mst_id,'os_order_mst');//删除主表
				$ans['status']=false;
				$ans['msg']='操作失败！';
			}
		}
		else{
			$ans['msg']=$result['msg'];
			$ans['status']=false;
		}			
		return $ans;
	}

}
