<?php
	// leftside
	/*require_once 'config.php';
	require_once 'include/medoo.min.php';
	 
	$database = new medoo($db_path);
	
	$pages = $database->select("pages",["[>]modules"=>"module_id"],
		 "*",["ORDER"=>'module_id']);*/
	
	$pages=Page::getPages();
	if (count($pages)==0){
		die();
	}
	
	for($i=0;$i<count($pages);$i++){		
		if (($i==0) or ($pages[$i]['module_id']<>$pages[$i-1]['module_id'])){
			if ($i<>0){
				echo '</ul>';								
				echo '</li>';	
			};
			echo '<li>';
			echo '<a href="#" class="dropdown-toggle">';
			echo '<span class="menu-text">
				'.$pages[$i]['module_name'].'										
			</span>
			<b class="arrow icon-angle-down"></b>';																
			echo '</a>';
			echo '<ul class="submenu">';
		}	
		echo '<li><a href="#/views'.$pages[$i]['url'].'">';	
		echo '<span class="menu-text"> '.$pages[$i]['page_name'].' </span>';								
		echo '</a></li>';
	}							
	echo '</ul>';
	echo '</li>';
?>	