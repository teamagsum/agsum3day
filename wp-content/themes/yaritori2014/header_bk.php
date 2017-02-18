<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
		<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
	?></title>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
	<script>viewportChange();</script>
	<noscript><meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" /></noscript>
	<!--[if IE]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script> 
	<![endif]-->
	<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
	<?php wp_deregister_script('jquery');?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="<?php echo esc_attr( $post->post_name ); ?>">
	<header id="musthead" role="banner">
		<div class="inner-wrapper">
			<div id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-small.gif" alt="<?php bloginfo( 'name' ); ?>" /></a></div>
			<nav id="site-navigation" role="navigation">
				<ul>
					<li class="inquire"><a href="<?php echo esc_url( home_url( '/' ) ); ?>inquire/">お問合せ</a></li>
					<li class="blog"><a href="<?php echo esc_url( home_url( '/' ) ); ?>blog/">スタッフブログ</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div id="main">
