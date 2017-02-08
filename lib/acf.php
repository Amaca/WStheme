<?php

namespace Roots\WStheme\ACF;


/*---------------------------------------------------
Include partial lines through ACF
--------------------------------------------------*/
function lines_loader($acfLineName, $postID) {
    $fields = get_fields($postID);
    $sections = $fields[$acfLineName];

    $s = 1;
    foreach($sections as $section){
        if ( ($section) ) {
            include(locate_template('partials/'.$section['acf_fc_layout'].'.php'));
        }
        $s++;
    }
}


/*---------------------------------------------------
ACF Option page
--------------------------------------------------*/
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


?>