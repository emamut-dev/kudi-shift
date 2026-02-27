<?php
/*
 * Plugin Name: Kudi Shift
 * Description: Plugin que permite obtener manualmente los tokens por modelo y por turno, generando los reportes necesarios para la administración del estudio.
 * Version: 1.0
 * Author: emamut
 * Author URI: https://emamut.netlify.app/
*/

// Evitar acceso directo
if (!defined('ABSPATH')) { exit; }

require_once dirname(__FILE__) . '/helpers/enqueue_scripts.php';
require_once dirname(__FILE__) . '/helpers/custom-post-types.php';
require_once dirname(__FILE__) . '/helpers/custom-fields.php';

add_action('admin_head', function() {
  global $post_type;

  if ($post_type === 'shifts') { // Cambia 'turno' por el slug de tu CPT
    echo '<style>
      #titlediv { display: none !important; }
    </style>';
  }
});

add_action('save_post_shift', function($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  $jornada    = get_post_meta($post_id, 'jornada', true);
  $fecha      = get_post_meta($post_id, 'fecha_turno', true);
  $new_title  = 'Turno - ' . $jornada . ' - ' . $fecha;

  remove_action('save_post_shift', __FUNCTION__);
  wp_update_post([
    'ID'         => $post_id,
    'post_title' => $new_title,
    'post_name'  => sanitize_title($new_title),
  ]);
});

// Capabilities personalizadas para los CPT "sites", "journal", "shift"

function add_theme_caps() {
  $roles = ['administrator', 'editor', 'contributor'];
  $capabilities = [
    'edit_site', 'read_site', 'delete_site', 'edit_sites', 'edit_others_sites', 'publish_sites', 'read_private_sites',
    'edit_journal', 'read_journal', 'delete_journal', 'edit_journals', 'edit_others_journals', 'publish_journals', 'read_private_journals',
    'edit_shift', 'read_shift', 'delete_shift', 'edit_shifts', 'edit_others_shifts', 'publish_shifts', 'read_private_shifts'
  ];

  foreach ($roles as $role_name) {
    $role = get_role($role_name);
    if ($role) {
      foreach ($capabilities as $cap) {
        $role->add_cap($cap);
      }
    }
  }
}
add_action('admin_init', 'add_theme_caps');