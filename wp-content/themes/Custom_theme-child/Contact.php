<?php
/*
Template Name: Custom Contact Page
Template Post Type: page, post
*/
?>

<main class="custom-page">
    <h1><?php the_title(); ?></h1>

    <div class="page-content">
        <?php
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
        ?>
        
    </div>
</main>
