<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<div class="row" style="height:50px">
	<div class="col-xs-5">
		客户:
		<select id='cust' class='width-50 chosen-select' data-placeholder='选择客户...'>
		</select>			
		<button class="btn btn-success" id="btn_search">查看</button>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<table id="grid-table"></table>
		<div id="grid-pager"></div>
	</div><!-- /.col -->
</div><!-- /.row -->

<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="assets/js/chosen.jquery.min.js"></script>
<script src="views/work/tasks.js"></script>