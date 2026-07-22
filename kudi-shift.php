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

define( 'KUDI_SHIFT_PATH', plugin_dir_path( __FILE__ ) );
define( 'KUDI_SHIFT_URL', plugin_dir_url( __FILE__ ) );

require_once dirname(__FILE__) . '/helpers/enqueue_scripts.php';
require_once dirname(__FILE__) . '/helpers/custom-post-types.php';
require_once dirname(__FILE__) . '/helpers/custom-fields.php';
require_once dirname(__FILE__) . '/helpers/cpt-fixes.php';
require_once KUDI_SHIFT_PATH . 'includes/class-admin-page.php';
require_once KUDI_SHIFT_PATH . 'includes/api.php';

// Cargar el script de Vue solo donde lo necesites (shortcode, página, etc.)
function kudi_shift_enqueue_assets() {
  wp_enqueue_script(
    'kudi-shift-vue-app',
    KUDI_SHIFT_URL . 'build/app.js',
    array(),
    filemtime( KUDI_SHIFT_PATH . 'build/app.js' ),
    true
  );

  // Pasamos datos de PHP a Vue: nonce, URL del REST endpoint, etc.
  wp_localize_script( 'kudi-shift-vue-app', 'kudiShiftData', array(
    'restUrl' => esc_url_raw( rest_url( 'kudi-shift/v1/' ) ),
    'nonce'   => wp_create_nonce( 'wp_rest' ),
  ) );
}
add_action( 'wp_enqueue_scripts', 'kudi_shift_enqueue_assets' );
