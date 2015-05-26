<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div id="tab_out">
	<div class="row" style="height:50px">
		<div class="col-xs-6">
			领料车间:
			<select id='workcenter'>
			</select>
		</div>
		
		<div class="col-xs-6">															
			<button id='btn_save' type="submit" class="btn btn-success icon-save">生成领料申请单</button>								
		</div>
	</div>	
	<div class="row">	
		<div class="col-xs-12">	
			<table id="subpart_dtl"></table>													
		</div>					
	</div>	
</div>
</form>
<?php include '../modal_products.php';?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/work/new_wc_work_draw.js"></script>