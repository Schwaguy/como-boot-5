<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php /* Template Name: WooCommerce */ ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<section class="page-section">
		<div class="container main content">
			<div class="row page-content">
				<div class="col-12 col-md-12 col-lg-12 content-wrap">
					<?php woocommerce_content(); ?>
					<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
				</div>
			</div>
		 </div><!-- /.main -->
	</section>
</main><!-- /#content-wrap -->
<?php get_footer(); ?>