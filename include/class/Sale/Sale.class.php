<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Sale extends Base {
	//列表 
	public static function getAllSaleOrderMst() {
		$db=self::__instance();
		$cols="sale_order_mst.id,cust_id,createday,op_id,cust_name,user_name";
		$sql="select $cols from sale_order_mst 
			left join customers on sale_order_mst.cust_id=customers.id 
			left join users on sale_order_mst.op_id=users.user_id 
			order by createday desc";
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
		
		$sql="select product_id,product_name,qty from sale_order_dtl 
			left join products on sale_order_dtl.product_id=products.id 
			where sale_order_dtl.mst_id=".$id." order by product_id";
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getSaleOutAllBySaleOrderId($id) {
		$db=self::__instance();
		
		$sql="select product_id,product_name,sum(qty) as out_qty from sale_out_dtl 
			left join products on sale_out_dtl.product_id=products.id 
			where sale_out_dtl.sale_order_mst_id=$id 
			GROUP BY sale_out_dtl.product_id 
			order by product_id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

}
