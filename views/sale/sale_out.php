<div id="tab_select">
	<div class="row">
		<div class="col-xs-12">
			<button id='btn_select' class="btn btn-success icon-search">选择销售订单</button>
		</div>
	</div>			
</div>
<form id="frm">
<div id="tab_out">
	<div class="row">
		<div class="col-xs-12">
			<label id="cust" class="control-label no-padding-right">客户:</label>	
			<button id='btn_reselect' class="btn btn-success icon-search">重新选择销售订单</button>
			<button id='btn_save' type="submit" class="btn btn-success icon-save">生成销售出库单</button>
			<table id="tbl_dtl"></table>													
		</div>						
	</div>	
</div>
</form>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/sale/sale_out.js"></script>