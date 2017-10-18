<?php
namespace Roots\WStheme\Setup;

/*---------------------------------------------------
Oggetto di configurazione con url custom
--------------------------------------------------*/
global $pagesID;

$host = 'http://'. $_SERVER['SERVER_NAME'];
$prodSite = 'http://www.nomesitoproduzione.net';  //cambiare nome sito con quello in produzione

if($host == $prodSite) {
    //produzione
    $pagesID = (object) [
        'templateUrl' => get_stylesheet_directory_uri(),
        'hostUrl' => $host,
        'productionUrl' => $prodSite,
        'blog' => 350,     //codice ID pagina blog per attivare campi ACF in index.php
        'contatti' => 14,  //codice ID pagina contatti per attivare mappa con main.js
    ];
} else {
    // locale e dev
    $pagesID = (object) [
        'templateUrl' => get_stylesheet_directory_uri(),
        'hostUrl' => $host,
        'productionUrl' => $prodSite,
        'blog' => 65,     //codice ID pagina blog per attivare campi ACF in index.php
        'contatti' => 24,  //codice ID pagina contatti per attivare mappa con main.js
    ];
}


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

    global $post;
    global $pagesID;

    if ( is_404()) {
        // invio l'oggetto di configurazione a javascript aggiungendo il POST ID della pagina
        $pagesID->isSinglePost = '';
        $pagesID->postID = '';
        $pagesID->isHome = '';
        $pagesID->isBlog = '';
    } else {
        $pagesID->isSinglePost = is_single($post->ID);
        $pagesID->postID = $post->ID;
        $pagesID->isHome = is_front_page($post->ID);
        $pagesID->isBlog = is_home($post->ID);
    }

    $JSinfo = (array) $pagesID;

    if (defined('WP_DEBUG') && true === WP_DEBUG) { //se è in debug mode prende da /src

        /*---------------------------------------------------
        JS INFO OBJECT DEBUG ON
        --------------------------------------------------*/
        $loadJsInfo = (object) [

            // isMobile
            'ismobile' =>
                    (object) [
                        'name'      => 'ismobile',
                        'url'       => get_template_directory_uri() . '/src/js/vendor/isMobile.js',
                        'deps'      => false,
                        'ver'       => '0.4.1',
                        'in_footer' => true
                    ],
            // jQuery Easing
            'easing'   =>
                    (object) [
                        'name'      => 'easing',
                        'url'       => get_template_directory_uri() . '/src/js/vendor/jquery.easing.min.js',
                        'deps'      => array('jquery'),
                        'ver'       => '1.3',
                        'in_footer' => true
                    ],
            // Slick Slider
            'slick'   =>
                    (object) [
                        'name'      => 'slick',
                        'url'       => get_template_directory_uri() . '/src/js/vendor/slick.js',
                        'deps'      => false,
                        'ver'       => '1.6.0',
                        'in_footer' => true
                    ],
            // Tether
            'tether'   =>
                    (object) [
                        'name'      => 'tether',
                        'url'       => get_template_directory_uri() . '/src/js/vendor/tether.js',
                        'deps'      => false,
                        'ver'       => '1.3.3',
                        'in_footer' => true
                    ],
            // Bootstrap
            'bootstrap' =>
                    (object) [
                        'name'      => 'bootstrap',
                        'url'       => get_template_directory_uri() . '/src/js/vendor/bootstrap.js',
                        'deps'      => false,
                        'ver'       => 'v4.0.0-alpha.5',
                        'in_footer' => true
                    ],
            // Main
            'main'   =>
                    (object) [
                        'name'      => 'main',
                        'url'       => get_template_directory_uri() . '/src/js/main.js',
                        'deps'      => false,
                        'ver'       => '1.0',
                        'in_footer' => true
                    ],
        ];

        /*---------------------------------------------------
        JS LOADER DEBUG ON
        --------------------------------------------------*/
        foreach ($loadJsInfo as $jsLibrary) {

            // promemoria inclusione js singolo:
            // wp_register_script( 'ismobile', get_template_directory_uri() . '/src/js/vendor/isMobile.js', false, '0.4.1', true ); wp_enqueue_script( 'ismobile' );

            wp_register_script( $jsLibrary->name, $jsLibrary->url, $jsLibrary->deps, $jsLibrary->ver, $jsLibrary->in_footer );
            wp_enqueue_script( $jsLibrary->name );

        }

        //localizzo lo script main per passare informazioni di WP a main.js
        wp_localize_script( 'main', 'wpToJs', $JSinfo );

    } else { //se non è in debug mode prende da /dist

        /*---------------------------------------------------
        JS LOADER DEBUG OFF
        --------------------------------------------------*/
        wp_register_script( 'main-min',
        get_template_directory_uri() . '/dist/js/main.min.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'main-min' );

        //localizzo lo script main per passare informazioni di WP ai file javascript
        wp_localize_script( 'main-min', 'wpToJs', $JSinfo );
    }

    /*---------------------------------------------------
    CSS INFO OBJECT
    --------------------------------------------------*/
    if (defined('WP_DEBUG') && true === WP_DEBUG) {
        $mainCss = (object) [
            'name'      => 'main-css',
            'url'       => get_template_directory_uri() . '/dist/css/main.css',
        ];
    } else {
        $mainCss = (object) [
            'name'      => 'main-css-min',
            'url'       => get_template_directory_uri() . '/dist/css/main.min.css',
        ];
    }

    $loadCssInfo = (object) [

        // isMobile
        'bootstrap-css' =>
                (object) [
                    'name'      => 'bootstrap-css',
                    'url'       => get_template_directory_uri() . '/dist/css/bootstrap.css',
                ],
        // Font Awesome
        'font-awesome' =>
                (object) [
                    'name'      => 'font-awesome',
                    'url'       => get_template_directory_uri() . '/dist/css/font-awesome.css',
                ],
		     // Slick
        'slick-css' =>
                (object) [
                    'name'      => 'slick-css',
                    'url'       => get_template_directory_uri() . '/dist/css/slick.css',
                ],
        // Slick
        'slick-theme' =>
                (object) [
                    'name'      => 'slick-theme',
                    'url'       => get_template_directory_uri() . '/dist/css/slick-theme.css',
                ],
        // Main CSS
        'main-css' => $mainCss,

    ];

    /*---------------------------------------------------
    CSS LOADER
    --------------------------------------------------*/
    foreach ($loadCssInfo as $cssLibrary) {

        // promemoria inclusione js singolo:
        // wp_register_style( 'main-css', get_template_directory_uri() . '/dist/css/main.css'); wp_enqueue_style( 'main-css' );

        wp_register_style( $cssLibrary->name, $cssLibrary->url);
        wp_enqueue_style( $cssLibrary->name );
    }

    //font
    //wp_register_style( 'font-hind','https://fonts.googleapis.com/css?family=Hind:400,500,600,700&amp;subset=latin-ext');
    //wp_enqueue_style( 'font-hind' );

}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\include_scripts' );


/*---------------------------------------------------
HOOK XDEFAULT
--------------------------------------------------*/
function hook_xdefault() {
    global $pagesID;
    if (is_front_page()) {
		echo'<link rel="alternate" hreflang="x-default" href="' . $pagesID->hostUrl . '" />'. PHP_EOL;

	}
}
add_action('wp_head',  __NAMESPACE__ . '\\hook_xdefault', 1);


/*---------------------------------------------------
DISABLE EMOJI
--------------------------------------------------*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
?>