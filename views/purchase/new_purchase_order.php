<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<div id="tab_select">
	<div class="row">
		<div class="col-xs-12">
			<button id='btn_select' class="btn btn-info icon-search">选择销售订单</button>
		</div>
	</div>			
</div>
<form id="frm">
<div id="tab_out">
	<div class="row" style="height:50px">
		<div class="col-xs-2">
			<div class="form-group">																		
				供应商:
				<select id='supplier'></select>
			</div>
		</div>
		<div class="col-xs-1">
			交货时间：
		</div>
		<div class="col-xs-9">		
			<div class="input-group input-group-sm">							
				<input type="text" id="deliveryday" name="deliveryday" class="form-control" placeholder='交货时间' />
				<span class="input-group-addon">
					<i class="icon-calendar"></i>
				</span>
				<button id='btn_reselect' class="btn btn-info icon-search">重新选择销售订单</button>
				<button id='btn_save' type="submit" class="btn btn-success icon-save">生成采购订单</button>					
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-xs-12">	
			<table id="tbl_dtl"></table>													
		</div>						
	</div>	
</div>
</form>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/purchase/new_purchase_order.js"></script>