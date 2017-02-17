<?php

namespace Roots\WStheme\Theme;

/*---------------------------------------------------
Register Custom Menus
--------------------------------------------------*/
register_nav_menus( array(
    'main_menu' => 'Menù principale di testata',
    'footer_menu' => 'Menù secondario su footer',
) );


/*---------------------------------------------------
Register Sidebar
--------------------------------------------------*/
function widgets_init() {
    register_sidebar([
      'name'          => __('Primary', 'wstheme'),
      'id'            => 'sidebar-primary',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>'
    ]);

    register_sidebar([
      'name'          => __('Footer', 'wstheme'),
      'id'            => 'sidebar-footer',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>'
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');


?>