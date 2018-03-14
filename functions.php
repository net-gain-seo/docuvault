<?php

if ( ! function_exists( 'nguandme_setup' ) ) :

    function nguandme_setup() {
        /**
         * Enable theme support features
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/
         */
        add_theme_support( 'title-tag' );

        add_theme_support( 'custom-header' );

        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'custom-background' );

        // add_theme_support( 'post-formats', array(
        //  'aside', 'image', 'video', 'quote', 'link', 'gallery',
        // ) );

        /**
         * Register navigation menus
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        register_nav_menus( array( 'main-menu' => 'Main Nav', 'footer-menu' => 'Footer Nav' ) );

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

    } // end setup function
endif;
add_action( 'after_setup_theme', 'nguandme_setup' );

/**
 * Enqueue scripts and styles.
 */
function nguandme_scripts() {
    wp_enqueue_script( 'ngacustom', get_bloginfo('template_url') . '/js/custom.js', 'jquery', '1.15', true );
    wp_enqueue_style( 'nguandme_main', get_bloginfo('template_url') . '/main.css', array('bootstrap'), '9.9', false );
    wp_enqueue_style( 'fontawesome', get_bloginfo('template_url') . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'Lato', 'https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,900' );
    wp_enqueue_style( 'OpenSans', 'https://fonts.googleapis.com/css?family=Open+Sans' );
}
add_action( 'wp_enqueue_scripts', 'nguandme_scripts' );

/*
 * Widgets
 */
function ngwidgets_init() {

  register_sidebar( array(
    'name'          => 'Blog Sidebar',
    'id'            => 'blog_sidebar',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
  ) );

}
add_action( 'widgets_init', 'ngwidgets_init' );
/*
* Testimonials
*
*/
// Our custom post type function
// Will use slick js, which is already enqueued by the slider post_type
function create_cpt_testimonials() {

    register_post_type( 'testimonials',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'supports' => array( 'title', 'editor', 'page-attributes' ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'testimonials', 'with_front' => false ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
        )
    );
}
register_taxonomy( 'categories', array('testimonials'), array(
    'hierarchical' => true,
    'label' => 'Categories',
    'singular_label' => 'Category',
    'rewrite' => array( 'slug' => 'categories', 'with_front'=> false )
    )
);
// Hooking up our function to theme setup
add_action( 'init', 'create_cpt_testimonials' );




function create_cpt_carousel() {

    register_post_type( 'carousel',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Carousel' ),
                'singular_name' => __( 'Carousel' )
            ),
            'supports' => array( 'title', 'editor', 'page-attributes' ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'carousel', 'with_front' => false ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_cpt_carousel' );





// Changing excerpt length
function new_excerpt_length($length) {
return 45;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Changing excerpt more
function new_excerpt_more($more) {
return ' (...)';
}
add_filter('excerpt_more', 'new_excerpt_more');



/*
* Utility Function
*
* Mainly used to get the post id of a page outside of the loop in a page template
 */
function get_the_post_id() {
  if (in_the_loop()) {
       $post_id = get_the_ID();
  } else {
       global $wp_query;
       $post_id = $wp_query->get_queried_object_id();
         }
  return $post_id;
}

include(STYLESHEETPATH.'/admin/custom_shortcodes.php');
include(TEMPLATEPATH.'/admin/post_types/white_paper/index.php');
include(TEMPLATEPATH.'/admin/post_types/case_studies/index.php');
include(TEMPLATEPATH.'/admin/post_types/career_jobs/index.php');
include(TEMPLATEPATH.'/admin/post_types/slider/index.php');
