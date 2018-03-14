<?php
    get_header();
    // $postId = get_the_post_id();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <div class="page-content front-page-content">
        <?php the_content(); ?>
    </div>

<?php endwhile; // End of the loop. ?>

<?php
    get_footer();
