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
            array( '%s', '%s' )
        );

        echo '<div class="notice notice-success is-dismissible">
                <p><strong>Success!</strong> Student added successfully.</p>
              </div>';
    }

    ?>

    <div class="wrap cp-students-page">

        <div class="cp-page-header">
            <div>
                <h1>Students</h1>
                <p>Add and manage student information.</p>
            </div>
        </div>

        <div class="cp-form-card">

            <div class="cp-card-header">
                <div class="cp-card-icon">
                    <span class="dashicons dashicons-admin-users"></span>
                </div>

                <div>
                    <h2>Add New Student</h2>
                    <p>Enter the student's basic information below.</p>
                </div>
            </div>

            <form method="POST" class="cp-student-form">

                <div class="cp-form-group">
                    <label for="cp_name">
                        Student Name
                    </label>

                    <div class="cp-input-wrapper">
                        <span class="dashicons dashicons-id"></span>

                        <input
                            type="text"
                            id="cp_name"
                            name="cp_name"
                            placeholder="Enter student name"
                            required
                        >
                    </div>
                </div>

                <div class="cp-form-group">
                    <label for="cp_email">
                        Email Address
                    </label>

                    <div class="cp-input-wrapper">
                        <span class="dashicons dashicons-email"></span>

                        <input
                            type="email"
                            id="cp_email"
                            name="cp_email"
                            placeholder="student@example.com"
                            required
                        >
                    </div>
                </div>

                <div class="cp-form-footer">

                    <button
                        type="submit"
                        name="cp_submit"
                        class="button cp-submit-btn"
                    >
                        <span class="dashicons dashicons-plus-alt2"></span>
                        Add Student
                    </button>

                </div>

            </form>

        </div>

    </div>

    <style>

        /* Page */
        .cp-students-page {
            max-width: 1000px;
        }

        /* Header */
        .cp-page-header {
            margin: 25px 0 20px;
        }

        .cp-page-header h1 {
            margin: 0 0 5px;
            font-size: 30px;
            font-weight: 700;
            color: #1d2327;
        }

        .cp-page-header p {
            margin: 0;
            color: #646970;
            font-size: 14px;
        }

        /* Card */
        .cp-form-card {
            max-width: 650px;
            background: #ffffff;
            border: 1px solid #dcdcde;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Card Header */
        .cp-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 25px 30px;
            background: linear-gradient(135deg, #f8faff, #eef4ff);
            border-bottom: 1px solid #e1e5eb;
        }

        .cp-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #2271b1;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cp-card-icon .dashicons {
            font-size: 25px;
            width: 25px;
            height: 25px;
        }

        .cp-card-header h2 {
            margin: 0 0 4px;
            font-size: 20px;
            color: #1d2327;
        }

        .cp-card-header p {
            margin: 0;
            color: #646970;
            font-size: 13px;
        }

        /* Form */
        .cp-student-form {
            padding: 30px;
        }

        .cp-form-group {
            margin-bottom: 22px;
        }

        .cp-form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #1d2327;
        }

        /* Input */
        .cp-input-wrapper {
            position: relative;
        }

        .cp-input-wrapper .dashicons {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8c8f94;
            pointer-events: none;
        }

        .cp-input-wrapper input {
            width: 100%;
            min-height: 46px;
            padding: 10px 14px 10px 44px;
            border: 1px solid #c3c4c7;
            border-radius: 7px;
            background: #fff;
            color: #1d2327;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .cp-input-wrapper input::placeholder {
            color: #a7aaad;
        }

        .cp-input-wrapper input:hover {
            border-color: #8c8f94;
        }

        .cp-input-wrapper input:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 2px rgba(34, 113, 177, 0.15);
            outline: none;
        }

        .cp-input-wrapper:focus-within .dashicons {
            color: #2271b1;
        }

        /* Footer */
        .cp-form-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #f0f0f1;
        }

        /* Button */
        .cp-submit-btn {
            display: inline-flex !important;
            align-items: center;
            gap: 7px;
            min-height: 44px !important;
            padding: 0 20px !important;
            border: none !important;
            border-radius: 7px !important;
            background: #2271b1 !important;
            color: #ffffff !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .cp-submit-btn:hover {
            background: #135e96 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(34, 113, 177, 0.25);
        }

        .cp-submit-btn:active {
            transform: translateY(0);
        }

        .cp-submit-btn .dashicons {
            font-size: 18px;
            width: 18px;
            height: 18px;
        }

        /* Success Notice */
        .cp-students-page .notice {
            max-width: 650px;
            margin: 0 0 20px;
            border-radius: 7px;
        }

        /* Responsive */
        @media screen and (max-width: 782px) {

            .cp-form-card {
                max-width: 100%;
            }

            .cp-card-header {
                padding: 20px;
            }

            .cp-student-form {
                padding: 20px;
            }

            .cp-page-header h1 {
                font-size: 26px;
            }

            .cp-form-footer {
                justify-content: stretch;
            }

            .cp-submit-btn {
                width: 100%;
                justify-content: center;
            }
        }

    </style>

    <?php
}


