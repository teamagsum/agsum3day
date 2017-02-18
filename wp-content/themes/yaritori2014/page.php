<?php get_header(); ?>
	<div class="inner-wrapper-820">
		<?php
		$page = get_post( get_the_ID() );
		$slug = $page->post_name;
		?>
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="page-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/title-<?php echo $slug ?>.gif" alt="<?php the_title(); ?>" /></div>
			<div id="container">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<div class="cf-box">
					<div class="content">
						<?php the_content(); ?>
					</div>										
				</div><!-- .cf-box -->
			</div><!-- #container -->
		<?php endwhile; ?>
	</div><!-- .inner-wrapper-820 -->
<?php get_footer(); ?>