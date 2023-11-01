<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php
/*  
Template Name: Page Section Extra Narrow
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
				<div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10 col-xxl-9 outer-wrap">
					<div class="inner-wrap">
						<?=formatSectionContent($sectionInfo,'section')?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>