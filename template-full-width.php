<?php
/*
  * Template Name: Full Width
  */
?>
<?php get_header(); ?>
<?php
$pageTitle = get_post_meta(get_the_ID(),'show_page_title',true);
if(has_post_thumbnail()) {
  echo '<div id="featured-image">'.get_the_post_thumbnail().'</div>';
}
echo '<div class="post_title"><div><h1>'.get_the_title().'</h1></div></div>';

?>

<div id="fullWidth">
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
</div>
<?php get_footer(); ?>
