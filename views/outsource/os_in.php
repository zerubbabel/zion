<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">	
	<div class="col-xs-12">
		加工单位:<select id='os_unit' class='width-50 chosen-select'
			data-placeholder='选择外协单位...'></select>
		入库仓库:<select id='loc'></select>			
		<button id='btn_save' type="submit" class="btn btn-success icon-save">入库</button>		
	</div>		
	<div class="col-xs-12">	
		<table id="tbl_dtl"></table>													
	</div>							
</form>
<?php include '../modal_products.php';?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="views/outsource/os_in.js"></script>