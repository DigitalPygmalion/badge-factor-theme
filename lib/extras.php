<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function site_brand() {

    // default to the blog name, in case no logo is set
    $output = get_bloginfo( 'name' );

    if ( has_custom_logo() ) {

        // get the url for the image
        $logo_url = wp_get_attachment_url(get_theme_mod( 'custom_logo' ));

        // wrap in image tag, save as string
        $logo   = '<img src="' . $logo_url . '" class="header-main-logo-image">';

        // optional, hide the site name, screen reader friendly
        $output = '<span class="sr-only">' . get_bloginfo( 'name' ) . '</span>';

        // stick them together
        $output .= $logo;

    }

    return $output;

}
