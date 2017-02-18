<?php
/**
 * Header template.
 *
 * @package P2
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	global $current_user;
	get_currentuserinfo();
	global $blog_id;

	//最後にアクセスしていたグループ(カテゴリー)
	//$key = PM_MYGROUPS_USER_META_LAST_CATID.'_'.$blog_id;

/*
	$testtoken = get_user_meta( $current_user->ID,'testtoken',true );
	$testua = get_user_meta( $current_user->ID,'testua',true );
	$lastcat = get_user_meta($current_user->ID, 'yrtr_lastcatid_3', true );
	echo "<pre>【testtoken】 $testtoken /【testua】 $testua /【lastcat】 $lastcat  </pre>";
*/

?>
<?php
if ( is_active_sidebar('head-area') ) {
	echo '<div id="from-adm"><ul id="head-area">';
	dynamic_sidebar('head-area');
	echo '</ul></div>';
}
?>
<div id="header">
	<div class="inner">
<?php do_action( 'before' ); ?>

	<div class="sleeve">
		<h1><a href="<?php echo home_url( '/' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>

		<?php if ( current_user_can( 'publish_posts' ) ) : ?>
			<a href="" id="" style="display: none;"><?php _e( 'Post', 'p2' ) ?></a>
		<?php endif; ?>
	</div>

<div class="pm-head">
<ul class="spmenu">
<li class="pconly"><?php get_search_form(); ?></li>
<li class="iphoneonly"><a class="IconInactive" id="pm-search" href="#" title="検索"><span data-icon="&#xe07f;" class="svgicon"></span></a></li>
<?php //if ( p2_user_can_post() && is_home() ) { ?>
<?php if ( p2_user_can_post() && (is_home() || is_category()) ) { ?>
<li class="iphoneonly"><a class="IconInactive" id="mobile-post-button" href="#" title="書き込み"><span data-icon="&#xe005;" class="svgicon"></span></a></li>
<?php } ?>
<li class="iphoneonly"><a class="IconInactive" id="pm-tool" href="#sidebar" title="ツール"><span data-icon="&#xe058;" class="svgicon"></span></a></li>
</ul>
</div>

	</div><!--/.inner-->

</div><!--/#header-->

<div class="iphoneonly" id="pm-search-form"><?php get_search_form(); ?></div>

<?php
if ( is_home() && is_active_sidebar('info-area') ) {
	echo '<div><ul id="info-area">';
	dynamic_sidebar('info-area');
	echo '</ul></div>';
}
?>

<div id="wrapper">