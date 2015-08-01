<?php
/**
 * @package WordPress
 * Template Name: FrontPage
 */
?>

<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

  <?php if($post->post_content=="") : ?>

<?php else : ?>

  <!-- +++++ Welcome Section +++++ -->

		<div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <img src="<?php echo get_stylesheet_directory_uri().'/images/toystory.jpg'; ?>" data-thumb="images/toystory.jpg" alt="" />
                <a href="http://dev7studios.com"><img src="<?php echo get_stylesheet_directory_uri().'/images/up.jpg';?>" data-thumb="images/up.jpg" alt="" title="This is an example of a caption" /></a>
                <img src="<?php echo get_stylesheet_directory_uri().'/images/walle.jpg';?>" data-thumb="images/walle.jpg" alt="" />
                <img src="<?php echo get_stylesheet_directory_uri().'/images/nemo.jpg';?>" data-thumb="images/nemo.jpg" alt="" title="#htmlcaption" />
            </div>
          <div id="htmlcaption" class="nivo-html-caption">
                <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
          </div>
        </div>
  
  
  
      <div class="container">
      <div class="row">
        <div class="col-lg-12">
        <?php if ( has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail(); ?>
                  <?php endif; ?>
				  
			<!---get the title--->	  
          <h1><?php the_title(); ?> </h1>
		  <!---get the content-->
          <p> <?php the_content(); ?></p>
        
        </div><!-- /col-lg-12 -->
      </div><!-- /row -->
    </div> <!-- /container -->
  </div><!-- /ww -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>

<?php endwhile; ?>	







<?php get_footer(); ?>