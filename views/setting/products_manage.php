<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<div class="row" id="tab_product">
	<div class="col-xs-12">
		筛选：<input type="text" id="product_filter"/>
	</div>
	<div class="col-xs-8">
		<!-- PAGE CONTENT BEGINS -->
		<table id="grid-table"></table>

		<div id="grid-pager"></div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
	<div class="col-xs-4" id="div_dtl">
		<table id="right_subpart"></table>
		<!--<div id="pager_d"></div>-->
	</div>
</div><!-- /.row -->
<form id="sub_frm">
<div class="row" id="tab_bom">
	<button id="btn_back" class="icon-arrow-left btn btn-default">返回</button>
	<button id='add_btn' class="btn btn-info icon-plus">添加子件</button>
	<button id='save_btn' class="btn btn-success icon-save" type="submit">保存</button>
<!--	<h1>物料清单:<span id="product_span"></span></h1>-->
	<table id="grid_subpart"></table>
	
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
						

						<div class="col-xs-12">
							筛选：<input type="text" id="modal_product_filter" placeholder="产品描述" />
						</div>
					</div>
					<div class='row'>	
						<div class="col-xs-12">						
							<table id="modal_tbl_products" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
							</table>						
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

<?php include '../modal_products.php';?>
<!-- page specific plugin scripts -->
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/setting/products_manage.js"></script>