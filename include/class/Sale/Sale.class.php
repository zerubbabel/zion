<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Sale extends Base {
	//列表 
	public static function getCustTypes() {		
		$result=Baseinfo::getSelect('cust_types');
		if($result){
			return $result;
		}
		return false;
	}

	public static function getCustomers() {
		$db=self::__instance();
		$sql='select a.id,a.cust_name,a.type_id,b.name as type_name from customers a 
			left join cust_types b on a.type_id=b.id 
			where a.status=1';
		$result = $db->query($sql)->fetchAll();
		if($result){
			return $result;
		}
		return false;
	}


	public static function addCustomer($cust_name,$type_id) {
		$db=self::__instance();
		$data=array('cust_name'=>$cust_name,'type_id'=>$type_id);
		$result = $db->insert('customers',$data);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}


	public static function updateCustomer($id,$cust_name,$type_id) {
		$db=self::__instance();
		$data=array('cust_name'=>$cust_name,'type_id'=>$type_id);
		$where=array('id'=>$id);
		$result = $db->update('customers',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function stopCustomer($id) {
		$db=self::__instance();
		$data=array('status'=>0);	
		$where=array('id'=>$id);
		$result = $db->update('customers',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function getAllSaleOrderMst($filter='') {
		$db=self::__instance();
		$cols="sale_order_mst.id,cust_id,createday,op_id,cust_name,user_name,
			deliveryday,importance.name as importance,order_status.name as status";
		$sql="select $cols from sale_order_mst 
			left join customers on sale_order_mst.cust_id=customers.id 
			left join users on sale_order_mst.op_id=users.user_id 
			left join importance on sale_order_mst.importance=importance.id 
			left join order_status on sale_order_mst.status=order_status.id 
			".$filter." order by importance.value desc,deliveryday,createday desc";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
	public static function getPassedSaleOrder() {
		$filter='where sale_order_mst.status=3';
		return self::getAllSaleOrderMst($filter);
	}
	public static function getSaleOutList() {
		$db=self::__instance();
		
		/*$sql="select a.id,a.createday,c.user_name,d.cust_name,
			e.name as loc_name,a.sale_order_mst_id from sale_out_mst a
			LEFT JOIN sale_order_mst b on a.sale_order_mst_id=b.id
			left JOIN users c on a.op_id=c.user_id
			LEFT JOIN customers d on d.id=b.cust_id
			LEFT JOIN locations e on e.id=a.loc_id 
			order by a.createday desc";*/
		$sql="select a.id,a.createday,c.user_name,d.cust_name,
			e.name as loc_name  from sale_out_mst a
			left JOIN users c on a.op_id=c.user_id
			LEFT JOIN customers d on a.cust_id=d.id
			LEFT JOIN locations e on e.id=a.loc_id 
			order by a.createday desc";	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getSaleOutDtlById($id) {
		$db=self::__instance();
		
		$sql="select b.id,qty,b.product_id,b.gg,
			b.product_name from sale_out_dtl a
			LEFT JOIN products b on a.product_id=b.id
			where mst_id=$id
			ORDER BY b.id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getSaleOrderMstById($id) {
		$db=self::__instance();
		$cols="sale_order_mst.id,cust_id,createday,op_id,cust_name,user_name";
		$sql="select $cols from sale_order_mst 
			left join customers on sale_order_mst.cust_id=customers.id 
			left join users on sale_order_mst.op_id=users.user_id  
			where sale_order_mst.id=$id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list[0];
		}
		return array ();
	}

	
	public static function getSaleOrderDtlById($id) {
		$db=self::__instance();
		
		$sql="select b.id,b.product_id,b.product_name,b.gg,a.qty  
			from sale_order_dtl a 
			left join products b on a.product_id=b.id 
			where a.mst_id=$id order by b.id";
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getSaleOutAllBySaleOrderId($id) {
		$db=self::__instance();
		
		$sql="select a.product_id as id,sum(qty) as qty from sale_out_dtl a 
			LEFT JOIN sale_out_mst b on a.mst_id=b.id		
			where b.sale_order_mst_id=$id 
			GROUP BY product_id 
			order by a.product_id";	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function insertSaleOutMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array('sale_order_mst_id'=>$mst_data['sale_order_mst_id'],
			'loc_id'=>$mst_data['loc_id'],
			'cust_id'=>$mst_data['cust_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('sale_out_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'sale out mst fail!';
		}
		return $ans;
	}

	public static function insertSaleOutDtl($dtl_data,$mst_id,$loc_id) {
		//明细表有一条成功status就为true全失败为false
		$ans=array();
		$status=false;
		$db=self::__instance();
		for($i=0;$i<count($dtl_data);$i++){
			$data=array('product_id'=>$dtl_data[$i]['product_id'],
				'qty'=>$dtl_data[$i]['qty'],
				'mst_id'=>$mst_id,'bin_id'=>$dtl_data[$i]['bin_id']);
			$id=$db->insert('sale_out_dtl',$data);
			if($id){
				$status=true;
				Stock::updateStock($dtl_data[$i]['product_id'],((int)$dtl_data[$i]['qty'])*(-1),$loc_id,$dtl_data[$i]['bin_id']);
			}else{
				$ans['msg']=$db->error();
			}

		}
		$ans['status']=$status;
		return $ans;
	}
	/*
	public static function deleteSaleOutMst($mst_id) {
		$db=self::__instance();
		$where=array('id'=>$mst_id);
		$id=$db->delete('sale_out_mst',$where);
		if($id){
			return array('status' =>true);
		}else{
			return array('status' =>false,'msg'=>$db->error());
		}
	}*/


	public static function updateSaleOrderStatus($mst_id) {
		//todo

	}

	public static function insertSaleOutOrder($mst_data,$dtl_data) {
		$db=self::__instance();
		$result=Stock::checkStock($dtl_data,$mst_data['loc_id']);//检查库存情况
		$ans=array();
		if ($result['status']){
			$result=Sale::insertSaleOutMst($mst_data);//插入主表
			if($result['status']){
				$mst_id=$result['id'];
				$result=Sale::insertSaleOutDtl($dtl_data,$mst_id,$mst_data['loc_id']);//插入明细表并更新库存
				if($result['status']){//明细表有一条成功status就为true
					Sale::updateSaleOrderStatus($mst_id);//判断并更新销售单状态为完成
					$ans['status']=true;
					$ans['msg']='操作成功！';
				}else{
					//Sale::deleteSaleOutMst($mst_id);//删除主表
					Baseinfo::deleteMst($mst_id,'sale_out_mst');//删除主表
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

	public static function updateSaleOrderById($id,$deliveryday,$status) {
		$db=self::__instance();
		$data=array('deliveryday'=>$deliveryday,'status'=>$status);
		$where=array('id'=>$id);
		$result = $db->update('sale_order_mst',$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}


}
