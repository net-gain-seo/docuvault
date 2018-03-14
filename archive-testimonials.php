<?php
    // TESTIMONIALS
    get_header();
?>


    <div class="mast page-mast">
        <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/08/mast-testimonials.jpg" />
        <div class="container mast-overlay">
            <h1>Customer Testimonials</h1>
        </div>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>
    <div class="container-fluid testimonials-listing">

        <div class="container">
            <article>

                <div class="the-testimonial">
                    <?php the_content(); ?>
                </div>

                <div class="txt-primary">
                    <?php the_title(); ?>
                </div>


            </article>
        </div>

    </div>
        <?php endwhile; // End of the loop. ?>

<?php
    get_footer();
