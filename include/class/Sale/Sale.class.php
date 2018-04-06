<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Sale extends Base {
	public static function isOrderUsed($id) {
		$db=self::__instance();	
		$sql='select out from sale_order_dtl  
			where mst_id='.$id;
		$result = $db->query($sql)->fetchAll();
		for($i=0;$i<count($result);$i++){
			if ($result[$i]['out']<>0){
				return true;
			}
		}
		return false;
	}
	public static function delSaleOrder($id) {
		$db=self::__instance();	
		if(!Sale::isOrderUsed($id)){
			return Baseinfo::deleteOrder($id,'sale_order_mst','sale_order_dtl');
		}else{
			return array('status' =>false,'msg'=>'订单已发生业务，不能删除！');
		}	
	}

	public static function insertCustomerOrderOutDtl($dtl_data,$customer_order_out_id) {
		//明细表有一条成功status就为true全失败为false
		
		$ans=array();
		$status=false;
		$db=self::__instance();
		$mst_tbls=array();
		//添加明细表并更新sale_order_mst的明细表中出库数量
		for($i=0;$i<count($dtl_data);$i++){
			$data=array(
			'mst_id'=>$customer_order_out_id,
			'out'=>$dtl_data[$i]['out'],
			'product_id'=>$dtl_data[$i]['product_id']);			
			$r=$db->insert('customer_order_out_dtl',$data);
			if($r){//更新sale_order_mst的明细表中出库数量
				$dtl_id=$dtl_data[$i]['dtl_id'];
				$out=$dtl_data[$i]['out'];
				$where=array('id'=>$dtl_id);
				$result=$db->has('sale_order_dtl',$where);
				if ($result){
					$data=array('out[+]'=>$out);
					$id=$db->update('sale_order_dtl',$data,$where);
					if($id){
						//记录成功出库的产品的主表id
						if (!in_array($dtl_data[$i]['mst_id'], $mst_tbls)){
							array_push($mst_tbls,$dtl_data[$i]['mst_id']);
						}
					}else{
						return array('status'=>false,'msg'=>$db->error());
					}
				}	
			}else{
				return array('status'=>false,'msg'=>$db->error());
			}					
		}
		//检查sale_order_mst的明细表中是否全部数量已经完成，若完成则customer_order_mst设置为done=1
		for($i=0;$i<count($mst_tbls);$i++){
			$mst_id=$mst_tbls[$i];
			$flag=true;//假设已经完成
			$sql='select qty-out as left from sale_order_dtl   
			where mst_id='.$mst_id;
			$result = $db->query($sql)->fetchAll();
			//return array('status'=>true,'msg'=>$result);
			if ($result){
				for ($j=0;$j<count($result);$j++){

					if($result[$j]['left']!=0){
						$flag=false;
						break;
					}
				}
			}
			else{
				$flag=false;
			}
			if($flag){
				//update sale_order_mst done=1
				$data=array('done'=>1);
				$where=array('id'=>$mst_id);
				$db->update('sale_order_mst',$data,$where);
			}
		}
			
		return array('status'=>true,'msg'=>'操作成功！');
	}

	public static function insertCustomerOrderOutMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'cust_id'=>$mst_data['cust_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('customer_order_out_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'customer order out mst fail!';
		}
		return $ans;
	}

	public static function insertCustomerOrderOut($mst_data,$dtl_data)
	{
		$db=self::__instance();		
		$ans=array();		
		$result=Sale::insertCustomerOrderOutMst($mst_data);//插入主表
		
		if($result['status']){
			$customer_order_out_mst_id=$result['id'];
			//插入明细表并更新更新原客户订单数量及原订单完成状态
			$result=Sale::insertCustomerOrderOutDtl($dtl_data,$customer_order_out_mst_id);//插入明细表并更新更新原客户订单数量及原订单完成状态
			if($result['status']){//明细表有一条成功status就为true
				//Sale::updateSaleOrderStatus($mst_id);//判断并更新销售单状态为完成			
				$ans['status']=true;
				$ans['msg']='操作成功！';
				//return $result;
			}else{
				//Sale::deleteSaleOutMst($mst_id);//删除主表
				Baseinfo::deleteMst($customer_order_out_mst_id,'customer_order_out_mst');//删除主表
				$ans['status']=false;
				$ans['msg']='操作失败！';
			}
		}
		else{
			$ans['msg']=$result['msg'];
			$ans['status']=false;
		}		
		return $ans;
		//return $result;
	}
	//列表 
	public static function getCustTypes() {		
		$result=Baseinfo::getSelect('cust_types');
		if($result){
			return $result;
		}
		return array();
	}
	public static function custProduct($cust_id){
		$db=self::__instance();
		$sql='select (b.qty-b.out) as qty,b.box,b.memo,c.product_id,c.id as p_id,c.product_name as name,c.gg,b.id as dtl_id,a.id as mst_id    
			from sale_order_mst a 
			left join sale_order_dtl b 
			on a.id=b.mst_id 
			left join products c 
			on b.product_id=c.id 
			where (b.qty-b.out)>0 and a.done=0 and a.cust_id='.$cust_id;
		$result = $db->query($sql)->fetchAll();
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
	public static function getSaleOutList($id=null,$date_start="",$date_end="") {
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
			LEFT JOIN locations e on e.id=a.loc_id ";	
		if($date_start!=""&&$date_end!=""){
			if($id==null){
				$sql.=' where a.createday>="'.$date_start.'" and a.createday<="'.$date_end.'"';
			}
			else{
				$sql.=' and a.createday>="'.$date_start.'" and a.createday<="'.$date_end.'"';
			}
		}
		$sql.=" order by a.createday desc ";	
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
		
		$sql="select b.id,b.product_id,b.product_name,b.gg,a.qty,a.memo   
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
				//$result=Sale::insertSaleOutDtl($dtl_data,$mst_id,$mst_data['loc_id']);//插入明细表并更新库存
				$result=Baseinfo::insertDtl($dtl_data,'sale_out',$mst_id,$mst_data['loc_id'],-1);//插入明细表并更新库存
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
