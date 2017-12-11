<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

include_once("widgets/footer_contact.php");
include_once("widgets/header_address.php");
include_once("widgets/header_login.php");
include_once("widgets/header_phone.php");

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');
  add_theme_support('custom-logo', [
        // whatever settings
        'height' => 100,
        'width' => 400,
        'flex-width' => true,
    ]);

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'footer_navigation' => __('Footer Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
    register_sidebar([
      'name'          => __('Primary', 'sage'),
      'id'            => 'sidebar-primary',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>'
    ]);

    /* The widget area for the sub header */
    register_sidebar([
        'name'            => __('Header', 'sage'),
        'id'              => 'sidebar-header',
        'before_widget'   => '',
        'after_widget'    => '',
        'before_title'    => '<h3>',
        'after_title'     => '</h3>'
    ]);


    /* The widget area for the first footer column @Todo: Make these all the same colums, now these are all specific for one property*/
    register_sidebar([
        'name'          => __('Footer column 1', 'sage'),
        'id'            => 'sidebar-footer-column-1',
        'before_widget' => '<div class="footer-mission %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-mission-heading-title">',
        'after_title'   => '</h4>'
    ]);

    /* The widget area for the second footer column @Todo: Make these all the same colums, now these are all specific for one property */
    register_sidebar([
        'name'          => __('Footer column 2', 'sage'),
        'id'            => 'sidebar-footer-column-2',
        'before_widget' => '<div class="footer-articles %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-articles-heading-title">',
        'after_title'   => '</h4>'
    ]);

    /* The widget area for the third footer column @Todo: Make these all the same colums, now these are all specific for one property */
    register_sidebar([
        'name'          => __('Footer column 3', 'sage'),
        'id'            => 'sidebar-footer-column-3',
        'before_widget' => '<div class="footer-contact %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-contact-heading-title">',
        'after_title'   => '</h4>'
    ]);

    /* The widget area for the second footer column @Todo: Make these all the same colums, now these are all specific for one property */
    register_sidebar([
        'name'          => __('Footer column 4', 'sage'),
        'id'            => 'sidebar-footer-column-4',
        'before_widget' => '<div class="footer-twitter %1$s %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-twitter-heading-title">',
        'after_title'   => '</h4>'
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-components.php'),
    is_page_template('template-homepage.php'),
    is_page(),
    is_singular('organisation'), //No Sidebar on a
    is_singular('badges'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


//Disable the cover picture in buddypress
add_filter( 'bp_is_profile_cover_image_active', '__return_false' );
add_filter( 'bp_is_groups_cover_image_active', '__return_false' );

//Theme buddypress installation

function init_xprofile_fields(){
  // Insert New Field

  $field =  array (
             'field_id'        => 1001,
             'field_group_id'  => 2,
             'name'            => 'qwertyuiop',
             'field_order'     => 1,
             'is_required'     => false,
             'type'            => 'textbox'
      );


  $result = xprofile_get_field(1001);
  if(is_null($result->id)){
    //xprofile_insert_field($field);
  }
}
add_action('plugins_loaded',__NAMESPACE__ . '\\init_xprofile_fields');

function xprofile_get_field( $field, $user_id = null, $get_data = true ) {
    if ( $field instanceof BP_XProfile_Field ) {
        $_field = $field;
    } elseif ( is_object( $field ) ) {
        $_field = new BP_XProfile_Field();
        $_field->fill_data( $field );
    } else {
        $_field = BP_XProfile_Field::get_instance( $field, $user_id, $get_data );
    }
    if ( ! $_field ) {
        return null;
    }
    return $_field;
}
