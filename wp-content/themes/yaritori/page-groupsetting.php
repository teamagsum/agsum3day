<?php
/*
 * Template Name: グループ編集専用　※plugin "PM_MyGroups"必須
 */
get_header();
?>
<div class="sleeve_main">
	<div id="main">
		<h2><?php the_title(); ?></h2>
<?php
//コンテンツを表示
if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
}

//use plugin "PM_MyGroups"
if(function_exists('pm_get_addcat_content')){
	pm_get_addcat_content();
}
?>
	</div><!-- /main -->

</div><!-- /sleeve_main -->
<?php get_footer(); ?>