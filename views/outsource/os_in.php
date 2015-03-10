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
			<button id='btn_select' class="btn btn-info icon-search">选择采购订单</button>
		</div>
	</div>			
</div>
<form id="frm">
<div id="tab_out">
	<div class="row" style="height:50px">
		<div class="col-xs-2">
			<label id="supplier" class="control-label no-padding-right">客户:</label>
		</div>	
		<div class="col-xs-10">	
			入库仓库:
			<select id='loc'>
			</select>	
			<button id='btn_reselect' class="btn btn-info icon-search">重新选择采购订单</button>
			<button id='btn_save' type="submit" class="btn btn-success icon-save">生成采购入库单</button>
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
<script src="views/outsource/os_in.js"></script>