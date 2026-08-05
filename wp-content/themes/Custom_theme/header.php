<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title><?php bloginfo('name'); ?></title>

    <?php wp_head(); ?>
</head>

<body>

<header>

    <h1>Website</h1>

    <a href="<?php echo home_url('/'); ?>">Home</a>

    <a href="<?php echo home_url('/about'); ?>">About</a>

     <nav>
        <?php wp_nav_menu(['theme_location' => 'primary-menu']); ?>
    </nav>

    <hr>

</header>