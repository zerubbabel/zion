<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Work extends Base {

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
		$sql="select b.id,b.product_name,qty from dtl a 
			left join products b on a.product_id=b.id 
			where a.mst_id=".$id. " and a.mst_table='work_draw' 
			order by b.id";		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getWorkDrawMst($id=null) {
		$db=self::__instance();
		$sql="select a.id,a.workcenter_id,a.createday,a.op_id,
			b.name as workcenter_name,c.user_name,d.name as status 
			from work_draw_mst a 
			left join workcenters b on a.workcenter_id=b.id 
			left join users c on a.op_id=c.user_id 
			left join order_status d on a.status=d.id ";
		if($id!=null){
			$sql.=' where id='.$id;
		}
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
}
