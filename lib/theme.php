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
Add search bar to main menu
--------------------------------------------------*/
function your_custom_menu_item ( $items, $args ) {

    if( $args->menu->name == 'Main Menu')  {
        $url = home_url(); 
        $items .=   '<li>
                        <div class="search-form">
                            <a href="#" class="search-toggle"></a>
                            <form role="search" method="get" action="'. $url .'">
                                <input type="text" class="search-field" value="" name="s" />
                                <button type="submit" class="search-submit" value="Cerca">cerca</button>
                            </form>
                        </div>
                    </li>';
    }

    return $items;
}
add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\\your_custom_menu_item', 10, 2 );


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