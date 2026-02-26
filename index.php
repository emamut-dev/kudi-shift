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
// require_once dirname(__FILE__) . '/helpers/custom-fields.php';

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