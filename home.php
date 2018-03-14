<?php
    // BLOG HOME
    get_header();
?>
<div id="featured-image"><img width="100%" src="<?php echo esc_url( home_url( '/' ) ); ?>/wp-content/uploads/2017/11/KeyboardBanner.png" ></div>
<div class="post_title"><div><h1>Blog</h1></div></div>
<?php echo do_shortcode( '[container fluid="true" background_color="#CC383D" inner_class="container" class="PageSummary signupform"]

[row]

[col size="lg-5 col-md-12 col-xsm-12" ]

<p class="pull-right">Sign up for free email blog updates</p>

[/col]

[col size="lg-7 col-md-12 col-xsm-12" ]

[contact-form-7 id="904" title="Email Signup"]

[/col]

[/row]

[/container]' ); ?>

<div class="container">
    <div class="row blog-content">
        <div class="col col-12 col-lg-9">

            <div class="blog-listing">
            <?php while ( have_posts() ) : the_post(); ?>
                <article>

                    <h2 class="post-title">
                        <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <?php the_excerpt(); ?>

                    <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" class="orangeText">Read more »</a>

                </article>
            <?php endwhile; // End of the loop. ?>
            </div>
            <div class="blogpagination">
  						<?php
              global $wp_query;
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

        </div>

        <div class="col col-12 col-lg-3">

            <div class="blog-sidebar">
                <?php dynamic_sidebar( 'blog_sidebar' ); ?>
            </div>

        </div>
    </div>
</div>
<?php echo do_shortcode( '[common_element id="917"]' ); ?>

<?php
    get_footer();
