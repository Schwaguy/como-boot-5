<?php
function comoModal_custom_meta() {
    add_meta_box('comoModal_meta', __('Modal Code','comoModal-textdomain'),'comoModal_meta_callback','page','normal','high');
}
add_action( 'add_meta_boxes', 'comoModal_custom_meta' );
function comoModal_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'comoModal_nonce' );
    $comoModal_stored_meta = get_post_meta( $post->ID );
    ?>
    <p><textarea type="text" name="comoModalCode" id="comoModalCode" style="width: 100%"><?php if ( isset ( $comoModal_stored_meta['comoModalCode'] ) ) echo $comoModal_stored_meta['comoModalCode'][0]; ?></textarea></p>
	<input type="hidden" name="comoModal_update_flag" value="true" />
    <?php 
}
// Saves the Team Member Info Section meta input
function comoModal_meta_save( $post_id ) {
	// Only do this if our custom flag is present
    if (isset($_POST['comoModal_update_flag'])) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'comoModal_nonce' ] ) && wp_verify_nonce( $_POST[ 'comoModal_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		// Specify Meta Variables to be Updated
		$metaVars = array('comoModalCode');
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
add_action( 'save_post', 'comoModal_meta_save' );
?>