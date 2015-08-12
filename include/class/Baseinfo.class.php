<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Baseinfo extends Base {
	
	//列表 
	public static function getModules() {
		$db=self::__instance();
		$sql="select module_id as id,module_name as name from modules";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getPagesById($module_id) {
		$db=self::__instance();
		$sql="select id,page_name as name from pages  
			where module_id='$module_id'
			order by id";
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getPrivilege($group_id) {
		$db=self::__instance();
		$sql="select page_id as id from access  
			where group_id=$group_id";
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function updatePrivilege($group_id,$data) {
		$db=self::__instance();
		$ans=array('status'=>true,'msg'=>'更新成功！');
		$db->delete('access',array('group_id'=>$group_id));//先删除
		
		for($i=0;$i<count($data);$i++){
			$row=array('group_id'=>$group_id,'page_id'=>$data[$i]);
			$result=$db->insert('access',$row);			
			if ($result>0){
				continue;
			}else{
				$ans['status']=false;
				$ans['msg']='更新失败！';
				return $ans;

			}
		}		
		return $ans;
	}

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
		$where=array('status'=>1,'ORDER'=>'id');
		$list = $db->select($table,$cols,$where);
		//$list = $db->select($table,$cols);
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getProducts() {
		$db=self::__instance();
		$sql="select id,product_name as name from products";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getBins($loc="") {
		$db=self::__instance();
		$sql="select a.id,a.bin as name,a.loc_id,b.name as loc_name 
			from location_bin a left join locations b on a.loc_id=b.id";
		if ($loc!=""){
			$sql.=" where a.loc_id=$loc";

		}	
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
		$sql="select id,product_name as name,min_stock from products where id=$id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list[0];
		}
		return array ();
	}


	
	//通用的insert into dtl
	//$flag为入库出库标记1为入库,-1为出库，帮助更新库存数量
	public static function insertDtl($dtl_data,$mst_table,$mst_id,$loc_id=null,$flag=1) {
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
					Stock::updateStock($dtl_data[$i]['product_id'],((int)$dtl_data[$i]['qty'])*$flag,$loc_id);
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

	public static function updateMinStock($id,$min_stock) {
		$db=self::__instance();
		$ans=array('status'=>false,'msg'=>'更新失败！');
		$data=array('min_stock'=>$min_stock);
		$where=array('id'=>$id);
		$result=$db->update('products',$data,$where);
		if($result && $result>0){
			$ans=array('status'=>true,'msg'=>'更新成功！');
		}
		return $ans;
	}

	public static function getStatus() {		
		$result=Baseinfo::getSelect('order_status');
		if($result){
			return $result;
		}
		return false;
	}
	public static function saveBom($product_id,$dtl_data) {	
		//todo 防止出现父件与子件一样的情况
		$db=self::__instance();
		$ans=array('status'=>true,'msg'=>'操作成功！');
		$where=array('product_id'=>$product_id);
		$db->delete('bom',$where);
		
		for($i=0;$i<count($dtl_data);$i++){
			$data=array('product_id'=>$product_id,'sub_id'=>$dtl_data[$i]['sub_id'],'qty'=>$dtl_data[$i]['qty']);
			$id=$db->insert('bom',$data);
			if(!$id){
				return array('status'=>false,'msg'=>'操作失败！');continue;
			}
		}
		return $ans;
	}

	public static function getSubpart($id){
		$db=self::__instance();
		$sql='select b.id,b.product_name as name,a.qty from bom a
			LEFT JOIN products b on a.sub_id=b.id 
			where a.product_id='.$id;
		$data = $db->query($sql)->fetchAll();
		return $data;
	}
}
