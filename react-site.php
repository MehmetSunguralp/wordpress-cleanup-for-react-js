<?php
/*
Plugin Name: React Site
Version: 1.0
Description: Fullscreen React SPA container
*/

/* ---------- Disable admin bar completely ---------- */
add_filter('show_admin_bar', '__return_false');

/* ---------- Use blank template for React page ---------- */
add_filter('template_include', function ($template) {
  if (is_page() && has_shortcode(get_post()->post_content, 'react_app')) {
    return plugin_dir_path(__FILE__) . 'react-blank.php';
  }
  return $template;
});

/* ---------- Shortcode ---------- */
add_shortcode('react_app', function () {
  return '<div id="root"></div>';
});

/* ---------- Load ONLY React assets ---------- */
add_action('wp_enqueue_scripts', function () {

  if (!is_page() || !has_shortcode(get_post()->post_content, 'react_app')) {
    return;
  }

  // Remove ALL WordPress / theme assets
  global $wp_scripts, $wp_styles;
  if ($wp_scripts) $wp_scripts->queue = [];
  if ($wp_styles)  $wp_styles->queue  = [];

  $assets_path = plugin_dir_path(__FILE__) . 'build/assets/';
  $assets_url  = plugin_dir_url(__FILE__) . 'build/assets/';

  if (!is_dir($assets_path)) return;

  foreach (scandir($assets_path) as $file) {

    // CSS
    if (str_ends_with($file, '.css')) {
      wp_enqueue_style(
        'react-css',
        $assets_url . $file,
        [],
        null
      );
    }

    // JS – ONLY main entry (index-xxxx.js)
    if (str_ends_with($file, '.js') && str_contains($file, 'index')) {

      wp_enqueue_script(
        'react-js',
        $assets_url . $file,
        [],
        null,
        true
      );

      // Load as ES module
      add_filter('script_loader_tag', function ($tag, $handle, $src) {
        if ($handle === 'react-js') {
          return '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
      }, 10, 3);

      break;
    }
  }

}, 1000);
