<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Stock extends Base {
	public static function getBinId($loc_id,$bin) {
		$db=self::__instance();
		$sql="select id from location_bin where loc_id=$loc_id and bin='$bin'";
		$list=$db->query($sql)->fetchAll();
		return $list;
	}

	public static function getProductBinQty($bin_id,$product_id) {
		$db=self::__instance();
		$sql="select qty from stocks where bin_id=$bin_id and product_id=$product_id";
		$list=$db->query($sql)->fetchAll();
		return $list;
	}

	public static function getStockById($loc_id,$product_id,$bin_id=null) {
		$db=self::__instance();
		$sql="select qty from stocks where loc_id=$loc_id and product_id=$product_id";
		if ($bin_id!=null){
			$sql.=" and bin_id=$bin_id";
		}
		$list=$db->query($sql)->fetchAll();
		if($list){
			return $list[0];
		}
		return array(0);//无库存返回0
	}

	
	public static function getStocks($loc_id,$product_id="",$product_name="",$bin="") {
		$db=self::__instance();
		/*$sql="select b.id,b.product_name as name,qty,b.min_stock,b.bin from stocks a
			LEFT JOIN products b on a.product_id=b.id 
			where loc_id=$loc_id
			order by b.id";	*/
		$sql="select b.id,b.product_id,b.product_name as name,b.gg,
			qty,b.min_stock,c.bin 
			from products b 
			LEFT JOIN stocks a on a.product_id=b.id 
			left join location_bin c on c.id=a.bin_id 
			where (a.loc_id=$loc_id or a.loc_id is null)";	
		if($product_id!=""){
			$sql.=" and b.product_id like '%".$product_id."%'";
		}	
		if($product_name!=""){
			$sql.=" and b.product_name like '%".$product_name."%'";
		}	
		if($bin!=""){
			$sql.=" and c.bin like '%".$bin."%'";
		}
		$sql.=" order by b.id";

		$list=$db->query($sql)->fetchAll();
		if($list){
			return $list;
		}
		return array();
	}

	public static function viewStocks($loc_id,$product_id="",$product_name="",$bin="") {
		$db=self::__instance();	
		$sql="select b.id,b.product_id,b.product_name as name,b.gg,
			qty,b.min_stock,c.bin 
			from products b 
			LEFT JOIN stocks a on a.product_id=b.id 
			left join location_bin c on c.id=a.bin_id 
			where (a.loc_id=$loc_id)";	
		if($product_id!=""){
			$sql.=" and b.product_id like '%".$product_id."%'";
		}	
		if($product_name!=""){
			$sql.=" and b.product_name like '%".$product_name."%'";
		}	
		if($bin!=""){
			$sql.=" and c.bin like '%".$bin."%'";
		}
		$sql.=" order by b.id";

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
			$stock_qty=Stock::getStockById($loc_id,$dtl_data[$i]['product_id'],$dtl_data[$i]['bin_id']);
			
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

	public static function updateStock($product_id,$qty,$loc_id,$bin_id=null) {
		$db=self::__instance();
		$where=array('AND'=>array('product_id'=>$product_id,'loc_id'=>$loc_id,'bin_id'=>$bin_id));
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
			$data=array('qty'=>$qty,'product_id'=>$product_id,'loc_id'=>$loc_id,'bin_id'=>$bin_id);		
			$id=$db->insert('stocks',$data);
			if($id){
				return array('status'=>true);
			}else{
				return array('status'=>false,'msg'=>$db->error());
			}
		}	
	}

	//基于库位更新库存
	public static function updateStockByBin($product_id,$bin_id,$qty=0) {
		$db=self::__instance();
		$where=array('AND'=>array('product_id'=>$product_id,'bin_id'=>$bin_id));
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
			$data=array('qty'=>$qty,'product_id'=>$product_id,'bin_id'=>$bin_id);		
			$id=$db->insert('stocks',$data);
			if($id){
				return array('status'=>true);
			}else{
				return array('status'=>false,'msg'=>$db->error());
			}
		}	
	}


	//期初物料库位管理
	public static function updateStockBin($product_id,$bin,$qty=0) {
		$db=self::__instance();
		$result=$db->select('location_bin',['loc_id','id'],['bin'=>$bin]);
		if($result){
			$loc_id=$result[0]['loc_id'];		
			$bin_id=$result[0]['id'];	
			$where=array('AND'=>array('product_id'=>$product_id,'loc_id'=>$loc_id));
			$result=$db->has('stocks',$where);
			if ($result){
				$data=array('qty'=>$qty,'bin_id'=>$bin_id);
				$id=$db->update('stocks',$data,$where);
				if($id){
					return array('status'=>true);
				}else{
					return array('status'=>false,'msg'=>$db->error());
				}
			}	
			else{
				$data=array('qty'=>$qty,'product_id'=>$product_id,'bin_id'=>$bin_id,'loc_id'=>$loc_id);		
				$id=$db->insert('stocks',$data);
				if($id){
					return array('status'=>true);
				}else{
					return array('status'=>false,'msg'=>$db->error());
				}
			}	
		}
		else{
			return array('status'=>false,'msg'=>'bin does not exists!');
		}
		
	}

	public static function deleteBin($id) {
		$db=self::__instance();
		$where=array('AND'=>array('bin_id'=>$id,'qty[>]'=>0));
		$result=$db->has('stocks',$where);
		if ($result){			
			return array('status'=>false,'msg'=>'库位中有产品，不能删除！');			
		}	
		else{	
			$db->delete('location_bin',array('id' =>$id));
			return array('status'=>true,'msg'=>'操作成功！');			
		}	
	}

	public static function insertBin($data){
		$db=self::__instance();		
		$table='location_bin';
		$where=array('bin'=>$data['bin'],);
		$result=$db->has($table,$where);
		if($result){
			return array('status'=>false,'msg'=>'bin already exists！');
		}
		else{
			$result=$db->insert($table,$data);
			if($result){
				return array('status'=>true,'msg'=>'操作成功！');
			}
			return array('status'=>false,'msg'=>'操作失败！');
		}
	}
}
