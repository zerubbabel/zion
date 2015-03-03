<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Baseinfo extends Base {
	//列表 
	public static function getCust() {
		$db=self::__instance();
		$sql="select id,cust_name as name from customers";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	//通用select数据
	public static function getSelect($table) {
		$db=self::__instance();
		$cols=array('id','name');
		$list = $db->select($table,$cols);
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getproducts() {
		$db=self::__instance();
		$sql="select id,product_name as name from products";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getLoc() {
		$db=self::__instance();
		$sql="select id,name from locations";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getProductById($id) {
		$db=self::__instance();
		$sql="select * from products where id=$id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list[0];
		}
		return array ();
	}


	
	//通用的insert into dtl
	public static function insertDtl($dtl_data,$mst_table,$mst_id,$loc_id) {
		//明细表有一条成功status就为true全失败为false
		$ans=array();
		$status=false;
		$db=self::__instance();
		for($i=0;$i<count($dtl_data);$i++){
			$data=array('product_id'=>$dtl_data[$i]['product_id'],
				'qty'=>$dtl_data[$i]['qty'],
				'mst_id'=>$mst_id,
				'mst_table'=>$mst_table);
			$id=$db->insert('dtl',$data);
			if($id){				
				$status=true;
				if ($loc_id!=null){//$loc_id==null表示无需更新stock
					Stock::updateStock($dtl_data[$i]['product_id'],$dtl_data[$i]['qty'],$loc_id);
				}
			}else{
				$ans['msg']=$db->error();
			}

		}
		$ans['status']=$status;		
		return $ans;
	}

	//通用mst deletion
	public static function deleteMst($mst_id,$table) {
		$db=self::__instance();
		$where=array('id'=>$mst_id);
		$id=$db->delete($table,$where);
		if($id){
			return array('status' =>true);
		}else{
			return array('status' =>false,'msg'=>$db->error());
		}
	}
}
