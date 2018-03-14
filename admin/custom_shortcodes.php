<?php

/**
 * SHORTCODES
 *
 */

// Remove empty paragraphs from beginning and end of [shortcode][/shortcode]
function noParagraphs($content){
    if ( '</p>' == substr( $content, 0, 4 ) && '<p>' == substr( $content, strlen( $content ) - 3 ) ){
        $content = substr( $content, 4, strlen( $content ) - 7 );
    }
    return $content;
}

function stripAllParagraphs($content) {
    return str_ireplace( array('<p>', '</p>'), '', $content );
}


function testimonials_wp_enqueue_scripts(){
    wp_register_style( 'slick-style', get_template_directory_uri().'/admin/post_types/slider/css/slick.css');
    wp_register_script( 'slick-script', get_template_directory_uri().'/admin/post_types/slider/js/slick.min.js',array('jquery'));
    wp_register_script( 'slick-slider', get_template_directory_uri().'/admin/post_types/slider/js/slick-slider.js',array('slick-script'));
}
add_action( 'wp_enqueue_scripts', 'testimonials_wp_enqueue_scripts' );

function testimonial_slider($atts) {
    wp_enqueue_style( 'slick-style');
    wp_enqueue_script( 'slick-script');
    wp_enqueue_script( 'slick-slider');

      global $post;

      extract( shortcode_atts( array(
          'class' => '',
          'posts_per_page' => $posts_per_page,
          'title' => '',
          'category' => ''
      ), $atts ));

      if($category == '') {
          $args = array(
            'post_type'   => array( 'testimonials' ),
            'posts_per_page' => $posts_per_page,
            'orderby' => 'publish_date',
            'order' => 'ASC'
          );
      }
      else {
          $args = array(
              'post_type'   => array( 'testimonials' ),
              'posts_per_page' => $posts_per_page,
              'orderby' => 'publish_date',
              'order' => 'ASC',
              'tax_query' => array(
                  array(
                      'taxonomy' => 'categories',
                      'field' => 'name',
                      'terms' => array($category)
                  )
              )
          );
      }


    // The Query
    $query = new WP_Query( $args );

    $to = '';
    $to .= '<h2 class="testimonialtitle">What Our Customers Say...</h2>';
    $to .= '<div class="testimonials-wrap">';

    if($query->have_posts()) {
        while($query->have_posts()):$query->the_post();
            $to .= '<div class="testimonial-slide">';
            $to .= '<img src="'.get_template_directory_uri().'/img/orangequotes.png" alt="Quote" width="96" height="76">';
            $to .= '<div class="testimonial-content">';
                $to .= wpautop(get_the_content());
              $to .= '</div>';
            $to .= '</div>';
        endwhile;
    }

    $to .= '</div>';
    return $to;
}
add_shortcode('testimonials','testimonial_slider');



function carousel_slider($atts) {
    wp_enqueue_style( 'slick-style');
    wp_enqueue_script( 'slick-script');
    wp_enqueue_script( 'slick-slider');

    extract( shortcode_atts( array(
        'class' => ''
      ), $atts ) );
    // WP_Query arguments
    $args = array(
        'post_type'   => array( 'carousel' ),
        'posts_per_page' => -1,
        'orderby' => 'publish_date',
        'order' => 'ASC'
    );
    // The Query
    $query = new WP_Query( $args );

    $to = '';
    $to .= '<div class="carousel-wrap">';

    if($query->have_posts()) {
        while($query->have_posts()):$query->the_post();
            $to .= '<div class="carousel-slide">';
            $to .= '<div class="carousel-content">';
                $to .= wpautop(get_the_content());
                $to .= '<p class="carousel-title">'.get_the_title().'</p>';
              $to .= '</div>';
            $to .= '</div>';
        endwhile;
    }

    $to .= '</div>';
    return $to;
}
add_shortcode('carousel','carousel_slider');







function nga_accordion($atts,$content) {
    extract( shortcode_atts( array(
        'title' => '',
        'toggleicons' => '' //2 Font awesome classes, comma delimited, omitting the fa- (e.g: plus,minus) closedclass,openclass
    ), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    $content = noParagraphs( $content );
    $ao = '';
    $ao .= '<div class="accordion-item">';
    $icons = '';
    if( isset($toggleicons) && $toggleicons != '' ) {
        $toggleicons = explode(',',$toggleicons);
        $icons = '<i class="fa fa-'.$toggleicons[0].'" data-open="'.$toggleicons[1].'" data-closed="'.$toggleicons[0].'"></i> ';
    }
        $ao .= '<h3 class="accordion-title">'.$icons.$title.'</h3>';
        $ao .= '<div class="accordion-content">';
            $ao .= $content;
        $ao .= '</div>';
    $ao .= '</div>';
    return $ao;
}
add_shortcode('accordion_item','nga_accordion');




function nga_latestpost($atts,$content) {
  extract( shortcode_atts( array(
      'content' => '',
      'title' => 'Did You Know?',
      'image' => '',
      'class' => ''
    ), $atts ) );
  $args = array(

      'posts_per_page' => 1
  );
  // The Query
  $query = new WP_Query( $args );

    $lp = '';

    $lp .= '<div class="container-fluid splitpage"><div class="container">';
    $lp .= '<div class="row padding0">';
    $lp .= '<div class="col col-lg-6 col-sm-12 col-xsm-12 greyhalf">';
    $lp .= '<h2 class="whiteText">Latest Post</h2>';
    if($query->have_posts()) {
        while($query->have_posts()):$query->the_post();
        $lp .= '<article class="latestposts">';
        $lp .= '<h5 class="posttitle"><a title="'.get_the_title().'"  class="whiteText" href="'.get_permalink().'">'.get_the_title().'</a></h5>';
        $lp .= '<p class="whiteText">'.get_the_excerpt().'</p>';
        $lp .= '<a title="'.get_the_title().'" href="'.get_permalink().'" class="buttonlight">Read more</a>';
        $lp .= '</article>';
        endwhile;
    }
    $lp .= '</div>';
    $lp .= '<div class="col col-lg-6 col-sm-12 col-xsm-12 redhalf whiteText">';
    $lp .= '<div class="mobileredbackground"></div>';
    $lp .= '<div class="mobilecontainer">';
    $lp .= '<h2 class="whiteText">'.$title.'</h2>';
    if( isset($image) && $image != '' ) {
      $lp .= '<img src="'.$image.'" class="didyouknowimg"/>';
    }
    $lp .= '<p class="whiteText">'.$content.'</p>';
    $lp .= '<a href="https://docuvaultdv.com/services/electronic-data-destruction/" class="button">Learn more about electronic data destruction </a>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '</div></div>';
    return $lp;
}
add_shortcode('latest_post','nga_latestpost');





function nga_careerjobs($atts,$content) {
  extract( shortcode_atts( array(
      'class' => ''
    ), $atts ) );
  $args = array(
      'post_type'   => array( 'career_jobs' ),
      'posts_per_page' => -1
  );
  // The Query
  $query = new WP_Query( $args );

    $cj = '';
    if($query->have_posts()) {
      $cj .= '<div class="container-fluid careerjobs" style="background-color: #F2F2F2;"><div class="container">';
      $cj .= '<div class="row padding50">';
      $cj .= '<div class="col col-lg-12 col-sm-12 col-xsm-12">';
        $cj .= '<h3>Current job opportunities</h3>';
        while($query->have_posts()):$query->the_post();
        $cj .= '<article class="careerjobs">';
        $cj .= '<h5 class="blackText"> <a title="'.get_the_title().'" class="blackText" href="'.get_permalink().'">'.get_the_title().'</a></h5>';
        $cj .= '<p>'.get_the_excerpt().'</p>';
        $cj .= '<a title="'.get_the_title().'" href="'.get_permalink().'" class="orangeText" target="_blank">Read full description >></a>';
        $cj .= '</article>';
        endwhile;
        $cj .= '</div>';
        $cj .= '</div>';
        $cj .= '</div></div>';
    }else{
      $cj .= '<div class="container-fluid careerjobs" style="background-color: #F2F2F2;"><div class="container">';
      $cj .= '<div class="row padding50">';
      $cj .= '<div class="col col-lg-12 col-sm-12 col-xsm-12">';
        $cj .= '<h3>Current job opportunities</h3>';
      $cj .= '<p>There are no job openings at this time. We’ll post new positions as they become available and please feel free to send us your resume for future reference. </p>';
      $cj .= '</div>';
      $cj .= '</div>';
      $cj .= '</div></div>';
    }

    return $cj;
}
add_shortcode('career_jobs','nga_careerjobs');