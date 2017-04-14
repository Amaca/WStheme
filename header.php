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
    <title><?php wp_title(''); ?></title>
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
                    'menu_class' => '',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</li></ul>'
                    )
                );
                ?>           
            </nav>

        </div>
    </header>
    <!-- /Header -->

    <?php get_template_part('partials/page_cover'); ?>

    <?php 
    if (is_singular('custom-post')) {
        $classCheck = 'custom-post';
    } else if ( is_post_type_archive('custom-post')) { 
        $classCheck = 'custom-post';
    } else if ( is_home()) { 
        $classCheck = 'listing'; 
    } else if (is_page_template('templates/hoempage.php')) {
        $classCheck = 'home';
    } else if (is_archive()) {
        $classCheck = 'listing';
    } else if (is_page()) {
        $classCheck = 'full-page';
    } else if (is_single()) {
        $classCheck = 'single-post';
    }
    ?>

    <!-- Main -->
    <div class="main <?php if (isset($classCheck)) { echo $classCheck; } ?>">