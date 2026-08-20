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


/**
 * Custom Social Links Widget
 */
class Yoko_SocialLinks_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct( 'Yoko_SocialLinks_Widget', esc_html__( 'Yoko Social Links', 'yoko' ), array(
			'classname'   => 'widget_social_links',
			'description' => esc_html__( 'Link to your social profiles like twitter, facebook or flickr.', 'yoko' ),
		) );
	}

	function widget($args, $instance) {
		$before_widget = $args['before_widget'];
		$after_widget  = $args['after_widget'];
		$before_title  = $args['before_title'];
		$after_title   = $args['after_title'];
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		$twitter_title = empty($instance['twitter_title']) ? ' ' : apply_filters('widget_twitter_title', $instance['twitter_title']);
		$twitter_url = empty($instance['twitter_url']) ? ' ' : apply_filters('widget_twitter_url', $instance['twitter_url']);
		$fb_title = empty($instance['fb_title']) ? ' ' : apply_filters('widget_fb_title', $instance['fb_title']);
		$fb_url = empty($instance['fb_url']) ? ' ' : apply_filters('widget_fb_url', $instance['fb_url']);
		$pinterest_title = empty($instance['pinterest_title']) ? ' ' : apply_filters('widget_pinterest_title', $instance['pinterest_title']);
		$pinterest_url = empty($instance['pinterest_url']) ? ' ' : apply_filters('widget_pinterest_url', $instance['pinterest_url']);
		$vimeo_title = empty($instance['vimeo_title']) ? ' ' : apply_filters('widget_vimeo_title', $instance['vimeo_title']);
		$vimeo_url = empty($instance['vimeo_url']) ? ' ' : apply_filters('widget_vimeo_url', $instance['vimeo_url']);
		$youtube_title = empty($instance['youtube_title']) ? ' ' : apply_filters('widget_youtube_title', $instance['youtube_title']);
		$youtube_url = empty($instance['youtube_url']) ? ' ' : apply_filters('widget_youtube_url', $instance['youtube_url']);
		$instagram_title = empty($instance['instagram_title']) ? ' ' : apply_filters('widget_instagram_title', $instance['instagram_title']);
		$instagram_url = empty($instance['instagram_url']) ? ' ' : apply_filters('widget_instagram_url', $instance['instagram_url']);
		$flickr_title = empty($instance['flickr_title']) ? ' ' : apply_filters('widget_flickr_title', $instance['flickr_title']);
		$flickr_url = empty($instance['flickr_url']) ? ' ' : apply_filters('widget_flickr_url', $instance['flickr_url']);
		$dribbble_title = empty($instance['dribbble_title']) ? ' ' : apply_filters('widget_dribbble_title', $instance['dribbble_title']);
		$dribbble_url = empty($instance['dribbble_url']) ? ' ' : apply_filters('widget_dribbble_url', $instance['dribbble_url']);
		$github_title = empty($instance['github_title']) ? ' ' : apply_filters('widget_github_title', $instance['github_title']);
		$github_url = empty($instance['github_url']) ? ' ' : apply_filters('widget_github_url', $instance['github_url']);
		$linkedin_title = empty($instance['linkedin_title']) ? ' ' : apply_filters('widget_linkedin_title', $instance['linkedin_title']);
		$linkedin_url = empty($instance['linkedin_url']) ? ' ' : apply_filters('widget_linkedin_url', $instance['linkedin_url']);

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '<ul>';
		if($twitter_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $twitter_url .'" class="twitter" target="_blank">'. $twitter_title .'</a></li>'; }
		if($fb_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $fb_url .'" class="facebook" target="_blank">'. $fb_title .'</a></li>'; }
		if($pinterest_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $pinterest_url .'" class="pinterest" target="_blank">'. $pinterest_title .'</a></li>'; }
		if($vimeo_title == ' ') { echo ''; } else {  echo  '  <li class="widget_sociallinks"><a href="'. $vimeo_url .'" class="vimeo" target="_blank">'. $vimeo_title .'</a></li>'; }
		if($youtube_title == ' ') { echo ''; } else {  echo  '  <li class="widget_sociallinks"><a href="'. $youtube_url .'" class="youtube" target="_blank">'. $youtube_title .'</a></li>'; }
		if($instagram_title == ' ') { echo ''; } else {  echo  '  <li class="widget_sociallinks"><a href="'. $instagram_url .'" class="instagram" target="_blank">'. $instagram_title .'</a></li>'; }
		if($flickr_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $flickr_url .'" class="flickr" target="_blank">'. $flickr_title .'</a></li>'; }
		if($dribbble_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $dribbble_url .'" class="dribbble" target="_blank">'. $dribbble_title .'</a></li>'; }
		if($github_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $github_url .'" class="github" target="_blank">'. $github_title .'</a></li>'; }
		if($linkedin_title == ' ') { echo ''; } else {  echo  '<li class="widget_sociallinks"><a href="'. $linkedin_url .'" class="linkedin" target="_blank">'. $linkedin_title .'</a></li>'; }
		echo '</ul>';
		echo $after_widget;

	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_title'] = strip_tags($new_instance['twitter_title']);
		$instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
		$instance['fb_title'] = strip_tags($new_instance['fb_title']);
		$instance['fb_url'] = strip_tags($new_instance['fb_url']);
		$instance['pinterest_title'] = strip_tags($new_instance['pinterest_title']);
		$instance['pinterest_url'] = strip_tags($new_instance['pinterest_url']);
		$instance['vimeo_title'] = strip_tags($new_instance['vimeo_title']);
		$instance['vimeo_url'] = strip_tags($new_instance['vimeo_url']);
		$instance['youtube_title'] = strip_tags($new_instance['youtube_title']);
		$instance['youtube_url'] = strip_tags($new_instance['youtube_url']);
		$instance['instagram_title'] = strip_tags($new_instance['instagram_title']);
		$instance['instagram_url'] = strip_tags($new_instance['instagram_url']);
		$instance['flickr_title'] = strip_tags($new_instance['flickr_title']);
		$instance['flickr_url'] = strip_tags($new_instance['flickr_url']);
		$instance['dribbble_title'] = strip_tags($new_instance['dribbble_title']);
		$instance['dribbble_url'] = strip_tags($new_instance['dribbble_url']);
		$instance['github_title'] = strip_tags($new_instance['github_title']);
		$instance['github_url'] = strip_tags($new_instance['github_url']);
		$instance['linkedin_title'] = strip_tags($new_instance['linkedin_title']);
		$instance['linkedin_url'] = strip_tags($new_instance['linkedin_url']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args(
		(array) $instance, array(
			'title' => '',
			'twitter_title' => '',
			'twitter_url' => '',
			'fb_title' => '',
			'fb_url' => '',
			'pinterest_title' => '',
			'pinterest_url' => '',
			'vimeo_title' => '',
			'vimeo_url' => '',
			'youtube_title' => '',
			'youtube_url' => '',
			'instagram_title' => '',
			'instagram_url' => '',
			'flickr_title' => '',
			'flickr_url' => '',
			'dribbble_title' => '',
			'dribbble_url' => '',
			'github_title' => '',
			'github_url' => '',
			'linkedin_title' => '',
			'linkedin_url' => '',
		) );
		$title = strip_tags($instance['title']);
		$twitter_title = strip_tags($instance['twitter_title']);
		$twitter_url = strip_tags($instance['twitter_url']);
		$fb_title = strip_tags($instance['fb_title']);
		$fb_url = strip_tags($instance['fb_url']);
		$pinterest_title = strip_tags($instance['pinterest_title']);
		$pinterest_url = strip_tags($instance['pinterest_url']);
		$vimeo_title = strip_tags($instance['vimeo_title']);
		$vimeo_url = strip_tags($instance['vimeo_url']);
		$youtube_title = strip_tags($instance['youtube_title']);
		$youtube_url = strip_tags($instance['youtube_url']);
		$instagram_title = strip_tags($instance['instagram_title']);
		$instagram_url = strip_tags($instance['instagram_url']);
		$flickr_title = strip_tags($instance['flickr_title']);
		$flickr_url = strip_tags($instance['flickr_url']);
		$dribbble_title = strip_tags($instance['dribbble_title']);
		$dribbble_url = strip_tags($instance['dribbble_url']);
		$github_title = strip_tags($instance['github_title']);
		$github_url = strip_tags($instance['github_url']);
		$linkedin_title = strip_tags($instance['linkedin_title']);
		$linkedin_url = strip_tags($instance['linkedin_url']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('twitter_title'); ?>"><?php _e( 'Twitter Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter_title'); ?>" name="<?php echo $this->get_field_name('twitter_title'); ?>" type="text" value="<?php echo esc_attr($twitter_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('twitter_url'); ?>"><?php _e( 'Twitter  URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter_url'); ?>" name="<?php echo $this->get_field_name('twitter_url'); ?>" type="text" value="<?php echo esc_attr($twitter_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('fb_title'); ?>"><?php _e( 'Facebook Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('fb_title'); ?>" name="<?php echo $this->get_field_name('fb_title'); ?>" type="text" value="<?php echo esc_attr($fb_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('fb_url'); ?>"><?php _e( 'Facebook URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('fb_url'); ?>" name="<?php echo $this->get_field_name('fb_url'); ?>" type="text" value="<?php echo esc_attr($fb_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('pinterest_title'); ?>"><?php _e( 'Pinterest Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('pinterest_title'); ?>" name="<?php echo $this->get_field_name('pinterest_title'); ?>" type="text" value="<?php echo esc_attr($pinterest_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('pinterest_url'); ?>"><?php _e( 'Pinterest URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('pinterest_url'); ?>" name="<?php echo $this->get_field_name('pinterest_url'); ?>" type="text" value="<?php echo esc_attr($pinterest_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('vimeo_title'); ?>"><?php _e( 'Vimeo Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_title'); ?>" name="<?php echo $this->get_field_name('vimeo_title'); ?>" type="text" value="<?php echo esc_attr($vimeo_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('vimeo_url'); ?>"><?php _e( 'Vimeo URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('vimeo_url'); ?>" name="<?php echo $this->get_field_name('vimeo_url'); ?>" type="text" value="<?php echo esc_attr($vimeo_url); ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('youtube_title'); ?>"><?php _e( 'YouTube Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('youtube_title'); ?>" name="<?php echo $this->get_field_name('youtube_title'); ?>" type="text" value="<?php echo esc_attr($youtube_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('youtube_url'); ?>"><?php _e( 'YouTube URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('youtube_url'); ?>" name="<?php echo $this->get_field_name('youtube_url'); ?>" type="text" value="<?php echo esc_attr($youtube_url); ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id('instagram_title'); ?>"><?php _e( 'Instagram Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('instagram_title'); ?>" name="<?php echo $this->get_field_name('instagram_title'); ?>" type="text" value="<?php echo esc_attr($instagram_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('instagram_url'); ?>"><?php _e( 'Instagram URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('instagram_url'); ?>" name="<?php echo $this->get_field_name('instagram_url'); ?>" type="text" value="<?php echo esc_attr($youtube_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('flickr_title'); ?>"><?php _e( 'Flickr Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('flickr_title'); ?>" name="<?php echo $this->get_field_name('flickr_title'); ?>" type="text" value="<?php echo esc_attr($flickr_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('flickr_url'); ?>"><?php _e( 'Flickr URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('flickr_url'); ?>" name="<?php echo $this->get_field_name('flickr_url'); ?>" type="text" value="<?php echo esc_attr($flickr_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('dribbble_title'); ?>"><?php _e( 'Dribbble Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('dribbble_title'); ?>" name="<?php echo $this->get_field_name('dribbble_title'); ?>" type="text" value="<?php echo esc_attr($dribbble_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('dribbble_url'); ?>"><?php _e( 'Dribbble URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('dribbble_url'); ?>" name="<?php echo $this->get_field_name('dribbble_url'); ?>" type="text" value="<?php echo esc_attr($dribbble_url); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('github_title'); ?>"><?php _e( 'GitHub Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('github_title'); ?>" name="<?php echo $this->get_field_name('github_title'); ?>" type="text" value="<?php echo esc_attr($github_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('github_url'); ?>"><?php _e( 'GitHub URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('github_url'); ?>" name="<?php echo $this->get_field_name('github_url'); ?>" type="text" value="<?php echo esc_attr($github_url); ?>" /></label></p>


			<p><label for="<?php echo $this->get_field_id('linkedin_title'); ?>"><?php _e( 'LinkedIn Text:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('linkedin_title'); ?>" name="<?php echo $this->get_field_name('linkedin_title'); ?>" type="text" value="<?php echo esc_attr($linkedin_title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('linkedin_url'); ?>"><?php _e( 'LinkedIn URL:', 'yoko' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('linkedin_url'); ?>" name="<?php echo $this->get_field_name('linkedin_url'); ?>" type="text" value="<?php echo esc_attr($linkedin_url); ?>" /></label></p>



<?php
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Yoko_SocialLinks_Widget' );
} );
