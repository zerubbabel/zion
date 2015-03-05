<?php
	require ('../../include/init.inc.php');
	$result=User::haveAccess($_SERVER['PHP_SELF']);	
	if(!$result){
		die();
	}
?>
<form id="frm">
<div class="row" style="height:40px">
	<div class="col-xs-12">
		<label>用户组：</label><select id="group"></select>
		<input type="button" class="btn btn-success" id="btn_save" value="更新" />
	</div>
<div>	
<?php
	$mods=Baseinfo::getModules();
	for ($i=0;$i<count($mods);$i++)
	{
?>
<div class="col-xs-12 col-sm-12 widget-container-span ui-sortable" id="<?php echo $mods[$i]['id']?>">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5><?php echo $mods[$i]['name'];?></h5>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#" class='collapse' id="a_<?php echo $mods[$i]['id']?>">
					<i class="icon-chevron-up"></i>
				</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding">
				<?php
					$pages=Baseinfo::getPagesById($mods[$i]['id']);
					for ($j=0;$j<count($pages);$j++){
						echo '<input class="pages" type="checkbox" value="'.$pages[$j]['id'].
							'" id="page_'.$pages[$j]['id'].'">'.$pages[$j]['name'];
					}
				?>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
</form>

<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/setting/privilege.js"></script>