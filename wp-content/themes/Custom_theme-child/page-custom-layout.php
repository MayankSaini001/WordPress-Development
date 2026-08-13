<?php
/*
Template Name: MyCustom Layout
Template Post Type: page, post
*/
?>


<div class="my-custom-container">
    <?php 
    while ( have_posts() ) : the_post();
        the_content(); // Displays page content
    endwhile; 
    ?>
    <h1>Testing</h1>
</div>



