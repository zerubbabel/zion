<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">

	<div class="col-xs-4">
		<label for="os_unit" class="control-label no-padding-right">外协单位:</label>
		<select id='os_unit'>
			<!--<option value=0>--请选择--</option>-->
		</select>	
	</div>	
	<div class="col-xs-1">
		交货时间：
	</div>
	<div class="col-xs-7">		
		<div class="input-group input-group-sm">			
			<input type="text" id="deliveryday" name="deliveryday" class="form-control" placeholder='交货时间' />
			<span class="input-group-addon">
				<i class="icon-calendar"></i>
			</span>
			<button id='add_btn' class="btn btn-success icon-plus">添加产品</button>
			<button id='save_btn' class="btn btn-success icon-save" type="submit">保存</button>													
		</div>	
	</div>
	<div class="col-xs-12">	
		<table id="grid_dtl" ></table>	
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
				<div class="modal-body ">
					<div class='row'>
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">筛选：</label>

						<div class="col-sm-9">
							<input type="text" id="product_filter" placeholder="产品描述" class="col-xs-10 col-sm-5" />
						</div>
					</div>
					<div class='row'>	
						<div class="col-sm-12">						
							<table id="modal_tbl_products" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
							</table>
							<div id="modal_pager"></div>						
						</div>
					</div>	
				</div>				
			</div>

			<div class="modal-footer no-margin-top">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- end of modal of products-->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/outsource/new_os_order.js"></script>