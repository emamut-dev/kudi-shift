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

// Agregar el menú al wp-admin
function add_menu_item() {
  add_menu_page(
    'Reporte de Tokens',           // Título de la página (tag <title>)
    'Turnos',           // Texto del menú lateral
    'manage_options',      // Capacidad requerida
    'kudi-shift',           // Slug único de la página
    'kudi_shift_render',    // Función que renderiza el contenido
    'dashicons-money-alt', // Ícono (dashicon o URL)
    30                     // Posición en el menú
  );
}
add_action('admin_menu', 'add_menu_item');

// Contenido de la página
function kudi_shift_render() {
  // Verificar permisos
  if (!current_user_can('manage_options')) {
    wp_die('No tienes permisos para acceder a esta página.');
  }
  ?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <p>Bienvenido a mi plugin.</p>
  </div>
  <?php
}