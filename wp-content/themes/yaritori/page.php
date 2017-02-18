<?php
/**
 * Static page template.
 *
 * @package P2
 */
?>
<?php get_header(); ?>

<div class="sleeve_main">

	<div id="main">
		<h2><?php the_title(); ?></h2>

		<ul id="postlist">
			<li>
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
<!-- content -->
				<?php the_content(); ?>
<!-- /content -->
			<?php endwhile; ?>

		<?php endif; ?>
			</li>
		</ul>

	</div><!-- /main -->

</div> <!-- /sleeve -->

<?php get_footer(); ?>