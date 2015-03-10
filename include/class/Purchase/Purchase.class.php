<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Purchase extends Base {

	public static function getSuppliers() {
		$db=self::__instance();
		$sql='select a.id,a.name as supplier_name,a.type_id,b.name as type_name from suppliers a 
			left join cust_types b on a.type_id=b.id 
			where a.status=1';
		$result = $db->query($sql)->fetchAll();
		if($result){
			return $result;
		}
		return false;
	}

	public static function addSupplier($supplier_name,$type_id) {
		$db=self::__instance();
		$data=array('name'=>$supplier_name,'type_id'=>$type_id);
		$result = $db->insert('suppliers',$data);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}


	public static function updateSupplier($id,$supplier_name,$type_id) {
		$db=self::__instance();
		$data=array('name'=>$supplier_name,'type_id'=>$type_id);
		$where=array('id'=>$id);
		$result = $db->update('suppliers',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function stopSupplier($id) {
		$db=self::__instance();
		$data=array('status'=>0);	
		$where=array('id'=>$id);
		$result = $db->update('suppliers',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function insertPurchaseMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'supplier_id'=>$mst_data['supplier_id'],
			'createday'=>$createday,
			'deliveryday'=>$mst_data['deliveryday'],
			'sale_order_mst_id'=>$mst_data['sale_order_mst_id'],
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('purchase_order_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'purchase order mst fail!';
		}
		return $ans;
	}	

	public static function insertPurchaseOrder($mst_data,$dtl_data) {
		$db=self::__instance();		
		$ans=array();		
		$result=Purchase::insertPurchaseMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Baseinfo::insertDtl($dtl_data,'purchase_order',$mst_id,null);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true					
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Baseinfo::deleteMst($mst_id,'purchase_order_mst');//删除主表
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

	public static function getAllPurchaseOrderMst($filter='') {
		$db=self::__instance();		
		$sql='select a.id,a.deliveryday,d.name as status,a.createday,b.user_name, 
			c.name as supplier_name  
			from purchase_order_mst a 
			left join users b on a.op_id=b.user_id 
			left join suppliers c on a.supplier_id=c.id  
			left join order_status d on a.status=d.id 
			'.$filter.'order by a.deliveryday,a.createday desc' ;	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array();
	}

	public static function getPassedPurchaseOrder() {
		$db=self::__instance();		
		$filter=' where a.status=3 ';
		return self::getAllPurchaseOrderMst($filter);
	}

	public static function updatePurchaseOrderById($id,$deliveryday,$status) {
		$db=self::__instance();
		$data=array('deliveryday'=>$deliveryday,'status'=>$status);
		$where=array('id'=>$id);
		$result = $db->update('purchase_order_mst',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function getPurchaseOrderDtlById($id) {
		$db=self::__instance();
		
		$sql="select b.id,b.product_name,qty from dtl a 
			left join products b on a.product_id=b.id 
			where a.mst_id=".$id. " and a.mst_table='purchase_order' 
			order by b.id";
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getPurchaseOrderMstById($id) {
		$db=self::__instance();
		$sql="select a.id,a.supplier_id,a.createday,a.op_id,
			b.name as supplier_name,c.user_name 
			from purchase_order_mst a 
			left join suppliers b on a.supplier_id=b.id 
			left join users c on a.op_id=c.user_id  
			where a.id=$id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list[0];
		}
		return array ();
	}

	public static function getPurchaseInAllByPurchaseOrderId($id) {
		$db=self::__instance();
		
		$sql="select a.product_id as id,sum(qty) as qty from dtl a 
			LEFT JOIN purchase_in_mst b on a.mst_id=b.id		
			where b.purchase_order_mst_id=$id and a.mst_table='purchase_in' 
			GROUP BY product_id 
			order by a.product_id";	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function insertPurchaseInMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array('purchase_order_mst_id'=>$mst_data['purchase_order_mst_id'],
			'loc_id'=>$mst_data['loc_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('purchase_in_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'purchae in mst fail!';
		}
		return $ans;
	}


	public static function updatePurchaseOrderStatus($mst_id) {
		//todo
	}
	public static function insertPurchaseInOrder($mst_data,$dtl_data) {
		$db=self::__instance();
		$ans=array();
		
		$result=Purchase::insertPurchaseInMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Baseinfo::insertDtl($dtl_data,'purchase_in',$mst_id,$mst_data['loc_id']);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true
				Purchase::updatePurchaseOrderStatus($mst_id);//判断并更新销售单状态为完成
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Baseinfo::deleteMst($mst_id,'purchase_in_mst');//删除主表
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
