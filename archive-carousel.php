<?php
    // Carousel
    get_header();
?>

    <?php while ( have_posts() ) : the_post(); ?>
    <div class="container-fluid carousel-listing">

        <div class="container">
            <article>

                <div class="the-carousel">
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
