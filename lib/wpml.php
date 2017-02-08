<?php

namespace Roots\WStheme\Wpml;


/*---------------------------------------------------
WPML - Translate strings
--------------------------------------------------*/
function lang($stringToTranslate) {
    return __($stringToTranslate, 'WStheme');
}


/*---------------------------------------------------
Language Selector
--------------------------------------------------*/
function language_selector(){
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l){
            if(!$l['active']){
                echo '<a href="'.$l['url'].'">' . $l['translated_name'] . '</a>';
            }
        }
    }
}


/*--------------------------------------------------
Translating String through ACF and WPML
--------------------------------------------------*/

//function translateString($var){
//    if( have_rows('translation_string', 'option') ){
//        while( have_rows('translation_string', 'option') ):
//            the_row();
//            $varToTrans = get_sub_field('var');
//            if ($varToTrans == $var) {
//                $stringToTrans = get_sub_field('label');
//                if (!($stringToTrans)){
//                    //al momento WPML non permette di accedere alla variabile dell'altra lingua, da sistemare.
//                    if (ICL_LANGUAGE_CODE=='it'){
//                        echo 'da tradurre';
//                    } else {
//                        echo 'translate';
//                    }
//                } else {
//                    echo $stringToTrans;
//                }
//            }
//        endwhile;
//    }
//}


/*--------------------------------------------------
Get Translating String through ACF and WPML
--------------------------------------------------*/

//function getTranslateString($var){
//    if( have_rows('translation_string', 'option') ){
//        while( have_rows('translation_string', 'option') ):
//            the_row();
//            $varToTrans = get_sub_field('var');
//            if ($varToTrans == $var) {
//                $stringToTrans = get_sub_field('label');
//                return $stringToTrans;
//            }
//        endwhile;
//    }
//}

?>