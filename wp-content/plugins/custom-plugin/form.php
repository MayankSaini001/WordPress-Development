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


function cp_add_menu() {
    add_menu_page(
        'Students',        // Page title (browser tab pe dikhega)
        'Students',         // Menu title (sidebar me dikhega)
        'manage_options',   // Capability - kaun access kar sakta hai
        'cp-students',       // Menu slug - unique ID is page ka
        'cp_render_page',   // Callback function - jo page ka content banayega
        'dashicons-groups', // Icon
        20                  // Position (sidebar me kahan dikhega)
    );
}
add_action( 'admin_menu', 'cp_add_menu' );

function cp_render_page() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'cp_students';

    if ( isset( $_POST['cp_submit'] ) ) {

        $name  = sanitize_text_field( $_POST['cp_name'] );
        $email = sanitize_email( $_POST['cp_email'] );

        $wpdb->insert(
            $table_name,
            array(
                'name'  => $name,
                'email' => $email,
            ),
            array( '%s', '%s' ) // dono fields string hain
        );

        echo '<div class="notice notice-success"><p>Student added successfully!</p></div>';
    }

    
    ?>
    <div class="wrap">
        <h1>Students</h1>

        <h2>Add New Student</h2>
        <form method="POST">
            <p>
                <label>Name</label><br>
                <input type="text" name="cp_name" required>
            </p>
            <p>
                <label>Email</label><br>
                <input type="email" name="cp_email" required>
            </p>
            <button type="submit" name="cp_submit" class="button button-primary">Add Student</button>
        </form>
    </div>
    <?php
}
