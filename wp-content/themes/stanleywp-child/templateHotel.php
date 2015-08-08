<?php
/*
Template Name: Hotels
*/

get_header(); 


$args = array( 'post_type' => 'hotel', 'posts_per_page' => 10);
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) { 
$loop->the_post(); ?>

<div class="row">
  <div class="col-xs-1">
  <?php $image = wp_get_attachment_image_src(get_field('slide1'), 'thumbnail'); ?>
<img height="60" width="60" src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title(get_field('slide1')) ?>" />
  </div>
  <div class="col-md-2">
<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
  </div>
</div>





<?php


  
}

get_footer(); ?>