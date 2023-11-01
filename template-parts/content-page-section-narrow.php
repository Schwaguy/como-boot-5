<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section Narrow
The default template part for displaying page sections 
*/
$sectionInfo = getSectionInfo($section);
$overlay = checkBGoverlay($sectionInfo);
?>
<section id="<?=$sectionInfo['sectionID']?>" class="page-section <?=$sectionInfo['sectionClass']?> <?=$sectionInfo['bgclass']?> clearfix" <?=$sectionInfo['sectionStyle']?>>
	<?=$overlay?>
	<div class="section-content">
		<div class="container main">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-11 outer-wrap">
					<?=formatSectionContent($sectionInfo,'section')?>
				</div>
			</div>
		</div>
	</div>
</section>