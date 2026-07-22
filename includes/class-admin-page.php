<?php
class Kudi_Shift_Admin_Page {

  public function __construct() {
    add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
  }

  public function add_menu_page() {
    add_menu_page(
      'Mi Formulario Vue',      // Título de la página
      'Formulario Vue',         // Título en el menú
      'manage_options',         // Capacidad requerida
      'kudi-shift-formulario',  // Slug único
      array( $this, 'render_page' ), // Callback que pinta el HTML
      'dashicons-forms',        // Icono
      25                        // Posición en el menú
    );
  }

  public function render_page() {
    echo '<div class="wrap">';
    echo '<h1>Mi Formulario Vue + SCF</h1>';
    echo '<div id="kudi-shift-app"></div>'; // Aquí se monta Vue
    echo '</div>';
  }

  public function enqueue_assets( $hook ) {
    // Solo carga el script en NUESTRA página, no en todo el admin
    if ( $hook !== 'toplevel_page_kudi-shift-formulario' ) {
      return;
    }

    wp_enqueue_script(
      'kudi-shift-vue-app',
      KUDI_SHIFT_URL . 'build/app.js',
      array(),
      filemtime( KUDI_SHIFT_PATH . 'build/app.js' ),
      true
    );

    wp_localize_script( 'kudi-shift-vue-app', 'kudiShiftData', array(
      'restUrl' => esc_url_raw( rest_url( 'kudi-shift/v1/' ) ),
      'nonce'   => wp_create_nonce( 'wp_rest' ),
    ) );
  }
}

new Kudi_Shift_Admin_Page();