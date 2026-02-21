<?php
function kudi_shift_scripts() {
  wp_enqueue_script('app', plugin_dir_url(__FILE__) . 'js/app.js', ['jquery'], '1.0', true);

  $current_user = wp_get_current_user();

  wp_localize_script('kudi-shift', 'KudiShift', [
    'userRoles' => $current_user->roles,
    'isAdmin'   => current_user_can('administrator'),
  ]);
}
add_action('wp_enqueue_scripts', 'kudi_shift_scripts');