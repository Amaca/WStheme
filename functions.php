<?php

/**
 * WS Theme Includes Readme
 *
 * The $wstheme_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 * To use functions on your .php files, you need to include your lib files using "use" command, for example:
 *
 * use Roots\WStheme\Custom;
 * use Roots\WStheme\ACF;
 * 
 * after that, you can request your function with the correct path, in this example case:
 * 
 * Custom\myCustomfunction(); or ACF\myAcfFunction(); etc
 *
 * To use a Wordpress Filter, you have to use the __NAMESPACE__ constant like this:
 * 
 * add_filter('next_posts_link_attributes',  __NAMESPACE__ . '\\posts_nextlink_attributes');
 * 
 * or you'll produce an error.
 *
 * For more informations you can contact mcarlett@websolute.it 
 * or read the Namespace section here: roots.io/upping-php-requirements-in-your-wordpress-themes-and-plugins
 * Namespaces structure based on Sage Theme
 * 
 * Websolute Rocks!
 * 
 */

$wstheme_includes = [
'lib/setup.php',           // Scripts and stylesheets
'lib/theme.php',           // Theme setup
'lib/custom.php',          // Custom functions
//'lib/acf.php',             // ACF functions
//'lib/woocommerce.php',     // Woocoommerce functions
//'lib/wpml.php'             // WPML functions
];

foreach ($wstheme_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);



?>