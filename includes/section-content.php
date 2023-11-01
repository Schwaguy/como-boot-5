<?php
	// If section has an aside, set columns 
	if (($sectionInfo['sectionAside'] != 'no-sidebar') || (!empty($sectionInfo['sectionAside']))) {
		startSidebarSection($sectionInfo,'section');		
	} else {
	?>
	<div class="row <?=((!empty($sectionInfo['rowAlignment'])) ? $sectionInfo['rowAlignment'] : 'justify-content-center')?>">
		<div class="<?=((!empty($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : 'col-12 col-lg-11')?> content-wrap <?=$sectionInfo['sectionContentClass']?>"><?php
	}
		//echo 'TEST!!!<br>';  
		echo formatSectionTitles($sectionInfo['sectionTitle'], $sectionInfo['sectionSubtitle'], '', $sectionInfo['sectionTitleLink'], $sectionInfo['sectionHeaderClass'], $sectionInfo['sectionTitleClass'], $sectionInfo['sectionSubtitleClass'], '', 'section');
		?>
		<div class="content <?=$sectionInfo['sectionContentInnerClass']?>"><?php
			echo apply_filters('the_content', $sectionInfo['sectionContent']);
		?></div>
		</div><!-- /content-wrap --><?php	   
	// If section has an aside, add aside
	if ((!empty($sectionInfo['sectionAside'])) && ($sectionInfo['sectionAside'] != 'no-sidebar')) {	
		addSectionAside($sectionInfo,'section');
		//echo $sectionAside;
	} else {
		?></div><?php
	}
		 
	// Additional Content Section
	if (isset($sectionInfo['sectionAdditionalContent'])) {
		if (!empty($sectionInfo['sectionAdditionalContent'])) {	
			?><div class="section-additional-content"><?=apply_filters('the_content', $sectionInfo['sectionAdditionalContent'])?></div><!-- /section-additional-content --><?php
		}
	}
?>