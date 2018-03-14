<?php get_header(); ?>

<?php
$postId = get_option('page_for_posts');
$pageTitle = get_post_meta($postId,'show_page_title',true);
?>
<section id="blogContent" class="blogPosts subpage py-5" >
    <div class="container">
        <div class="row">
            <main class="col col-12 col-md-12">
                <?php
                while ( have_posts() ) : the_post();
                    echo '<article class="clearfix articlespacing">';
                    echo '<div class="date py-1">';
                        echo '<span>'.get_the_time('F').' </span>';
                        echo '<span>'.get_the_time('d').', </span>';
                        echo '<span>'.get_the_time('Y').'</span>';
                        echo '</div>';
                    echo '<h2><a title="'.get_the_title().'"  class="blogtitle" href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    }
                    the_excerpt();
                    echo '<p><a title="'.get_the_title().'" href="'.get_permalink().'" class="button">Read More »</a></p>';
                    echo '</article>';
                endwhile;
                ?>
                <div class="blogpagination">
      						<?php
      						echo paginate_links( array(
      							'base' => str_replace( 9999999, '%#%', esc_url( get_pagenum_link( 9999999 ) ) ),
      							'format' => 'page/%#%/',
      							'current' => max( 1, get_query_var('paged') ),
      							'total' => $wp_query->max_num_pages,
                    'prev_text'          => __('<img src="https://docuvaultdv.com/wp-content/uploads/2017/12/left-arrow.jpg" class="dirarrow">'),
      							'next_text'          => __('<img src="https://docuvaultdv.com/wp-content/uploads/2017/12/right-arrow.jpg" class="dirarrow">'),
      							'add_args'           => false
      						) );
      						?>
      					</div>
            </main>
        </div>
    </div>
</section>

<?php get_footer(); ?>
