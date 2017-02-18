<?php get_header(); ?>

		<div class="inner-wrapper-820">
			<div class="page-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/title-blog.gif" alt="スタッフブログ" /></div>
			<div id="container">
				<div class="page-title">スタッフブログ</div>
				<div class="cf-box">
					<div id="primary">
						<div class="content" role="main">

<?php //query_posts($query_string.'&'.$paged); ?>

		<?php if ( have_posts() ) : ?>
			<?php while (have_posts()) : the_post(); ?>

							<article>
								<header>
									<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><div class="date"><?php the_time('Y年m月d日'); ?></div><?php the_title(); ?></a></h1>
								</header>
								<div class="entry-content">
									<?php the_excerpt(); ?>
									<div class="t-right">
										<a href="<?php the_permalink(); ?>" class="more-link">続きを読む</a>
									</div>
								</div>
							</article>

			<?php endwhile; ?>

<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?> 


		<?php else: ?>
				<article>記事はありません</article>			

		<?php endif; ?>
						<?php //wp_reset_query(); ?>

						</div>
				
					</div><!-- #primary -->

					<?php get_sidebar(); ?>

				</div><!-- .cf-box -->
			</div><!-- #container -->
		</div><!-- .inner-wrapper-820 -->

<?php get_footer(); ?>