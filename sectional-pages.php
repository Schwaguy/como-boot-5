<?php
/* ##################### Sectional Page Custom Meta Info ##################### */
/*
// Custom Meta  WYSIWYG
function comosection_wysiwyg_callback($post) {
	$asideWidth = get_post_meta($post->ID, 'comosection-aside-width', true);
	$asideWidth = get_post_meta($post->ID, 'comosection-aside-width', true);
	$asideWidthXL = get_post_meta($post->ID, 'comosection-aside-width-XL', true);
	$asideWidthLG = get_post_meta($post->ID, 'comosection-aside-width-LG', true);
	$asideWidthMD = get_post_meta($post->ID, 'comosection-aside-width-MD', true);
	$asideWidthSM = get_post_meta($post->ID, 'comosection-aside-width-SM', true);
	$asideWidthXS = get_post_meta($post->ID, 'comosection-aside-width-XS', true);
	$asideWidthXXS = get_post_meta($post->ID, 'comosection-aside-width-XXS', true);
	
	$asideTitle = get_post_meta($post->ID, 'comosection-aside-title', true);
	$asideTitleLink = get_post_meta($post->ID, 'comosection-aside-title-link', true);
	$asideSubTitle = get_post_meta($post->ID, 'comosection-aside-subtitle', true);
	$asideClass = get_post_meta($post->ID, 'comosection-aside-class', true);
	?>
<div class="meta-contain"><div class="comometa-row-title"><label for="comosection-aside-width"><?php _e( 'Aside Column Width', 'comostrap-textdomain' )?></label></div><div class="comometa-row-content">
		<table class="como-meta-table">
			<tr>
				<td><label>XXS:</label> <input type="number" min="0" max="12" name="comosection-aside-width-XXS" id="comosection-aside-width-XXS" value="<?php if ( isset ( $asideWidthXXS ) ) echo $asideWidthXXS; ?>" /></td>
				<td><label>XS:</label><input type="number" min="0" max="12" name="comosection-aside-width-XS" id="comosection-aside-width-XS" value="<?php if ( isset ( $asideWidthXS ) ) echo $asideWidthXS; ?>" /></td>
				<td><label>SM:</label><input type="number" min="0" max="12" name="comosection-aside-width-SM" id="comosection-aside-width-SM" value="<?php if ( isset ( $asideWidthSM ) ) echo $asideWidthSM; ?>" /></td>
				<td><label>MD:</label><input type="number" min="0" max="12" name="comosection-aside-width-MD" id="comosection-aside-width-MD" value="<?php if ( isset ( $asideWidthMD ) ) echo $asideWidthMD; ?>" /></td>
				<td><label>LG:</label><input type="number" min="0" max="12" name="comosection-aside-width-LG" id="comosection-aside-width-LG" value="<?php if ( isset ( $asideWidthLG ) ) echo $asideWidthLG; ?>" /></td>
				<td><label>XL:</label><input type="number" min="0" max="12" name="comosection-aside-width-XL" id="comosection-aside-width-XL" value="<?php if ( isset ( $asideWidthXL ) ) echo $asideWidthXL; ?>" /></td>
				<td><label>XXL:</label><input type="number" min="0" max="12" name="comosection-aside-width" id="comosection-aside-width" value="<?php if ( isset ( $asideWidth ) ) echo $asideWidth; ?>" /></td>
			</tr>
		</table>
	</div></div>
	<p><label for="comosection-aside-title" class="comometa-row-title"><?php _e( 'Aside Title', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-aside-title" id="comosection-aside-title" value="<?php if ( isset ( $asideTitle ) ) echo $asideTitle; ?>" /></span></p>
	<p><label for="comosection-aside-title-link" class="comometa-row-title"><?php _e( 'Aside Title Link', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-aside-title-link" id="comosection-aside-title-link" value="<?php if ( isset ( $asideTitleLink ) ) echo $asideTitleLink; ?>" /></span></p>
	
	<p><label for="comosection-aside-subtitle" class="comometa-row-title"><?php _e( 'Aside Subtitle', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-aside-subtitle" id="comosection-aside-subtitle" value="<?php if ( isset ( $asideSubTitle ) ) echo $asideSubTitle; ?>" /></span></p>
	
	<p><label for="comosection-aside-class" class="comometa-row-title"><?php _e( 'Aside Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-aside-class" id="comosection-aside-class" value="<?php if ( isset ( $asideClass ) ) echo $asideClass; ?>" /></span></p>
    <?php
	$content = get_post_meta($post->ID, 'comosection-aside', true);
	wp_editor(htmlspecialchars_decode($content) , 'comosection-aside', array("media_buttons" => true));
}*/
// Loads the color picker javascript
function como_section_color_enqueue() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'meta-box-color-js', get_template_directory_uri() . '/js/meta-box-colorpicker.js', array( 'wp-color-picker' ) );
}
/*
function como_section_meta_callback($post) {
    wp_nonce_field(basename( __FILE__ ), 'como_section_nonce');
    $comosection_stored_meta = get_post_meta($post->ID);
    ?>
    <p><label for="comosection-id" class="comometa-row-title"><?php _e( 'Section ID', 'comostrap-textdomain' )?></label>
  	<span class="comometa-row-content"><input type="text" name="comosection-id" id="comosection-id" value="<?php if ( isset ( $comosection_stored_meta['comosection-id'] ) ) echo $comosection_stored_meta['comosection-id'][0]; ?>" /></span></p>
   
    <p><label for="comosection-class" class="comometa-row-title"><?php _e( 'Section Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-class" id="comosection-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-class'] ) ) echo $comosection_stored_meta['comosection-class'][0]; ?>" /><em>Class to apply to entire page section</em></span></p>
	<p><label for="comosection-class" class="comometa-row-title"><?php _e( 'Section Row Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-row-class" id="comosection-row-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-row-class'] ) ) echo $comosection_stored_meta['comosection-row-class'][0]; ?>" /><em>class to apply to row that surrounds content and sidebar areas</em></span></p>
	<p><label for="comosection-title-link" class="comometa-row-title"><?php _e( 'Section Title Link', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-title-link" id="comosection-title-link" value="<?php if ( isset ( $comosection_stored_meta['comosection-title-link'] ) ) echo $comosection_stored_meta['comosection-title-link'][0]; ?>" /><em>If section title should be a link</em></span></p>
<p><label for="comosection-title-class" class="comometa-row-title"><?php _e( 'Section Header Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-header-class" id="comosection-header-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-header-class'] ) ) echo $comosection_stored_meta['comosection-header-class'][0]; ?>" /><em>Class that wraps both title and subtitle</em></span></p>
	
	<p><label for="comosection-title-class" class="comometa-row-title"><?php _e( 'Section Title Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-title-class" id="comosection-title-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-title-class'] ) ) echo $comosection_stored_meta['comosection-title-class'][0]; ?>" /></span></p>
	<p><label for="comosection-subtitle-class" class="comometa-row-title"><?php _e( 'Section Subtitle Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-subtitle-class" id="comosection-subtitle-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-subtitle-class'] ) ) echo $comosection_stored_meta['comosection-subtitle-class'][0]; ?>" /></span></p>
	<p><label for="comosection-content-class" class="comometa-row-title"><?php _e( 'Section Content Class', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="text" name="comosection-content-class" id="comosection-content-class" value="<?php if ( isset ( $comosection_stored_meta['comosection-content-class'] ) ) echo $comosection_stored_meta['comosection-content-class'][0]; ?>" /></span></p>
   
    <p><label for="comosection-bgcolor" class="comometa-row-title"><?php _e( 'Background Color', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input name="comosection-bgcolor" id="comosection-bgcolor" type="text" value="<?php if ( isset ( $comosection_stored_meta['comosection-bgcolor'] ) ) echo $comosection_stored_meta['comosection-bgcolor'][0]; ?>" class="meta-color" /></span></p>
   
    <p><label for="comosection-parallax" class="comometa-row-title"><?php _e( 'Parallax Background:', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input type="checkbox" name="comosection-parallax" id="comosection-parallax" value="yes" <?php if ( isset ( $comosection_stored_meta['comosection-parallax'] ) ) checked( $comosection_stored_meta['comosection-parallax'][0], 'yes' ); ?> /> <?php _e( 'Enable Parallax Scrolling for background image (<em>background color will be ignored</em>)', 'comostrap-textdomain' )?></span></p>
	<p><label for="comosection-overlay-color" class="comometa-row-title"><?php _e( 'Background Overlay Color:', 'comostrap-textdomain' )?></label><span class="comometa-row-content"><input name="comosection-overlay-color" id="comosection-overlay-color" type="text" value="<?php if ( isset ( $comosection_stored_meta['comosection-overlay-color'] ) ) echo $comosection_stored_meta['comosection-overlay-color'][0]; ?>" class="meta-color" /></span></p>
   
	<p><label for="comosection-overlay-opacity" class="comometa-row-title"><?php _e( 'Background Overlay Opacity:', 'comostrap-textdomain' )?></label>
  	<span class="comometa-row-content"><input type="number" name="comosection-overlay-opacity" id="comosection-overlay-opacity" min="0.01" max="1.00" step="0.01" value="<?php if ( isset ( $comosection_stored_meta['comosection-overlay-opacity'] ) ) echo $comosection_stored_meta['comosection-overlay-opacity'][0]; ?>" /></span></p>
    <p>
        <label class="comometa-row-title"><?php _e( 'Background Value:', 'comostrap-textdomain' )?></label>
        <span class="comometa-row-content">
        	<input type="radio" name="comosection-bgvalue" id="comosection-bgvalue-one" value="light" <?php if ( isset ( $comosection_stored_meta['comosection-bgvalue'] ) ) checked( $comosection_stored_meta['comosection-bgvalue'][0], 'light' ); ?>>
          	<?php _e( 'Light Background', 'comostrap-textdomain' )?>
           	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          	<input type="radio" name="comosection-bgvalue" id="comosection-bgvalue-two" value="dark" <?php if ( isset ( $comosection_stored_meta['comosection-bgvalue'] ) ) checked( $comosection_stored_meta['comosection-bgvalue'][0], 'dark' ); ?>>
         	<?php _e( 'Dark Background', 'comostrap-textdomain' )?>
            <?php _e( '<br><em>Assigns a "light" or "dark" class to section for content styling</em>', 'comostrap-textdomain' )?>
        </span>
    </p>
   
    <input type="hidden" name="comoSection_update_flag" value="true" />
    <?php
}*/
// Saves the Page Section meta input
/*function como_section_meta_save( $post_id ) {
	
	// Only do this if our custom flag is present
    if (isset($_POST['comoSection_update_flag'])) {
	
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'como_section_nonce' ] ) && wp_verify_nonce( $_POST[ 'como_section_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return; // Exits script depending on save status
		}
		// Specify Meta Variables to be Updated
		$metaVars = array('comosection-id','comosection-class','comosection-content-class','comosection-row-class','comosection-title-link','comosection-header-class','comosection-title-class','comosection-subtitle-class','comosection-bgcolor','comosection-parallax','comosection-overlay-opacity','comosection-overlay-color','comosection-bgvalue','comosection-aside-width','comosection-aside-width-XL','comosection-aside-width-LG','comosection-aside-width-MD','comosection-aside-width-SM','comosection-aside-width-XS','comosection-aside-width-XXS','comosection-aside-title','comosection-aside-title-link','comosection-aside-subtitle','comosection-aside-class','comosection-aside');
		$checkboxVars = array('comosection-parallax');
		// Update Meta Variables
		foreach ($metaVars as $var) {
			if (in_array($var,$checkboxVars)) {
				if (isset($_POST[$var])) {
					update_post_meta($post_id, $var, 'yes');
				} else {
					update_post_meta($post_id, $var, $var);
				}
			} elseif ($var == 'comosection-aside') {
				$data = htmlspecialchars($_POST['comosection-aside']);
				update_post_meta($post_id, 'comosection-aside', $data);
			} else {
				if(isset($_POST[$var])) {
					update_post_meta($post_id, $var, $_POST[$var]);
				}
			}
		}
	}
}
add_action( 'save_post', 'como_section_meta_save' );*/
// Check for Background Overlay
/*function checkBGoverlay($pid) {
	$sectionInfo['overlay-color'] = get_post_meta($pid,'comosection-overlay-color',true);
	$sectionInfo['overlay-opacity'] = get_post_meta($pid,'comosection-overlay-opacity',true);
	if ($sectionInfo['overlay-color']) {
		$overlay = '<div class="bg-overlay" style="background-color: '. $sectionInfo['overlay-color'] .'; ';
		$overlay .= (($sectionInfo['overlay-opacity']) ? '-webkit-opacity: '. $sectionInfo['overlay-opacity'] .'; ' . '-moz-opacity: '. $sectionInfo['overlay-opacity'] .'; ' . 'opacity: '. $sectionInfo['overlay-opacity'] .'; ' : '');
		$overlay .= '"></div>';
	} else {
		$overlay = '';
	}
	return $overlay;
}*/
// Get Page Section Information
/*if (!function_exists('getSectionInfo')) {
	function getSectionInfo($sectionID) {
		$sectionInfo['id'] = $sectionID;
		$sectionInfo['sectionID'] = get_post_meta($sectionID, 'comosection-id', true);
		$sectionInfo['class'] = get_post_meta($sectionID,'comosection-class',true);
		$sectionInfo['row-class'] = get_post_meta($sectionID,'comosection-row-class',true);
		$sectionInfo['content-class'] = get_post_meta($sectionID,'comosection-content-class',true);
		$sectionInfo['content'] = get_post_field('post_content', $sectionID);
		$sectionInfo['title-link'] = get_post_meta($sectionID,'comosection-title-link',true);
		$sectionInfo['header-class'] = get_post_meta($sectionID,'comosection-header-class',true);
		$sectionInfo['title-class'] = get_post_meta($sectionID,'comosection-title-class',true);
		$sectionInfo['subtitle-class'] = get_post_meta($sectionID,'comosection-subtitle-class',true);
		$sectionInfo['pagesubtitle'] = get_post_meta($sectionID,'_pagesubtitle',true);
		$sectionInfo['subtitle'] = get_post_meta($sectionID,'comosection-subtitle',true);
		$sectionInfo['class'] = get_post_meta($sectionID,'comosection-class',true);
		$sectionInfo['background-color'] = get_post_meta($sectionID,'comosection-bgcolor',true);
		$sectionInfo['value'] = get_post_meta($sectionID,'comosection-bgvalue',true);
		$sectionInfo['bgClass'] = '';
		$sectionInfo['background'] = '';
		if ($sectionInfo['background-color']) {
			$sectionInfo['background'] .= 'background-color: '. $sectionInfo['background-color'] .';';
		}
		$sectionInfo['parallax'] = get_post_meta($sectionID,'comosection-parallax',false);
		$sectionInfo['parallax-speed'] = get_post_meta($sectionID,'comosection-parallax-speed',true);
		$sectionInfo['parallax-position'] = get_post_meta($sectionID,'comosection-parallax-position',true);
		if (has_post_thumbnail($sectionID)) {
			$thumb_id = get_post_thumbnail_id($sectionID);
			$thumbnail = wp_get_attachment_image_src($thumb_id,'full', true);
			
			if ($sectionInfo['parallax']) {
				$sectionInfo['parallaxBG'] = $thumbnail[0];
				$sectionInfo['parallaxBGwidth'] = $thumbnail[1];
				$sectionInfo['parallaxBGheight'] = $thumbnail[2];
				$sectionInfo['background'] .= 'background-image: url('. $thumbnail[0] .');';
				$sectionInfo['bgClass'] .= 'parallax';
				$sectionInfo['enableParallax'] = true;
			} else {
				$sectionInfo['background'] .= 'background-image: url('. $thumbnail[0] .');';
				$sectionInfo['bgClass'] .= '';
				$sectionInfo['enableParallax'] = false;
			}
		}
		$sectionStyle = (($sectionInfo['background']) ? 'style="'. $sectionInfo['background'] .'"' : '');
		$sectionInfo['aside'] = get_post_meta($sectionID,'comosection-aside',true);
		$sectionInfo['aside-title'] = get_post_meta($sectionID,'comosection-aside-title',true);
		$sectionInfo['aside-title-link'] = get_post_meta($sectionID,'comosection-aside-title-link',true);
		$sectionInfo['aside-subtitle'] = get_post_meta($sectionID,'comosection-aside-subtitle',true);
		$sectionInfo['aside-class'] = get_post_meta($sectionID,'comosection-aside-class',true);
		$sectionInfo['aside-width'] = (get_post_meta($sectionID,'comosection-aside-width',true) ? get_post_meta($sectionID,'comosection-aside-width',true) : 6);
		$sectionInfo['aside-width-XL'] = (get_post_meta($sectionID,'comosection-aside-width-XL',true) ? get_post_meta($sectionID,'comosection-aside-width-XL',true) : $sectionInfo['aside-width']);
		$sectionInfo['aside-width-LG'] = (get_post_meta($sectionID,'comosection-aside-width-LG',true) ? get_post_meta($sectionID,'comosection-aside-width-LG',true) : $sectionInfo['aside-width-XL']);
		$sectionInfo['aside-width-MD'] = (get_post_meta($sectionID,'comosection-aside-width-MD',true) ? get_post_meta($sectionID,'comosection-aside-width-MD',true) : $sectionInfo['aside-width-LG']);
		$sectionInfo['aside-width-SM'] = (get_post_meta($sectionID,'comosection-aside-width-SM',true) ? get_post_meta($sectionID,'comosection-aside-width-SM',true) : $sectionInfo['aside-width-MD']);
		$sectionInfo['aside-width-XS'] = (get_post_meta($sectionID,'comosection-aside-width-XS',true) ? get_post_meta($sectionID,'comosection-aside-width-XS',true) : $sectionInfo['aside-width-SM']);
		$sectionInfo['aside-width-XXS'] = (get_post_meta($sectionID,'comosection-aside-width-XXS',true) ? get_post_meta($sectionID,'comosection-aside-width-XXS',true) : $sectionInfo['aside-width-XS']);
		$sectionInfo['bgClass'] .= (($sectionInfo['value']) ? ' '. $sectionInfo['value'] : ''); 
		return $sectionInfo;
	}
}*/
// Calculate width of content column based on width of aside
/*if (!function_exists('calculateColumns')) { 
	function calculateColumns($sectionInfo,$spacing) {
		if ($spacing == 'between') {
			$colLeft['XXL'] = (($sectionInfo['aside-width']!=12) ? 12-$sectionInfo['aside-width']-1 : $sectionInfo['aside-width']);
			$colLeft['XL'] = (($sectionInfo['aside-width-XL']!=12) ? 12-$sectionInfo['aside-width-XL']-1 : $sectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($sectionInfo['aside-width-LG']!=12) ? 12-$sectionInfo['aside-width-LG']-1 : $sectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($sectionInfo['aside-width-MD']!=12) ? 12-$sectionInfo['aside-width-MD'] : $sectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($sectionInfo['aside-width-SM']!=12) ? 12-$sectionInfo['aside-width-SM'] : $sectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XS'] : $sectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XXS'] : $sectionInfo['aside-width-XS']);
		} elseif ($spacing == 'narrow') {
			$colLeft['XXL'] = (($sectionInfo['aside-width']!=12) ? 11-$sectionInfo['aside-width'] : $sectionInfo['aside-width']);
			$colLeft['XL'] = (($sectionInfo['aside-width-XL']!=12) ? 11-$sectionInfo['aside-width-XL'] : $sectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($sectionInfo['aside-width-LG']!=12) ? 11-$sectionInfo['aside-width-LG'] : $sectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($sectionInfo['aside-width-MD']!=12) ? 11-$sectionInfo['aside-width-MD'] : $sectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($sectionInfo['aside-width-SM']!=12) ? 12-$sectionInfo['aside-width-SM'] : $sectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XS'] : $sectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XXS'] : $sectionInfo['aside-width-XS']);
		} else {
			$colLeft['XXL'] = (($sectionInfo['aside-width']!=12) ? 12-$sectionInfo['aside-width'] : $sectionInfo['aside-width']);
			$colLeft['XL'] = (($sectionInfo['aside-width-XL']!=12) ? 12-$sectionInfo['aside-width-XL'] : $sectionInfo['aside-width-XL']);
			$colLeft['LG'] = (($sectionInfo['aside-width-LG']!=12) ? 12-$sectionInfo['aside-width-LG'] : $sectionInfo['aside-width-LG']);
			$colLeft['MD'] = (($sectionInfo['aside-width-MD']!=12) ? 12-$sectionInfo['aside-width-MD'] : $sectionInfo['aside-width-MD']);
			$colLeft['SM'] = (($sectionInfo['aside-width-SM']!=12) ? 12-$sectionInfo['aside-width-SM'] : $sectionInfo['aside-width-SM']);
			$colLeft['XS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XS'] : $sectionInfo['aside-width-XS']);
			$colLeft['XXS'] = (($sectionInfo['aside-width-XS']!=12) ? 12-$sectionInfo['aside-width-XXS'] : $sectionInfo['aside-width-XS']);
		}
		return $colLeft;
	}
}*/
// Format Section Aside
/*if (!function_exists('addSectionAside')) {
	function addSectionAside($sectionInfo) {
		$titleLinkStart = ''; 
		$titleLinkEnd = ''; 
		if ($sectionInfo['aside-title-link']) {
			$titleLinkStart = '<a href="'. $sectionInfo['aside-title-link'] .'" title="'. $sectionInfo['aside-title'] .'">';
			$titleLinkEnd = '</a>'; 
		}
		$sectionAside = '</div>
			<aside class="aside col-'. $sectionInfo['aside-width-XXS'] .' col-xxs-'. $sectionInfo['aside-width-XXS'] .' col-xs-'. $sectionInfo['aside-width-XS'] .' col-sm-'. $sectionInfo['aside-width-SM'] .' col-md-'. $sectionInfo['aside-width-MD'] .' col-lg-'. $sectionInfo['aside-width-LG'] .' col-xl-'. $sectionInfo['aside-width-XL'] .' col-xxl-'. $sectionInfo['aside-width'] .' sidebar '. $sectionInfo['aside-class'] .'">
			'. ($sectionInfo['aside-title'] ? '<h2 class="aside-title">'. $titleLinkStart . $sectionInfo['aside-title'] . $titleLinkEnd .'</h2>' : '') . ($sectionInfo['aside-subtitle'] ? '<h3 class="aside-subtitle">'. $sectionInfo['aside-subtitle'] .'</h3>' : '') . apply_filters('the_content', htmlspecialchars_decode($sectionInfo['aside'])) .'</aside>
		</div><!-- /row -->';
		return $sectionAside;
	}
}*/
// Print Page Section repeater Fields
function print_section_fields($cnt, $p = null) {
if ($p === null){
    $a = $b = $c = $d = $e = $f = $g = $h = $i = $j = $k = $l = $m = $n = $o = $p = $q = '';
} else {
    $a = $p['comosection-id'];
    $b = $p['comosection-class'];
    $c = $p['comosection-row-class'];
	$d = $p['comosection-title-link'];
	$e = $p['comosection-header-class'];
	$f = $p['comosection-title-class'];
	$g = $p['comosection-subtitle-class'];
	$h = $p['comosection-content-class'];
	$i = $p['comosection-bgcolor'];
	$j = (($p['comosection-parallax'] == 'yes') ? $p['comosection-parallax'] : 'no');
	$jChecked = (($j=='yes') ? 'checked' : '');
	$k = $p['comosection-overlay-color'];
	$l = $p['comosection-overlay-opacity'];
	$m = $p['comosection-bgvalue'];
	if ($m == 'light') {
		$lightChecked = 'checked'; 
		$darkChecked = ''; 
	} elseif ($m == 'dark') {
		$lightChecked = ''; 
		$darkChecked = 'checked';
	} else {
		$lightChecked = ''; 
		$darkChecked = '';
	}
}
return  <<<HTML
<div>
    <p><label class="comometa-row-title">Section ID</label>
  	<span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-id]" value="$a" /></span></p>
   
    <p><label class="comometa-row-title">Section Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-class]" value="$b" /><em>Class to apply to entire page section</em></span></p>
	<p><label class="comometa-row-title">Section Row Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-row-class]" value="$c" /><em>class to apply to row that surrounds content and sidebar areas</em></span></p>
	<p><label class="comometa-row-title">Section Title Link</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-title-link]" value="$d" /><em>If section title should be a link</em></span></p>
	<p><label class="comometa-row-title">Section Header Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-header-class]" value="$e" /><em>Class that wraps both title and subtitle</em></span></p>
	
	<p><label class="comometa-row-title">Section Title Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-title-class]" value="$f" /></span></p>
	<p><label class="comometa-row-title">Section Subtitle Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-subtitle-class]" value="$g" /></span></p>
	<p><label class="comometa-row-title">Section Content Class</label><span class="comometa-row-content"><input type="text" name="section_data[$cnt][comosection-content-class]" value="$h" /></span></p>
   
    <p><label class="comometa-row-title">Background Color</label><span class="comometa-row-content"><input name="section_data[$cnt][comosection-bgcolor]" type="text" value="$i" class="meta-color" /></span></p>
   
    <p><label class="comometa-row-title">Parallax Background</label><span class="comometa-row-content"><input type="checkbox" name="section_data[$cnt][comosection-parallax]" value="yes" $jChecked /> Enable Parallax Scrolling for background image (<em>background color will be ignored</em>)</span></p>
	<p><label class="comometa-row-title">Background Overlay Color</label><span class="comometa-row-content"><input name="section_data[$cnt][comosection-overlay-color]" type="text" value="$k" class="meta-color" /></span></p>
   
	<p><label class="comometa-row-title">Background Overlay Opacity</label><span class="comometa-row-content"><input type="number" name="section_data[$cnt][comosection-overlay-opacity]" min="0.01" max="1.00" step="0.01" value="$k" /></span></p>
    
	<p>
        <label class="comometa-row-title">Background Value</label>
        <span class="comometa-row-content">
        	<input type="radio" name="section_data[$cnt][comosection-bgvalue]" value="light" $lightChecked>
          	Light Background
           	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          	<input type="radio" name="section_data[$cnt][comosection-bgvalue]" id="comosection-bgvalue-two" value="dark" $darkChecked>
         	Dark Background
            <br><em>Assigns a "light" or "dark" class to section for content styling</em>
        </span>
    </p>
	
	<span class="remove">Remove</span>
</div>
HTML
;
}
//add custom field - move
add_action('add_meta_boxes', 'como_section_init');
function object_init(){
  add_meta_box( 'form-moves-box', 'Form Moves', 'page_section_meta', 'ata_form', 'normal', 'high' );
}
// Page Section Meta
add_action('admin_init','como_section_init');
function como_section_init() {
	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : '');
	if ($post_id) {
		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
		if (strpos($template_file, 'page-section') !== false) {
			add_meta_box('como_section_meta', __('Page Section Info','como-section-meta'),'page_section_meta','page','normal','high');
			//add_meta_box('como_section_sidebar', __('Section Sidebar','como-section-wysiwyg'),'comosection_wysiwyg_callback','page','normal','high');
			add_action( 'admin_enqueue_scripts', 'como_section_color_enqueue' );
		}
	}
}
function page_section_meta(){
 global $post;
  $data = get_post_meta($post->ID,'section_data',true);
  echo '<div>'; 
  echo '<div id="page_sections">';
  $c = 0;
    if (count($data) > 0){
        foreach((array)$data as $p ){
            if (isset($p['num']) || isset($p['side'])|| isset($p['name'])|| isset($p['stance'])|| isset($p['section'])){
                echo print_section_fields($c,$p);
                $c = $c +1;
            }
        }
    }
    echo '</div>';
    ?>
        <span id="here"></span>
        <span class="add"><?php echo __('Add Page Section'); ?></span>
        <script>
            var $ =jQuery.noConflict();
                $(document).ready(function() {
                var count = <?php echo $c; ?>;
                $(".add").click(function() {
                    count = count + 1;
                   $('#page_sections').append('<? echo implode('',explode("\n",print_section_fields('count'))); ?>'.replace(/count/g, count));
                    return false;
                });
                $(".remove").live('click', function() {
                    $(this).parent().remove();
                });
            });
        </script>
    <?php
    echo '</div>';
	echo '<input type="hidden" name="comoSection_update_flag" value="true" />'; 
}
// Save Page Sections
add_action('save_post', 'save_section');
function save_section($post_id){ 
	global $post;
	
	// Only do this if our custom flag is present
    if (isset($_POST['comoSection_update_flag'])) {
	
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'como_section_nonce' ] ) && wp_verify_nonce( $_POST[ 'como_section_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return; // Exits script depending on save status
		}
	
		// to prevent metadata or custom fields from disappearing... 
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id; 
		// OK, we're authenticated: we need to find and save the data
		if (isset($_POST['section_data'])){
			$data = $_POST['section_data'];
			update_post_meta($post_id,'section_data',$data);
		} else {
			delete_post_meta($post_id,'section_data');
		}
	}
} 
?>