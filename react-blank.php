<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts (React controls typography) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&family=Urbanist:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet"
  />
<?php
$assets_dir = plugin_dir_url(__FILE__) . 'build/assets/';
$files = scandir(plugin_dir_path(__FILE__) . 'build/assets/');
foreach ($files as $file) {
  if (str_ends_with($file, '.css')) {
    echo '<link rel="stylesheet" href="' . esc_url($assets_dir . $file) . '">' . PHP_EOL;
  }
}
?>

  <?php wp_head(); ?>
</head>

<body style="margin:0; padding:0;">
  <?php echo do_shortcode('[react_app]'); ?>
  <?php wp_footer(); ?>
</body>
</html>
