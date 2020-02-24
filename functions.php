<?php
  function SWB_theme_setup() {
  add_theme_support( 'custom-logo' );
  add_theme_support( 'menus' );
  add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'SWB_theme_setup' );


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
    'page_title'  => 'Site Wide Settings',
    'menu_title'  => 'Site Wide Settings',
    'menu_slug'   => 'site-wide-settings',
    'capability'  => 'edit_posts',
    'redirect'    => true,
    'position'      => '1.99',
		));
		
		acf_add_options_sub_page(array(
			'page_title'  => 'Logo',
			'menu_title'  => 'Logo',
			'parent_slug' => 'site-wide-settings',
		));

		acf_add_options_sub_page(array(
			'page_title'  => 'Connect',
			'menu_title'  => 'Connect',
			'parent_slug' => 'site-wide-settings',
		));

		acf_add_options_sub_page(array(
			'page_title'  => 'Social Media Links',
			'menu_title'  => 'Social Media Links',
			'parent_slug' => 'site-wide-settings',
		));

		acf_add_options_sub_page(array(
			'page_title'  => 'Website Footer',
			'menu_title'  => 'Website Footer',
			'parent_slug' => 'site-wide-settings',
		));
}


function nullify_empty($value, $post_id, $field)
{
    if (empty($value)) {
        return null;
    }
    return $value;
}

add_filter('acf/format_value/type=image', 'nullify_empty', 100, 3);
add_filter('acf/format_value/type=relationship', 'nullify_empty', 100, 3);
add_filter('acf/format_value/type=repeater', 'nullify_empty', 100, 3);
add_filter('acf/format_value/type=gallery', 'nullify_empty', 100, 3);

// Load and preview buttons for Gatsby. //
function switchback_styles() { 
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/styles.css', array(), '1.1' );
}
add_action( 'admin_enqueue_scripts', 'switchback_styles' );

require_once('preview_button.php');
require_once('rebuild_button.php');
