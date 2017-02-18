<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if(is_search()): ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Search Results for: %s' ), get_search_query() ); ?></h1>
				</header>
			<?php elseif(is_category()): ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Category Archives: %s' ), single_cat_title( '', false ) ); ?></h1>
					<?php if ( category_description() ) : ?>
					<div class="archive-meta"><?php echo category_description(); ?></div>
					<?php endif; ?>
				</header><!-- .archive-header -->
			<?php elseif(is_tag()): ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s' ), single_tag_title( '', false ) ); ?></h1>
					<?php if ( tag_description() ) : ?>
					<div class="archive-meta"><?php echo tag_description(); ?></div>
					<?php endif; ?>
				</header><!-- .archive-header -->
			<?php elseif(is_archive()): ?>
				<header class="archive-header">
					<h1 class="archive-title"><?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s' ), get_the_date() );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s' ), get_the_date( _x( 'Y F', 'monthly archives date format' ) ) );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
						else :
							_e( 'Archives' );
						endif;
					?></h1>
				</header><!-- .archive-header -->
			<?php endif; ?>
			
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			
			<?php if (function_exists("pagination")) {
			    pagination($additional_loop->max_num_pages);
			} ?>
			
		<?php else : ?>
			<article>
				<p>お探しの記事は見つかりませんでした。</p>
			</article>
		<?php endif; ?>
	
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>