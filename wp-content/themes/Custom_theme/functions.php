<?php

// Theme Setup
function custom_theme_setup() {

    // Dynamic Title
    add_theme_support('title-tag');

    // Featured Image Support
    add_theme_support('post-thumbnails');

    // Custom Logo Support
    add_theme_support('custom-logo');

    // Register Navigation Menu
    register_nav_menus(array(
        'primary-menu' => 'Primary Menu',
    ));
}

add_action('after_setup_theme', 'custom_theme_setup');


// Load CSS & JS
function custom_theme_scripts() {

    // Main CSS
    wp_enqueue_style(
        'theme-style',
        get_stylesheet_uri()
    );

    // Agar baad me JS add karna ho to ye uncomment kar dena

    /*
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0',
        true
    );
    */

}

add_action('wp_enqueue_scripts', 'custom_theme_scripts');

function my_theme_setup()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'my_theme_setup');