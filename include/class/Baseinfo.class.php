<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Baseinfo extends Base {
	//通用order deletion(mst & del)
	public static function deleteOrder($mst_id,$mst,$dtl) {
		$db=self::__instance();
		$mstwhere=array('id'=>$mst_id);
		$dtlwhere=array('mst_id'=>$mst_id);
		$mstid=$db->delete($mst,$mstwhere);
		$dtlid=$db->delete($dtl,$dtlwhere);
		if($mstid && $dtlid){
			return array('status' =>true);
		}else{
			return array('status' =>false,'msg'=>$db->error());
		}
	}

	public static function ProductMonthly($month,$product_id){
		$db=self::__instance();		
		/*$sql="SELECT '生产入库' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
				from work_in_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN workcenters f on f.id=a.workcenter_id
				where a.createday like '$month%' 
				and b.product_id=$product_id 
				union 
				SELECT '生产领料' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
				from draw_out_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN workcenters f on f.id=a.workcenter_id
				where a.createday like '$month%' 
				and b.product_id=$product_id 
				";*/	
		$array_sql=array();			
		$array_sql[]="SELECT '生产入库' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
			from work_in_mst a
			left join dtl b on a.id=b.mst_id				
			LEFT JOIN users c on c.user_id=a.op_id 
			LEFT JOIN locations d on a.loc_id=d.id
			LEFT JOIN location_bin e on b.bin_id=e.id
			LEFT JOIN workcenters f on f.id=a.workcenter_id
			where a.createday like '$month%' 
			and b.product_id=$product_id ";
		$array_sql[]="SELECT '生产领料' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
				from draw_out_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN workcenters f on f.id=a.workcenter_id
				where a.createday like '$month%' 
				and b.product_id=$product_id ";
		$array_sql[]="SELECT '销售出库' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.cust_name as units 
				from sale_out_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN customers f on f.id=a.cust_id
				where a.createday like '$month%' 
				and b.product_id=$product_id ";
			$array_sql[]="SELECT '采购入库' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
				from purchase_in_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN suppliers f on f.id=a.supplier_id
				where a.createday like '$month%' 
				and b.product_id=$product_id ";
			$array_sql[]="SELECT '外协出库' as type,a.createday,c.user_name,d.name as loc_name ,e.bin,b.qty,f.name as units 
				from os_out_mst a
				left join dtl b on a.id=b.mst_id				
				LEFT JOIN users c on c.user_id=a.op_id 
				LEFT JOIN locations d on a.loc_id=d.id
				LEFT JOIN location_bin e on b.bin_id=e.id
				LEFT JOIN os_units f on f.id=a.os_unit
				where a.createday like '$month%' 
				and b.product_id=$product_id ";
				 		
		$ans=array();		
		for($i=0;$i<count($array_sql);$i++){
			$list = $db->query($array_sql[$i])->fetchAll();
			if($list){
				$ans=array_merge($ans,$list);
			}

		}		
		return $ans;
		/*
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
		*/
	}

	public static function addNewProduct($product){
		$db=self::__instance();		
		$data=array(
			'product_id'=>$product['product_id'],
			'product_name'=>$product['product_name'],
			'gg'=>$product['gg'],
			'min_stock'=>$product['min_stock'],
			);
		
		$id=$db->insert('products',$data);
		if ($id) {			
			return $id;
		}
		return null;
	}

	public static function isProductDuplicate($product){
		$db=self::__instance();		
		$product_name=$product['product_name'];
		$sql="select id from products where product_name='$product_name'
			 and product_id='".$product['product_id']."' and gg='".$product['gg']."'";
		/*if ($product['product_id']){
			$sql.=" and product_id='".$product['product_id']."'";
		}
		if ($product['gg']){
			$sql.=" and gg='".$product['gg']."'";
		}	*/
			
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return array('status'=>true);
		}
		return array('status'=>false);
	}

	public static function getDtlById($id,$mst_table) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,b.product_id,b.gg,c.bin,d.qty as stock_qty,
			a.qty from dtl a 
			left join products b on a.product_id=b.id 
			left join location_bin c on c.id=a.bin_id
			left join stocks d on d.product_id=b.id and d.bin_id=a.bin_id 			
			where a.mst_id=".$id. " and a.mst_table='$mst_table'   
			order by b.id";		
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
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

	public static function getProducts4Select() {
		$db=self::__instance();
		$sql="select a.id,a.product_name as name,a.product_id,a.gg,
			c.bin     
			from products a left join stocks b on a.id=b.product_id 
			left join location_bin c on c.id=b.bin_id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {		
			$db=array();	
			for($i=0;$i<count($list);$i++){
				$db[]['id']=$list[$i]['id'];
				$db[$i]['name']='';
				for($j=1;$j<count($list[$i]);$j++){
					$tmp=($list[$i][$j]==null)?'':'|'.$list[$i][$j];
					$db[$i]['name'].=$tmp;
				}
			}
			return $db;
		}
		return array ();
	}

	public static function getProducts() {
		$db=self::__instance();
		$sql="select a.id,a.product_name as name,a.product_id,a.gg,
			a.min_stock,b.qty,c.bin,d.name as loc_name,d.id as loc_id   
			from products a left join stocks b on a.id=b.product_id 
			left join location_bin c on c.id=b.bin_id 
			left join locations d on c.loc_id=d.id";
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
				'bin_id'=>$dtl_data[$i]['bin_id'],
				'mst_id'=>$mst_id,
				'mst_table'=>$mst_table);
			
			$id=$db->insert('dtl',$data);
			//return $id;
			if($id){				
				$status=true;
				if ($loc_id!=null){//$loc_id==null表示无需更新stock
					Stock::updateStock($dtl_data[$i]['product_id'],((int)$dtl_data[$i]['qty'])*$flag,$loc_id,$dtl_data[$i]['bin_id']);
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
