<?php
/**
 * Yoko functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Yoko
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'yoko', get_template_directory() . '/languages' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 620;

/**
 * Tell WordPress to run yoko() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'yoko' );

if ( ! function_exists( 'yoko' ) ):

/**
* Returns the Google font stylesheet URL if available.
 */

function yoko_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by PT Sans or Raleway translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$droid_sans = _x( 'on', 'Droid Sans font: on or off', 'yoko' );

	$droid_serif = _x( 'on', 'Droid Serif font: on or off', 'yoko' );

	if ( 'off' !== $droid_sans || 'off' !== $droid_serif ) {
		$font_families = array();

		if ( 'off' !== $droid_sans )
			$font_families[] = 'Droid Sans:400,700';

		if ( 'off' !== $droid_serif )
			$font_families[] = 'Droid Serif:400,700,400italic,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}


/**
 * Enqueue scripts and styles.
 */
function yoko_scripts() {
	global $wp_styles;

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

	// Loads JavaScript for Smooth Scroll
	wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), '1.4', true );

	// Add Google Webfonts
	wp_enqueue_style( 'yoko-fonts', yoko_fonts_url(), array(), null );

	// Loads main stylesheet.
	wp_enqueue_style( 'yoko-style', get_stylesheet_uri(), array(), '2013-10-21' );

}
add_action( 'wp_enqueue_scripts', 'yoko_scripts' );


/**
 * Sets up theme defaults and registers support for WordPress features.
 */
function yoko() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	//  Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'yoko' ),
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'video', 'image', 'quote' ) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'yoko_custom_background_args', array(
		'default-color'	=> 'ececec',
		'default-image'	=> '',
	) ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See yoko_admin_header_style(), below.
	$args = array(
		'default-image'	 => get_template_directory_uri() . '/images/headers/ginko.jpg',
		'width'          => 1102,
		'height'         => 350,
		'flex-height'    => true,
		'flex-width'     => true,
		'header-text'    => false,
		'uploads'        => true,
		'video'          => false,
	);
	add_theme_support( 'custom-header', $args );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
			'ginko' => array(
			'url' => '%s/images/headers/ginko.jpg',
			'thumbnail_url' => '%s/images/headers/ginko-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Ginko', 'yoko' )
			),
			'flowers' => array(
			'url' => '%s/images/headers/flowers.jpg',
			'thumbnail_url' => '%s/images/headers/flowers-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Flowers', 'yoko' )
			),
			'plant' => array(
			'url' => '%s/images/headers/plant.jpg',
			'thumbnail_url' => '%s/images/headers/plant-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Plant', 'yoko' )
			),
			'sailing' => array(
			'url' => '%s/images/headers/sailing.jpg',
			'thumbnail_url' => '%s/images/headers/sailing-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sailing', 'yoko' )
			),
			'cape' => array(
			'url' => '%s/images/headers/cape.jpg',
			'thumbnail_url' => '%s/images/headers/cape-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cape', 'yoko' )
			),
			'seagull' => array(
			'url' => '%s/images/headers/seagull.jpg',
			'thumbnail_url' => '%s/images/headers/seagull-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Seagull', 'yoko' )
			)
	) );
}
endif;

if ( ! function_exists( 'yoko_admin_header_style' ) ) :

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 * Referenced via add_custom_image_header() in yoko_setup().
 */
function yoko_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#heading {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}

</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function yoko_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'yoko_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 */
function yoko_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'yoko_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function yoko_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'yoko' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and yoko_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function yoko_auto_excerpt_more( $more ) {
	return ' &hellip;' . yoko_continue_reading_link();
}
add_filter( 'excerpt_more', 'yoko_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function yoko_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= yoko_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'yoko_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 */
function yoko_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'yoko_remove_gallery_css' );

if ( ! function_exists( 'yoko_comment' ) ) :

/**
 * Template for comments and pingbacks.
 */
function yoko_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-gravatar"><?php echo get_avatar( $comment, 65 ); ?></div>

		<div class="comment-body">
		<div class="comment-meta commentmetadata">
		<?php printf( __( '%s', 'yoko' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?><br/>
		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'yoko' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( 'Edit &rarr;', 'yoko' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<?php comment_text(); ?>

		<?php if ( $comment->comment_approved == '0' ) : ?>
		<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'yoko' ); ?></p>
		<?php endif; ?>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->

		</div>
		<!--comment Body-->

	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'yoko' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'yoko'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized area and update sidebar with default widgets
 */
function yoko_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar 1', 'yoko' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array (
		'name' => __( 'Sidebar 2', 'yoko' ),
		'id' => 'sidebar-2',
		'description' => __( 'An second sidebar area', 'yoko' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'init', 'yoko_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function yoko_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'yoko_remove_recent_comments_style' );

/**
 * Search form custom styling
 */
function yoko_search_form( $form ) {

		$form = '<form role="search" method="get" class="searchform" action="'.home_url('/').'" >
		<div>
		<input type="text" class="search-input" value="' . get_search_query() . '" name="s" id="s" />
		<input type="submit" class="searchsubmit" value="'. esc_attr__('Search', 'yoko') .'" />
		</div>
		</form>';

		return $form;
}
add_filter( 'get_search_form', 'yoko_search_form' );

/**
 * Remove the default CSS style from the WP image gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * Add Theme Customizer CSS
 */
function yoko_customize_css() {
		?>
	<style type="text/css" id="yoko-themeoptions-css">
		a {color: <?php echo get_theme_mod( 'link_color', '#009BC2' ); ?>;}
		#content .single-entry-header h1.entry-title {color: <?php echo get_theme_mod( 'link_color', '#009BC2' ); ?>!important;}
		input#submit:hover {background-color: <?php echo get_theme_mod( 'link_color', '#009BC2' ); ?>!important;}
		#content .page-entry-header h1.entry-title {color: <?php echo get_theme_mod( 'link_color', '#009BC2' ); ?>!important;}
		.searchsubmit:hover {background-color: <?php echo get_theme_mod( 'link_color', '#009BC2' ); ?>!important;}
	</style>
		<?php
}
add_action( 'wp_head', 'yoko_customize_css');

/**
 * Customizer additions
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme Options page
 */
require get_template_directory() . '/inc/theme-options.php';
