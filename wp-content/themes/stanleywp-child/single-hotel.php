<?php
/* Single Hotel Page */

get_header(); 

 $postid = get_the_ID();  

$args = array('p' => $postid, 'post_type' => 'hotel');
$loop = new WP_Query( $args );


while ( $loop->have_posts() ) { 
$loop->the_post(); ?>


<div class="row">
<div class="col-lg-8 col-lg-offset-2 centered">
  <div class="col-md-8 col-lg-offset-2 centered">
<h2><?php the_title(); ?></h2>

<?php
$stars = get_field('rating');
if($stars==1){  
echo '<i class="fa fa-star"></i>';
echo $stars;
} 

$stars = get_field('rating');
if($stars==2){  
echo '<i class="fa fa-star"></i>,<i class="fa fa-star"></i>';
echo $stars;
}

$stars = get_field('rating');
if($stars==3){  
echo '<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>';
echo $stars;
}

$stars = get_field('rating');
if($stars==4){  
echo '<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>';
echo $stars;
}

$stars = get_field('rating');
if($stars==5){  
echo '<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>,<i class="fa fa-star"></i>';
echo $stars;
}
?>
</div>
<div class="col-xs-8 col-lg-offset-2 centered">
<?php

if(get_field('address'))
{
	echo '<p>' . get_field('address') . '</p>';
}
?>
</div>
<?php

 
$image_full = wp_get_attachment_image_src(get_field('slide1'), 'full');
$image_full2 = wp_get_attachment_image_src(get_field('slide2'), 'full');
$image_full3 = wp_get_attachment_image_src(get_field('slide3'), 'full');
$image_full4 = wp_get_attachment_image_src(get_field('slide4'), 'full');
$image_thumb = wp_get_attachment_image_src(get_field('slide1'), 'thumbnail'); 
$image_thumb2 = wp_get_attachment_image_src(get_field('slide2'), 'thumbnail');
$image_thumb3 = wp_get_attachment_image_src(get_field('slide3'), 'thumbnail');
$image_thumb4 = wp_get_attachment_image_src(get_field('slide4'), 'thumbnail');
 ?>


<img height="300" width="300" src="<?php echo $image_full[0]; ?>" alt="<?php echo get_the_title(get_field('slide1')) ?>" /><br><br>


<div class="panel panel-default">
    <div style=" background-color: black; color:white;" class="panel-heading">Hotel Description</div>
    <div class="panel-body">
            <div id="slider" class="nivoSlider">
                <img src="<?php echo $image_full[0]; ?>" alt="" data-thumb="<?php echo $image_thumb[0];?>" alt="" />
                <img src="<?php echo $image_full2[0]; ?>" alt="" data-thumb="<?php echo $image_thumb2[0];?>" alt="" />
                <img src="<?php echo $image_full3[0];?>" alt="" data-thumb="<?php echo $image_thumb3[0];?>" alt="" />
                <img src="<?php echo $image_full4[0];?>" alt="" data-thumb="<?php echo $image_thumb4[0];?>" alt="" />
            </div>

</div>	
</div>		
			
			



</div>
</div>
<div class="panel panel-default col-xs-8 col-lg-offset-2">
<div class="panel-body">
<?php
if(get_field('detail'))
{
	echo '<p>' . get_field('detail') . '</p>';
}



}
?>
</div>
</div>


<?php get_footer(); ?>