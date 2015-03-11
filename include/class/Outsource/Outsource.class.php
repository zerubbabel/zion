<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Outsource extends Base {
	public static function getosTypes() {		
		$result=Baseinfo::getSelect('os_types');
		if($result){
			return $result;
		}
		return false;
	}

	public static function addOs_unit($name,$type_id){
		$db=self::__instance();
		$table='os_units';
		$data=array('name'=>$name,'type_id'=>$type_id);
		$result=$db->insert($table,$data);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}
	public static function stopOs_unit($id){
		$db=self::__instance();
		$table='os_units';
		$data=array('status'=>0);
		$where=array('id'=>$id);
		$result=$db->update($table,$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}
	public static function updateOs_unit($id,$name,$type_id){
		$db=self::__instance();
		$table='os_units';
		$data=array('name'=>$name,'type_id'=>$type_id);
		$where=array('id'=>$id);
		$result=$db->update($table,$data,$where);
		if($result && $result>0){
			return array('status'=>true);
		}
		return array('status'=>false);
	}
	public static function getOs_units(){
		$db=self::__instance();
		/*$table='os_units';
		$data=array('id','name');
		$result=$db->select($table,$data);*/
		$sql='select a.id,a.name,b.name as type_name from os_units a
			LEFT JOIN os_types b on a.type_id=b.id';
		$result=$db->query($sql)->fetchAll();
		return $result;		
	}
	public static function getOsInMst($id=null){
		$db=self::__instance();
		$sql='select a.id,a.createday,b.name as loc_name, 
			c.user_name,d.name as os_unit_name from os_in_mst a 
			LEFT JOIN locations b on a.loc_id=b.id 
			left join users c on a.op_id=c.user_id 
			left join os_units d on a.os_unit=d.id';
		if ($id!=null){
			$sql.=' where a.id='.$id;
		}	
		$result=$db->query($sql)->fetchAll();
		return $result;		
	}

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
			'os_order_mst_id'=>$mst_data['os_order_mst_id'],
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

	public static function getOsStocks($os_unit){
		$db=self::__instance();
		//$sql=''
		/*SELECT
	a.os_unit,a.product_name,a.id,a.qty as out_qty,b.qty as in_qty,(a.qty-b.qty) as left_qty 
FROM
	v_os_out_stocks a
LEFT JOIN v_os_in_stocks b ON a.os_unit = b.os_unit
AND a.id = b.id*/
		$table='v_os_out_stock';
		$cols=array('id','product_name','qty');
		$where=array();
		if ($os_unit){
			$where=array('os_unit'=>$os_unit);
		}
		$data=$db->select($table,$cols,$where);
		return $data;
	}

	public static function insertOsInMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'os_unit'=>$mst_data['os_unit'],
			'loc_id'=>$mst_data['loc_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('os_in_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'os out mst fail!';
		}
		return $ans;
	}

	public static function getOs_unitTypeInfo($os_unit){
		$db=self::__instance();
		$sql='select b.id,b.name from os_units a 
		left join os_types b on a.type_id=b.id 
		where a.id='.$os_unit;
		$result=$db->query($sql)->fetchAll();
		if ($result){
			return $result[0];
		}
		else{
			return false;
		}
	}
	public static function getProductByOscode($os_code){
		$db=self::__instance();
		$where=array('os_code'=>$os_code);
		$table='products';
		$cols=array('id');
		$result=$db->select($table,$cols,$where);		
		if($result){
			return $result[0];
		}		
		return false;		
	}
	public static function insertOsInDtl($dtl_data,$mst_id,$loc_id,$os_unit) {
		//明细表有一条成功status就为true全失败为false
		$ans=array();
		$status=false;
		$db=self::__instance();
		for($i=0;$i<count($dtl_data);$i++){
			//获得os工序完成后产品代码，如products表中还无此产品则新增
			$os_unit_info=Outsource::getOs_unitTypeInfo($os_unit);
			$os_code=$dtl_data[$i]['product_id'].'-'.$os_unit_info['id'];
			$product=Outsource::getProductByOscode($os_code);
			if($product){
				$product_id=$product['id'];
			}
			else{
				$product=Baseinfo::getProductById($dtl_data[$i]['product_id']);	
				$data=array('product_name'=>$product['name'].'-已'.$os_unit_info['name'],'os_code'=>$os_code);
				$product_id=$db->insert('products',$data);
			}
			$data=array('p_product_id'=>$dtl_data[$i]['product_id'],
				'product_id'=>$product_id,
				'qty'=>$dtl_data[$i]['qty'],
				'mst_id'=>$mst_id);
			$id=$db->insert('os_in_dtl',$data);
			if($id){				
				$status=true;				
				Stock::updateStock($product_id,((int)$dtl_data[$i]['qty']),$loc_id);				
			}else{
				$ans['msg']=$db->error();
			}
		}
		$ans['status']=$status;		
		return $ans;
	}

	public static function insertOsInOrder($mst_data,$dtl_data) {
		$db=self::__instance();		
		$ans=array();		
		
		$result=Outsource::insertOsInMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Outsource::insertOsInDtl($dtl_data,$mst_id,$mst_data['loc_id'],$mst_data['os_unit']);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true					
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Baseinfo::deleteMst($mst_id,'os_in_mst');//删除主表
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

	public static function getOsInDtlById($id) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,qty from os_in_dtl a 
			left join products b on a.product_id=b.id 
			where a.mst_id=".$id. " order by b.id";	
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function insertOsTest(){
		
	}
}

