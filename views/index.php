<?php
	require ('../include/init.inc.php');
	$pages=User::getShortCut();
	
	if ($pages){		
		$height=ceil(count($pages) / 5)*66+40;
?>
<div class="col-xs-12 col-sm-12 widget-container-span ui-sortable" id="div_short_cut">
	<div class="widget-box">
		<div class="widget-header header-color-blue">
			<h5>快捷菜单</h5>
			<div class="widget-toolbar">
				<a data-action="collapse" href="#" class='collapse' id="a_<?php echo $mods[$i]['id']?>">
					<i class="icon-chevron-up"></i>
				</a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding" style='height:<?php echo $height;?>px'>
				<div class="space-6"></div>
				<div class="col-sm-12 infobox-container">
					<?php 
						for($i=0;$i<count($pages);$i++){
					?>
					<div class="infobox infobox-green  ">
						<div class="infobox-icon">
							<i class="icon-comments"></i>
						</div>
						<div class="infobox-data">
							<?php
								echo '<a href="#/views'.$pages[$i]['url'].'">';
								echo '<span class="menu-text"> '.$pages[$i]['page_name'].' </span>';								
								echo '</a>';
							?>
						</div>											
					</div>
					<?php
						}//end of for
					?>
				</div>			
			</div>
		</div>
	</div>
</div>

<?php 

} //end of if
?>
<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
<script src="assets/js/jqGrid/i18n/grid.locale-cn.js"></script>
<script src="views/index.js"></script>