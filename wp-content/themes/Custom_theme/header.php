<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>

    <?php the_custom_logo(); ?>

    <h1><?php bloginfo('name'); ?></h1>

    <p><?php bloginfo('description'); ?></p>

    <nav>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'menu_class'     => 'main-menu',
        ));
        ?>
    </nav>

</header>