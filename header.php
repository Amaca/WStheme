<?php
/**
 * @package WordPress
 * @subpackage wstheme
 * @since WS Theme
 */
 ?>

<?php
use Roots\WStheme\Setup;
use Roots\WStheme\Custom;
use Roots\WStheme\ACF;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php echo ( get_bloginfo('name') . ' - ' . get_bloginfo('description') ); ?></title>
    <meta charset="utf-8" />
    <link rel="icon" href="favicon.png" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> 
    <?php wp_head(); ?>
</head>
<body>

<div class="wrapper">

    <!-- Header -->
    <header class="header">
        <div class="container">
    
            <nav class="main-nav">
                <?php 
                wp_nav_menu( array
                    (
                    'menu' => 'Main Menu', 
                    'container' => false, 
                    'container_class' => false, 
                    'menu_id' => '',
                    'menu_class' => ''
                    )
                );
                ?>           
            </nav>

        </div>
    </header>
    <!-- /Header -->

    <?php get_template_part('partials/page_cover'); ?>

    <!-- Main -->
    <div class="main">