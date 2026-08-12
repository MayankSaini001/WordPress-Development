<?php
/*
Plugin Name: Custom Login
Description: Custom WordPress Login System
Author: Mayank Saini
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit;
}


/*Login Form Shortcode*/

function custom_login_form()
{
    ob_start();
    ?>

    <h2>Custom Login</h2>

    <?php
    if (isset($_GET['login']) && $_GET['login'] === 'failed') {
        echo '<p style="color:red;">Invalid username or password.</p>';
    }
    ?>

    <form method="POST">

        <?php
        wp_nonce_field(
            'custom_login',
            'custom_login_nonce'
        );
        ?>

        <p>
            <label>Username or Email</label>
            <br>

            <input
                type="text"
                name="username"
                required
            >
        </p>

        <p>
            <label>Password</label>
            <br>

            <input
                type="password"
                name="password"
                required
            >
        </p>

        <p>
            <label>
                <input
                    type="checkbox"
                    name="remember"
                >
                Remember Me
            </label>
        </p>

        <button
            type="submit"
            name="custom_login"
        >
            Login
        </button>

    </form>

    <?php

    return ob_get_clean();
}


/*Process Login*/

function custom_process_login()
{
    /*Check Form Submit*/

    if (!isset($_POST['custom_login'])) {
        return;
    }


    /*Verify Nonce*/

    if (
        !isset($_POST['custom_login_nonce']) ||
        !wp_verify_nonce(
            $_POST['custom_login_nonce'],
            'custom_login'
        )
    ) {
        wp_die('Security check failed.');
    }


    /*Get Form Data*/

    $username = sanitize_text_field(
        $_POST['username']
    );

    $password = $_POST['password'];

    $remember = isset($_POST['remember']);


    /*Login Credentials*/

    $credentials = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember,
    );


    /*WordPress Login*/

    $user = wp_signon(
        $credentials,
        false
    );


    /*Check Login Error*/

    if (is_wp_error($user)) {

        echo '<h3>Login Failed</h3>';

        echo '<p>';
        echo esc_html(
            $user->get_error_message()
        );
        echo '</p>';

        exit;
    }


    /*Login Successful*/

    wp_safe_redirect(
        home_url('/dashboard/')
    );

    exit;
}


/*Hooks*/

add_action(
    'init',
    'custom_process_login'
);


/*Register Shortcode*/

add_shortcode(
    'custom_login',
    'custom_login_form'
);