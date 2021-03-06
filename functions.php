<?php
/**
 * estilo functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package estilo
 */

if ( ! function_exists( 'estilo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function estilo_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on estilo, use a find and replace
	 * to change 'estilo' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'estilo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'slide', 1270, 700, true );
	add_image_size( 'square', 800, 800, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'estilo' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
}
endif; // estilo_setup
add_action( 'after_setup_theme', 'estilo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function estilo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'estilo_content_width', 1140 );
}
add_action( 'after_setup_theme', 'estilo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estilo_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'estilo' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Tweets', 'estilo' ),
		'id'            => 'tweets',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );}
add_action( 'widgets_init', 'estilo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function estilo_scripts() {
	wp_enqueue_style( 'font-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'estilo-style', get_stylesheet_uri() );

	// Global JS calls, Inclueds: SKIP, NAV, PACE, SLICK
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', '', '', true );


	// INSOIRATION JS
	if (is_page( 'inspiration' )):
		wp_enqueue_script( 'inspiration', get_template_directory_uri() . '/js/inspiration.js', '', '', true );
	endif; // end check or inmspiration page

	// NEWS JS
	if (is_page( 'news' )):
		wp_enqueue_script( 'news', get_template_directory_uri() . '/js/news.js', '', '', true );
	endif; // end check or news page

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'estilo_scripts' );

/**
 * ADD TYPEKIT TO HEAD
 */
function typekit() {
?>
<script>
  (function(d) {
    var config = {
      kitId: 'nad8eha',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
<?php
}
add_action( 'wp_head', 'typekit', 90 );


function wc_category_title_archive_products(){

  if(is_product_category()) {
	
	$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

	if ( $product_cats && ! is_wp_error ( $product_cats ) ) {

        $single_cat = array_shift( $product_cats ); ?>

        <h2 class="product_category_title"><?php echo $single_cat->name; ?></h2>

	<?php 
	}
  }
}
//add_action( 'woocommerce_before_main_content', 'wc_category_title_archive_products', 5 );


// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

/**
 * Custom options page for this theme.
 */
require get_template_directory() . '/inc/options.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
