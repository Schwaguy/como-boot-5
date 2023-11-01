<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: Page - Narrow */ ?>
<?php get_header(); ?>
<div id="content-wrap" aria-label="main" role="main">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xs-12 col-sm-12 col-md-11 col-lg-10">
				<h1 class="entry-title"><?php _e( 'Page Not Found', 'como-boot' ); ?></h1>
               	<div class="intro-text">
					<p><?php _e( 'The page you were looking for could not be found. It might have been removed, renamed, or did not exist in the first place.', 'como-boot' ); ?></p>
				</div>
				<?php
					get_search_form(
						array(
							'label' => __( '404 not found', 'como-boot' ),
						)
					);
				?>
			</div>
		</div>
	</div>
</div><!-- /#content-wrap -->
			
<?php get_footer(); ?>