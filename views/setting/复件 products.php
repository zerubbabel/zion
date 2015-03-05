<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div class="row">
	<div class="col-xs-12" id="toolbar">
		
	</div>
	<div class="col-xs-12">	
		<table id="tbl_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
		</table>		
		<div id="pager"></div>											
	</div>						
</div>	
</form>

<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/setting/products.js"></script>