<?php
namespace Roots\WStheme\Custom;

/*---------------------------------------------------
Image path
--------------------------------------------------*/
function image_path($imageName, $get) {
    if (!$get) {
        echo get_template_directory_uri() . '/dist/img/' . $imageName;
    } else {
        return get_template_directory_uri() . '/dist/img/' . $imageName;
    }
}


/*---------------------------------------------------
DEBUG Print inline
--------------------------------------------------*/
function print_inline($object) {
    echo '<pre>';
    print_r($object);
    echo '</pre>';
}


/*---------------------------------------------------
DEBUG Fixed console
--------------------------------------------------*/
function console($object) {
    echo '<div style="position: fixed; background: #444; right: 0; bottom: 50px;  z-index: 999999; color: #ffffff; padding: 20px; opacity: 0.9">';
    print_inline($object);
    echo '</div>';
}


/*---------------------------------------------------
Clean Excerpt
--------------------------------------------------*/
function excerpt_more() {
    return ' &hellip;';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


/*---------------------------------------------------
Excerpt lenght
--------------------------------------------------*/
function et_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', __NAMESPACE__ . '\\et_excerpt_length');


/*---------------------------------------------------
Custom Excerpt
--------------------------------------------------*/
function custom_excerpt($number) {

    $excerpt = get_the_content();
    if (strlen($excerpt) > $number) {
        $maxLength = $number;
        $excerpt = preg_replace("/<img[^>]+\>/i", "", $excerpt);
        $excerpt = (substr($excerpt, 0, $maxLength)) . '..."';
    }
    echo '<div class="text">' . $excerpt . '</div>';
}


/*---------------------------------------------------
Disable admin bar
--------------------------------------------------*/
function my_function_admin_bar(){
    return false;
}
add_filter( 'show_admin_bar' ,  __NAMESPACE__ . '\\my_function_admin_bar');


/*---------------------------------------------------
Allow SVG uploads
--------------------------------------------------*/
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes',  __NAMESPACE__ . '\\cc_mime_types');


/*---------------------------------------------------
Single post images
--------------------------------------------------*/
function add_classes_to_linked_images($html) {
    $classes = 'custom-image-class'; // can do multiple classes, separate with space / use fancybox for lightbox
    $pClass = 'wp-image';

    $patterns = array();
    $replacements = array();

    $patterns[0] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
    // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
    $replacements[0] = '<p class="' . $pClass . '"><a\1 class="' . $classes . '"><img\2></a></p>';

    $html = preg_replace($patterns, $replacements, $html);

    return $html;
}

add_filter('the_content', __NAMESPACE__ . '\\add_classes_to_linked_images', 100, 1);


/*---------------------------------------------------
Single post gallery
--------------------------------------------------*/
function my_post_gallery($output, $attr) {

    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    // Here's your actual output, you may customize it to your need
    $output = "<div class=\"blog-gallery\">\n";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
        $img = wp_get_attachment_image_src($id, 'medium');
        //      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
        $img = wp_get_attachment_image_src($id, 'full');

        $output .= "<div class=\"item\">\n";
        $output .= "<img src=\"{$img[0]}\"  alt=\"\" />\n";
        $output .= "</div>\n";
    }

    $output .= "</div>\n";

    return $output;
}
add_filter('post_gallery',  __NAMESPACE__ . '\\my_post_gallery', 10, 2);


/*---------------------------------------------------
Archive pagination
--------------------------------------------------*/
function pagination() {
    $prev = '';
    $next = '';
    $prev .= '<button class="whitebg" type="button">
            <div class="btntop">Precedenti</div>
          </button>';

    $next .= '<button class="whitebg" type="button">
            <div class="btntop">Successivi</div>
         </button>';
    posts_nav_link( ' ', $prev, $next );
}


/*---------------------------------------------------
Attributes to Prev/Next buttons
--------------------------------------------------*/
function posts_nextlink_attributes() {
    return 'class="next"';
}

function posts_prevlink_attributes() {
    return 'class="prev"';
}

add_filter('next_posts_link_attributes',  __NAMESPACE__ . '\\posts_nextlink_attributes');
add_filter('previous_posts_link_attributes',  __NAMESPACE__ . '\\posts_prevlink_attributes');


/*---------------------------------------------------
Search Filters
--------------------------------------------------*/
//function SearchFilter($query) {
//    if ($query->is_search) {
//        $query->set('post_type', array( 'progetto', 'ricerche' ) );
//    }
//    return $query;
//}
//add_filter('pre_get_posts', __NAMESPACE__ . '\\SearchFilter');


/*--------------------------------------------------
Crea le breadcrumbs
--------------------------------------------------*/
function create_breadcrumbs() {
    $home = 'Home';
    if ( !is_home() && !is_front_page() || is_paged() ) {
?>
<!-- Breadcrumb -->
<section id="breadcrumb">
    <div class="container">

        <ol class="breadcrumb">
            <?php

        global $post;
        $homeLink = get_bloginfo('url');
        echo '<li><a href="' . $homeLink . '">' . $home . '</a></li>';

        if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' '));
            echo '<li>' . single_cat_title('', false) . '</li>';

        } elseif ( is_day() ) {
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
            echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
            echo '<li>' . get_the_time('d') . '</li>';

        } elseif ( is_month() ) {
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
            echo '<li>' . get_the_time('F') . '</li>';

        } elseif ( is_year() ) {
            echo '<li>' . get_the_time('Y') . '</li>';

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                //echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
                echo '<li><a href="#" onclick="backClick()">' . $post_type->labels->singular_name . '</a></li>';
                echo '<li>' . get_the_title() . '</li>';
            ?>
            <script>
                            function backClick() {
                                if (document.referrer.indexOf(window.location.host) !== -1) {
                                    history.go(-1);
                                    return false;
                                } else {
                                    window.location.href = window.location.origin;
                                }
                            }
            </script>
            <?php
            } else {
                $cat = get_the_category();
                if ($cat){
                    $cat = $cat[0];
                    echo '<li>' . get_category_parents($cat, TRUE, ' ') . '</li>';
                }
                echo '<li>' . get_the_title() . '</li>';
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo '<li>' . $post_type->labels->singular_name . '</li>';

        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ');
            echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
            echo '<li>' . get_the_title() . '</li>';

        } elseif ( is_page() && !$post->post_parent ) {
            echo '<li>' . get_the_title() . '</li>';

        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ';
            echo '<li>' . get_the_title() . '</li>';

        } elseif ( is_search() ) {
            echo '<li>' . get_search_query() . '</li>';

        } elseif ( is_tag() ) {
            echo '<li>' . single_tag_title('', false) . '</li>';

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo '<li>' . $userdata->display_name . '</li>';

        } elseif ( is_404() ) {
            echo '<li>Error 404</li>';
        }

        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }

            ?>

        </ol>

    </div>
</section>
<!-- /Breadcrumb -->

<?php
    }
}
?>