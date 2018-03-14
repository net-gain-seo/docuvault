<?php
add_action( 'init', 'create_custom_career_jobs_post_types' );

//CUSTOM POST TYPE
function create_custom_career_jobs_post_types() {
    register_post_type( 'career_jobs',
        array(
            'labels' => array(
                'name' => 'Career Jobs',
                'singular_name' => 'Career Jobs',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Career Jobs Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit Career Jobs Slide',
                'new_item' => 'New Career Jobs Slide',
                'view' => 'View',
                'view_item' => 'View Career Jobs Slide',
                'search_items' => 'Search Career Jobs Slide',
                'not_found' => 'No Career Jobs Slide found',
                'not_found_in_trash' => 'No Career Jobs Slide found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'career_jobs', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'career_jobs_icons' );
function career_jobs_icons() { ?>
    <style type="text/css" media="screen">
        /****career_jobs****/
        #menu-posts-career_jobs .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/career_jobs/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-career_jobs:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-career_jobs.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//career_jobs META BOX
function my_career_jobs_admin() {
    add_meta_box( 'career_jobs_meta_box',
        'Author Info',
        'display_career_jobs_meta_box',
        'career_jobs', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'my_career_jobs_admin' );

function display_career_jobs_meta_box( $test ) {
    global $post;
    $custom = get_post_custom($post->ID);

    $authtext = esc_html( get_post_meta( $test->ID, 'career_jobs_text', true ) );
    $complink = esc_html( get_post_meta( $test->ID, 'career_jobs_link', true ) );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%">Download Case Study Text</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="career_jobs_text" value="<?php echo $authtext; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Download Case Study Link</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="career_jobs_link" value="<?php echo $complink; ?>" /></td>
        </tr>
        <tr><td style="width: 100%">&nbsp;</td></tr>
        <input type="hidden" name="career_jobs_flag" value="true" />
    </table>
<?php
}

function custom_fields_career_jobs_update($post_id, $post ){
    if ( $post->post_type == 'career_jobs' ) {
        if (isset($_POST['career_jobs_flag'])) {
            update_post_meta($post_id, "num_stars", $_POST['num_stars']);

            if ( isset( $_POST['career_jobs_text'] ) && $_POST['career_jobs_text'] != '' ) {
                update_post_meta( $post_id, 'career_jobs_text', $_POST['career_jobs_text'] );
            }else{
                update_post_meta( $post_id, 'career_jobs_text', '');
            }

            if ( isset( $_POST['career_jobs_link'] ) && $_POST['career_jobs_link'] != '' ) {
                update_post_meta( $post_id, 'career_jobs_link', $_POST['career_jobs_link'] );
            }else{
                update_post_meta( $post_id, 'career_jobs_link', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_career_jobs_update', 10, 2 );


function career_jobs_func($atts) {
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

    $career_jobs = '';

    $career_jobs .= '<div '.(($id != '')? 'id="'.$id.'"':'').' class="testouter '.(($class != '')? $class:"").'">';
        if($title != ''){
            $career_jobs .= '<h2>'.$title.'</h2>';
        }

        $career_jobs .= '<div>';
            $career_jobs .= '<div id="career_jobs-'.$offset.'" class="career_jobs '.(($carousel == 'yes')?"career_jobs-carousel":"").'" data-offset="'.$offset.'" data-howmany="1" data-timeout="400" data-direction="'.$direction.'">';
                $career_jobs .= '<div class="carousel-list">';
                    wp_reset_query();
                    if($ids == ''){
                        $args = array(
                            'post_type' => 'career_jobs',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }else{
                        $idarray = explode(',', $ids);

                        $args = array(
                            'post_type' => 'career_jobs',
                            'posts_per_page' => $posts_per_page,
                            'post__in' => $idarray,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }

                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $authtext = get_post_meta($post->ID, 'career_jobs_text', true);
                        $complink = get_post_meta($post->ID, 'career_jobs_link', true);
                        $stars = get_post_meta($post->ID, 'num_stars', true);

                        $career_jobs .= '<div class="row">';

                            $career_jobs .= '<div class="CaseContent">';
                            $career_jobs .= '<h3>'.get_the_title().'</h3>';
                                //$career_jobs .= '<h3>'.get_the_title().'</h3>';

                                $career_jobs .= apply_filters('the_content', get_the_excerpt());
                                $career_jobs .= '<a href="'.$complink.'" class="readmoretest orangeText">'.$authtext.'</a>';
                                //$career_jobs .= '<a href="'.get_permalink().'" class="readmoretest orangeText">'.$authtext.'</a>';

                            $career_jobs .= '</div>';
                        $career_jobs .= '</div>';
                    endwhile;
                    wp_reset_query();
                $career_jobs .= '</div>';
            $career_jobs .= '</div>';

            if($carousel == 'yes'){
                $career_jobs .= '<div id="career_jobs-pr-nx-'.$offset.'" class="career_jobs-pr-nx">';
                    $career_jobs .= '<div id="career_jobs-prev-'.$offset.'" class="career_jobs-prev"><div>Prev</div></div>';
                    $career_jobs .= '<div id="career_jobs-next-'.$offset.'" class="career_jobs-next"><div>Next</div></div>';
                $career_jobs .= '</div>';
            }

        $career_jobs .= '</div>';

        if($carousel == 'yes'){
            wp_enqueue_script( 'modular-wp-student-success', get_template_directory_uri() . '/admin/post_types/career_jobs/testimonials.js', array('jquery'), '1.0.0', true );

        }
    $career_jobs .= '</div>';

    return $career_jobs;
}

add_shortcode( 'career_jobsold', 'career_jobs_func' );;






//SHORTCODE career_jobs BUTTON
function career_jobs_shortcode_btn() {
    //Abort early if the user will never see TinyMCE
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    //Add a callback to regiser our tinymce plugin
    add_filter("mce_external_plugins", "register_career_jobs_tinymce");

    // Add a callback to add our button to the TinyMCE toolbar
    add_filter('mce_buttons', 'add_career_jobs_tinymce_btn');
}

add_action('init', 'career_jobs_shortcode_btn');


//This callback registers our plug-in
function register_career_jobs_tinymce($plugin_array) {
    $plugin_array['career_jobs_button'] = get_bloginfo('template_directory').'/admin/post_types/career_jobs/tinymce.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function add_career_jobs_tinymce_btn($buttons) {
    //Add the button ID to the $button array
    $buttons[] = "career_jobs_button";
    return $buttons;
}

?>
