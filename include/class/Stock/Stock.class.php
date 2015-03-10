<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Stock extends Base {

	public static function getStockById($loc_id,$product_id) {
		$db=self::__instance();
		$sql="select qty from stocks where loc_id=$loc_id and product_id=$product_id";
		$list=$db->query($sql)->fetchAll();
		if($list){
			return $list[0];
		}
		return array(0);//无库存返回0
	}
	
	public static function getStocks($loc_id) {
		$db=self::__instance();
		$sql="select b.id,b.product_name as name,qty,b.min_stock from stocks a
			LEFT JOIN products b on a.product_id=b.id 
			where loc_id=$loc_id
			order by b.id";	
			
		$list=$db->query($sql)->fetchAll();
		if($list){
			return $list;
		}
		return array();
	}

	public static function checkStock($dtl_data,$loc_id) {
		$ans=array();
		$error_indexs=array();
		$status=true;
		$j=0;
		for($i=0;$i<count($dtl_data);$i++){
			$stock_qty=Stock::getStockById($loc_id,$dtl_data[$i]['product_id']);
			
			if (((int)$stock_qty['qty'])<((int)$dtl_data[$i]['qty'])){
				$status=false;
				$error_indexs[$j]=$i;
				$j++;
			}
		}
		$ans['error_indexs']=$error_indexs;
		$ans['status']=$status;
		return $ans;
	}
	/*
	public static function updateStock($product_id,$qty,$loc_id) {
		$db=self::__instance();
		$data=array('qty[-]'=>$qty);
		$where=array('AND'=>array('product_id'=>$product_id,'loc_id'=>$loc_id));
		$id=$db->update('stocks',$data,$where);
		if($id){
			return array('status'=>true);
		}else{
			return array('status'=>false,'msg'=>$db->error());
		}		
	}*/

	public static function updateStock($product_id,$qty,$loc_id) {
		$db=self::__instance();
		$where=array('AND'=>array('product_id'=>$product_id,'loc_id'=>$loc_id));
		$result=$db->has('stocks',$where);
		if ($result){
			$data=array('qty[+]'=>$qty);
			$id=$db->update('stocks',$data,$where);
			if($id){
				return array('status'=>true);
			}else{
				return array('status'=>false,'msg'=>$db->error());
			}
		}	
		else{
			$data=array('qty'=>$qty,'product_id'=>$product_id,'loc_id'=>$loc_id);		
			$id=$db->insert('stocks',$data);
			if($id){
				return array('status'=>true);
			}else{
				return array('status'=>false,'msg'=>$db->error());
			}
		}	
	}

}
