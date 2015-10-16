<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
	$month=(strftime('%Y-%m'));	
?>
<label for="month" class="control-label no-padding-right">月份:</label>
<input type="textbox" id="month" VALUE="<?PHP echo $month ?>"/>
<label for="product" class="control-label no-padding-right">产品:</label>
<select class="width-50 chosen-select" id="product" 
	data-placeholder="选择产品...">		
</select>
<button class="btn btn-success btn-sm icon-search" id="btn_search">查看</button>
<div class="row">
	<div class="col-xs-12">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/chosen.jquery.js"></script>
<script src="views/report/r_monthly.js"></script>