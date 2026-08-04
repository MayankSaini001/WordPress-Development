<?php
function mytheme_setup() {

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    // register_nav_menus([
    //     'primary' => 'primary'
    // ]);
}

add_action('after_setup_theme', 'mytheme_setup');

function mytheme_assets() {

    wp_enqueue_style(
        'style',
        get_stylesheet_uri()
    );

}

function delete_primary_menu() {

    $menu = wp_get_nav_menu_object('Primary Menu');

    if ($menu) {
        wp_delete_nav_menu($menu->term_id);
    }

}

add_action('switch_theme', 'delete_primary_menu');

add_action('wp_enqueue_scripts', 'mytheme_assets');