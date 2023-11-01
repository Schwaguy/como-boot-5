<?php
// Specify Main Section Fields
$GLOBALS['mainSectionFields'] = array('mainID','mainClass','rowClass','titleLink','headerClass','titleClass','subtitleClass','subtitle2Class','contentClass','contentInnerClass','bgcolor','parallax','overlayColor','overlayOpacity','bgvalue','mainSectionTemplate','mainHorizontalClass','mainVerticalClass','mainContentColXXXXS','mainContentColXXXS','mainContentColXXS','mainContentColXS','mainContentColSM','mainContentColMD','mainContentColLG','mainContentColXL','mainContentColXXL','mainContentColXXXL','mainContentColXXXXL','mainBgImage','mainAside','mainAsideColXXXXS','mainAsideColXXXS','mainAsideColXXS','mainAsideColXS','mainAsideColSM','mainAsideColMD','mainAsideColLG','mainAsideColXL','mainAsideColXXL','mainAsideColXXXL','mainAsideColXXXXL','asideTitle','asideTitleLink','asideSubtitle','asideClass','asideTitleClass','asideSubtitleClass','asideWrapClass','asideContentClass','asideHeaderClass','asideID','asideContent','additionalContent','additionalContentRowClass','additionalContentColOneClass','additionalContentColTwoClass','additionalContentColTwoContent');
// Specify Repeating Section Fields
$GLOBALS['sectionFields'] = array('sectionOrder','sectionTitle','sectionID','sectionClass','sectionHeaderClass','sectionTitleClass','sectionTitleLink','sectionRowClass','sectionSubtitle','sectionSubtitleClass','sectionContentClass','sectionContentInnerClass','sectionBgColor','sectionParallax','sectionOverlayColor','sectionOverlayOpacity','sectionBgValue','sectionBgImage','sectionTemplate','sectionContent','sectionAside','sectionHorizontalClass','sectionVerticalClass','sectionContentColXXXXS','sectionContentColXXXS','sectionContentColXXS','sectionContentColXS','sectionContentColSM','sectionContentColMD','sectionContentColLG','sectionContentColXL','sectionContentColXXL','sectionContentColXXXL','sectionContentColXXXXL','sectionAsideColXXXXS','sectionAsideColXXXS','sectionAsideColXXS','sectionAsideColXS','sectionAsideColSM','sectionAsideColMD','sectionAsideColLG','sectionAsideColXL','sectionAsideColXXL','sectionAsideColXXXL','sectionAsideColXXXXL','sectionAsideHeaderClass','sectionAsideTitle','sectionAsideTitleLink','sectionAsideTitleClass','sectionAsideSubtitle','sectionAsideSubtitleClass','sectionAsideClass','sectionAsideID','sectionAsideWrapClass','sectionAsideContentClass','sectionAsideContent','sectionAdditionalContent','sectionAdditionalContentRowClass','sectionAdditionalContentColOneClass','sectionAdditionalContentColTwoClass','sectionAdditionalContentColTwoContent'); 
$GLOBALS['checkboxVars'] = array('sectionParallax');
//$GLOBALS['sectionColumnFields'] = array('mainColumnWidths','asideColumnWidths');
$GLOBALS['bgValueFields'] = array('bgvalue','sectionBgValue');
$GLOBALS['parallaxFields'] = array('parallax','sectionParallax');
$GLOBALS['titles'] = array('asideTitle','asideSubtitle','sectionTitle','sectionSubtitle','sectionAsideTitle','sectionAsideSubtitle');
$GLOBALS['textAreas'] = array('asideContent','sectionContent','additionalContent','additionalContentColTwo','sectionAsideContent','sectionAdditionalContent','sectionAdditionalContentColTwo');
$GLOBALS['colWidths'] = array('XXXXS','XXXS','XXS','XS','SM','MD','LG','XL','XXL','XXXL','XXXXL');
$GLOBALS['horizontalOptions'] = array(
	'justify-content-start' => 'Justify Columns Start',
	'justify-content-center' => 'Justify Columns Center',
	'justify-content-end' => 'Justify Columns End',
	'justify-content-around' => 'Justify Columns Around',
	'justify-content-between' => 'Justify Columns Between',
	'global' => 'Use Global Column Settings'
);
$GLOBALS['verticalOptions'] = array(
	'align-items-start' => 'Align Columns Start',
	'align-items-center' => 'Align Columns Center',
	'align-items-end' => 'Align Columns End'
);
// Register Color Picker and Image Upload scripts
function como_sectionalPage_scripts_enqueue() {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('meta-box-color-js', get_template_directory_uri() .'/js/meta-box-colorpicker.js', array('wp-color-picker'));
    wp_enqueue_media();
	wp_register_script( 'como-img-upload', get_template_directory_uri() . '/js/image-upload.js', array( 'jquery' ) );
	wp_localize_script( 'como-img-upload', 'meta_image',
		array(
			'title' => 'Choose or Upload an Image',
			'button' => 'Use this image'
		)
	);
	wp_enqueue_script( 'como-img-upload' );
}
// Get Available Sidebars
function sectionAsideOptions($sectionSB, $fieldName) {
	?>
	<select name="<?=$fieldName?>" class="sectionAside sectionInput">
		<?php
			$nosbSel = '';
			$customSel = '';
			if (($sectionSB == 'no-sidebar') || empty($sectionSB)) {
				$nosbSel = 'selected="selected"';
			} elseif ($sectionSB == 'custom-sidebar') {
				$customSel = 'selected="selected"';
			} 
		?>
		<option value="no-sidebar">No Sidebar</option>
		<option value="custom-sidebar" <?=$customSel?>>Custom Sidebar</option>
		<?php
			foreach ($GLOBALS['wp_registered_sidebars'] as $sb) {
				if ((!strpos($sb['id'], 'footer')) && (!strpos($sb['id'], 'header'))) {
					$sbSelected = (($sectionSB==$sb['id']) ? 'selected="selected"' : '');
					?>
					<option value="<?=$sb['id']?>" <?=$sbSelected?>><?=$sb['name']?></option>
					<?php
				}
			}
		?>
	</select>
	<?php
}
// Get available Templates
function getPageSectionTemplates($sectionTemp, $fieldName) {
	$comoDir = trailingslashit(get_template_directory()) .'template-parts';
	$themeDir = trailingslashit(get_stylesheet_directory()) .'template-parts';
	$sectionTemplates = array();
	if ($dir = opendir($comoDir)) {
		while (false !== ($file = readdir($dir))) {
			if ($file != "." && $file != ".." && $file != "_notes") {
				// Get Template Name
				$filedata = get_file_data($comoDir .'/'. $file, array('name'=>'Template Name'));
				$sectionTemplates[] = array('file'=>$file,'name'=>$filedata['name']);
			}
		}
		closedir($dir);
	}
	if (file_exists($themeDir)) {
		if ($dir = opendir($themeDir)) {
			while (false !== ($file = readdir($dir))) {
				if ($file != "." && $file != ".." && $file != "_notes") {
					// Get Template Name
					$filedata = get_file_data($themeDir .'/'. $file, array('name'=>'Template Name'));
					$sectionTemplates[] = array('file'=>$file,'name'=>$filedata['name']);
				}
			}
			closedir($dir);
		}
	}
	$sectionTemplates = array_map('unserialize', array_unique(array_map('serialize', $sectionTemplates)));
	
	$selectOptions = array();
	foreach ($sectionTemplates as $temp) {
		if (isset($temp['file'])) {
			if (strpos($temp['file'], 'page-section') !== false) {
				$selectOptions[] = $temp;
			}
		}
	}
	
	$defaltSel = (((empty($sectionTemp)) || ($sectionTemp == 'default')) ? 'selected="selected"' : '');
	?>
	<select name="<?=$fieldName?>" class="sectionTemplateSelect sectionInput">
		<option value="content-page-section.php" <?=$defaltSel?>>Default</option>
		<?php
			foreach($selectOptions as $template) {
				
				echo '<option value="'. $template['file'] .'" '. (($sectionTemp == $template['file']) ? ' selected="selected"' : '') .'>'. $template['name'] .'</option>';
			}
		?>
	</select>
	<?php
}
// Get Bootstrap Column Settings
function getColumns($columnData, $format, $fieldTitle, $repeater=false) {
	$columnData = ((!is_array($columnData)) ? (explode(',',$columnData)) : $columnData);
	if ($format == 'adminForm') {
		foreach ($GLOBALS['colWidths'] as $col) {
			?><td><label><?=$col?>:</label><input type="number" min="0" max="12" name="<?=$fieldTitle?><?=$col?><?=(($repeater) ? '[]' : '')?>" class="sectionInput sectionContent<?=$col?>" value="<?=((isset($columnData[$col])) ? $columnData[$col] : '')?>" /></td><?php
		}
	} elseif ($format == 'adminPage') {
		foreach ($GLOBALS['colWidths'] as $col) {
			?><div><p><label><?=$col?>:</label><input type="number" min="0" max="12" name="<?=$fieldTitle?><?=$col?><?=(($repeater) ? '[]' : '')?>" class="sectionInput sectionContent<?=$col?>" value="<?=(isset($columnData[$col]) ? $columnData[$col] : '')?>" style="display: block; width: 97%" /></p></div><?php
		}
	} elseif ($format == 'arrap') {
		$variableArr = array();
		foreach ($GLOBALS['colWidths'] as $col) {
			$variableArr[$col] = (isset($columnData[$col]) ? $columnData[$col] : ''); 
		}
		return $variableArr;
	} 
}
// Build Main Section Info Admin Form
function como_section_meta_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'como_section_nonce');
	$mainSectionInfo = get_post_meta($post->ID, 'mainSectionInfo', true);
	
	// Get Section Values
	foreach ($GLOBALS['mainSectionFields'] as $fieldName) {
		$$fieldName = (isset($mainSectionInfo[$fieldName]) ? (((!empty($mainSectionInfo[$fieldName]))) ? $mainSectionInfo[$fieldName] : '') : '');
		//echo '<br>'. $fieldName .': '. $$fieldName;
	}
	$colClass = 'col col-12 col-md-6 col-xxl-4 field-wrap'; 
	$labelClass = 'col-12 col-md-3';
	$inputClass = 'col-12 col-md-9 input-col'; 
	?>
	<div class="row como-admin main-section-info">
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Section ID', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="mainID" value="<?=$mainID?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Section Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="mainClass" value="<?=$mainClass?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Row Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="rowClass" value="<?=$rowClass?>" /><p class="note">Applied to to the row that surrounds content and sidebar</p></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Title Link', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="titleLink" value="<?=$titleLink?>" />
				<p class="note">If section title should be a link</p></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Header Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="headerClass" value="<?=$headerClass?>" /><p class="note">Class that wraps both title and subtitle</p></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Title Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="titleClass" value="<?=$titleClass?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Subtitle Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="subtitleClass" value="<?=$subtitleClass?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Secondary Subtitle Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="subtitle2Class" value="<?=$subtitle2Class?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Content Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="contentClass" value="<?=$contentClass?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Content Inner Class', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="text" name="contentInnerClass" value="<?=$contentInnerClass?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Background Color', 'como' )?></label>
				<div class="<?=$inputClass?>"><input name="bgcolor" type="text" value="<?=$bgcolor?>" class="meta-color" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Parallax', 'como' )?></label>
				<div class="<?=$inputClass?> pt-1">
					<input type="hidden" name="parallax" value="no" />
					<input type="checkbox" name="parallax" id="parallax" value="yes" <?php if (isset($parallax)) checked($parallax, 'yes'); ?> /> <span class="note"><?php _e( 'Enable Parallax Scrolling for background image', 'como' )?></span>
				</div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Overlay Color', 'como' )?></label>
				<div class="<?=$inputClass?>"><input name="overlayColor" type="text" value="<?=$overlayColor?>" class="meta-color" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Overlay Opacity', 'como' )?></label>
				<div class="<?=$inputClass?>"><input type="number" name="overlayOpacity" min="0.00" max="1.00" step="0.01" value="<?=$overlayOpacity?>" /></div>
			</div>
		</div>
		<div class="<?=$colClass?>">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Background Value', 'como' )?></label>
				<div class="<?=$inputClass?> pt-1">
					<div>
						<input type="radio" name="bgvalue" value="light" <?php if (isset($bgvalue)) checked($bgvalue, 'light' ); ?>>
						<?php _e( 'Light Background', 'como' )?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="bgvalue" value="dark" <?php if (isset($bgvalue)) checked($bgvalue, 'dark' ); ?>>
						<?php _e( 'Dark Background', 'como' )?>
					</div>
					<?php _e( '<br><em>Assigns a "light" or "dark" class to section for content styling</em>', 'como' )?>
				</div>
			</div>
		</div>
		
		<!--  Column Allignment Options -->
		<div class="col-12 pb-3">
			<div class="row">
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Horizontal', 'como' )?></label>
						<div class="<?=$inputClass?>">
							<select name="mainHorizontalClass">
							<?php 
								foreach ($GLOBALS['horizontalOptions'] as $key=>$value) {
									echo '<option value="'. $key .'" '. (($key==$mainHorizontalClass) ? ' selected="selected"' : '') .'>'. $value .'</option>'; 
								}
							?>
							</select>
						</div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Vertical', 'como' )?></label>
						<div class="<?=$inputClass?>">
							<select name="mainVerticalClass">
								<option value="">&lt; select &gt;</option>
							<?php 
								foreach ($GLOBALS['verticalOptions'] as $key=>$value) {
									echo '<option value="'. $key .'" '. (($key==$mainVerticalClass) ? ' selected="selected"' : '') .'>'. $value .'</option>'; 
								}
							?>
							</select>
						</div>
					</div>
				</div>
			</div>	
		</div>
		
		<!-- Content Columns Widths -->
		<div class="col-12 pt-3">
			<div class="row">
				<label class="col-12 col-md-2 col-xl-1"><p class="sidebar-column-title">Content Columns</p></label>
				<div class="col-12 col-md-10 col-xl-11 input-col">
					<table class="como-meta-table">
						<tr>
							<?php 
								$mainColumnWidths = array();
								foreach($GLOBALS['colWidths'] as $col) {
									$var = 'mainContentCol'. $col;
									$mainColumnWidths[$col] = $$var;
								}
							?>
							<?=getColumns($mainColumnWidths, 'adminForm', 'mainContentCol')?>
						</tr>
						<tr>
							<td colspan="8">
								<p class="note">Set column widths for Main Content Area</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<!-- Main Section Background Image -->	
		<div class="<?=$colClass?> bg-image-col">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Background Image', 'como' )?></label>
				<div class="<?=$inputClass?> upload-field">
					<?php
						// Get WordPress' media upload URL
						$upload_link = esc_url(get_upload_iframe_src('image', $post->ID));
	
						// Get the image src
						$mainBgImage_img_src = wp_get_attachment_image_src($mainBgImage, 'medium');
						$have_mainBgImage = is_array($mainBgImage_img_src);
					?>
					<div class="row image-upload-form">
						<div class="col-12 col-md-6">
							<a class="upload_mainBgImage meta-image-button button <?php if ($have_mainBgImage) { echo 'hidden'; } ?>" href="<?php echo $upload_link ?>"><?php _e('Set custom image')?></a>
						
							<a class="delete_mainBgImage meta-image-delete-button button <?php if (!$have_mainBgImage) { echo 'hidden'; } ?>" href="#"><?php _e('Remove this image')?></a><br>
							
							<input class="image-upload-field" name="mainBgImage" type="hidden" value="<?php echo esc_attr($mainBgImage); ?>" />
						</div>
						<div class="col-12 col-md-6 custom-img-wrap">
							<?php if ($have_mainBgImage) : ?>
							<img src="<?php echo $mainBgImage_img_src[0] ?>" alt="" class="bg-preview" />
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php $mainSidebar = ((isset($mainAside)) ? $mainAside : ''); ?>
		<div class="<?=$colClass?> sidebar-select">
			<div class="row">
				<label class="<?=$labelClass?>"><?php _e( 'Main Sidebar', 'como' )?></label>
				<div class="col-12 col-md-9 input-col pt-1">
					<?=sectionAsideOptions($mainSidebar, 'mainAside')?> 
					<p class="note">Does this section have a sidebar?</p>
				</div>
			</div>
		</div>
		
		<div class="col-12 sidebar-columns <?=(($mainAside=='no-sidebar') ? 'hide' : 'show')?>">
			<div class="row">
				<label class="col-12 col-md-2 col-xl-1"><p class="sidebar-column-title"><?php _e( 'Sidebar Columns', 'como' )?></p></label>
				<div class="col-12 col-md-10 col-xl-11 input-col">
					<table class="como-meta-table">
						<tr>
							<?php 
								$asideColumnWidths = array();
								foreach($GLOBALS['colWidths'] as $col) {
									$var = 'mainAsideCol'. $col;
									$asideColumnWidths[$col] = $$var;
								}
							?>
							<?=getColumns($asideColumnWidths, 'adminForm', 'mainAsideCol')?>
						</tr>
						<tr>
							<td colspan="8">
								<p class="note">Set column widths for Sidebar</p>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<label class="col-12 col-md-2 col-xl-1"><?php _e( 'Sidebar Class', 'como' )?></label>
				<div class="col-12 col-md-10 col-xl-11 input-col"><input type="text" name="asideClass" class="sectionAsideClass sectionInput" value="<?=$asideClass?>" />
				<p class="note">Applied to entire Sidebar</p></div>
			</div>
		</div>
		
		<div id="main-aside" class="col-12 section-custom-sidebar <?=(($mainSidebar=='custom-sidebar') ? 'show' : 'hide')?>">
			<h2 class="section-aside-title">Custom Sidebar</h2>
			
			<div class="row">
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Title', 'como' )?></label>
						<div class="<?=$inputClass?>"><input type="text" name="asideTitle" class="sectionAsideTitle sectionInput" value="<?=$asideTitle?>" />
						<p class="note">Main title for Sidebar Section</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Sidebar ID', 'como' )?></label>
						<div class="<?=$inputClass?>"><input type="text" name="asideID" class="sectionAsideID sectionInput" value="<?=$asideID?>" />
						<p class="note">Applied to entire Sidebar</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Wrap Class', 'como' )?></label>
						<div class="<?=$inputClass?>"><input name="asideWrapClass" type="text" class="sectionAsideWrapClass sectionInput" value="<?=$asideWrapClass?>" />
						<p class="note">Wraps aside header and content areas</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Title Class', 'como' )?></label>
						<div class="<?=$inputClass?>"><input name="asideTitleClass" type="text" class="asideTitleClass sectionInput" value="<?=$asideTitleClass?>" />
						<p class="note">Applied to Sidebar Title</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Title Link', 'como' )?></label>
						<div class="<?=$inputClass?>"><input type="text" name="asideTitleLink" class="sectionAsideTitleLink sectionInput" value="<?=$asideTitleLink?>" />
						<p class="note">Applied to Sidebar Title</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Header Class', 'como' )?></label>
						<div class="<?=$inputClass?>"><input name="asideHeaderClass" type="text" class="sectionAsideHeaderClass sectionInput" value="<?=$asideHeaderClass?>" />
						<p class="note">Applied to Sidebar Header</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Subtitle', 'como' )?></label>
						<div class="<?=$inputClass?>"><input type="text" name="asideSubtitle" class="sectionAsideSubtitle sectionInput" value="<?=$asideSubtitle?>" />
						<p class="note">Subtitle for Sidebar Section</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Subtitle Class', 'como' )?></label>
						<div class="<?=$inputClass?>"><input name="asideSubtitleClass" type="text" class="sectionAsideSubtitleClass sectionInput" value="<?=$asideSubtitleClass?>" />
						<p class="note">Applied to Sidebar Subtitle</p></div>
					</div>
				</div>
				<div class="<?=$colClass?>">
					<div class="row">
						<label class="<?=$labelClass?>"><?php _e( 'Content Class', 'como' )?></label>
						<div class="<?=$inputClass?>"><input name="asideContentClass" type="text" class="sectionAsideContentClass sectionInput" value="<?=$asideContentClass?>" />
						<p class="note">Applied to Sidebar Content</p></div>
					</div>
				</div>
			</div>
			<div class="row">	
				<div class="col-12">
					<div class="row">
						<div class="col-12">
							<div class="input-col">
								<?=
								// create a new instance of the WYSIWYG editor
								wp_editor(html_entity_decode($asideContent), 'main-aside-editor', array(
									'wpautop'       => true,
									'textarea_name' => 'asideContent',
									'textarea_rows' => 10
								) )
								?>
							</div>	
						</div>
					</div>
				</div>
			</div>
			
			
			
		</div>
		
		<div class="col col-12">
			<div class="row additional-content-toggle">
				<div class="col-12"><strong>Additional Section Content</strong></div>
			</div>
			<div class="row additional-content">
				<div class="col-12">
					<div class="row">
						<div class="col-12">
							<div class="input-col">
								<div class="row">
									<label class="col-12 col-md-2 col-xxl-1">Content Row Class</label>
									<div class="col-12 col-md-10 col-xxl-11 input-col"><input type="text" name="additionalContentRowClass" class="additionalContentRowClass sectionInput" value="<?=$additionalContentRowClass?>" />
									<p class="note">Applied to Additional Content Area Row</p></div>
								</div>
								<div class="row">
									<div class="col col-12 col-lg-6">	
										<div class="row">
											<label class="<?=$labelClass?>">Col One Class</label>
											<div class="<?=$inputClass?>"><input type="text" name="additionalContentColOneClass" class="additionalContentColOneClass sectionInput" value="<?=$additionalContentColOneClass?>" />
											<p class="note">Applied to Additional Content Area Column One</p></div>
										</div>
										<?=
										// create a new instance of the WYSIWYG editor
										wp_editor(html_entity_decode($additionalContent), 'additional-content-editor', array(
											'wpautop'       => true,
											'textarea_name' => 'additionalContent',
											'textarea_rows' => 10
										) )
										?>
										<p class="note">Additional Content Column Two <strong>WILL NOT</strong> display if Column One is Blank</p>
									</div>
									<div class="col col-12 col-lg-6">	
										<div class="row">
											<label class="<?=$labelClass?>">Col Two Class</label>
											<div class="<?=$inputClass?>"><input type="text" name="additionalContentColTwoClass" class="additionalContentColTwoClass sectionInput" value="<?=$additionalContentColTwoClass?>" />
											<p class="note">Applied to Additional Content Area Column Two</p></div>
										</div>
										<?=
										// create a new instance of the WYSIWYG editor
										wp_editor(html_entity_decode($additionalContentColTwoContent), 'additional-content-editor', array(
											'wpautop'       => true,
											'textarea_name' => 'additionalContentColTwoContent',
											'textarea_rows' => 10
										) )
										?>
										<p class="note">Additional Content Column Two <strong>WILL NOT</strong> display if Column One is Blank</p>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <input type="hidden" name="comoSection_update_flag" value="true" />
	<?php
}
// Build Repeatable Section Admin Form(s)
function showSectionForm($fields, $sectionFields, $hidden=false) {
	// Get Section Values
	foreach ($sectionFields as $fieldName) {
		$$fieldName = (isset($fields[$fieldName]) ? (((!empty($fields[$fieldName]))) ? $fields[$fieldName] : '') : '');
	}
	$visibleClass = (($hidden==true) ? '' : 'sectionOrder-visible');
	$colClass = 'col col-12 col-md-6 col-xxl-4'; 
	$labelClass = 'col-12 col-md-3';
	$inputClass = 'col-12 col-md-9 input-col';
	?>
	<table class="como-section-table">
		<tr class="title-row">
			<td class="handle como-handle order-handle order ui-sortable-handle" title="Drag to Reorder" rowspan="2">
				<input type="text" class="como_sectionOrder <?=$visibleClass?>" name="sectionOrder[]" value="<?=$sectionOrder?>" readonly />
			</td>
			<td class="handle como-handle order ui-sortable-handle section-header"><h3 class="section-title"><?=((!empty($sectionTitle)) ? $sectionTitle : '<span class="title-placeholder">Add New page Section</span>')?></h3></td>
			<td class="content-toggle"><a href="#"></a></td>
		</tr>
		<tr class="section-content">
			<td>
				<div class="section-form-wrap">
					<h2 class="section-aside-title">Content Area</h2>
					<div class="row">
						<div class="<?=$colClass?>">
							<div class="row">
								<label class="<?=$labelClass?>">Section Title</label>
								<div class="<?=$inputClass?>"><input type="text" name="sectionTitle[]" class="sectionTitle sectionInput" value="<?=$sectionTitle?>" /><p class="note">Page Section Title</p></div>
							</div>
						</div>
						<div class="<?=$colClass?>">
							<div class="row">
								<label class="<?=$labelClass?>">Subtitle</label>
								<div class="<?=$inputClass?>"><input type="text" name="sectionSubtitle[]" class="sectionSubtitle sectionInput" value="<?=$sectionSubtitle?>" /><p class="note">Subtitle for section</p></div>
							</div>
						</div>
					</div>
					
					<div class="row settings-toggle">
						<div class="col-12"><strong>Section Settings</strong></div>
					</div>
					
					<div class="section-settings">
					
						<div class="row">
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Section ID</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionID[]" class="sectionID sectionInput" value="<?=$sectionID?>" />
									<p class="note">Page Section ID</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Section Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionClass[]" class="sectionClass sectionInput" value="<?=$sectionClass?>" />
									<p class="note">Applied to entire page section</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Row Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionRowClass[]" class="sectionRowClass sectionInput" value="<?=$sectionRowClass?>" />
									<p class="note">Applies to row that surrounds content and sidebar</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Header Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionHeaderClass[]" class="sectionHeaderClass sectionInput" value="<?= $sectionHeaderClass?>" />
									<p class="note">Applied to section header</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Title Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionTitleClass[]" class="sectionTitleClass sectionInput" value="<?= $sectionTitleClass?>" />
									<p class="note">Applied to section title</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Title Link</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionTitleLink[]" class="sectionTitleLink sectionClass sectionInput" value="<?=$sectionTitleLink?>" />
									<p class="note">If section title should be a link </p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Subtitle Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionSubtitleClass[]" class="sectionSubtitleClass sectionInput" value="<?=$sectionSubtitleClass?>" />
									<p class="note">Applied to section title</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Content Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionContentClass[]" class="sectionContentClass sectionInput" value="<?=$sectionContentClass?>" />
									<p class="note">Applied to sections main content area (including title)</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Content Inner Class</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionContentInnerClass[]" class="sectionContentInnerClass sectionInput" value="<?=$sectionContentInnerClass?>" />
									<p class="note">Applied to only main content (not including title)a</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">BG Color</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionBgColor[]" class="sectionBgColor sectionInput meta-color" value="<?=$sectionBgColor?>" />
									<span class="note">Background Color for entire section</span></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Overlay Color</label>
									<div class="<?=$inputClass?>"><input type="text" name="sectionOverlayColor[]" class="sectionOverlayColor sectionInput meta-color" value="<?=$sectionOverlayColor?>" />
									<span class="note">Overlay Color for Image Background</span></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Parallax</label>
									<div class="<?=$inputClass?> pt-1">
										<div class="specFieldWrap">
											<input type="checkbox" value="yes" <?=(($sectionParallax == 'yes') ? 'checked="checked"' : '')?> class="sectionParallax sectionInput sectionInputCheckbox" /> 
											<span class="note">Enable Parallax Background Image</span>
											<input type="hidden" class="sectionInputCheckboxValue" name="sectionParallax[]" value="<?=$sectionParallax?>" />
										</div>
									</div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">Overlay Opacity</label>
									<div class="<?=$inputClass?>"><input type="number" min="0.00" max="1.00" step="0.01" name="sectionOverlayOpacity[]" class="sectionOverlayOpacity sectionInput" value="<?=$sectionOverlayOpacity?>" />
									<p class="note">Sets opacity of BG overlay color</p></div>
								</div>
							</div>
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>">BG Value</label>
									<div class="<?=$inputClass?> pt-1">
										<div class="specFieldWrap">
											<input type="radio" class="sectionInputRadio" name="sectBGval-<?=$sectionOrder?>" value="light" <?php if (isset($sectionBgValue)) checked($sectionBgValue, 'light' ); ?>> <?php _e( 'Light Background', 'como' )?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" class="sectionInputRadio" name="sectBGval-<?=$sectionOrder?>" value="dark" <?php if (isset($sectionBgValue)) checked($sectionBgValue, 'dark' ); ?>>
											<?php _e( 'Dark Background', 'como' )?>
											<p class="note">Assigns a "light" or "dark" class to section for content styling</p>
											<input type="hidden" name="sectionBgValue[]" value="<?=$sectionBgValue?>" class="sectionBgValue sectionInput sectionInputRadioValue" /> 
										</div>
									</div>
								</div>
							</div>
							<!-- Section Background Image -->	
							<div class="<?=$colClass?> bg-image-col">
								<div class="row">
									<label class="<?=$labelClass?>"><?php _e( 'Background Image', 'como' )?></label>
									<div class="<?=$inputClass?> upload-field">
										<?php
											global $post;
											$sectionBgImage_img_src = ''; 
											$have_sectionBgImage = '';
											// Get WordPress' media upload URL
											$upload_link = esc_url(get_upload_iframe_src('image', $post->ID));
											// Get the image src
											$sectionBgImage_img_src = wp_get_attachment_image_src($sectionBgImage, 'medium');
											$have_sectionBgImage = is_array($sectionBgImage_img_src);
										?>
										<div class="row image-upload-form">
											<div class="col-12 col-md-6">
												<a class="upload_sectionBgImage meta-image-button button <?php if ($have_sectionBgImage) { echo 'hidden'; } ?>" href="<?php echo $upload_link ?>"><?php _e('Set BG Image')?></a>
												<a class="delete_sectionBgImage meta-image-delete-button button <?php if (!$have_sectionBgImage) { echo 'hidden'; } ?>" href="#"><?php _e('Remove BG Image')?></a><br>
												<input class="image-upload-field" name="sectionBgImage[]" type="hidden" value="<?php echo esc_attr($sectionBgImage); ?>" />
											</div>
											<div class="col-12 col-md-6 custom-img-wrap">
												<?php if ($have_sectionBgImage) : ?>
												<img src="<?php echo $sectionBgImage_img_src[0] ?>" alt="" class="bg-preview" />
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php $sectionBgImage = ''; ?>
							<!-- Section Template Select -->
							<div class="<?=$colClass?>">
								<div class="row">
									<label class="<?=$labelClass?>"><?php _e( 'Section Template', 'como' )?></label>
									<div class="<?=$inputClass?>">
										<?=getPageSectionTemplates($sectionTemplate, 'sectionTemplate[]')?>
										<p class="note">Select Page Section Template</p>
									</div>
								</div>
							</div>
							<!--  Column Allignment Options -->
							<div class="col-12 pb-3">
								<div class="row">
									<div class="<?=$colClass?>">
										<div class="row">
											<label class="<?=$labelClass?>"><?php _e( 'Horizontal', 'como' )?></label>
											<div class="<?=$inputClass?>">
												<select name="sectionHorizontalClass[]">
												<?php 
													foreach ($GLOBALS['horizontalOptions'] as $key=>$value) {
														echo '<option value="'. $key .'" '. (($key==$sectionHorizontalClass) ? ' selected="selected"' : '') .'>'. $value .'</option>'; 
													}
												?>
												</select>
											</div>
										</div>
									</div>
									<div class="<?=$colClass?>">
										<div class="row">
											<label class="<?=$labelClass?>"><?php _e( 'Vertical', 'como' )?></label>
											<div class="<?=$inputClass?>">
												<select name="sectionVerticalClass[]">
												<?php 
													foreach ($GLOBALS['verticalOptions'] as $key=>$value) {
														echo '<option value="'. $key .'" '. (($key==$sectionVerticalClass) ? ' selected="selected"' : '') .'>'. $value .'</option>'; 
													}
												?>
												</select>
											</div>
										</div>
									</div>
								</div>	
							</div>
							<!-- Content Column Width -->						
							<div class="col-12">
								<div class="row">
									<label class="col-12 col-md-2 col-xl-1"><p class="sidebar-column-title">Content Columns</p></label>
									<div class="col-12 col-md-10 col-xl-11 input-col">
										<table class="como-meta-table">
											<tr>
												<?php 
													$sectionContentCols = array();
													foreach($GLOBALS['colWidths'] as $col) {
														$var = 'sectionContentCol'. $col;
														$sectionContentCols[$col] = $$var;
													}
												?>
												<?=getColumns($sectionContentCols, 'adminForm', 'sectionContentCol', true)?>
											</tr>
											<tr>
												<td colspan="7">
													<p class="note">Set column widths for Main Content Area</p>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div><!-- / section-settings -->
					
					<div class="row">
						<div class="col-12">
							<div class="row">
								<div class="col-12">
									<!--<label>Section Content</label>-->
									<div class="input-col">
										<?php
										// create a new instance of the WYSIWYG editor
										wp_editor(htmlspecialchars_decode($sectionContent), 'section-editor-'. $sectionOrder, array(
											'wpautop'       => true,
											'textarea_name' => 'sectionContent[]',
											'textarea_rows' => 10,
										) )
										?>
									</div>	
								</div>
							</div>
						</div>
						<div class="col-12 sidebar-select">
							<div class="row">
								<label class="<?=$labelClass?>">Section Sidebar</label>
								<div class="<?=$inputClass?> pt-1">
									<?=sectionAsideOptions($sectionAside, 'sectionAside[]')?> <span class="note">Does this section have a sidebar?</span>
								</div>
							</div>
						</div>
						<div class="col-12 sidebar-columns <?=(($sectionAside=='no-sidebar') ? 'hide' : 'show')?>">
							<div class="row">
								<label class="col-12 col-md-2 col-xl-1"><p class="sidebar-column-title">Sidebar Columns</p></label>
								<div class="col-12 col-md-10 col-xl-11 input-col">
									<table class="como-meta-table">
										<tr>
											<?php 
												$sectionAsideCols = array();
												foreach($GLOBALS['colWidths'] as $col) {
													$var = 'sectionAsideCol'. $col;
													$sectionAsideCols[$col] = $$var;
												}
											?>
											<?=getColumns($sectionAsideCols, 'adminForm', 'sectionAsideCol', true)?>
										</tr>
										<tr>
											<td colspan="7">
												<p class="note">Set column widths for Sidebar</p>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row">
								<label class="col-12 col-md-2 col-xl-1">Sidebar Class</label>
								<div class="col-12 col-md-10 col-xl-11 input-col"><input type="text" name="sectionAsideClass[]" class="sectionAsideClass sectionInput" value="<?=$sectionAsideClass?>" />
								<p class="note">Applied to entire Sidebar</p></div>
							</div>
						</div>	
						
						<div class="col-12 section-custom-sidebar <?=(($sectionAside=='custom-sidebar') ? 'show' : 'hide')?>">
							<h2 class="section-aside-title">Custom Sidebar</h2>
							<div class="row">
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Aside Title</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideTitle[]" class="sectionAsideTitle sectionInput" value="<?=$sectionAsideTitle?>" />
										<p class="note">Main title for Aside Section</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Aside ID</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideID[]" class="sectionAsideID sectionInput" value="<?=$sectionAsideID?>" />
										<p class="note">Applied to Aside</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Wrap Class</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideWrapClass[]" class="sectionAsideWrapClass sectionInput" value="<?=$sectionAsideWrapClass?>" />
										<p class="note">Wraps aside header and content areas</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Title Class</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideTitleClass[]" class="sectionAsideTitleClass sectionInput" value="<?=$sectionAsideTitleClass?>" />
										<p class="note">Applied to Aside Main Title</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Title Link</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideTitleLink[]" class="sectionAsideTitleLink sectionInput" value="<?=$sectionAsideTitleLink?>" />
										<p class="note">Applied to Aside Main Title</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Header Class</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideHeaderClass[]" class="sectionAsideHeaderClass sectionInput" value="<?=$sectionAsideHeaderClass?>" />
										<p class="note">Applied to Aside Header</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Aside Subtitle</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideSubtitle[]" class="sectionAsideSubtitle sectionInput" value="<?=$sectionAsideSubtitle?>" />
										<p class="note">Subtitle for Aside Section</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Subtitle Class</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideSubtitleClass[]" class="sectionAsideSubtitleClass sectionInput" value="<?=$sectionAsideSubtitleClass?>" />
										<p class="note">Applied to Aside Subtitle</p></div>
									</div>
								</div>
								<div class="<?=$colClass?>">
									<div class="row">
										<label class="<?=$labelClass?>">Content Class</label>
										<div class="<?=$inputClass?>"><input type="text" name="sectionAsideContentClass[]" class="sectionAsideContentClass sectionInput" value="<?=$sectionAsideContentClass?>" />
										<p class="note">Applied to Aside Content</p></div>
									</div>
								</div>
								<div class="col-12">
									<div class="row">
										<div class="col-12">
											<div class="input-col">
												<?=
												// create a new instance of the WYSIWYG editor
												wp_editor(html_entity_decode($sectionAsideContent), 'aside-editor-'. $sectionOrder, array(
													'wpautop'       => true,
													'textarea_name' => 'sectionAsideContent[]',
													'textarea_rows' => 10
												) )
												?>
											</div>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Additional Content Section - Normally Beneath the main section -->
					
					<div class="row additional-content-toggle">
						<div class="col-12"><strong>Additional Section Content</strong></div>
					</div>
					
					<div class="row additional-content">
						<div class="col-12">
							<div class="row">
								<div class="col-12">
									<div class="input-col">
										<div class="row">
											<label class="col-12 col-md-2 col-xxl-1">Content Row Class</label>
											<div class="col-12 col-md-10 col-xxl-11 input-col"><input type="text" name="sectionAdditionalContentRowClass[]" class="sectionAdditionalContentRowClass sectionInput" value="<?=$sectionAdditionalContentRowClass?>" />
											<p class="note">Applied to Additional Content Area Row</p></div>
										</div>
										<div class="row">
											<div class="col col-12 col-lg-6">	
												<div class="row">
													<label class="<?=$labelClass?>">Col One Class</label>
													<div class="<?=$inputClass?>"><input type="text" name="sectionAdditionalContentColOneClass[]" class="sectionAdditionalContentColOneClass sectionInput" value="<?=$sectionAdditionalContentColOneClass?>" />
													<p class="note">Applied to Additional Content Area Column One</p></div>
												</div>
												<?=
												// create a new instance of the WYSIWYG editor
												wp_editor(html_entity_decode($sectionAdditionalContent), 'additional-content-editor-'. $sectionOrder, array(
													'wpautop'       => true,
													'textarea_name' => 'sectionAdditionalContent[]',
													'textarea_rows' => 10
												) )
												?>
												<p class="note">Additional Content Column Two <strong>WILL NOT</strong> display if Column One is Blank</p>
											</div>
											<div class="col col-12 col-lg-6">	
												<div class="row">
													<label class="<?=$labelClass?>">Col Two Class</label>
													<div class="<?=$inputClass?>"><input type="text" name="sectionAdditionalContentColTwoClass[]" class="sectionAdditionalContentColTwoClass sectionInput" value="<?=$sectionAdditionalContentColTwoClass?>" />
													<p class="note">Applied to Additional Content Area Column Two</p></div>
												</div>
												<?=
												// create a new instance of the WYSIWYG editor
												wp_editor(html_entity_decode($sectionAdditionalContentColTwoContent), 'additional-content-editor-'. $sectionOrder, array(
													'wpautop'       => true,
													'textarea_name' => 'sectionAdditionalContentColTwoContent[]',
													'textarea_rows' => 10
												) )
												?>
												<p class="note">Additional Content Column Two <strong>WILL NOT</strong> display if Column One is Blank</p>
											</div>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</td>
			<td class="btn-row">
				<div class="section-form-wrap">
					<a class="button button-secondary remove-row" href="#">Remove</a>
				</div>
			</td>
		</tr>
	</table>
	<?php
}
// Page Main Section Meta
add_action('admin_init','como_section_init');
function como_section_init() {
	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : '');
	if ($post_id) {
		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
		if (strpos($template_file, 'page-section') !== false) {
			
			// Add Main Section Info Metabox
			add_meta_box('como_section_meta', __('Main Page Section Info','como-section-meta'),'como_section_meta_callback','page','after_title','high');
			
			// Minify Main Section Info Metabox by default
			add_filter('postbox_classes_post_postexcerpt','minify_metabox');
			function minify_metabox($classes) {
				array_push($classes,'closed');
				return $classes;
			}
			
			//add_meta_box('como_section_sidebar', __('Section Sidebar','como-section-wysiwyg'),'comosection_wysiwyg_callback','page','after_title','high');
			
			// Add Color selection scripts
			add_action( 'admin_enqueue_scripts', 'como_sectionalPage_scripts_enqueue' );
		}
		dd_close_metabox_by_default('page', 'como_section_meta');
	}
}
// Initiate Repeatable Section meta Boxes
add_action('admin_init', 'add_repeatable_pagesection_meta_boxes', 2);
function add_repeatable_pagesection_meta_boxes() {
	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : '');
	if ($post_id) {
		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
		if ((strpos($template_file, 'page-section') !== false) || (strpos($template_file, 'sectional') !== false)) {
			add_meta_box( 'pagesection-group', __('Additional Page Sections','como-section-meta'), 'repeatable_pagesection_metabox_display', 'page', 'normal', 'high');
			add_action( 'admin_enqueue_scripts', 'como_sectionalPage_scripts_enqueue' );
			//add_action('admin_print_styles', 'como_sectionalPage_admin_styles');
		}
	}
}
// Display Section Admin Meta Box
function repeatable_pagesection_metabox_display() {
    global $post;
    $como_pageSections = get_post_meta($post->ID, 'como_pageSections', true);
	//wp_nonce_field( 'pre_repeatable_pagesection_metabox_nonce', 'pre_repeatable_pagesection_metabox_nonce' );
	wp_nonce_field(basename( __FILE__ ), 'como_section_nonce');
    ?>
    <script type="text/javascript">
		jQuery(document).ready(function( $ ){
			$('#add-row').on('click', function() {
				var row = $('.empty-row.screen-reader-text').clone(true);
				row.removeClass('empty-row screen-reader-text');
				row.insertBefore('#repeatable-pagesections-fieldset li:last');
				var inputs = $('#repeatable-pagesections-fieldset input.sectionOrder-visible');
				var nbElems = inputs.length;
				$(row).find('input.como_sectionOrder').val(nbElems+1).addClass('sectionOrder-visible');
				return false;
			});
			$('.remove-row').on('click', function() {
				$(this).parents('li').remove();
				return false;
			});
			$(function() {
				$('#repeatable-pagesections-fieldset').sortable({
					handle: '.handle',
					revert: true,
					stop: function () {
						var inputs = $('#repeatable-pagesections-fieldset input.como_sectionOrder');
						$(inputs).each(function(idx) {
							$(this).val(idx+1);
						});
					}
				});
				$('ul, li').disableSelection();
			});
			$('body').on('click', '.content-toggle', function() {
				$(this).toggleClass('open');
    			$header = $(this).closest('.title-row');
    			$content = $header.next('.section-content').find('.section-form-wrap');
    			$content.toggleClass('show');
				return false;
			});
			$('body').on('click', '.settings-toggle', function() {
				$(this).toggleClass('open');
    			$content = $(this).next('.section-settings');
    			$content.toggleClass('show');
				return false;
			});
			$('body').on('click', '.additional-content-toggle', function() {
				$(this).toggleClass('open');
    			$content = $(this).next('.additional-content');
    			$content.toggleClass('show');
				return false;
			});
			$('body').on('blur', '.first-section input.sectionInput', function() {
				if (!$(this).val()) {
					console.log('empty');
				} else {
					var orderField = $(this).closest('.como_sectionOrder');
					var sectionForm = $(this).closest('.como-section-table');
					if (!$(orderField).val()) {
						var iputs = $('#repeatable-pagesections-fieldset input.sectionOrder-visible');
						var nElems = iputs.length;
						$(sectionForm).find('input.como_sectionOrder').val(nElems).addClass('sectionOrder-visible');
					}
				}
			});
			$('body').on('keyup', '.first-section input.sectionTitle', function() {
				var newTitle = $(this).val();
				console.log(newTitle);
				$(this).closest('.como-section-table').find('.section-title').html(newTitle);
			});
			$('body').on('change', '.sectionAside', function() {
				var $asideValue = $(this).val();
				var $asideColumns = $(this).closest('.sidebar-select').next('.sidebar-columns');
				var $asideForm = $(this).parents('.como-admin').find('.section-custom-sidebar');
				
				// Show/Hide Sidebar column Width Form
				if ((($asideValue) === '') || ($asideValue === 'no-sidebar')) {
					$asideColumns.removeClass('show').addClass('hide');
					$asideForm.removeClass('show').addClass('hide');
				} else {
					$asideColumns.removeClass('hide').addClass('show');	
					if ($asideValue === 'custom-sidebar') {
						$asideForm.removeClass('hide').addClass('show');
					} else {
						$asideForm.removeClass('show').addClass('hide');
					}
				}
			});
			$('body').on('change', '.sectionInputCheckbox', function() {
				var $valField = $(this).parents('.specFieldWrap').children('.sectionInputCheckboxValue');
				var cbValue = $(this).val();
				if ($(this).is(':checked')) {
					$valField.val(cbValue);
				} else {
					$valField.val('');
				}
			});
			$('body').on('change', '.sectionInputRadio', function() {
				var $valField = $(this).parents('.specFieldWrap').find('.sectionInputRadioValue');
				var cbValue = $(this).val();
				$valField.val(cbValue);
			});
		});
	</script>
	<ul id="repeatable-pagesections-fieldset" class="sortable como-page-sections como-admin">
	<?php
		if ($como_pageSections) {
			$f = 0;
			foreach ($como_pageSections as $fields) {
				?><li class="ui-state-default como-page-section">
				<?=showSectionForm($fields, $GLOBALS['sectionFields']);?>
				</li><?php
			}
		} else {
			// show a blank section form
			?><li class="ui-state-default como-page-section first-section">
			<?=showSectionForm($fields=array(), $GLOBALS['sectionFields']);?>
			</li><?php
		}
	?>	
		<!-- add empty hidden section for jQuery -->
		<li class="empty-row screen-reader-text ui-state-default como-page-section">
			<?=showSectionForm($fields=array(), $GLOBALS['sectionFields'],true)?>
		</li>
	</ul>
	<p style="text-align: right; padding-right: 1em;"><a id="add-row" class="button button-primary" href="#">Add Section</a></p>
	<input type="hidden" name="comoSection_update_flag" value="true" />
	<?php
}
// Save Section Meta
add_action('save_post', 'repeatable_pagesection_metabox_save');
function repeatable_pagesection_metabox_save($post_id) {
	// Only do this if our custom flag is present
    if (isset($_POST['comoSection_update_flag'])) {
	
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'como_section_nonce' ] ) && wp_verify_nonce( $_POST[ 'como_section_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return; // Exits script depending on save status
		}
		if (!current_user_can('edit_post', $post_id))
			return;
		// Save Main Section info
		$oldMain = get_post_meta($post_id, 'mainSectionInfo', true);
		$newMain = array();
		foreach ($GLOBALS['mainSectionFields'] as $fieldName) {
			//echo '<br>'. $fieldName .': '. ((is_array($_POST[$fieldName])) ? 'ARRAY' : $_POST[$fieldName]); 
			//$newMain[$fieldName] = ((isset($_POST[$fieldName])) ? ((!empty($_POST[$fieldName])) ? ((is_array($_POST[$fieldName])) ? implode($_POST[$fieldName]) : ((in_array($fieldName,$GLOBALS['textAreas'])) ? htmlentities($_POST[$fieldName]) : $_POST[$fieldName])) : '') : '');
			$newMain[$fieldName] = ((isset($_POST[$fieldName])) ? ((!empty($_POST[$fieldName])) ? ((is_array($_POST[$fieldName])) ? implode($_POST[$fieldName]) : ((in_array($fieldName,$GLOBALS['textAreas'])) ? htmlentities($_POST[$fieldName]) : ((in_array($fieldName,$GLOBALS['titles'])) ? htmlentities($_POST[$fieldName]) : $_POST[$fieldName]))) : '') : '');
		}
		//exit;
		
		// Save Repeatable Page Sections
		$old = get_post_meta($post_id, 'como_pageSections', true);
		$new = array();
		$comoPageSections = $_POST['sectionOrder'];
		$count = count($_POST['sectionOrder'])-1;
		for ($i = 0; $i<$count; $i++) {
			if (isset($comoPageSections[$i])) {
				if (!empty($comoPageSections[$i])) {
					foreach ($GLOBALS['sectionFields'] as $fieldName) {
						
						if (isset($_POST[$fieldName][$i])) {
							if (is_array($_POST[$fieldName][$i])) {
								$new[$i][$fieldName] = implode(',',$_POST[$fieldName][$i]);
							} else {
								//$new[$i][$fieldName] = ((in_array($fieldName,$GLOBALS['textAreas'])) ? htmlentities($_POST[$fieldName][$i]) : $_POST[$fieldName][$i]);
								$new[$i][$fieldName] = ((in_array($fieldName,$GLOBALS['textAreas'])) ? htmlentities($_POST[$fieldName][$i]) : ((in_array($fieldName,$GLOBALS['titles'])) ? htmlentities($_POST[$fieldName][$i]) : $_POST[$fieldName][$i]));
							}
						} else {
							$new[$i][$fieldName] = ''; 	
						}
						//echo '<br>'. $fieldName .': '. $new[$i][$fieldName];
					}
				}
			}
			//echo '<br>-----------------------------'; 
		}
		//exit;
		
		// to prevent metadata or custom fields from disappearing... 
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id; 
		
		if ( !empty( $newMain ) && $newMain != $oldMain )
			update_post_meta( $post_id, 'mainSectionInfo', $newMain );
		elseif ( empty($newMain) && $oldMain )
			delete_post_meta( $post_id, 'mainSectionInfo', $oldMain );
		
		if ( !empty( $new ) && $new != $old )
			update_post_meta( $post_id, 'como_pageSections', $new );
		elseif ( empty($new) && $old )
			delete_post_meta( $post_id, 'como_pageSections', $old );
	}
}
// Get Sectional Page Information
if (!function_exists('getPageInfo')) {
	function getpageInfo($pageID) {
		$pageInfo = array();
		$mainSectionMeta = get_post_meta($pageID, 'mainSectionInfo', true);
		$mainSectionInfo = array();
		$mainSectionInfo['id'] = $pageID;
		$mainSectionInfo['background-style'] = '';
		$mainSectionInfo['bgclass'] = ''; 
		
		foreach ($GLOBALS['mainSectionFields'] as $field) {
			$mainSectionInfo[$field] = (isset($mainSectionMeta[$field]) ? $mainSectionMeta[$field] : '');
		}
		
		if ($mainSectionInfo['bgcolor']) {
			$mainSectionInfo['background-style'] .= 'background-color: '. $mainSectionInfo['bgcolor'] .';';
		}
		
		if (!empty($mainSectionInfo['mainBgImage'])) {
			$bgImage = wp_get_attachment_image_src($mainSectionInfo['mainBgImage'],'full', true);
			if ($mainSectionInfo['parallax'] == 'yes') {
				$mainSectionInfo['background-style'] .= 'background-image: url('. $bgImage[0] .');';
				$mainSectionInfo['bgclass'] .= 'parallax ';
			} else {
				$mainSectionInfo['background-style'] .= 'background-image: url('. $bgImage[0] .');';
				$mainSectionInfo['bgclass'] .= '';
			}
		}
		
		if (!empty($section['bgValue'])) {
			$section['bgclass'] .= $section['bgValue'] .' ';
		}
		
		// Get Row Alignment Information 
		$mainSectionInfo['rowAlignment'] = ''; 
		$mainSectionInfo['rowAlignment'] .= ((!empty($mainSectionInfo['mainHorizontalClass'])) ? $mainSectionInfo['mainHorizontalClass'] .' ' : '');
		$mainSectionInfo['rowAlignment'] .= ((!empty($mainSectionInfo['mainVerticalClass'])) ? $mainSectionInfo['mainVerticalClass'] .' ' : ''); 
		
		// Get Main Column Information
		$mainSectionInfo['contentColumns'] = '';
		$mainSectionInfo['asideColumns'] = '';
		foreach ($GLOBALS['colWidths'] as $width) {
			if (!empty($mainSectionInfo['mainContentCol'. $width])) {
				if ($width == 'XXXXS') { 
					$mainSectionInfo['contentColumns'] .= strtolower('col-'. $mainSectionInfo['mainContentCol'. $width] .' ');
				}	
				$mainSectionInfo['contentColumns'] .= strtolower('col-'. $width .'-'. $mainSectionInfo['mainContentCol'. $width].' ');
			}
			if (!empty($mainSectionInfo['mainAsideCol'. $width])) {
				if ($width == 'XXXXS') { 
					$mainSectionInfo['asideColumns'] .= strtolower('col-'. $mainSectionInfo['mainAsideCol'. $width].' ');
				}	
				$mainSectionInfo['asideColumns'] .= strtolower('col-'. $width .'-'. $mainSectionInfo['mainAsideCol'. $width] .' ');
			}
		}
		$mainSectionInfo['sectionStyle'] = (($mainSectionInfo['background-style']) ? ' style="'. $mainSectionInfo['background-style'] .'"' : '');
		$mainSectionInfo['mainClass'] .= (($mainSectionInfo['bgvalue']) ? ' '. $mainSectionInfo['bgvalue'] : ''); 
		$pageInfo['main'] = $mainSectionInfo;
		
		
		
		// Additional Section Content
		$mainSectionInfo['additionalContentRowClass'] = (isset($mainSectionInfo['additionalContentRowClass']) ? html_entity_decode($mainSectionInfo['additionalContentRowClass']) : '');
		$mainSectionInfo['additionalContentColOneClass'] = (isset($mainSectionInfo['additionalContentColOneClass']) ? html_entity_decode($mainSectionInfo['additionalContentColOneClass']) : '');
		$mainSectionInfo['additionalContent'] = (isset($mainSectionInfo['additionalContent']) ? html_entity_decode($mainSectionInfo['additionalContent']) : '');
		$mainSectionInfo['additionalContentColTwoClass'] = (isset($mainSectionInfo['additionalContentColTwoClass']) ? html_entity_decode($mainSectionInfo['additionalContentColTwoClass']) : '');
		$mainSectionInfo['additionalContentColTwoContent'] = (isset($mainSectionInfo['additionalContentColTwoContent']) ? html_entity_decode($mainSectionInfo['additionalContentColTwoContent']) : '');
		
		
		
		
		
		
		
		
		
		// Get Page Sections
		$pageSectionMeta = get_post_meta($pageID, 'como_pageSections', true);
		$pageInfo['sections'] = $pageSectionMeta;
		
		return $pageInfo;
	}
}
// Get Section Info
if (!function_exists('getSectionInfo')) {
	function getSectionInfo($section) {
		$section['bgclass'] = '';
		$section['background-style'] = ''; 
		if (!empty($section['sectionBgColor'])) {
			$section['background-style'] .= 'background-color: '. $section['sectionBgColor'] .';';
		}
		if (!empty($section['sectionBgImage'])) {
			$bgImageURL = wp_get_attachment_url($section['sectionBgImage']);
			if ($section['sectionParallax'] == 'yes') {
				$section['background-style'] .= 'background-image: url('. $bgImageURL .');';
				$section['bgclass'] .= 'parallax ';
			} else {
				$section['background-style'] .= 'background-image: url('. $bgImageURL  .');';
				$section['bgclass'] .= '';
			}
		}
		if (!empty($section['sectionBgValue'])) {
			$section['bgclass'] .= $section['sectionBgValue'] . ' ';
		}
		
		if (!empty($section['sectionTemplate'])) {
			$section['sectionTemplate'] = $section['sectionTemplate'];
		}
		
		// Get Section Column Information
		$section['contentColumns'] = '';
		$section['asideColumns'] = '';
		foreach ($GLOBALS['colWidths'] as $width) {
			if (!empty($section['sectionContentCol'. $width])) {
				if ($width == 'XXXXS') { 
					$section['contentColumns'] .= strtolower('col-'. $section['sectionContentCol'. $width].' ');
				}	
				$section['contentColumns'] .= strtolower('col-'. $width .'-'. $section['sectionContentCol'. $width].' ');
			}
			if (!empty($section['sectionAsideCol'. $width])) {
				if ($width == 'XXXXS') { 
					$section['asideColumns'] .= strtolower('col-'. $section['sectionAsideCol'. $width].' ');
				}	
				$section['asideColumns'] .= strtolower('col-'. $width .'-'. $section['sectionAsideCol'. $width].' ');
			}
		}
		$section['sectionStyle'] = ((isset($section['background-style'])) ? ' style="'. $section['background-style'] .'"' : '');
		
		// Get Row Alignment Information 
		$section['rowAlignment'] = ''; 
		$section['rowAlignment'] .= ((!empty($section['sectionHorizontalClass'])) ? $section['sectionHorizontalClass'] .' ' : '');
		$section['rowAlignment'] .= ((!empty($section['mainVerticalClass'])) ? $section['mainVerticalClass'] .' ' : ''); 
		
		// Additional Section Content
		$section['sectionAdditionalContentRowClass'] = (isset($section['sectionAdditionalContentRowClass']) ? html_entity_decode($section['sectionAdditionalContentRowClass']) : '');
		$section['sectionAdditionalContentColOneClass'] = (isset($section['sectionAdditionalContentColOneClass']) ? html_entity_decode($section['sectionAdditionalContentColOneClass']) : '');
		$section['sectionAdditionalContent'] = (isset($section['sectionAdditionalContent']) ? html_entity_decode($section['sectionAdditionalContent']) : '');
		$section['sectionAdditionalContentColTwoClass'] = (isset($section['sectionAdditionalContentColTwoClass']) ? html_entity_decode($section['sectionAdditionalContentColTwoClass']) : '');
		$section['sectionAdditionalContentColTwoContent'] = (isset($section['sectionAdditionalContentColTwoContent']) ? html_entity_decode($section['sectionAdditionalContentColTwoContent']) : '');
			
		return $section;
	}
}
// Calculate width of content column based on width of aside
if (!function_exists('calculateColumns')) { 
	function calculateColumns($mainSectionInfo,$spacing) {
		if ($spacing == 'between') {
			$colLeft['XXL'] = (($mainSectionInfo['aside-width']!=12) ? 12-$mainSectionInfo['aside-width']-1 : $mainSectionInfo['aside-width']);
			$colLeft['XL'] = (($mainSectionInfo['aside-width-XL']!=12) ? 12-$mainSectionInfo['aside-width-XL']-1 : $mainSectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($mainSectionInfo['aside-width-LG']!=12) ? 12-$mainSectionInfo['aside-width-LG']-1 : $mainSectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($mainSectionInfo['aside-width-MD']!=12) ? 12-$mainSectionInfo['aside-width-MD'] : $mainSectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($mainSectionInfo['aside-width-SM']!=12) ? 12-$mainSectionInfo['aside-width-SM'] : $mainSectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XS'] : $mainSectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XXS'] : $mainSectionInfo['aside-width-XS']);
		} elseif ($spacing == 'narrow') {
			$colLeft['XXL'] = (($mainSectionInfo['aside-width']!=12) ? 11-$mainSectionInfo['aside-width'] : $mainSectionInfo['aside-width']);
			$colLeft['XL'] = (($mainSectionInfo['aside-width-XL']!=12) ? 11-$mainSectionInfo['aside-width-XL'] : $mainSectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($mainSectionInfo['aside-width-LG']!=12) ? 11-$mainSectionInfo['aside-width-LG'] : $mainSectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($mainSectionInfo['aside-width-MD']!=12) ? 11-$mainSectionInfo['aside-width-MD'] : $mainSectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($mainSectionInfo['aside-width-SM']!=12) ? 12-$mainSectionInfo['aside-width-SM'] : $mainSectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XS'] : $mainSectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XXS'] : $mainSectionInfo['aside-width-XS']);
		} else {
			$colLeft['XXL'] = (($mainSectionInfo['aside-width']!=12) ? 12-$mainSectionInfo['aside-width'] : $mainSectionInfo['aside-width']);
			$colLeft['XL'] = (($mainSectionInfo['aside-width-XL']!=12) ? 12-$mainSectionInfo['aside-width-XL'] : $mainSectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($mainSectionInfo['aside-width-LG']!=12) ? 12-$mainSectionInfo['aside-width-LG'] : $mainSectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($mainSectionInfo['aside-width-MD']!=12) ? 12-$mainSectionInfo['aside-width-MD'] : $mainSectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($mainSectionInfo['aside-width-SM']!=12) ? 12-$mainSectionInfo['aside-width-SM'] : $mainSectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XS'] : $mainSectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($mainSectionInfo['aside-width-XS']!=12) ? 12-$mainSectionInfo['aside-width-XXS'] : $mainSectionInfo['aside-width-XS']);
		}
		return $colLeft;
	}
}
// Check for Background Overlay
function checkBGoverlay($sectionInfo) {
	if ((isset($sectionInfo['overlayColor'])) || (isset($sectionInfo['sectionOverlayColor']))) {
		if (isset($sectionInfo['overlayColor'])) {
			$overlayColor = $sectionInfo['overlayColor']; 
		} elseif (isset($sectionInfo['sectionOverlayColor'])) {
			$overlayColor = $sectionInfo['sectionOverlayColor'];
		} else {
			$overlayColor = ''; 	
		}
		//$overlayColor = (((isset($sectionInfo['overlayColor'])) ? $sectionInfo['overlayColor'] : (isset($sectionInfo['sectionOverlayColor'])) ? $sectionInfo['sectionOverlayColor'] : ''));
		if (isset($sectionInfo['overlayOpacity'])) {
			$overlayOpacity = $sectionInfo['overlayOpacity'];
		} elseif (isset($sectionInfo['sectionOverlayOpacity'])) {
			$overlayOpacity = $sectionInfo['sectionOverlayOpacity'];
		} else {
			$overlayOpacity = ''; 
		}
		//$overlayOpacity = (((isset($sectionInfo['overlayOpacity'])) ? $sectionInfo['overlayOpacity'] : (isset($sectionInfo['sectionOverlayOpacity'])) ? $sectionInfo['sectionOverlayOpacity'] : ''));
		$overlay = '<div class="bg-overlay"';
		$overlay .= (($overlayColor || $overlayOpacity) ? ' style="' : ''); 
		$overlay .= (($overlayOpacity) ? 'background-color: '. $overlayColor .'; ' : '');
		$overlay .= (($overlayOpacity) ? '-webkit-opacity: '. $overlayOpacity .'; ' . '-moz-opacity: '. $overlayOpacity .'; ' . 'opacity: '. $overlayOpacity .'; ' : '');
		$overlay .= (($overlayColor || $overlayOpacity) ? '"' : '');
		$overlay .= '></div>';
	} else {
		$overlay = '';
	}
	return $overlay;
}
// Format Section Row / Content 
if (!function_exists('startSidebarSection')) {
	function startSidebarSection($sectionInfo,$type='section') {
		$globalOptions = get_option('como_theme_display_options');
		$globalRowClasses = (isset($globalOptions['global-row-class']) ? $globalOptions['global-row-class'] : '');
		$globalContentClasses = (isset($globalOptions['global-content-class']) ? $globalOptions['global-content-class'] : '');
		
		if ($type == 'main') {
			$contentArray = array(
				'horizontal' => ((isset($sectionInfo['mainHorizontalClass'])) ? $sectionInfo['mainHorizontalClass'] : ''),
				'vertical' => ((isset($sectionInfo['mainVerticalClass'])) ? $sectionInfo['mainVerticalClass'] : ''),
				'columns' => ((isset($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : ''),
				'rowClass'=> ((isset($sectionInfo['rowClass'])) ? $sectionInfo['rowClass'] : ''),
				'contentClass'=> ((isset($sectionInfo['contentClass'])) ? $sectionInfo['contentClass'] : '')
			);
		} else {
			$contentArray = array(
				'horizontal' => ((isset($sectionInfo['sectionHorizontalClass'])) ? $sectionInfo['sectionHorizontalClass'] : ''),
				'vertical' => ((isset($sectionInfo['sectionVerticalClass'])) ? $sectionInfo['sectionVerticalClass'] : ''),
				'columns'=> ((isset($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : ''),
				'rowClass'=> ((isset($sectionInfo['sectionRowClass'])) ? $sectionInfo['sectionRowClass'] : ''),
				'contentClass'=> ((isset($sectionInfo['sectionContentClass'])) ? $sectionInfo['sectionContentClass'] : '')
			);
		}
		
		$rowAlignmentClasses = 'justify-content-center'; 
		if (!empty($contentArray['horizontal'])) {
			if ($contentArray['horizontal'] == 'global') {
				if (!empty($globalRowClasses)) {
					$rowAlignmentClasses = $globalRowClasses;
				}
			} else {
				$rowAlignmentClasses = $contentArray['horizontal'];
			}
		}
		
		if (!empty($contentArray['vertical'])) {
			if ($contentArray['horizontal'] == 'global') {
				if (!empty($globalRowClasses)) {
					$rowAlignmentClasses = $globalRowClasses;
				}
			} else {
				$rowAlignmentClasses .= ' '. $contentArray['vertical'];
			}
		}
		
		
		$contentClasses = (!empty($contentArray['columns']) ? $contentArray['columns'] : (!empty($globalContentClasses) ? $globalContentClasses : 'col-12'));
				
		?><div class="row <?=$rowAlignmentClasses?> <?=$contentArray['rowClass']?>"><div class="col <?=$contentClasses?> content-wrap <?=$contentArray['contentClass']?>"><?php
	}
}
// Format Section Aside
if (!function_exists('addSectionAside')) {
	function addSectionAside($asideInfo,$type='section') {
		if ($type == 'main') {
			$asideArray = array(
				'title' => html_entity_decode($asideInfo['asideTitle']),
				'titleLink' => $asideInfo['asideTitleLink'],
				'subtitle'=> html_entity_decode($asideInfo['asideSubtitle']),
				'class'=> $asideInfo['asideClass'],
				'titleClass'=> $asideInfo['asideTitleClass'],
				'subtitleClass'=> $asideInfo['asideSubtitleClass'],
				'wrapClass'=> $asideInfo['asideWrapClass'],
				'headerClass'=> $asideInfo['asideHeaderClass'],
				'contentClass'=> $asideInfo['asideContentClass'],
				'asideID'=> (isset($asideInfo['asideID']) ? $asideInfo['asideID'] : ''),
				'content' => html_entity_decode($asideInfo['asideContent']),
				'columns' => $asideInfo['asideColumns'],
				'aside' => $asideInfo['mainAside']
			);
		} else {
			$asideArray = array(
				'title' => html_entity_decode($asideInfo['sectionAsideTitle']),
				'titleLink' => $asideInfo['sectionAsideTitleLink'],
				'subtitle'=> html_entity_decode($asideInfo['sectionAsideSubtitle']),
				'class'=> $asideInfo['sectionAsideClass'],
				'wrapClass'=> $asideInfo['sectionAsideWrapClass'],
				'titleClass'=> $asideInfo['sectionAsideTitleClass'],
				'subtitleClass'=> $asideInfo['sectionAsideSubtitleClass'],
				'contentClass'=> $asideInfo['sectionAsideContentClass'],
				'headerClass'=> $asideInfo['sectionAsideHeaderClass'],
				'asideID'=> (isset($asideInfo['sectionAsideID']) ? $asideInfo['sectionAsideID'] : ''),
				'content' => html_entity_decode($asideInfo['sectionAsideContent']),
				'columns' => $asideInfo['asideColumns'],
				'aside' => $asideInfo['sectionAside']
			);
		}
		
		$globalOptions = get_option('como_theme_display_options');
		$globalAsideClasses = (isset($globalOptions['global-aside-class']) ? $globalOptions['global-aside-class'] : '');
		
		$asideClasses = (!empty($asideArray['columns']) ? 'col '. $asideArray['columns'] : (!empty($globalAsideClasses) ? $globalAsideClasses : ''));
		
		?><aside class="aside <?=$asideClasses?> <?=$asideArray['class']?>" id="<?=$asideArray['asideID']?>"><div class="sidebar inner-aside-wrap <?=$asideArray['wrapClass']?>">
		<?php 
		if ($asideArray['aside'] == 'custom-sidebar') {
			$titleLinkStart = ''; 
			$titleLinkEnd = ''; 
			if (isset($asideArray['titleLink'])) {
				if (!empty($asideArray['titleLink'])) {
					$titleLinkStart = '<a href="'. $asideArray['titleLink'] .'" title="'. $asideArray['title'] .'">';
					$titleLinkEnd = '</a>'; 
				}
			}
			?><?=($asideArray['title'] ? '<header class="aside-header '. $asideArray['headerClass'] .'"><h2 class="aside-title '. $asideArray['titleClass'] .'">'. $titleLinkStart . $asideArray['title'] . $titleLinkEnd .'</h2>' : '')?>  <?=($asideArray['subtitle'] ? '<h3 class="aside-subtitle '. $asideArray['subtitleClass'] .'">'. $asideArray['subtitle'] .'</h3>' : '') ?><?=((($asideArray['title']) || ($asideArray['subtitle'])) ? '</header>' : '')?><div class="aside-content-wrap <?=$asideArray['contentClass']?>"> <?=apply_filters('the_content', htmlspecialchars_decode($asideArray['content']))?></div>
		<?php
		} elseif (is_active_sidebar($asideArray['aside'])) {
			dynamic_sidebar($asideArray['aside']);
		} 
		?></div><!-- /inner-aside-wrap --></aside></div><!-- / row --><?php
	}
}

// Format Section Aside
if (!function_exists('addSectionAdditional')) {
	function addSectionAdditional($additionalInfo,$type='section') {
		if ($type == 'main') {
			$additionalArray = array(
				'additionalContent' => html_entity_decode($additionalInfo['additionalContent']),
				'additionalContentRowClass' => $additionalInfo['additionalContentRowClass'],
				'additionalContentColOneClass'=> $additionalInfo['additionalContentColOneClass'],
				'additionalContentColTwoClass'=> $additionalInfo['additionalContentColTwoClass'],
				'additionalContentColTwoContent'=> html_entity_decode($additionalInfo['additionalContentColTwoContent'])
			);
		} else {
			$additionalArray = array(
				'additionalContent' => html_entity_decode($additionalInfo['sectionAdditionalContent']),
				'additionalContentRowClass' => $additionalInfo['sectionAdditionalContentRowClass'],
				'additionalContentColOneClass'=> $additionalInfo['sectionAdditionalContentColOneClass'],
				'additionalContentColTwoClass'=> $additionalInfo['sectionAdditionalContentColTwoClass'],
				'additionalContentColTwoContent'=> html_entity_decode($additionalInfo['sectionAdditionalContentColTwoContent'])
			);
		}
		if (isset($additionalArray['additionalContent'])) {
			if (!empty($additionalArray['additionalContent'])) {	
				$columnTwoContent = '';
				$rowClass = ''; 
				if (isset($additionalArray['additionalContentRowClass'])) {
					if (!empty($additionalArray['additionalContentRowClass'])) {
						$rowClass = $additionalArray['additionalContentRowClass'];
					}
				}
				$colOneClass = 'col col-12'; 
				if (isset($additionalArray['additionalContentColOneClass'])) {
					if (!empty($additionalArray['additionalContentColOneClass'])) {
						$colOneClass = $additionalArray['additionalContentColOneClass'];
					}
				}
				if (isset($additionalArray['additionalContentColTwoContent'])) {
					if (!empty($additionalArray['additionalContentColTwoContent'])) {
						$colTwoClass = 'col col-6'; 
						if (isset($additionalArray['additionalContentColTwoClass'])) {
							if (!empty($additionalArray['additionalContentColTwoClass'])) {
								$colTwoClass = $additionalArray['additionalContentColTwoClass'];
							}
						}
						$columnTwoContent = '<div class="'. $colTwoClass .'">'. apply_filters('the_content', $additionalArray['additionalContentColTwoContent']) .'</div>'; 
					}
				} else {
					$columnTwoContent = '';
				}
				?><div class="section-additional-content <?=$rowClass?>"><div class="<?=$colOneClass?>"><?=apply_filters('the_content', $additionalArray['additionalContent'])?></div><?=$columnTwoContent?></div><!-- /section-additional-content --><?php
			}
		}
	}
}

// Format Section Content Area
if (!function_exists('formatSectionContent')) {
	function formatSectionContent($sectionInfo,$type='section',$reverseTitles=false,$headerOverride=false,$showTitles=true) {
		// If section has an aside, set columns 
		if (($sectionInfo['sectionAside'] != 'no-sidebar') || (!empty($sectionInfo['sectionAside']))) {
			startSidebarSection($sectionInfo,'section');		
		} else {
			?>
			<div class="row <?=((!empty($sectionInfo['rowAlignment'])) ? $sectionInfo['rowAlignment'] : 'justify-content-center')?>">
				<div class="<?=((!empty($sectionInfo['contentColumns'])) ? $sectionInfo['contentColumns'] : 'col-12 col-lg-11')?> content-wrap <?=$sectionInfo['sectionContentClass']?>"><?php
		}
				if ($showTitles) {
					echo formatSectionTitles($title=htmlspecialchars_decode($sectionInfo['sectionTitle']), $subtitle=htmlspecialchars_decode($sectionInfo['sectionSubtitle']), $subtitle2='', $titleLink=$sectionInfo['sectionTitleLink'], $headerClass=$sectionInfo['sectionHeaderClass'], $mtClass=$sectionInfo['sectionTitleClass'], $stClass=$sectionInfo['sectionSubtitleClass'], $st2Class='', $titleType='section', $titleElement='h2', $subtitleElement='h3', $subtitle2Element='', $reverse=$reverseTitles, $headerOverride=$headerOverride);
				}
				?>
				<div class="content <?=$sectionInfo['sectionContentInnerClass']?>">
					<?=apply_filters('the_content', htmlspecialchars_decode($sectionInfo['sectionContent']))?>
				</div>
			</div><!-- /content-wrap --><?php	   
		// If section has an aside, add aside
		if ((!empty($sectionInfo['sectionAside'])) && ($sectionInfo['sectionAside'] != 'no-sidebar')) {	
			addSectionAside($sectionInfo,'section');
			//echo $sectionAside;
		} else {
			?></div><?php
		}
		// Additional Content Section
		addSectionAdditional($sectionInfo,$type='section');
	}
}