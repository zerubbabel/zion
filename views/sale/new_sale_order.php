<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div class="row">
	<div class="col-xs-6">
		
		客户:
		<select id='cust'>
			<!--<option value=0>--请选择--</option>-->
		</select>	
		订单重要性：
		<select id='importance'>
		</select>
		<input type="text" id="order_no" name="order_no" placeholder='订单号' />		
	</div>	
	<div class="col-xs-1">
		交货时间：
	</div>
	<div class="col-xs-5">		
		<div class="input-group input-group-sm">			
			<input type="text" id="deliveryday" name="deliveryday" class="form-control" placeholder='交货时间' />
			<span class="input-group-addon">
				<i class="icon-calendar"></i>
			</span>
			
		
			<button id='add_btn' class="btn btn-info icon-plus">添加产品</button>
			<button id='save_btn' class="btn btn-success icon-save" type="submit">保存</button>
		</div>
	</div>
	<div class="col-xs-12">
		<table id="grid_dtl" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
		</table>	
	</div>	
</div>	
</form>
<!--modal of products-->
<div id="modal_products" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header no-padding">
				<div class="table-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<span class="white">&times;</span>
					</button>
					选择产品 
				</div>
			</div>

			<div class="modal-body no-padding ">												
				<div class="modal-body" id="modal_products_body">
					<div class='row'>
						筛选:<input type="text" id="product_filter" placeholder="产品描述"/>
					</div>
					<div class='row'>	
						<div class="col-xs-12">						
							<table id="modal_tbl_products" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
							</table>						
						</div>
					</div>	
				</div>				
			</div>
			<div class="modal-footer no-margin-top"></div>
		</div>
	</div>
</div>

<!-- end of modal of products-->

<!-- page specific plugin scripts -->
<!--<script src="assets/js/jqModal.min.js"></script>-->
<!--
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>


-->
<script src="assets/js/data-time/bootstrap-datepicker.min.js"></script>
<script src="assets/js/data-time/bootstrap-datepicker.zh-CN.js"></script>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/sale/new_sale_order.js"></script>