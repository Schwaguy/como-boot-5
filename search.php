<?php defined('ABSPATH') or die('No Hackers!'); ?>
<?php get_header(); ?>
<main id="content-wrap" aria-label="main" role="main">
	<div class="container main">
		<section class="page-section search-page">
			<?php if ( have_posts() ) : ?>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-11 col-xl-10">
						
						<header class="page-header">
							<h1 class="search-title"><?php echo $wp_query->found_posts; ?> <?php _e( 'Search Results Found For', 'locale' ); ?>: "<?php the_search_query(); ?>"</h1>
						</header>
					
						<ul class="search-results">
						<?php while ( have_posts() ) { the_post(); ?>
						   <li>
							 <h3 class="post-title"><a href="<?php echo get_permalink(); ?>">
							   <?php the_title();  ?>
							 </a></h3>
							 <?php  //the_post_thumbnail('medium') ?>
							 <?php echo substr(get_the_excerpt(), 0,200); ?>
							 <div class="h-readmore"> <a href="<?php the_permalink(); ?>">Read More</a></div>
						   </li>
						<?php } ?>
						</ul>
					   <?php echo '<div id="pagination">'. paginate_links() .'</div>'; ?>
				</div>
			</div>
			<?php
			else:
				include (locate_template('/template-parts/content-none.php',true));     
			endif; ?>
			<div class="post-edit"><?php edit_post_link( __( 'Edit', 'como-strap' ) ); ?></div>
		</section>
	</div>
</main>
<?php get_footer(); ?>