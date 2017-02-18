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
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/magnific-popup/magnific-popup.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script>
	$(document).ready(function() {
	    $('.movie').magnificPopup({
	        type: 'iframe',
	        mainClass: 'mfp-fade',
        	removalDelay: 160,
	        preloader: false,
	        fixedContentPos: false
	    });
	});
	</script>
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
					<li class="order"><a href="<?php echo esc_url( home_url( '/' ) ); ?>apply/">無料お申し込み</a></li>
					<li class="staffblog"><a href="<?php echo esc_url( home_url( '/' ) ); ?>blog/">スタッフブログ</a></li>
					<li class="function"><a href="<?php echo esc_url( home_url( '/' ) ); ?>service/">機能説明</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div id="main">