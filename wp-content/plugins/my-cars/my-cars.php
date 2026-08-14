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

function register_car_taxonomy() {

    $labels = array(
        'name'              => 'Car Categories',
        'singular_name'     => 'Car Category',
        'search_items'      => 'Search Car Categories',
        'all_items'         => 'All Car Categories',
        'parent_item'       => 'Parent Car Category',
        'parent_item_colon' => 'Parent Car Category:',
        'edit_item'         => 'Edit Car Category',
        'update_item'       => 'Update Car Category',
        'add_new_item'      => 'Add New Car Category',
        'new_item_name'     => 'New Car Category Name',
        'menu_name'         => 'Car Categories',
    );

    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => array(
            'slug' => 'car-category',
        ),
    );

    register_taxonomy(
        'car_category',
        array('car'),
        $args
    );
}

add_action('init', 'register_car_taxonomy');