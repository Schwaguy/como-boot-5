<?php
function comoFooterScrips_custom_meta() {
    add_meta_box('comoFooterScrips_meta', __('Footer Scripts','comoFooterScrips-textdomain'),'comoFooterScrips_meta_callback','page','normal','high');
}
add_action( 'add_meta_boxes', 'comoFooterScrips_custom_meta' );
function comoFooterScrips_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'comoFooterScrips_nonce' );
    $comoFooterScrips_stored_meta = get_post_meta( $post->ID );
    ?>
    <p><textarea type="text" name="comoFooterScrips" id="comoFooterScrips" style="width: 100%"><?php if ( isset ( $comoFooterScrips_stored_meta['comoFooterScrips'] ) ) echo $comoFooterScrips_stored_meta['comoFooterScrips'][0]; ?></textarea></p>
	<input type="hidden" name="comoFooterScrips_update_flag" value="true" />
    <?php 
}
// Saves the Team Member Info Section meta input
function comoFooterScrips_meta_save( $post_id ) {
	// Only do this if our custom flag is present
    if (isset($_POST['comoFooterScrips_update_flag'])) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'comoFooterScrips_nonce' ] ) && wp_verify_nonce( $_POST[ 'comoFooterScrips_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		// Specify Meta Variables to be Updated
		$metaVars = array('comoFooterScrips');
		$checkboxVars = array();
		$externalVars = array();
		$ignoreVars = array();
		// Update Meta Variables
		foreach ($metaVars as $var) {
			if (!in_array($var,$ignoreVars)) {
				if (in_array($var,$checkboxVars)) {
					if (isset($_POST[$var])) {
						update_post_meta($post_id, $var, 'yes');
					} else {
						update_post_meta($post_id, $var, '');
					}
				} else {
					if(isset($_POST[$var])) {
						update_post_meta($post_id, $var, $_POST[$var]);
					} else {
						update_post_meta($post_id, $var, '');
					}
				}
			}
		}
	}
}
add_action( 'save_post', 'comoFooterScrips_meta_save' );
?>