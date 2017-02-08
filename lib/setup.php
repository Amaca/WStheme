<?php

namespace Roots\WStheme\Setup;


/*--------------------------------------------------
Inclusione JQUERY
--------------------------------------------------*/
function switch_jquery(){
    if ( !is_admin() ){
        wp_deregister_script('jquery');
        wp_register_script('jquery', ( get_template_directory_uri() . '/dist/js/vendor/jquery-3.1.0.min.js'), false, '3.1.0', false);
        wp_enqueue_script('jquery');

    }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\switch_jquery');


/*---------------------------------------------------
Including scripts
--------------------------------------------------*/
function include_scripts(){

    if (defined('WP_DEBUG') && true === WP_DEBUG) { //se è in debug mode prende da /src

        wp_register_script( 'ismobile',
        get_template_directory_uri() . '/src/js/vendor/isMobile.js', false, '0.4.1', true );
        wp_enqueue_script( 'ismobile' );

        wp_register_script( 'easing',
        get_template_directory_uri() . '/src/js/vendor/jquery.easing.min.js', array('jquery') , '1.3', true );
        wp_enqueue_script( 'easing' );

        wp_register_script( 'slick',
        get_template_directory_uri() . '/src/js/vendor/slick.js', false, '1.6.0', true );
        wp_enqueue_script( 'slick' );

        wp_register_script( 'tether',
        get_template_directory_uri() . '/src/js/vendor/tether.js', false, '1.3.3', true );
        wp_enqueue_script( 'tether' );

        wp_register_script( 'bootstrap',
        get_template_directory_uri() . '/src/js/vendor/bootstrap.js', false, 'v4.0.0-alpha.5', true );
        wp_enqueue_script( 'bootstrap' );

        wp_register_script( 'main',
        get_template_directory_uri() . '/src/js/main.js', false, '1.0', true );
        wp_enqueue_script( 'main' );

        $themePath = array( 'templateUrl' => get_stylesheet_directory_uri() );
        //localizzo lo script main per passare la path del tema a main.js
        wp_localize_script( 'main', 'mainTheme', $themePath );

        //css
        wp_register_style( 'bootstrap-css',
        get_template_directory_uri() . '/dist/css/bootstrap.css');
        wp_enqueue_style( 'bootstrap-css' );

        wp_register_style( 'font-awesome',
        get_template_directory_uri() . '/dist/css/font-awesome.css');
        wp_enqueue_style( 'font-awesome' );

        wp_register_style( 'main-css',
        get_template_directory_uri() . '/dist/css/main.css');
        wp_enqueue_style( 'main-css' );

    } else { //se non è in debug mode prende da /dist
           
        wp_register_script( 'main-min', 
        get_template_directory_uri() . '/dist/js/main.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'main-min' );

        $themePath = array( 'templateUrl' => get_stylesheet_directory_uri() );
        //localizzo lo script main per passare la path del tema a main.min.js
        wp_localize_script( 'main-min', 'mainTheme', $themePath );

        //css
        wp_register_style( 'bootstrap-css',
        get_template_directory_uri() . '/dist/css/bootstrap.min.css');
        wp_enqueue_style( 'bootstrap-css' );

        wp_register_style( 'font-awesome',
        get_template_directory_uri() . '/dist/css/font-awesome.css');
        wp_enqueue_style( 'font-awesome' );

        wp_register_style( 'main-css',
        get_template_directory_uri() . '/dist/css/main.min.css');
        wp_enqueue_style( 'main-css' );

    }
    //font
    wp_register_style( 'font-hind','https://fonts.googleapis.com/css?family=Hind:400,500,600,700&amp;subset=latin-ext');
    wp_enqueue_style( 'font-hind' );
 
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\include_scripts' );

?>