<?php

namespace Roots\WStheme\Wpml;


/*---------------------------------------------------
WPML - Translate strings
--------------------------------------------------*/
function lang($stringToTranslate, $echo) {
    if ($echo) {
        return _e($stringToTranslate, 'WStheme');
    } else {
        return __($stringToTranslate, 'WStheme');
    }
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
IP redirection
--------------------------------------------------*/
function ipRedir() {

    global $sitepress;
    global $pagesID;

    if ($pagesID->hostUrl == $pagesID->productionUrl) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

	if($_SERVER['REDIRECT_URL'] == ''){
        $url = 'http://geoip.websolute.it/ip2location/get_info.aspx?ipaddress=' . $ip;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $sessionResult = simplexml_load_string($result);
        $nazione = $sessionResult->CountryCode;
        if($nazione == 'SM') $nazione = 'IT';
        if(trim($nazione) == '-') $nazione = IT;

        $redir = ($nazione!='IT'?"en":"it");

        if($_SERVER['REQUEST_URI'] != '/wp-login.php'){

            if(!strstr($_SERVER['REQUEST_URI'],'wp-admin')){

                header("HTTP/1.1 301 Moved Permanently");
                header("Location: /".$redir."/");
	            exit();
            }
	    }
    }
}

add_action( 'init',  __NAMESPACE__ . '\\ipRedir', 5); //togli il commento per attivare il redirect


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