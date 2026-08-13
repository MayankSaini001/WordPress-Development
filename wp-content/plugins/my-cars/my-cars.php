<?php
/**
 * Plugin Name: My Cars
 * Description: Custom Post Type for Cars
 * Version: 1.0.0
 */

function register_cars_post_type() {

    $labels = array(
        'name'          => 'Cars',
        'singular_name' => 'Car',
        'menu_name'     => 'Cars',
        'add_new_item'  => 'Add New Car',
        'edit_item'     => 'Edit Car',
        'all_items'     => 'All Cars',
    );

    $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'has_archive'        => true,
    'show_in_rest'       => true,
    'menu_icon'          => 'dashicons-car',

    'supports' => array(
        'title',
        'editor',
        'thumbnail',
    ),

    'rewrite' => array(
        'slug'       => 'cars',
        'with_front' => false,
    ),
);

    register_post_type('car', $args);
}

add_action('init', 'register_cars_post_type');