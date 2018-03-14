<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<div id="featured-image"><img width="100%" src="<?php echo esc_url( home_url( '/' ) ); ?>/wp-content/uploads/2017/11/KeyboardBanner.png" ></div>
<div class="post_title"><div><h1>404 Page Not Found</h1></div></div>
<div class="container">
    <div class="row">
      <div class="col col-12 col-lg-9">
          <p>Oops, we’re sorry. We can’t find the page you’re looking for. </p>
          <p>The link you followed may be broken or the page may have been removed.</p>
          <p>Back to <a href="<?php echo esc_url( home_url( '/' ) ); ?>">homepage</a></p>
			</div><!-- .page-wrapper -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
