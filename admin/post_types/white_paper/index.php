<?php
add_action( 'init', 'create_custom_white_paper_post_types' );

//CUSTOM POST TYPE
function create_custom_white_paper_post_types() {
    register_post_type( 'white_paper',
        array(
            'labels' => array(
                'name' => 'White Paper',
                'singular_name' => 'White Paper',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New White Paper Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit White Paper Slide',
                'new_item' => 'New White Paper Slide',
                'view' => 'View',
                'view_item' => 'View White Paper Slide',
                'search_items' => 'Search White Paper Slide',
                'not_found' => 'No White Paper Slide found',
                'not_found_in_trash' => 'No White Paper Slide found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'white_paper', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'white_paper_icons' );
function white_paper_icons() { ?>
    <style type="text/css" media="screen">
        /****white_paper****/
        #menu-posts-white_paper .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/white_paper/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-white_paper:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-white_paper.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//white_paper META BOX
function my_white_paper_admin() {
    add_meta_box( 'white_paper_meta_box',
        'Author Info',
        'display_white_paper_meta_box',
        'white_paper', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'my_white_paper_admin' );

function display_white_paper_meta_box( $test ) {
    global $post;
    $custom = get_post_custom($post->ID);

    $authtext = esc_html( get_post_meta( $test->ID, 'white_paper_text', true ) );
    $complink = esc_html( get_post_meta( $test->ID, 'white_paper_link', true ) );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%">Download White Paper Text</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="white_paper_text" value="<?php echo $authtext; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Download White Paper Link</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="white_paper_link" value="<?php echo $complink; ?>" /></td>
        </tr>
        <tr><td style="width: 100%">&nbsp;</td></tr>
        <input type="hidden" name="white_paper_flag" value="true" />
    </table>
<?php
}

function custom_fields_white_paper_update($post_id, $post ){
    if ( $post->post_type == 'white_paper' ) {
        if (isset($_POST['white_paper_flag'])) {
            update_post_meta($post_id, "num_stars", $_POST['num_stars']);

            if ( isset( $_POST['white_paper_text'] ) && $_POST['white_paper_text'] != '' ) {
                update_post_meta( $post_id, 'white_paper_text', $_POST['white_paper_text'] );
            }else{
                update_post_meta( $post_id, 'white_paper_text', '');
            }

            if ( isset( $_POST['white_paper_link'] ) && $_POST['white_paper_link'] != '' ) {
                update_post_meta( $post_id, 'white_paper_link', $_POST['white_paper_link'] );
            }else{
                update_post_meta( $post_id, 'white_paper_link', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_white_paper_update', 10, 2 );


function white_paper_func($atts) {
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

    $white_paper = '';
                    wp_reset_query();
                    if($ids == ''){
                        $args = array(
                            'post_type' => 'white_paper',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }else{
                        $idarray = explode(',', $ids);

                        $args = array(
                            'post_type' => 'white_paper',
                            'posts_per_page' => $posts_per_page,
                            'post__in' => $idarray,
                            'post_id' => $postid,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }

                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $authtext = get_post_meta($post->ID, 'white_paper_text', true);
                        $complink = get_post_meta($post->ID, 'white_paper_link', true);
                        $stars = get_post_meta($post->ID, 'num_stars', true);
                        $post = get_post( $id );

                        $white_paper .= '<div class="row padding25">';
                        if ( has_post_thumbnail() ) {
                          $white_paper .= '<div class="WhitePaperimg">'.get_the_post_thumbnail( $page->ID, 'thumbnail' ).'</div>';
                        }
                            $white_paper .= '<div class="WhitePaperContent">';
                            $white_paper .= '<h3 class="orangeText">'.get_the_title().'</h3>';
                                $white_paper .= apply_filters('the_content', get_the_excerpt());
                                $white_paper .= '<a href="'.$complink.'" class="readmoretest buttonlight" target="_blank">'.$authtext.'</a>';
                                $white_paper .= '</div>';
                        $white_paper .= '</div>';
                    endwhile;
                    wp_reset_query();
    return $white_paper;
}

add_shortcode( 'white_paper', 'white_paper_func' );;

?>
