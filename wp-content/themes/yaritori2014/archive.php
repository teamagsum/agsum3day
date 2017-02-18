<?php get_header(); ?>

		<div class="inner-wrapper-820">
			<div class="page-logo"><img src="<?php echo get_template_directory_uri(); ?>/images/title-blog.gif" alt="スタッフブログ" /></div>
			<div id="container">
				<div class="page-title">スタッフブログ：
					<?php
						if ( is_day() ) :
							printf( __( '%sのアーカイブ' ), get_the_date() );
						elseif ( is_month() ) :
							printf( __( '%sのアーカイブ' ), get_the_date( _x( 'Y F', 'monthly archives date format' ) ) );
						elseif ( is_year() ) :
							printf( __( '%sのアーカイブ' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
						else :
							_e( 'Archives' );
						endif;
					?>
				</div>
				<div class="cf-box">
					<div id="primary">
						<div class="content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
							<article>
								<header>
									<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><div class="date"><?php the_date(); ?></div><?php the_title(); ?></a></h1>
								</header>
								<div class="entry-content">
									<?php the_excerpt(); ?>
									<div class="t-right">
										<a href="<?php the_permalink(); ?>" class="more-link">続きを読む</a>
									</div>
								</div>
							</article>
		<?php endwhile; ?>
						</div>						
					</div><!-- #primary -->

					<?php get_sidebar(); ?>

				</div><!-- .cf-box -->
			</div><!-- #container -->
		</div><!-- .inner-wrapper-820 -->

<?php get_footer(); ?>