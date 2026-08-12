<?php
/*
Plugin Name: Custom plugin
Description: Collect the information of the students
Author: Mayank Saini
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit;
}


/*CREATE DATABASE TABLE*/

function cp_create_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'cp_students';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}

register_activation_hook(__FILE__, 'cp_create_table');


/*ADD ADMIN MENU*/

function cp_add_menu()
{
    add_menu_page(
        'Students',
        'Students',
        'manage_options',
        'cp-students',
        'cp_render_page',
        'dashicons-groups',
        20
    );
}

add_action('admin_menu', 'cp_add_menu');


/*MAIN ADMIN PAGE*/

function cp_render_page()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'cp_students';


    /*DELETE*/

    if (
        isset($_GET['action']) &&
        $_GET['action'] === 'delete' &&
        isset($_GET['id'])
    ) {

        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to delete students.');
        }

        $id = absint($_GET['id']);

        if (
            isset($_GET['_wpnonce']) &&
            wp_verify_nonce(
                $_GET['_wpnonce'],
                'cp_delete_student_' . $id
            )
        ) {

            $wpdb->delete(
                $table_name,
                array(
                    'id' => $id
                ),
                array('%d')
            );

            echo '<div class="notice notice-success is-dismissible">
                    <p><strong>Success!</strong> Student deleted successfully.</p>
                  </div>';
        }
    }


    /*CREATE / UPDATE*/

    if (isset($_POST['cp_submit'])) {

        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to manage students.');
        }

        if (
            !isset($_POST['cp_student_nonce']) ||
            !wp_verify_nonce(
                $_POST['cp_student_nonce'],
                'cp_save_student'
            )
        ) {
            wp_die('Security check failed.');
        }


        $name = isset($_POST['cp_name'])
            ? sanitize_text_field($_POST['cp_name'])
            : '';

        $email = isset($_POST['cp_email'])
            ? sanitize_email($_POST['cp_email'])
            : '';

        $student_id = isset($_POST['cp_id'])
            ? absint($_POST['cp_id'])
            : 0;


        /*Validation*/

        if (empty($name) || empty($email)) {

            echo '<div class="notice notice-error is-dismissible">
                    <p><strong>Error!</strong> Name and email are required.</p>
                  </div>';

        } elseif (!is_email($email)) {

            echo '<div class="notice notice-error is-dismissible">
                    <p><strong>Error!</strong> Please enter a valid email address.</p>
                  </div>';

        } else {


            /*UPDATE*/

            if ($student_id > 0) {

                $wpdb->update(
                    $table_name,

                    array(
                        'name'  => $name,
                        'email' => $email,
                    ),

                    array(
                        'id' => $student_id
                    ),

                    array(
                        '%s',
                        '%s',
                    ),

                    array(
                        '%d'
                    )
                );

                echo '<div class="notice notice-success is-dismissible">
                        <p><strong>Success!</strong> Student updated successfully.</p>
                      </div>';

            }


            /*CREATE*/

            else {

                $wpdb->insert(
                    $table_name,

                    array(
                        'name'  => $name,
                        'email' => $email,
                    ),

                    array(
                        '%s',
                        '%s'
                    )
                );

                echo '<div class="notice notice-success is-dismissible">
                        <p><strong>Success!</strong> Student added successfully.</p>
                      </div>';
            }
        }
    }


    /*GET STUDENT FOR EDIT*/

    $edit_student = null;

    if (
        isset($_GET['action']) &&
        $_GET['action'] === 'edit' &&
        isset($_GET['id'])
    ) {

        $id = absint($_GET['id']);

        $edit_student = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE id = %d",
                $id
            )
        );
    }


    /*READ ALL STUDENTS*/

    $students = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY id DESC"
    );

    ?>


    <div class="wrap cp-students-page">


        <!-- PAGE HEADER -->

        <div class="cp-page-header">

            <div>

                <h1>Students</h1>

                <p>
                    Add and manage student information.
                </p>

            </div>

        </div>


        <!-- SUCCESS / ERROR MESSAGES -->



        <!-- FORM CARD -->

        <div class="cp-form-card">


            <div class="cp-card-header">

                <div class="cp-card-icon">

                    <span class="dashicons dashicons-admin-users"></span>

                </div>


                <div>

                    <h2>

                        <?php
                        echo $edit_student
                            ? 'Edit Student'
                            : 'Add New Student';
                        ?>

                    </h2>

                    <p>

                        <?php
                        echo $edit_student
                            ? 'Update student information below.'
                            : 'Enter the student information below.';
                        ?>

                    </p>

                </div>

            </div>



            <!-- FORM -->

            <form method="POST" class="cp-student-form">


                <?php
                wp_nonce_field(
                    'cp_save_student',
                    'cp_student_nonce'
                );
                ?>


                <!-- STUDENT ID -->

                <input
                    type="hidden"
                    name="cp_id"
                    value="<?php
                    echo $edit_student
                        ? esc_attr($edit_student->id)
                        : '';
                    ?>"
                >


                <!-- NAME -->

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
                            value="<?php
                            echo $edit_student
                                ? esc_attr($edit_student->name)
                                : '';
                            ?>"
                            required
                        >

                    </div>

                </div>



                <!-- EMAIL -->

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
                            value="<?php
                            echo $edit_student
                                ? esc_attr($edit_student->email)
                                : '';
                            ?>"
                            required
                        >

                    </div>

                </div>



                <!-- BUTTON -->

                <div class="cp-form-footer">

                    <button
                        type="submit"
                        name="cp_submit"
                        class="button cp-submit-btn"
                    >

                        <span class="dashicons dashicons-plus-alt2"></span>

                        <?php
                        echo $edit_student
                            ? 'Update Student'
                            : 'Add Student';
                        ?>

                    </button>


                    <?php if ($edit_student): ?>

                        <a
                            href="<?php
                            echo esc_url(
                                admin_url(
                                    'admin.php?page=cp-students'
                                )
                            );
                            ?>"
                            class="button cp-cancel-btn"
                        >
                            Cancel
                        </a>

                    <?php endif; ?>

                </div>


            </form>

        </div>



        <!-- STUDENTS LIST -->

        <div class="cp-list-card">


            <div class="cp-list-header">

                <div>

                    <h2>All Students</h2>

                    <p>
                        List of all registered students.
                    </p>

                </div>

            </div>



            <table class="wp-list-table widefat fixed striped">


                <thead>

                    <tr>

                        <th width="80">
                            ID
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th width="180">
                            Actions
                        </th>

                    </tr>

                </thead>



                <tbody>


                <?php if (!empty($students)): ?>


                    <?php foreach ($students as $student): ?>


                        <tr>


                            <td>
                                <?php
                                echo esc_html($student->id);
                                ?>
                            </td>


                            <td>

                                <strong>
                                    <?php
                                    echo esc_html($student->name);
                                    ?>
                                </strong>

                            </td>


                            <td>

                                <?php
                                echo esc_html($student->email);
                                ?>

                            </td>


                            <td>


                                <!-- EDIT -->

                                <a
                                    href="<?php
                                    echo esc_url(
                                        admin_url(
                                            'admin.php?page=cp-students&action=edit&id=' .
                                            $student->id
                                        )
                                    );
                                    ?>"
                                    class="button button-small"
                                >

                                    Edit

                                </a>



                                <!-- DELETE -->

                                <?php

                                $delete_url = wp_nonce_url(
                                    admin_url(
                                        'admin.php?page=cp-students&action=delete&id=' .
                                        $student->id
                                    ),
                                    'cp_delete_student_' . $student->id
                                );

                                ?>

                                <a
                                    href="<?php
                                    echo esc_url($delete_url);
                                    ?>"
                                    class="button button-small cp-delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this student?');"
                                >

                                    Delete

                                </a>


                            </td>


                        </tr>


                    <?php endforeach; ?>


                <?php else: ?>


                    <tr>

                        <td colspan="4">

                            <p>
                                No students found.
                            </p>

                        </td>

                    </tr>


                <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>



    <style>


        /* PAGE */

        .cp-students-page {
            max-width: 1100px;
        }



        /* HEADER */

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



        /* FORM CARD */

        .cp-form-card {

            max-width: 650px;

            background: #ffffff;

            border: 1px solid #dcdcde;

            border-radius: 12px;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.05);

            overflow: hidden;

            margin-bottom: 30px;
        }



        /* CARD HEADER */

        .cp-card-header {

            display: flex;

            align-items: center;

            gap: 15px;

            padding: 25px 30px;

            background:
                linear-gradient(
                    135deg,
                    #f8faff,
                    #eef4ff
                );

            border-bottom:
                1px solid #e1e5eb;
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



        /* FORM */

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



        /* INPUT */

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

            padding:
                10px 14px 10px 44px;

            border:
                1px solid #c3c4c7;

            border-radius: 7px;

            background: #fff;

            color: #1d2327;

            font-size: 14px;

            box-sizing: border-box;

            transition: all 0.2s ease;
        }



        .cp-input-wrapper input:focus {

            border-color: #2271b1;

            box-shadow:
                0 0 0 2px
                rgba(34, 113, 177, 0.15);

            outline: none;
        }



        /* FOOTER */

        .cp-form-footer {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 28px;

            padding-top: 22px;

            border-top:
                1px solid #f0f0f1;
        }



        /* SUBMIT */

        .cp-submit-btn {

            display: inline-flex !important;

            align-items: center;

            gap: 7px;

            min-height: 44px !important;

            padding:
                0 20px !important;

            border: none !important;

            border-radius: 7px !important;

            background:
                #2271b1 !important;

            color: #ffffff !important;

            font-size: 14px !important;

            font-weight: 600 !important;

            cursor: pointer;
        }



        .cp-submit-btn:hover {

            background:
                #135e96 !important;
        }



        /* CANCEL */

        .cp-cancel-btn {

            display: inline-flex;

            align-items: center;

            min-height: 44px;

            padding: 0 20px;

            border-radius: 7px;
        }



        /* LIST */

        .cp-list-card {

            background: #ffffff;

            border:
                1px solid #dcdcde;

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 4px 15px rgba(0, 0, 0, 0.05);
        }



        .cp-list-header {

            padding: 20px 25px;

            border-bottom:
                1px solid #dcdcde;
        }



        .cp-list-header h2 {

            margin: 0 0 5px;

            font-size: 20px;
        }



        .cp-list-header p {

            margin: 0;

            color: #646970;
        }



        .cp-list-card table {

            border: none;
        }



        .cp-list-card th {

            font-weight: 600;
        }



        .cp-delete-btn {

            color: #b32d2e !important;

            border-color:
                #b32d2e !important;
        }



        /* RESPONSIVE */

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

                flex-direction: column;
            }


            .cp-submit-btn,
            .cp-cancel-btn {

                width: 100%;

                justify-content: center;
            }


            .cp-list-card {

                overflow-x: auto;
            }

        }


    </style>


    <?php
}