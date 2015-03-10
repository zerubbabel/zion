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
			'deliveryday'=>$mst_data['deliveryday'],
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


	public static function insertOsOutMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'os_unit'=>$mst_data['os_unit'],
			'loc_id'=>$mst_data['loc_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('os_out_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'os out mst fail!';
		}
		return $ans;
	}

	public static function insertOsOutOrder($mst_data,$dtl_data) {
		$db=self::__instance();		
		$ans=array();		
		$result=Stock::checkStock($dtl_data,$mst_data['loc_id']);//检查库存情况
		if ($result['status']){
			$result=Outsource::insertOsOutMst($mst_data);//插入主表
			if($result['status']){
				$mst_id=$result['id'];
				$result=Baseinfo::insertDtl($dtl_data,'os_out',$mst_id,$mst_data['loc_id'],-1);//插入明细表并更新库存
				if($result['status']){//明细表有一条成功status就为true					
					$ans['status']=true;
					$ans['msg']='操作成功！';
				}else{
					Baseinfo::deleteMst($mst_id,'os_out_mst');//删除主表
					$ans['status']=false;
					$ans['msg']='操作失败！';
				}
			}
			else{
				$ans['msg']=$result['msg'];
				$ans['status']=false;
			}				
		}	
		else{//库存不足
			$ans['msg']='';
			for ($i=0;$i<count($result['error_indexs']);$i++){
				$product_id=$dtl_data[$result['error_indexs'][$i]]['product_id'];			
				$product_name=Baseinfo::getProductById($product_id)['name'];		
				$ans['msg'].=$product_name.',';
			}
			$ans['msg'].='库存不足！';
			$ans['status']=false;
		}
		return $ans;
	}

	public static function getAllOsOrderMst($filter='') {
		$db=self::__instance();
		$sql="select a.id,a.os_unit,a.createday,a.op_id,b.name as os_unit_name,c.user_name,
			a.deliveryday,d.name as status from os_order_mst a 
			left join os_units b on a.os_unit=b.id 
			left join users c on a.op_id=c.user_id  
			left join order_status d on a.status=d.id 
			".$filter." order by a.deliveryday,a.createday desc";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
	public static function getPassedOsOrderMst() {
		$filter=' where a.status=3 ';
		return self::getAllOsOrderMst($filter);
	}

	public static function updateOsOrderById($id,$deliveryday,$status) {
		$db=self::__instance();
		$data=array('deliveryday'=>$deliveryday,'status'=>$status);
		$where=array('id'=>$id);
		$result = $db->update('os_order_mst',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function getOsOrderDtlById($id) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,qty from dtl a 
			left join products b on a.product_id=b.id 
			where a.mst_id=".$id. " and a.mst_table='os_order' 
			order by b.id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getOsOrderMstById($id) {
		$db=self::__instance();
		$sql="select a.id,a.os_unit,a.createday,a.op_id,
			b.name as os_unit_name,c.user_name 
			from os_order_mst a 
			left join os_units b on a.os_unit=b.id 
			left join users c on a.op_id=c.user_id  
			where a.id=$id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list[0];
		}
		return array ();
	}

	public static function getOsOutAllByOsOrderId($id) {
		$db=self::__instance();
		
		$sql="select a.product_id as id,sum(qty) as qty from dtl a 
			LEFT JOIN os_out_mst b on a.mst_id=b.id		
			where b.os_order_mst_id=$id and a.mst_table='os_out' 
			GROUP BY product_id 
			order by a.product_id";	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
}

