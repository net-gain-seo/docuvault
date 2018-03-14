<?php
    get_header();
?>
<?php
    $postId = get_the_post_id();
    $primaryTitle = get_post_meta( $postId, 'mast_page_title', true );
    $sectionTitle = get_post_meta( $postId, 'mast_section_title', true );
?>
<div id="featured-image"><img width="100%" src="<?php echo esc_url( home_url( '/' ) ); ?>/wp-content/uploads/2017/11/KeyboardBanner.png" ></div>
<div class="post_title"><div><h1><?php the_title(); ?></h1></div></div>
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

<div class="container blog-content">
    <div class="row">
        <div class="col col-12 col-lg-9">
            <?php while ( have_posts() ) : the_post(); ?>

                <article>
                    <div class="blog-article">
                        <?php the_content(); ?>
                    </div>
                </article>

            <?php endwhile; // End of the loop. ?>

            <div class="next-prev">
                <div class="prev"><?php previous_post_link('%link', '<img src="https://docuvaultdv.com/wp-content/uploads/2017/12/left-arrow.jpg" class="dirarrow"> <span>Previous Post</span>', FALSE); ?></div>
                <div class="next"><?php next_post_link('%link', '<span>Next Post</span> <img src="https://docuvaultdv.com/wp-content/uploads/2017/12/right-arrow.jpg" class="dirarrow">', FALSE); ?></div>
            </div>
        </div>

        <div class="col col-12 col-lg-3">

            <div class="blog-sidebar">
                <?php dynamic_sidebar( 'blog_sidebar' ); ?>
            </div>

        </div>
    </div>

</div>

<?php
    get_footer();
