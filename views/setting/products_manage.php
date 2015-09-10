<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>

<div class="row" id="tab_product">	
	<div class="col-xs-3">
		<form class="form-horizontal" role="form" id="new_frm">
            <fieldset>
               <legend>新增产品</legend>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="product_id">产品代码</label>
                  <div class="col-sm-8">
                     <input class="form-control" id="product_id" type="text"/>
                  </div>                   
               </div>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="product_name">产品名称</label>
                  <div class="col-sm-8">
                     <input class="form-control" id="product_name" type="text" />
                  </div>                   
               </div>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="gg">规格</label>
                  <div class="col-sm-8">
                     <input class="form-control" id="gg" type="text" />
                  </div>                   
               </div>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="min_stock">最小库存</label>
                  <div class="col-sm-8">
                     <input class="form-control" id="min_stock" type="text" />
                  </div>                   
               </div>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="loc">仓库</label>
                  <div class="col-sm-8">
                     <select id="loc"></select>
                  </div>                   
               </div>
               <div class="form-group">
                  <label class="col-sm-4 control-label" for="bin">库位</label>
                  <div class="col-sm-8">
                     <input class="form-control" id="bin" type="text" />
                  </div>                   
               </div>
               <div class="form-group">
                  
                  <div class="col-sm-8">
                  	 <div class="col-sm-6">                     
                     <input type="submit" class="btn btn-success icon-save" value="保存" id="btn_save"/>
                     </div>

                     <div class="col-sm-6">
                     <button id='btn_cancel' class="btn btn-primary icon-reset" type="cancel">取消</button>
                     </div>
                  </div>                   
               </div>
            </fieldset>     
        </form>                                 
	</div>	
	<div class="col-xs-9">
		产品名称：<input type="text" id="product_filter"/>
	
		<!-- PAGE CONTENT BEGINS -->
		<table id="grid-table"></table>

		<div id="grid-pager"></div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
	<!-- 2015-8-13
	<div class="col-xs-4" id="div_dtl">
		<table id="right_subpart"></table>
	</div>
	-->
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