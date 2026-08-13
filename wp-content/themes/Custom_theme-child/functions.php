<?php

add_action('wp_enqueue_scripts', function () {

    // Parent theme CSS
    wp_enqueue_style(
        'custom-theme-style',
        get_template_directory_uri() . '/style.css'
    );

    // Child theme CSS
    wp_enqueue_style(
        'custom-theme-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('custom-theme-style'),
        wp_get_theme()->get('Version')
    );

});