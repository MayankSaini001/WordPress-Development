<?php
/*
Plugin Name: Custom plugin
Description: Collect the information of the students
Author: Mayank Saini
Version: 1.0
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function cp_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cp_students';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'cp_create_table' );