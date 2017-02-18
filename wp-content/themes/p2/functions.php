<?php
/**
 * @package P2
 */

require_once( get_template_directory() . '/inc/utils.php' );

p2_maybe_define( 'P2_INC_PATH', get_template_directory()     . '/inc' );
p2_maybe_define( 'P2_INC_URL',  get_template_directory_uri() . '/inc' );
p2_maybe_define( 'P2_JS_PATH',  get_template_directory()     . '/js'  );
p2_maybe_define( 'P2_JS_URL',   get_template_directory_uri() . '/js'  );

class P2 {
	/**
	 * DB version.
	 *
	 * @var int
	 */
	var $db_version = 3;

	/**
	 * Options.
	 *
	 * @var array
	 */
	var $options = array();

	/**
	 * Option name in DB.
	 *
	 * @var string
	 */
	var $option_name = 'p2_manager';

	/**
	 * Components.
	 *
	 * @var array
	 */
	var $components = array();

	/**
	 * Includes and instantiates the various P2 components.
	 */
	function P2() {
		// Fetch options
		$this->options = get_option( $this->option_name );
		if ( false === $this->options )
			$this->options = array();

		// Include the P2 components
		$includes = array( 'compat', 'terms-in-comments', 'js-locale',
			'mentions', 'search', 'js', 'options-page', 'widgets/recent-tags', 'widgets/recent-comments',
			'list-creator' );

		require_once( P2_INC_PATH . "/template-tags.php" );

		// Logged-out/unprivileged users use the add_feed() + ::ajax_read() API rather than the /admin-ajax.php API
		// current_user_can( 'read' ) should be equivalent to is_user_member_of_blog()
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ( p2_user_can_post() || current_user_can( 'read' ) ) )
			$includes[] = 'ajax';

		foreach ( $includes as $name ) {
			require_once( P2_INC_PATH . "/$name.php" );
		}

		// Add the default P2 components
		$this->add( 'mentions',             'P2_Mentions'             );
		$this->add( 'search',               'P2_Search'               );
		$this->add( 'post-list-creator',    'P2_Post_List_Creator'    );
		$this->add( 'comment-list-creator', 'P2_Comment_List_Creator' );

		// Bind actions
		add_action( 'init',       array( &$this, 'init'             ) );
		add_action( 'admin_init', array( &$this, 'maybe_upgrade_db' ), 5 );
	}

	function init() {
		// Load language pack
		load_theme_textdomain( 'p2', get_template_directory() . '/languages' );

		// Set up the AJAX read handler
		add_feed( 'p2.ajax', array( $this, 'ajax_read' ) );
	}

	function ajax_read() {
		if ( ! defined( 'DOING_AJAX' ) ) {
			define( 'DOING_AJAX', true );
		}

		require_once( P2_INC_PATH . '/ajax-read.php' );

		P2Ajax_Read::dispatch();
	}

	/**
	 * Will upgrade the database if necessary.
	 *
	 * When upgrading, triggers actions:
	 *    'p2_upgrade_db_version'
	 *    'p2_upgrade_db_version_$number'
	 *
	 * Flushes rewrite rules automatically on upgrade.
	 */
	function maybe_upgrade_db() {
		if ( ! isset( $this->options['db_version'] ) || $this->options['db_version'] < $this->db_version ) {
			$current_db_version = isset( $this->options['db_version'] ) ? $this->options['db_version'] : 0;

			do_action( 'p2_upgrade_db_version', $current_db_version );
			for ( ; $current_db_version <= $this->db_version; $current_db_version++ ) {
				do_action( "p2_upgrade_db_version_$current_db_version" );
			}

			// Flush rewrite rules once, so callbacks don't have to.
			flush_rewrite_rules();

			$this->set_option( 'db_version', $this->db_version );
			$this->save_options();
		}
	}

	/**
	 * COMPONENTS API
	 */
	function add( $component, $class ) {
		$class = apply_filters( "p2_add_component_$component", $class );
		if ( class_exists( $class ) )
			$this->components[ $component ] = new $class();
	}
	function get( $component ) {
		return $this->components[ $component ];
	}
	function remove( $component ) {
		unset( $this->components[ $component ] );
	}

	/**
	 * OPTIONS API
	 */
	function get_option( $key ) {
		return isset( $this->options[ $key ] ) ? $this->options[ $key ] : null;
	}
	function set_option( $key, $value ) {
		return $this->options[ $key ] = $value;
	}
	function save_options() {
		update_option( $this->option_name, $this->options );
	}
}

$GLOBALS['p2'] = new P2;

function p2_get( $component = '' ) {
	global $p2;
	return empty( $component ) ? $p2 : $p2->get( $component );
}
function p2_get_option( $key ) {
	return $GLOBALS['p2']->get_option( $key );
}
function p2_set_option( $key, $value ) {
	return $GLOBALS['p2']->set_option( $key, $value );
}
function p2_save_options() {
	return $GLOBALS['p2']->save_options();
}




/**
 * ----------------------------------------------------------------------------
 * NOTE: Ideally, the rest of this file should be moved elsewhere.
 * ----------------------------------------------------------------------------
 */

if ( ! isset( $content_width ) )
	$content_width = 632;

$themecolors = array(
	'bg'     => 'ffffff',
	'text'   => '555555',
	'link'   => '3478e3',
	'border' => 'f1f1f1',
	'url'    => 'd54e21',
);

/**
 * Setup P2 Theme.
 *
 * Hooks into the after_setup_theme action.
 *
 * @uses p2_get_supported_post_formats()
 */
function p2_setup() {
	require_once( get_template_directory() . '/inc/custom-header.php' );
	p2_setup_custom_header();

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', p2_get_supported_post_formats( 'post-format' ) );

	add_theme_support( 'custom-background', apply_filters( 'p2_custom_background_args', array( 'default-color' => 'f1f1f1' ) ) );

	add_filter( 'the_content', 'make_clickable', 12 ); // Run later to avoid shortcode conflicts

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'p2' ),
	) );

	if ( is_admin() && false === get_option( 'prologue_show_titles' ) )
		add_option( 'prologue_show_titles', 1 );
}
add_filter( 'after_setup_theme', 'p2_setup' );

function p2_register_sidebar() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'p2' ),
	) );
	register_sidebar( array(
		'name' => 'InfoArea',
		'id' => 'info-area',
	) );
	register_sidebar( array(
		'name' => 'HeadArea',
		'id' => 'head-area',
	) );
}
add_filter( 'widgets_init', 'p2_register_sidebar' );

function p2_background_color() {
	$background_color = get_option( 'p2_background_color' );

	if ( '' != $background_color ) :
	?>
	<style type="text/css">
		body {
			background-color: <?php echo esc_attr( $background_color ); ?>;
		}
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_background_color' );

function p2_background_image() {
	$p2_background_image = get_option( 'p2_background_image' );

	if ( 'none' == $p2_background_image || '' == $p2_background_image )
		return false;

?>
	<style type="text/css">
		body {
			background-image: url( <?php echo get_template_directory_uri() . '/i/backgrounds/pattern-' . sanitize_key( $p2_background_image ) . '.png' ?> );
		}
	</style>
<?php
}
add_action( 'wp_head', 'p2_background_image' );

/**
 * Add a custom class to the body tag for the background image theme option.
 *
 * This dynamic class is used to style the bundled background
 * images for retina screens. Note: The background images that
 * ship with P2 have been deprecated as of P2 1.5. For backwards
 * compatibility, P2 will still recognize them if the option was
 * set before upgrading.
 *
 * @since P2 1.5
 */
function p2_body_class_background_image( $classes ) {
	$image = get_option( 'p2_background_image' );

	if ( empty( $image ) || 'none' == $image )
		return $classes;

	$classes[] = esc_attr( 'p2-background-image-' . $image );

	return $classes;
}
add_action( 'body_class', 'p2_body_class_background_image' );

// Content Filters
function p2_title( $before = '<h2>', $after = '</h2>', $echo = true ) {
	if ( is_page() )
		return;

	if ( is_single() && false === p2_the_title( '', '', false ) ) { ?>
		<h2 class="transparent-title"><?php the_title(); ?></h2><?php
		return true;
	} else {
		p2_the_title( $before, $after, $echo );
	}
}

/**
 * Generate a nicely formatted post title
 *
 * Ignore empty titles, titles that are auto-generated from the
 * first part of the post_content
 *
 * @package WordPress
 * @subpackage P2
 * @since 1.0.5
 *
 * @param    string    $before    content to prepend to title
 * @param    string    $after     content to append to title
 * @param    string    $echo      echo or return
 * @return   string    $out       nicely formatted title, will be boolean(false) if no title
 */
function p2_the_title( $before = '<h2>', $after = '</h2>', $echo = true ) {
	global $post;

	$temp = $post;
	$t = apply_filters( 'the_title', $temp->post_title, $temp->ID );
	$title = $temp->post_title;
	$content = $temp->post_content;
	$pos = 0;
	$out = '';

	// Don't show post title if turned off in options or title is default text
	if ( 1 != (int) get_option( 'prologue_show_titles' ) || 'Post Title' == $title )
		return false;

	$content = trim( $content );
	$title = trim( $title );
	$title = preg_replace( '/\.\.\.$/', '', $title );
	$title = str_replace( "\n", ' ', $title );
	$title = str_replace( '  ', ' ', $title);
	$content = str_replace( "\n", ' ', strip_tags( $content) );
	$content = str_replace( '  ', ' ', $content );
	$content = trim( $content );
	$title = trim( $title );

	// Clean up links in the title
	if ( false !== strpos( $title, 'http' ) )  {
		$split = @str_split( $content, strpos( $content, 'http' ) );
		$content = $split[0];
		$split2 = @str_split( $title, strpos( $title, 'http' ) );
		$title = $split2[0];
	}

	// Avoid processing an empty title
	if ( '' == $title )
		return false;

	// Avoid processing the title if it's the very first part of the post content
	// Which is the case with most "status" posts
	$pos = strpos( $content, $title );
	if ( false === $pos || 0 < $pos ) {
		if ( is_single() )
			$out = $before . $t . $after;
		else
			$out = $before . '<a href="' . get_permalink( $temp->ID ) . '">' . $t . '&nbsp;</a>' . $after;

		if ( $echo )
			echo $out;
		else
			return $out;
	}

	return false;
}

function p2_comments( $comment, $args ) {
	$GLOBALS['comment'] = $comment;

	if ( !is_single() && get_comment_type() != 'comment' )
		return;

	$depth          = prologue_get_comment_depth( get_comment_ID() );
	$can_edit_post  = current_user_can( 'edit_post', $comment->comment_post_ID );

/*
	$reply_link     = prologue_get_comment_reply_link(
		array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => ' | ', 'reply_text' => __( 'Reply', 'p2' ) ),
		$comment->comment_ID, $comment->comment_post_ID );
*/
//PM HS
	$reply_link     = prologue_get_comment_reply_link(
		array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '', 'reply_text' => __( 'Reply', 'p2' ) ),
		$comment->comment_ID, $comment->comment_post_ID );

	$content_class  = 'commentcontent';
	if ( $can_edit_post )
		$content_class .= ' comment-edit';

	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<?php do_action( 'p2_comment' ); ?>

		<?php echo get_avatar( $comment, 32 ); ?>
		<h4>
			<?php echo get_comment_author_link(); ?>
			<span class="meta">
				<?php echo p2_date_time_with_microformat( 'comment' ); ?>
				<span class="actions">
					<a class="thepermalink" href="<?php echo esc_url( get_comment_link() ); ?>" title="<?php esc_attr_e( 'Link', 'p2' ); ?>"><?php _e( 'Link', 'p2' ); ?></a>
					<?php
					//Moved by PM HS
					//echo $reply_link;

					if ( $can_edit_post ){
						edit_comment_link( __( 'Edit', 'p2' ), ' | ' );
						//Add 削除 by PM HS
						$url = clean_url(wp_nonce_url( admin_url()."comment.php?action=deletecomment&p=$comment->comment_post_ID&c=$comment->comment_ID", "delete-comment_$comment->comment_ID" ));
						echo ' | '."<a href='$url' class='deleteComment'>" . "削除" . "</a>";
					}

					echo $reply_link;

					?>
				</span>
			</span>
		</h4>
		<div id="commentcontent-<?php comment_ID(); ?>" class="<?php echo esc_attr( $content_class ); ?>"><?php
				echo apply_filters( 'comment_text', $comment->comment_content, $comment );

				if ( $comment->comment_approved == '0' ): ?>
					<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'p2' ); ?></em></p>
				<?php endif; ?>
		</div>
	<?php
}

function get_tags_with_count( $post, $format = 'list', $before = '', $sep = '', $after = '' ) {
	$posttags = get_the_tags($post->ID, 'post_tag' );

	if ( !$posttags )
		return '';

	foreach ( $posttags as $tag ) {
		if ( $tag->count > 1 && !is_tag($tag->slug) ) {
			$tag_link = '<a href="' . get_tag_link( $tag ) . '" rel="tag">' . $tag->name . ' ( ' . number_format_i18n( $tag->count ) . ' )</a>';
		} else {
			$tag_link = $tag->name;
		}

		if ( $format == 'list' )
			$tag_link = '<li>' . $tag_link . '</li>';

		$tag_links[] = $tag_link;
	}

	return apply_filters( 'tags_with_count', $before . join( $sep, $tag_links ) . $after, $post );
}

function tags_with_count( $format = 'list', $before = '', $sep = '', $after = '' ) {
	global $post;
	echo get_tags_with_count( $post, $format, $before, $sep, $after );
}

function p2_title_from_content( $content ) {
	$title = p2_excerpted_title( $content, 8 ); // limit title to 8 full words

	// Try to detect image or video only posts, and set post title accordingly
	if ( empty( $title ) ) {
		if ( preg_match("/<object|<embed/", $content ) )
			$title = __( 'Video Post', 'p2' );
		elseif ( preg_match( "/<img/", $content ) )
			$title = __( 'Image Post', 'p2' );
	}

	return $title;
}

function p2_excerpted_title( $content, $word_count ) {
	$content = strip_tags( $content );
//	$words = preg_split( '/([\s_;?!\/\(\)\[\]{}<>\r\n\t"]|\.$|(?<=\D)[:,.\-]|[:,.\-](?=\D))/', $content, $word_count + 1, PREG_SPLIT_NO_EMPTY );
// mod by PM HS (/をトリムしないように)
	$words = preg_split( '/([\s_;?!\(\)\[\]{}<>\r\n\t"]|\.$|(?<=\D)[:,.\-]|[:,.\-](?=\D))/', $content, $word_count + 1, PREG_SPLIT_NO_EMPTY );

	if ( count( $words ) > $word_count ) {
		array_pop( $words ); // remove remainder of words
		$content = implode( ' ', $words );
		$content = $content . '...';
	} else {
		$content = implode( ' ', $words );
	}

	$content = trim( strip_tags( $content ) );

	return $content;
}

function p2_add_reply_title_attribute( $link ) {
	return str_replace( "rel='nofollow'", "rel='nofollow' title='" . __( 'Reply', 'p2' ) . "'", $link );
}
add_filter( 'post_comments_link', 'p2_add_reply_title_attribute' );

function p2_fix_empty_titles( $data, $postarr ) {
	if ( 'post' != $data['post_type'] )
		return $data;

	if ( ! empty( $postarr['post_title'] ) )
		return $data;

	$data['post_title'] = p2_title_from_content( $data['post_content'] );

	return $data;
}
add_filter( 'wp_insert_post_data', 'p2_fix_empty_titles', 10, 2 );

function p2_add_head_content() {
	if ( is_home() && is_user_logged_in() ) {
		include_once( ABSPATH . '/wp-admin/includes/media.php' );
	}
}
add_action( 'wp_head', 'p2_add_head_content' );

function p2_new_post_noajax() {
	if ( empty( $_POST['action'] ) || $_POST['action'] != 'post' )
	    return;

	if ( !is_user_logged_in() )
		auth_redirect();

	if ( !current_user_can( 'publish_posts' ) ) {
		wp_redirect( home_url( '/' ) );
		exit;
	}

	$current_user = wp_get_current_user();

	check_admin_referer( 'new-post' );

	$user_id        = $current_user->ID;
	$post_content   = $_POST['posttext'];
	$tags           = $_POST['tags'];

	$post_title = p2_title_from_content( $post_content );

	$post_id = wp_insert_post( array(
		'post_author'   => $user_id,
		'post_title'    => $post_title,
		'post_content'  => $post_content,
		'tags_input'    => $tags,
		'post_status'   => 'publish'
	) );

	$post_format = 'status';
	if ( in_array( $_POST['post_format'], p2_get_supported_post_formats() ) )
		$post_format = $_POST['post_format'];

	set_post_format( $post_id, $post_format );

	wp_redirect( home_url( '/' ) );

	exit;
}
add_filter( 'template_redirect', 'p2_new_post_noajax' );

/**
 * iPhone viewport meta tag.
 *
 * Hooks into the wp_head action late.
 *
 * @uses p2_is_iphone()
 * @since P2 1.4
 */
function p2_viewport_meta_tag() {
	if ( p2_is_iphone() )
		echo '<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no"/>';
}
add_action( 'wp_head', 'p2_viewport_meta_tag', 1000 );

/**
 * iPhone Stylesheet.
 *
 * Hooks into the wp_enqueue_scripts action late.
 *
 * @uses p2_is_iphone()
 * @since P2 1.4

 * レスポンシブ化のため不採用　PM HS 2014
 */
/*
function p2_iphone_style() {
	if ( p2_is_iphone() ) {
		wp_enqueue_style(
			'p2-iphone-style',
			get_template_directory_uri() . '/style-iphone.css',
			array(),
			'20120402'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'p2_iphone_style', 1000 );
*/

/**
 * Print Stylesheet.
 *
 * Hooks into the wp_enqueue_scripts action.
 *
 * @since P2 1.5
 */
function p2_print_style() {
	wp_enqueue_style( 'p2', get_stylesheet_uri() );
	wp_enqueue_style( 'p2-print-style', get_template_directory_uri() . '/style-print.css', array( 'p2' ), '20120807', 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'p2_print_style' );

/*
	Modified to replace query string with blog url in output string
*/
function prologue_get_comment_reply_link( $args = array(), $comment = null, $post = null ) {
	global $user_ID;

	if ( post_password_required() )
		return;

	$defaults = array( 'add_below' => 'commentcontent', 'respond_id' => 'respond', 'reply_text' => __( 'Reply', 'p2' ),
		'login_text' => __( 'Log in to Reply', 'p2' ), 'depth' => 0, 'before' => '', 'after' => '' );

	$args = wp_parse_args($args, $defaults);

//escape by PM HS ("likeが最下のコメントに付かない対"策)
/*
	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;
*/

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	$post = get_post($post);

	if ( 'open' != $post->comment_status )
		return false;

	$link = '';

	$reply_text = esc_html( $reply_text );

	if ( get_option( 'comment_registration' ) && !$user_ID )
		$link = '<a rel="nofollow" href="' . site_url( 'wp-login.php?redirect_to=' . urlencode( get_permalink() ) ) . '">' . esc_html( $login_text ) . '</a>';
	else
//escape by PM HS
/*
		$link = "<a rel='nofollow' class='comment-reply-link' href='". get_permalink($post). "#" . urlencode( $respond_id ) . "' title='". __( 'Reply', 'p2' )."' onclick='return addComment.moveForm(\"" . esc_js( "$add_below-$comment->comment_ID" ) . "\", \"$comment->comment_ID\", \"" . esc_js( $respond_id ) . "\", \"$post->ID\")'>$reply_text</a>";
*/
	return apply_filters( 'comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

function prologue_comment_depth_loop( $comment_id, $depth )  {
	$comment = get_comment( $comment_id );

	if ( isset( $comment->comment_parent ) && 0 != $comment->comment_parent ) {
		return prologue_comment_depth_loop( $comment->comment_parent, $depth + 1 );
	}
	return $depth;
}

function prologue_get_comment_depth( $comment_id ) {
	return prologue_comment_depth_loop( $comment_id, 1 );
}

function prologue_comment_depth( $comment_id ) {
	echo prologue_get_comment_depth( $comment_id );
}

function prologue_poweredby_link() {
	return apply_filters( 'prologue_poweredby_link', sprintf( '<a href="%1$s" rel="generator">%2$s</a>', esc_url( __('http://wordpress.org/', 'p2') ), sprintf( __('Proudly powered by %s.', 'p2'), 'WordPress' ) ) );
}

function p2_hidden_sidebar_css() {
	$hide_sidebar = get_option( 'p2_hide_sidebar' );
		$sleeve_margin = ( is_rtl() ) ? 'margin-left: 0;' : 'margin-right: 0;';
	if ( '' != $hide_sidebar ) :
	?>
	<style type="text/css">
		.sleeve_main { <?php echo $sleeve_margin;?> }
		#wrapper { background: transparent; }
		#header, #footer, #wrapper { width: 760px; }
	</style>
	<?php endif;
}
add_action( 'wp_head', 'p2_hidden_sidebar_css' );

// Network signup form
function p2_before_signup_form() {
	echo '<div class="sleeve_main"><div id="main">';
}
add_action( 'before_signup_form', 'p2_before_signup_form' );

function p2_after_signup_form() {
	echo '</div></div>';
}
add_action( 'after_signup_form', 'p2_after_signup_form' );

/**
 * Returns accepted post formats.
 *
 * The value should be a valid post format registered for P2, or one of the back compat categories.
 * post formats: link, quote, standard, status
 * categories: link, post, quote, status
 *
 * @since P2 1.3.4
 *
 * @param string type Which data to return (all|category|post-format)
 * @return array
 */
function p2_get_supported_post_formats( $type = 'all' ) {
	$post_formats = array( 'link', 'quote', 'status' );

	switch ( $type ) {
		case 'post-format':
			break;
		case 'category':
			$post_formats[] = 'post';
			break;
		case 'all':
		default:
			array_push( $post_formats, 'post', 'standard' );
			break;
	}

	return apply_filters( 'p2_get_supported_post_formats', $post_formats );
}

/**
 * Is site being viewed on an iPhone or iPod Touch?
 *
 * For testing you can modify the output with a filter:
 * add_filter( 'p2_is_iphone', '__return_true' );
 *
 * @return bool
 * @since P2 1.4

 * PMで再定義（plugin）20140215 PM HS
 */

/*
function p2_is_iphone() {
	$output = false;

	if ( ( strstr( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) && ! strstr( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) || isset( $_GET['iphone'] ) && $_GET['iphone'] )
		$output = true;

	$output = (bool) apply_filters( 'p2_is_iphone', $output );

	return $output;
}
*/

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since P2 1.5
 */
function p2_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'p2' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'p2_wp_title', 10, 2 );


/*
 * tag could widget カスタマイズ PM HS
 */
function pm_custom_tag_cloud() {

	$args = array(
		'orderby' => 'count',
		'order' => 'DESC',
		'hide_empty' => false,
	);
	$tags = get_tags($args);
	foreach($tags as $tag) {

		$ptnML = '/type="ML"/';
		$ptnSP = '/name="([a-zA-Z]+)"/';
		$tag_description = $tag->description;
		$tag_ID = $tag->term_id;

		//メールタグ
		if ( preg_match( $ptnML , $tag_description ) ) {
			$exclude[]=$tag_ID;
		}
		//特殊タグ
		elseif ( preg_match( $ptnSP , $tag_description ) ) {
			$exclude[]=$tag_ID;
		}
		//その他のタグ
		else {
		}
  	}

        $args = array(
                'exclude'     => $exclude,
        );
        return $args;
}
//add_filter( 'widget_tag_cloud_args', 'pm_custom_tag_cloud');


/*
------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------
以下、PMカスタマイズ
------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------
*/

/*
 * タグクラウドを（0件のもモノも）全部表示
 */
add_filter( 'widget_tag_cloud_args', 'pm_show_all_tags_in_tag_cloud' );
function pm_show_all_tags_in_tag_cloud( $args ) {
	$args['hide_empty']=false;
	return $args;
}

/*
 * P2の投稿タイトル長過ぎ問題を解決
 */
add_filter( 'wp_insert_post_data', 'pm_p2_fix_toooooLooooong_titles', 20, 2 );
function pm_p2_fix_toooooLooooong_titles( $data, $postarr ) {
	if ( 'post' != $data['post_type'] )
		return $data;
/*
	if ( ! empty( $postarr['post_title'] ) )
		return $data;
*/
	//題名の準備
	$subjectOrg = $data['post_title'];
	$subject = $subjectOrg;

	//mention部分を削除
	global $p2;
	$mentions = $p2->components['mentions']->find_mentions($data['post_title']);
	foreach($mentions as $one){
		$subject = str_replace("@".$one , "", $subject);
	}

	//改行があればそこまで
//	list($subject) = split ("\n",$subject);

	//頭の20文字のみ取り出し
	$subject = mb_substr(strip_tags($subject),0,20);
	$subject = mb_substr(esc_html($subject),0,20);
	$subject = mb_substr($subject,0,20,"UTF-8");

	//変更されているなら…を付ける
	if($subjectOrg != $subject){
		$subject.="…";
	}

	//修正版を戻す
	$data['post_title'] = $subject;
	return $data;
}


/**
 * 読み込みJSの後から調整
 */

add_action( 'wp_enqueue_scripts', 'pm_redo_enqueue_scripts', 1000 );

function pm_redo_enqueue_scripts() {

	//iPhone以外でも読み込ませる（RSW対応のため）
	wp_dequeue_script( 'iphone' );
	wp_enqueue_script(
		'smartphone',
		get_template_directory_uri() . '/js/iphone.js',
		array( 'jquery' ),
		'20120402',
		true
	);

/*
	wp_enqueue_script(
		'fastclick',
		get_template_directory_uri() . '/js/fastclick.js',
		array( 'jquery' ),
		'',
		true
	);
*/

	//jquery.cookieの読み込み
	wp_enqueue_script(
		'jquery.cookie.min',
		"//cdn.jsdelivr.net/jquery.cookie/1.4.0/jquery.cookie.min.js",
		array( 'jquery' ),
		'',
		true
	);

	//jquery.jTaggingの読み込み
	if(is_home() or is_front_page()){
		wp_enqueue_script(
			'jquery.jTagging',
			get_stylesheet_directory_uri() . '/jquery.jTagging.js',
			array('jquery'),
			'20121124'
		);
	}

}

function pm_js_setting() {
?>
<script type="text/javascript">  
jQuery( function( $ ) {

	//FastClick.attach(document.body);

	//続きを読むをajaxで読み込み
	$('a.more-link').click(function(event) {
			//aリンクの動作を停止
			event.preventDefault();
			//リンク先URLを取得
			var page = $(this).attr('href');
			$(this).parent().parent()
				.load(page+' div.postcontent p')
				.fadeOut()
				.slideDown(200);
	});

	//<!--more-->挿入ツール
	$('#more-buttons a').click(function(event) {
			//aリンクの動作を停止
			event.preventDefault();
			//タグを追加
			var current = $('#posttext').val();

			if ( current.indexOf("<!--more-->") == -1 ) {
				$('#posttext').val(current + "<!--more-->");
			}

	});

});  
</script>
<?php
}
add_action( 'wp_head', 'pm_js_setting', 1000 );



/**
 * TOPのソーティング表示
 */
function pm_show_order_choice(){
	print <<< EOF
<div id="orderby_and_tagfilter">
<div id="orderby">
<span>表示順：</span><a href="#" id="last_post">投稿日時</a>｜<a href="#" id="last_activity">コメント日時も考慮</a>
</div>
<div id="tagfilter">
<span>除外対象：</span><a href="#" id="tag_all">なし</a>｜<a href="#" id="tag_notin--勤怠-電話">"勤怠,電話"以外</a>｜<a href="#" id="tag_notin--勤怠">"勤怠"以外</a>
</div>
</div>
<script type="text/javascript">
jQuery(function($){

	/*orderby*/
	if($.cookie('wppm_search_order')){
		selected="#"+$.cookie('wppm_search_order');
		$(selected).addClass('selected');
	} else {
		$("#last_post").addClass('selected');
	}

	$("#orderby a").on( "click", function(){
		if( $(this).attr("id") != $.cookie('wppm_search_order') ){
			$.cookie('wppm_search_order', $(this).attr("id"), { expires: 7 });
			location.reload();
		}
	});

	/*tagfilter*/
	if($.cookie('wppm_tagfilter')){
		selected="#"+$.cookie('wppm_tagfilter');
		$(selected).addClass('selected');
	} else {
		$("#tag_all").addClass('selected');
	}

	$("#tagfilter a").on( "click", function(){
		if( $(this).attr("id") != $.cookie('wppm_tagfilter') ){
			$.cookie('wppm_tagfilter', $(this).attr("id"), { expires: 7 });
			//alert($(this).attr("id"));
			location.reload();
		}
	});


}); 
</script>    
EOF;
}


/**
 * 引数やクッキーの内容によってquery追加
 */
function pm_sort_and_tagfiters( $query ) {

  if ( !is_admin() && $query->is_home() && $query->is_main_query() ) {

   //TOPの表示件数
   $query->set( 'posts_per_page', 10 );

   //コメント日時もソート時に考慮するか？      
	 if ( $_COOKIE["wppm_search_order"] == "last_activity"){
	       $query->set( 'orderby_last_activity', 1 );
	 }
      
	 //タグによるfilter：クッキーの値は『tag_notin--勤怠-電話』（filter--tag-tag-...）	
	 if ( $_COOKIE["wppm_tagfilter"] != "tag_all"){

	  	list($filter,$tags) = explode("--",$_COOKIE["wppm_tagfilter"]);

	  	$tags_name = explode("-",$tags);
	  	if( count($tags_name) < 1){
	  		wp_die("フィルターの設定が間違っています。(tagfilter)");
	  	}

	   	 //タグの名前をidに変換
	  	 $tags_id = array();
		   foreach($tags_name as $tag_name){
		    	$term = get_term_by( "name", $tag_name, "post_tag");
			    $tags_id[] = $term->term_id;
		   }

		   if ($filter == "tag_notin"){
			    $query->set( 'tag__not_in', $tags_id );
		   } elseif ($filter == "tag_in"){
			    $query->set( 'tag__in', $tags_id );
		   }
  
	 }

 }
  
}
add_action( 'pre_get_posts', 'pm_sort_and_tagfiters' );


/**
 * 閲覧はログインユーザーのみ
 */
/*
function pm_memberonly() {
	if (!is_user_logged_in()) {
		auth_redirect();
	}
}
add_action( 'wp_head', 'pm_memberonly' );
*/


/**
 * ML対策のfrom ,return-path設定
 */
/*
function pm_set_return_path( $phpmailer ) {
	$phpmailer->Sender = get_option( 'admin_email' );
}
add_action( 'phpmailer_init', 'pm_set_return_path' );
function pm_set_mail_from( $email ) {
    return get_option( 'admin_email' );
}
function pm_set_mail_from_name( $email_from ) {
    return 'PRESSMAN (VOICES)';
}
add_filter( 'wp_mail_from', 'pm_set_mail_from' );
add_filter( 'wp_mail_from_name', 'pm_set_mail_from_name' );
*/


/**
 * RSSフィードのキャッシュのライフタイムの変更 PM HS
 */
add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 60;' ) );


/**
 * RSSフィードのキャッシュ無効化 PM HS
 */
/*
function do_not_cache_feeds(&$feed) {
    $feed->enable_cache(false);
}
add_action( 'wp_feed_options', 'do_not_cache_feeds' );
*/


/**
 * Admin Barの無効化
 */
//add_filter('show_admin_bar', '__return_false');
function pm_function_admin_bar_is_only_for_admin($content) {
  return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'pm_function_admin_bar_is_only_for_admin');


/**
 * text widget内でショートコードを有効化
 */
add_filter('widget_text', 'do_shortcode');


/**
 * shortcode for members latest post (テスト中)
 */
function pm_MembersRecentPost($atts) {
	extract( shortcode_atts(
			array(
				'id' => '000',
				), $atts
		)
	);

	$the_query = new WP_Query( "posts_per_page=1&author=$id" );

	$buf = '<div class="userclm userclm-'.$id.'">'.$id;
	$buf.= '<ul>';

	while ( $the_query->have_posts() ) : $the_query->the_post();
		$buf.= '<li>';

		switch ( p2_get_post_format( $post->ID ) ) {
			case 'status':
				$buf.= get_the_content();
				break;
			case 'link':
			case 'quote':
			case 'post':
			case 'standard':
			default:
				$buf.= "<strong>".get_the_title()."</strong><br />";
				$buf.= get_the_excerpt();
				break;
		}

		$buf.= '</li>';	
	endwhile; 

	$buf.= '</ul></div>';

	// 投稿データをリセット
	wp_reset_postdata();

	return $buf;

}
add_shortcode('pm_MembersRecentPost', 'pm_MembersRecentPost');



/**
 * タブレット判定（途中...）
 */
function pm_is_tablet() {
	$is_ipad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
	if ($is_ipad)
		return true;
	else return false;
}


/**
 * スマホ判定上書き
 */
if(!function_exists("p2_is_iphone")){//上書き定義出来ないので
	function p2_is_iphone() {
		$output = false;

		//アンドロイドにも対応　※wp_is_mobileはipadも含んでしまうので除外 PM HS
		if ( wp_is_mobile() && ! pm_is_tablet() ) 
			$output = true;

//		$output = (bool) apply_filters( 'p2_is_iphone', $output );

		return $output;
	}
}


/**
 * タグを簡単にフォームに挿入するjavascript「jTagging」
 * http://phpjavascriptroom.com/exp3.php?f=include/ajax/jquery_plugin_other/jtagging.inc
 * http://www.skuare.net/test/jTagging.html
 */
function pm_jTagging_setting() {
	if(is_home() or is_front_page()){
?>
<script type="text/javascript">  
jQuery( function( $ ) {

	$("#TagInputHelper a").click(function(){
		var $tagsnow = $("#tags").val();
		if($tagsnow =="<?php esc_attr_e( 'Tag it', 'p2' ); ?>") {$("#tags").val("");}
	});

	var TagInputHelper = new Array($("#TagInputHelper"));  
	var normalClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "#666", backgroundColor : "none", border : "0" };  //非選択時  
	var selectedClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "#666", backgroundColor : "none", border : "0"}; //選択時  
	var normalHoverClass = { padding : "2px 2px 0 2px", textDecoration : "none", color : "red", backgroundColor : "none", border : "0"}; //ホバー時  
	$("#tags").jTagging(TagInputHelper, ",", normalClass, selectedClass, normalHoverClass);

//	$("#tags").jTagging($("#TagInputHelper"), ",");  

});  
</script>
<?php
	}
}
add_action( 'wp_head', 'pm_jTagging_setting', 1000 );

function pm_TagInputHelper() {
	$buf = "";
	$bufML = "";
	$bufSP = "";
	$args = array(
		'orderby' => 'count',
		'order' => 'DESC',
		'hide_empty' => false,
	);
	$tags = get_tags($args);
	foreach($tags as $tag) {

		$ptnML = '/type="ML"/';
		$ptnSP = '/name="([a-zA-Z]+)"/';
		$tag_description = $tag->description;

		//メールタグ
		if ( preg_match( $ptnML , $tag_description , $regex) ) {
			$bufML.= '<a href="#" onclick="return false;" class="tagML">'.$tag->name."</a>\n";
		}
		//特殊タグ
		elseif ( preg_match( $ptnSP , $tag_description , $regex) ) {
			$bufSP.= '<a href="#" onclick="return false;" class="tagSP-'.$regex[1].'">'.$tag->name."</a>\n";
		}
		//その他のタグ
		else {
			$bufOther.= '<a href="#" onclick="return false;" class="tagNORM">'.$tag->name."</a>\n";    
		}
  	}
	if($bufSP != ""){
		$html_bufSP = "		<div class='TagSPgroup'><span>特殊タグ</span>$bufSP</div>n";
	}
	if($bufML != ""){
		$html_bufML = "		<div class='TagMLgroup'><span>メールタグ</span>$bufML</div>";
	}
	if($bufOther != ""){
		$html_bufOther = "		<div class='TagNORMgroup'><span>通常タグ</span>$bufOther</div>";
	}
				
	if($bufSP.$bufML.$bufOther != ""){				
		echo <<<EOF
			<div id='TagInputHelper'>
				$html_bufSP
				$html_bufML
				$html_bufOther
			</div>
EOF;
	}

	return;
}
add_action( 'p2_post_form' , 'pm_TagInputHelper', 1000 );


/*
役割別でタグを抽出--->shortcodeにしました
※タグの説明文に　[pm-tagrole name="admin"]　を追加。
*/
function pm_ExtractTagList($attr) {
	$buf = "";
	$rolename = $attr['rolename'];
	$ptn = "/\[pm-tagrole name=\"".$rolename."\"\]/";
	$args = array(
		'orderby' => 'count',
		'order' => 'DESC',
		'hide_empty' => false,
	);
	$tags = get_tags($args);
	foreach($tags as $tag) {
		$tag_slug = esc_html($tag->slug);
		$tag_name = esc_html($tag->name);
		$tag_link = get_tag_link($tag->term_id);
		$tag_description = $tag->description;
		if (preg_match($ptn, $tag_description)) {
     			$buf.= '<li class="'.$tag_slug.'"><a href="'.$tag_link.'">'.$tag_name." (".$tag->count.")</a></li>";
		}
  	}
	return "<ul class='pm_ExtractTagList pm_ExtractTagList-".$rolename."'>$buf</ul>";
}
add_shortcode('pm_ExtractTagList', 'pm_ExtractTagList');


/*--------------------------
 * 削除リンクを追加
 */
function p2_delete_action_links() {
	global $post;
	global $current_user;
	$id = $post->ID;

	if (current_user_can('edit_post', $post->ID)) {
		echo "| <a href='" . wp_nonce_url(admin_url()."post.php?action=delete&post=$id", 'delete-post_' . $post->ID) . "' title='削除' class='p2_delete_action_links'>削除</a>";
	}
}
add_action( 'p2_action_links', 'p2_delete_action_links', 9 );


/*--------------------------
 * 投稿時にメール (MLタグが付いていたときのみ)
 */
function email_to_ML($post_ID)  {

	$post = get_post($post_ID);
	$author = get_userdata($post->post_author);

	/*
	 *ステータスが公開のときのみ（編集時の再公開も含む）
	 */
	if($post->post_status == 'publish') {

		$to = '';

		//タグの説明にemailが入っていた時にそれをtoに加える
		//ついでにタグリストも取得
		$posttags = get_the_tags($post_ID);
		$pattern = '/([^"]+@[^"]+)/';
		if ($posttags) {
			$taglist = '';
			foreach($posttags as $posttag) {
				$taglist.= $posttag->name . ' '; 
				$str = $posttag->description;
				if ( $tmp = preg_match($pattern,$str,$regex) ) {
					$to.=$regex[0].",";
				}
			}
		}
		
		/*
		 * toが設定されていたら配信
		 */
		if ($to != "" ) {

			//題名の準備
			$subject = strip_tags($post->post_title);

			//改行があればそこまで
			list($subject) = split ("\n",$subject);

			//頭の20文字のみ取り出し
			$subject = mb_substr(strip_tags($subject),0,20);
			$subject = mb_substr(esc_html($subject),0,20);
			$subject = mb_substr($subject,0,20,"UTF-8");
			$subject = "[". get_bloginfo("name")." $post_ID] ". $subject;

			$message = strip_tags($post->post_content);

			$headers[] = 'From: PRESSMAN\'s VOICE <pressman.inc@gmail.com>';
			//TEST PM HS 20140214
			//$headers[] = 'Cc: hiroshi <hiroshi_sekiguchi@pressman.ne.jp>';

			//本文をアレンジ
			$permalink = get_permalink($post_ID);
//			$permalink = home_url("?p={$post_ID}");//日本語タイトルだと長くなるので短く
			$message =<<<EOM

{$author->display_name} さんの投稿
-------------------------------------------
[本文]
$message
-------------------------------------------
[タグ]
$taglist
-------------------------------------------
[この投稿のURL]
$permalink
EOM;
			wp_mail( $to, $subject, $message, $headers );
		}

	}

	return $post_ID;

}
add_action('publish_post', 'email_to_ML');



/**
 * Custom code added to P2 to enable email notifications
 * when a user is @mentioned in the site.
 *
 * Original at http://trepmal.com/2011/06/24/using-wordpress-multisite-p2-and-more/
 * and modified from there.
 */
add_action('publish_post','send_email_notification_once',9);
function send_email_notification_once($postID) {
	$post = get_post($postID);
	$author = get_userdata($post->post_author);
	global $p2;
	$mentions = $p2->components['mentions']->find_mentions($post->post_content);
	$permalink = get_permalink($postID);
	$blog_title = get_bloginfo('name');

	$message = strip_tags($post->post_content);

	$taglist = '';
	$posttags = get_the_tags($postID);
	if ($posttags) {
		foreach($posttags as $tag) {
			$taglist.= $tag->name . ' '; 
		}
	}

	$message =<<<EOM
[本文]
$message
-------------------------------------------
[タグ]
$taglist
-------------------------------------------
[この投稿のURL]
$permalink
EOM;

	$headers[] = 'From: PRESSMAN\'s VOICES <'.get_option('admin_email').'>';
//	$headers[] = 'Cc: '.$author->display_name.' <'.$author->user_email.'>';

	//mentionされている数だけ回す
	foreach ( $mentions as $match ) {
		$email = get_user_by('slug',$match)->user_email;
		wp_mail($email, "[$blog_title] {$author->display_name} さんからのダイレクトメッセージ", $message,$headers);
	}

}

/*
 * コメント欄の@mentionにもメール
 */
add_action('comment_post','send_email_notification_once_comment',9);
function send_email_notification_once_comment($commentID){
	$comment = get_comment($commentID);
	global $p2;
	$mentions = $p2->components['mentions']->find_mentions($comment->comment_content);
	$permalink = get_permalink($comment->comment_post_ID)."#comment-".$commentID;
	$blog_title = get_bloginfo('name');

	$headers[] = 'From: PRESSMAN\'s VOICES <'.get_option('admin_email').'>';

	foreach ( $mentions as $match ) {
		$email = get_user_by('slug',$match)->user_email;
//		$message = "You have been mentioned by {$comment->comment_author} in this comment:\n $permalink \n\n {$comment->comment_content} ";

		$message =<<<EOM
[コメント内容]
{$comment->comment_content}
-------------------------------------------
[コメントのURL]
$permalink
EOM;

//		wp_mail($email, "[$blog_title] You've been mentioned in a comment by {$comment->comment_author}", $message);
		wp_mail($email, "[$blog_title] {$comment->comment_author} さんからのダイレクトメッセージ.", $message,$headers);
	}
}


/*
 * get_commentsテスト
 */
/*
function pm_MemberList(){
	$args = array(
		'status' => 'approve',
		'type' => 'comment',
	);
	$comments = get_comments($args);
	foreach($comments as $comment){
		$CommentCountByUser[$comment->comment_author]++;
	}
	arsort($CommentCountByUser);
	$buf = print_r($CommentCountByUser,ture);

	return "<pre>$buf</pre>";
}
add_shortcode('pm_MemberList', 'pm_MemberList');
*/


/*
 * アドミン専用body classs追加
 */
/*
function pm_add_role_to_body_class($classes) {
	if ( current_user_can('administrator') ) {
		$classes[]= 'role-adm';
	}
	return $classes;
}
add_filter('body_class','pm_add_role_to_body_class');
*/

/*
 * アドミン専用ステータス表示
 */
function pm_wpstatus() {

	//無効に
	return;

	//ネットワーク管理者以外なら無効
	if( !is_super_admin() ){return;}

?>
<p class="pm_wpstatus"><?php global $wpdb; echo $wpdb->num_queries; ?>q / <?php timer_stop(1); ?>sec
 / <?php if($_ENV['HHVM']){echo "HHVM ON"; } else {echo "HHVM off";} ?>
 / <?php if(is_ssl()){echo "SSL ON"; } else {echo "SSL off";} ?></p>
<?php

	return;

}


/*
 *WPアップデート非表示
 */
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
