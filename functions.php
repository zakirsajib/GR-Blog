<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
	function chld_thm_cfg_locale_css( $uri ){
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
			$uri = get_template_directory_uri() . '/rtl.css';
		return $uri;
	}
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION
if ( !function_exists( 'child_theme_configurator_css' ) ):
	function child_theme_configurator_css() {
		wp_enqueue_style( 'globerunner-swiper',  get_stylesheet_directory_uri() . '/assets/css/swiper.min.css' );
		wp_enqueue_style( 'globerunner-main',  get_stylesheet_directory_uri() . '/assets/css/main.css' );
		wp_enqueue_style( 'globerunner-output',  get_stylesheet_directory_uri() . '/output.css' );
		wp_enqueue_style( 'globerunner-style',  get_stylesheet_directory_uri() . '/style.css' );

		wp_enqueue_script( 'globerunner-video-lazyload',  get_stylesheet_directory_uri() . '/assets/js/video.lazyload.js', array( 'jquery', 'globerunner-swiper' ), null, true );
		wp_enqueue_script( 'globerunner-swiper',  get_stylesheet_directory_uri() . '/assets/js/swiper.min.js', null , null, true );
		wp_enqueue_script( 'globerunner-main',  get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery', 'globerunner-swiper' ), null, true );

		// Zakir Added
		wp_enqueue_script( 'globerunner-blog-code',  get_stylesheet_directory_uri() . '/assets/js/blog2.js', array( 'jquery', 'globerunner-swiper' ), null, true );

		wp_localize_script(
			'globerunner-main',
			'ajax_obj',
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		);


	}
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

add_action( 'admin_enqueue_scripts', function(){
	wp_enqueue_script( 'globerunner-admin-main',  get_stylesheet_directory_uri() . '/assets/js/admin-main.js', array( 'jquery' ), null, true );
	wp_enqueue_style( 'globerunner-main-admin',  get_stylesheet_directory_uri() . '/assets/css/main.css' );
}, 99 );

function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

require_once( get_stylesheet_directory() . '/inc/theme-functions.php');
//
require_once( get_stylesheet_directory() . '/inc/acf-gutenberg-blocks.php');
//
require_once( get_stylesheet_directory() . '/inc/init.php');
//
require_once( get_stylesheet_directory() . '/inc/filters.php');

// Custom post types
require_once( get_stylesheet_directory() . '/post-type/team.php');

require_once( get_stylesheet_directory() . '/post-type/case-studies.php');

require_once( get_stylesheet_directory() . '/post-type/testimonial.php');

// hooks
//require_once( get_stylesheet_directory() . '/hooks/google-tag-manager.php');

// widgets
require_once( get_stylesheet_directory() . '/widget/menu-posts.php');

require_once( get_stylesheet_directory() . '/widget/menu-pages.php');



add_shortcode( 'hubspot-contact', 'gr_insert_hubspot_form' );
function gr_insert_hubspot_form() {

	echo '
	<!--[if lte IE 8]>
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
<![endif]-->
<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
<script>
  hbspt.forms.create({
	region: "na1",
	portalId: "20012294",
	formId: "af3865fe-b1b6-4357-ae2e-6d2543ad9bbb"
});
</script>

';

}


//Insert banner after half way through of single post content.

add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {

		$ad_code = '<div class="banner-fig" style="padding-bottom:2rem;"><a href="http://globerunner-20012294.hs-sites.com/10-key-seo-ranking-factors" target="_blank"><img src="https://globerunner.com/wp-content/uploads/2022/08/SEO-Bumper-for-Workflow.png" alt="banner" /></a></div>';

		// We are putting banner in Halfway through the article
		$placement = __check_paragraph_count_blog($content);
		$placement = ceil($placement/2);

    if ( is_single() && ! is_admin() && in_category('SEO') ) {
        return dispatch_prefix_insert_after_paragraph( $ad_code, $placement, $content );
    }

    return $content;

}

// Parent Function that makes the magic happen

function dispatch_prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {

        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }

        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }

    return implode( '', $paragraphs );
}

// Get the total count of paragraph in article.
function __check_paragraph_count_blog( $content ) {
    global $post;
    if ( $post->post_type == 'post' ) {
        $count = substr_count( $content, '</p>' );
        return $count;
    } else {
        return 0;
    }
}
