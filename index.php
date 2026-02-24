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
