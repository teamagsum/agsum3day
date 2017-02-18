<?php get_header(); ?>

		<div class="inner-wrapper-820">
			<div class="page-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/title-blog.gif" alt="スタッフブログ" /></div>
			<div id="container">
				<div class="page-title">スタッフブログ</div>
				<div class="cf-box">
					<div id="primary">
						<div class="content" role="main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
							<article>
								<header>
									<h1 class="entry-title"><div class="date"><?php the_date(); ?></div><?php the_title(); ?></h1>
								</header>
								<div class="entry-content">
									<?php the_content(); ?>
								</div>
							</article>
								<div class="back-link"><a href="<?php echo esc_url( home_url( '/' ) ); ?>blog/">&lt;&nbsp;記事一覧に戻る</a></div>

		<?php endwhile; ?>
	<?php endif; ?>
						</div>						
					</div><!-- #primary -->

					<?php get_sidebar(); ?>

				</div><!-- .cf-box -->
			</div><!-- #container -->
		</div><!-- .inner-wrapper-820 -->

<?php get_footer(); ?>