<?php

/**
 * Enables support for post thumbnails in the theme.
 *
 * This function adds theme support for post thumbnails, allowing
 * featured images to be set for posts and custom post types.
 */
function enable_post_thumbnails() {
  if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
  }
}
add_action('after_setup_theme', 'enable_post_thumbnails');

/**
 * Registers the 'slider' custom post type.
 *
 * The 'slider' post type is created with the following properties:
 * - label: 'Sliders'
 * - public: true
 * - show_ui: true
 * - show_in_menu: true
 * - supports: array('title', 'editor', 'thumbnail')
 * - has_archive: true
 * - rewrite: array('slug' => 'sliders')
 * - menu_icon: 'dashicons-images-alt2'
 *
 * The 'slider' post type is used to store the title, description, and image of
 * a slider item.
 */
function create_slider_post_type() {
  if (function_exists('register_post_type')) {
    $args = array(
      'label'               => 'Sliders',
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'supports'            => array('title', 'editor', 'thumbnail'),
      'has_archive'         => true,
      'rewrite'             => array('slug' => 'sliders'),
      'menu_icon'           => 'dashicons-images-alt2',
    );
    register_post_type('slider', $args);
  }
}
add_action('init', 'create_slider_post_type');

/**
 * Register custom image size for 'Slider' post type
 */
function register_slider_image_size() {
  if (function_exists('add_image_size')) {
    add_image_size('slider_thumbnail', 300, 370, true);
  }
}
add_action('after_setup_theme', 'register_slider_image_size');

/**
 * get image
 */
function get_image($source = '')
{
	return get_template_directory_uri() . '/img/' . $source;
}

/**
 * Displays the slider block.
 *
 * Queries for 10 'slider' post type posts and displays them as slider cards.
 *
 * @since 1.0.0
 */
function display_slider() {
  ?>
  <div class="slider">
    <div class="swiper-container">
      <ul class="swiper-wrapper">
        <?php
          // Query for slider posts
          $args = array(
            'post_type' => 'slider',
            'posts_per_page' => 10,
          );

          $query = new WP_Query($args);

          if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
              // Get the slider card part
              get_template_part('parts/slider', 'card');
            endwhile;
          endif;
          wp_reset_postdata();
        ?>
      </ul>
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>

    <!-- Add Navigation -->
    <div class="swiper-button-next">
      <svg class='icon-chevron' width='24' height='24'>
        <use href='<?= get_image('icon/sprite.svg#icon-chevron') ?>'></use>
      </svg>
    </div>
    <div class="swiper-button-prev">
      <svg class='icon-chevron' width='24' height='24'>
        <use href='<?= get_image('icon/sprite.svg#icon-chevron') ?>'></use>
      </svg>
    </div>
  </div>
  <?php
}

/**
 * Displays a popup for a slider item.
 *
 * The popup contains a title and description for the slider item. The content
 * of the popup is populated dynamically using JavaScript.
 *
 * @since 1.0.0
 */
function display_slider_popup() {
  ?>
  <!-- Popup for Slider Item -->
  <div id="slider-popup" class="slider-popup mfp-hide">
    <h2 class="popup-title">Description</h2>
    <div class="popup-content"></div>
  </div>
  <?php
}

/**
 * Handles the AJAX request to get the description of a slider item.
 *
 * The function checks if post_id is passed in the request and
 * retrieves the description of the slider item with the given id.
 * The description is then returned in the response.
 *
 * @since 1.0.0
 */
function get_slider_description() {
  // Check if post_id is passed
  if (isset($_POST['post_id'])) {
    $post_id = intval($_POST['post_id']);

    $description = get_the_content(null, false, $post_id);

    // Return the description in the response
    wp_send_json_success(['description' => $description]);
  } else {
    wp_send_json_error();
  }

  // Don't forget to die in the end
  wp_die();
}
add_action('wp_ajax_get_slider_description', 'get_slider_description');
add_action('wp_ajax_nopriv_get_slider_description', 'get_slider_description');

