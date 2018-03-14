<?php
add_action( 'init', 'create_custom_case_studies_post_types' );

//CUSTOM POST TYPE
function create_custom_case_studies_post_types() {
    register_post_type( 'case_studies',
        array(
            'labels' => array(
                'name' => 'Case Studies',
                'singular_name' => 'Case Studies',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Case Studies Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit Case Studies Slide',
                'new_item' => 'New Case Studies Slide',
                'view' => 'View',
                'view_item' => 'View Case Studies Slide',
                'search_items' => 'Search Case Studies Slide',
                'not_found' => 'No Case Studies Slide found',
                'not_found_in_trash' => 'No Case Studies Slide found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'case_studies', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'case_studies_icons' );
function case_studies_icons() { ?>
    <style type="text/css" media="screen">
        /****case_studies****/
        #menu-posts-case_studies .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/case_studies/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-case_studies:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-case_studies.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//case_studies META BOX
function my_case_studies_admin() {
    add_meta_box( 'case_studies_meta_box',
        'Author Info',
        'display_case_studies_meta_box',
        'case_studies', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'my_case_studies_admin' );

function display_case_studies_meta_box( $test ) {
    global $post;
    $custom = get_post_custom($post->ID);

    $authtext = esc_html( get_post_meta( $test->ID, 'case_studies_text', true ) );
    $complink = esc_html( get_post_meta( $test->ID, 'case_studies_link', true ) );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%">Download Case Study Text</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="case_studies_text" value="<?php echo $authtext; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Download Case Study Link</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="case_studies_link" value="<?php echo $complink; ?>" /></td>
        </tr>
        <tr><td style="width: 100%">&nbsp;</td></tr>
        <input type="hidden" name="case_studies_flag" value="true" />
    </table>
<?php
}

function custom_fields_case_studies_update($post_id, $post ){
    if ( $post->post_type == 'case_studies' ) {
        if (isset($_POST['case_studies_flag'])) {
            update_post_meta($post_id, "num_stars", $_POST['num_stars']);

            if ( isset( $_POST['case_studies_text'] ) && $_POST['case_studies_text'] != '' ) {
                update_post_meta( $post_id, 'case_studies_text', $_POST['case_studies_text'] );
            }else{
                update_post_meta( $post_id, 'case_studies_text', '');
            }

            if ( isset( $_POST['case_studies_link'] ) && $_POST['case_studies_link'] != '' ) {
                update_post_meta( $post_id, 'case_studies_link', $_POST['case_studies_link'] );
            }else{
                update_post_meta( $post_id, 'case_studies_link', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_case_studies_update', 10, 2 );


function case_studies_func($atts) {
    extract( shortcode_atts( array(
        'offset' => 0,
        'carousel' => 'no',
        'id' => '',
        'ids' => '',
        'class' => '',
        'posts_per_page' => -1,
        'title' => '',
        'direction' => 'left'
    ), $atts ));

    global $post;

    $case_studies = '';

    $case_studies .= '<div '.(($id != '')? 'id="'.$id.'"':'').' class="testouter '.(($class != '')? $class:"").'">';
        if($title != ''){
            $case_studies .= '<h2>'.$title.'</h2>';
        }

        $case_studies .= '<div>';
            $case_studies .= '<div id="case_studies-'.$offset.'" class="case_studies '.(($carousel == 'yes')?"case_studies-carousel":"").'" data-offset="'.$offset.'" data-howmany="1" data-timeout="400" data-direction="'.$direction.'">';
                $case_studies .= '<div class="carousel-list">';
                    wp_reset_query();
                    if($ids == ''){
                        $args = array(
                            'post_type' => 'case_studies',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }else{
                        $idarray = explode(',', $ids);

                        $args = array(
                            'post_type' => 'case_studies',
                            'posts_per_page' => $posts_per_page,
                            'post__in' => $idarray,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }

                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $authtext = get_post_meta($post->ID, 'case_studies_text', true);
                        $complink = get_post_meta($post->ID, 'case_studies_link', true);
                        $stars = get_post_meta($post->ID, 'num_stars', true);

                        $case_studies .= '<div class="row">';

                            $case_studies .= '<div class="CaseContent">';
                            $case_studies .= '<h3>'.get_the_title().'</h3>';
                                //$case_studies .= '<h3>'.get_the_title().'</h3>';

                                $case_studies .= apply_filters('the_content', get_the_excerpt());
                                $case_studies .= '<a href="'.$complink.'" class="readmoretest orangeText" target="_blank">'.$authtext.'</a>';
                                //$case_studies .= '<a href="'.get_permalink().'" class="readmoretest orangeText">'.$authtext.'</a>';

                            $case_studies .= '</div>';
                        $case_studies .= '</div>';
                    endwhile;
                    wp_reset_query();
                $case_studies .= '</div>';
            $case_studies .= '</div>';

            if($carousel == 'yes'){
                $case_studies .= '<div id="case_studies-pr-nx-'.$offset.'" class="case_studies-pr-nx">';
                    $case_studies .= '<div id="case_studies-prev-'.$offset.'" class="case_studies-prev"><div>Prev</div></div>';
                    $case_studies .= '<div id="case_studies-next-'.$offset.'" class="case_studies-next"><div>Next</div></div>';
                $case_studies .= '</div>';
            }

        $case_studies .= '</div>';

        if($carousel == 'yes'){
            wp_enqueue_script( 'modular-wp-student-success', get_template_directory_uri() . '/admin/post_types/case_studies/testimonials.js', array('jquery'), '1.0.0', true );

        }
    $case_studies .= '</div>';

    return $case_studies;
}

add_shortcode( 'case_studies', 'case_studies_func' );;






//SHORTCODE case_studies BUTTON
function case_studies_shortcode_btn() {
    //Abort early if the user will never see TinyMCE
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    //Add a callback to regiser our tinymce plugin
    add_filter("mce_external_plugins", "register_case_studies_tinymce");

    // Add a callback to add our button to the TinyMCE toolbar
    add_filter('mce_buttons', 'add_case_studies_tinymce_btn');
}

add_action('init', 'case_studies_shortcode_btn');


//This callback registers our plug-in
function register_case_studies_tinymce($plugin_array) {
    $plugin_array['case_studies_button'] = get_bloginfo('template_directory').'/admin/post_types/case_studies/tinymce.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function add_case_studies_tinymce_btn($buttons) {
    //Add the button ID to the $button array
    $buttons[] = "case_studies_button";
    return $buttons;
}

?>
