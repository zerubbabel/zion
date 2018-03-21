<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Work extends Base {
	public static function workTask() {
		$db=self::__instance();
		$sql='select b.product_id,b.product_name,b.gg,(a.qty-a.out) as qty,
			a.jh,a.box,a.memo   
			from sale_order_dtl a 
			left join products b 
			on a.product_id=b.id 
			where a.qty>a.out 
			order by a.jh asc';
		$list = $db->query($sql)->fetchAll();
		return $list;	
	}
	public static function getDrawOutMst($id=null,$date_start,$date_end) {
		$db=self::__instance();
		$sql="select a.id,a.workcenter_id,a.createday,a.op_id,d.name as loc_name,
			b.name as workcenter_name,c.user_name  
			from draw_out_mst a 
			left join workcenters b on a.workcenter_id=b.id 
			left join users c on a.op_id=c.user_id 
			left join locations d on d.id=a.loc_id ";

		if($id!=null&&$id!=''){
			$sql.=" where a.id=".$id;
		}
		
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

	public static function getDrawOutDtlById($id) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,b.product_id,b.gg,c.bin,
			qty from dtl a 
			left join products b on a.product_id=b.id 
			left join location_bin c on c.id=a.bin_id 			
			where a.mst_id=".$id. " and a.mst_table='draw_out' 
			order by b.id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getWorkInList() {
		$db=self::__instance();
		$sql="select a.id,a.createday,b.user_name,c.name as wc_name,
			d.name as loc_name from work_in_mst a
			LEFT JOIN users b on a.op_id=b.user_id
			left join workcenters c on c.id=a.workcenter_id
			LEFT JOIN locations d on d.id=a.loc_id 
			order by a.id desc";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function insertWorkDrawMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array(
			'workcenter_id'=>$mst_data['workcenter_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('work_draw_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].'work draw mst fail!';
		}
		return $ans;
	}

	

	public static function deleteWorkDrawMst($mst_id) {
		$db=self::__instance();
		$where=array('id'=>$mst_id);
		$id=$db->delete('work_draw_mst',$where);
		if($id){
			return array('status' =>true);
		}else{
			return array('status' =>false,'msg'=>$db->error());
		}
	}

	public static function insertWorkDraw($mst_data,$dtl_data) {
		$db=self::__instance();
		
		$ans=array();
		
		$result=Work::insertWorkDrawMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Baseinfo::insertDtl($dtl_data,'work_draw',$mst_id);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true					
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Work::deleteWorkDrawMst($mst_id);//删除主表
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

	public static function insertDrawOut($mst_data,$dtl_data) {
		$db=self::__instance();
		$result=Stock::checkStock($dtl_data,$mst_data['loc_id']);//检查库存情况
		$ans=array();
		if ($result['status']){
			$result=Work::insertWorkDrawMst($mst_data);//插入主表
			if($result['status']){
				$mst_id=$result['id'];
				$result=Baseinfo::insertDtl($dtl_data,'work_draw',$mst_id,$mst_data['loc_id']);//插入明细表并更新库存
				if($result['status']){//明细表有一条成功status就为true					
					$ans['status']=true;
					$ans['msg']='操作成功！';
				}else{
					Work::deleteWorkDrawMst($mst_id);//删除主表
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


	public static function getWorkDrawDtlById($id) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,b.product_id,b.gg,c.bin,
			qty from dtl a 
			left join products b on a.product_id=b.id 
			left join location_bin c on c.id=a.bin_id 			
			where a.mst_id=".$id. " and a.mst_table='work_draw' 
			order by b.id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
	public static function getDrawOutAllByWorkDrawId($id) {
		$db=self::__instance();		
		$sql="select a.product_id as id,sum(qty) as qty from dtl a 
			LEFT JOIN draw_out_mst b on a.mst_id=b.id		
			where b.work_draw_mst_id=$id and a.mst_table='draw_out' 
			GROUP BY product_id 
			order by a.product_id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getWorkDrawMst($id=null,$date_start,$date_end,$status=null) {
		$db=self::__instance();
		$sql="select a.id,a.workcenter_id,a.createday,a.op_id,
			b.name as workcenter_name,c.user_name,d.name as status 
			from work_draw_mst a 
			left join workcenters b on a.workcenter_id=b.id 
			left join users c on a.op_id=c.user_id 
			left join order_status d on a.status=d.id ";

		if($id!=null&&$id!=''){
			$sql.=" where a.id=".$id;
		}
		if ($status!=null){
			if($id==null){
				$sql.=" where a.status=$status";
			}
			else{
				$sql.=" and a.status=$status";
			}
		}
		if($date_start!=""&&$date_end!=""){
			if($id==null && $status==null){
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

	public static function getWorkInMst($id=null,$date_start="",$date_end="") {
		$db=self::__instance();
		$sql="select a.id,a.workcenter_id,a.createday,a.op_id,
		b.name as workcenter_name,c.user_name,d.name as loc_name 
		from work_in_mst a left join workcenters b on a.workcenter_id=b.id 
		left join users c on a.op_id=c.user_id 
		left join locations d on a.loc_id=d.id ";
	
		if($id!=null&&$id!=''){
			$sql.=' where a.id='.$id;
		}
		if($date_start!=""&&$date_end!=""){
			$sql.=' where a.createday>="'.$date_start.'" and a.createday<="'.$date_end.'"';
		}
		$sql.=" order by a.createday desc ";
		//return $sql;
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getWorkInDtlById($id) {
		$db=self::__instance();		
		$sql="select b.id,b.product_name,b.product_id,b.gg,c.bin,
			qty from dtl a 
			left join products b on a.product_id=b.id 
			left join location_bin c on a.bin_id=c.id 
			where a.mst_id=".$id. " and a.mst_table='work_in' 
			order by b.id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
	public static function updateWorkDrawById($id,$status) {
		$db=self::__instance();
		$table='work_draw_mst';
		$where=array('id'=>$id);
		$data=array('status'=>$status);
		$result=$db->update($table,$data,$where);
		if($result && $result>0){
			return true;
		}
		return false;
	}

	public static function updateWorkDrawStatus($mst_id) {
		//todo
	}

	public static function insertDrawOutMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array('work_draw_mst_id'=>$mst_data['work_draw_mst_id'],
			'loc_id'=>$mst_data['loc_id'],
			'workcenter_id'=>$mst_data['workcenter_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('draw_out_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].' draw out mst fail!';
		}
		return $ans;
	}

	public static function insertDrawOutOrder($mst_data,$dtl_data) {
		$db=self::__instance();
		$result=Stock::checkStock($dtl_data,$mst_data['loc_id']);//检查库存情况
		$ans=array();
		if ($result['status']){
			$result=Work::insertDrawOutMst($mst_data);//插入主表
			if($result['status']){
				$mst_id=$result['id'];
				$result=Baseinfo::insertDtl($dtl_data,'draw_out',$mst_id,$mst_data['loc_id'],-1);//插入明细表并更新库存
				//return $result;
				if($result['status']){//明细表有一条成功status就为true
					Work::updateWorkDrawStatus($mst_id);//判断并更新销售单状态为完成
					$ans['status']=true;
					$ans['msg']='操作成功！';
				}else{
					Baseinfo::deleteMst($mst_id,'work_out_mst');//删除主表
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


	public static function insertWorkInMst($mst_data) {
		$db=self::__instance();		
		$createday=date('Y-m-d H:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$data=array('workcenter_id'=>$mst_data['workcenter_id'],
			'loc_id'=>$mst_data['loc_id'],
			'createday'=>$createday,
			'op_id'=>$op_id);
		$ans=array();
		$id=$db->insert('work_in_mst',$data);
		if($id){
			$ans['status']=true;
			$ans['id']=$id;			
		}else{			
			$ans['status']=false;
			$ans['msg']=$db->error()[2].' work in mst fail!';
		}
		return $ans;
	}

	public static function insertWorkInOrder($mst_data,$dtl_data) {
		$db=self::__instance();
		$ans=array();
		
		$result=Work::insertWorkInMst($mst_data);//插入主表
		if($result['status']){
			$mst_id=$result['id'];
			$result=Baseinfo::insertDtl($dtl_data,'work_in',$mst_id,$mst_data['loc_id'],1);//插入明细表并更新库存
			if($result['status']){//明细表有一条成功status就为true
				//Work::updateWorkDrawStatus($mst_id);//判断并更新销售单状态为完成
				$ans['status']=true;
				$ans['msg']='操作成功！';
			}else{
				Baseinfo::deleteMst($mst_id,'work_in_mst');//删除主表
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
