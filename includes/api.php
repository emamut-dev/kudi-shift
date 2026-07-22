<?php
class KUDI_SHIFT_REST_API {

  public function __construct() {
    add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  public function register_routes() {
    register_rest_route( 'kudi-shift/v1', '/submit', array(
      'methods'             => 'POST',
      'callback'            => array( $this, 'handle_submit' ),
      'permission_callback' => '__return_true', // ajusta según tu caso
    ) );
  }

  public function handle_submit( WP_REST_Request $request ) {
    $params = $request->get_json_params();

    // Validación básica
    if ( empty( $params['titulo'] ) ) {
      return new WP_REST_Response( array( 'error' => 'Falta el título' ), 400 );
    }

    // Creamos (o actualizamos) el post
    $post_id = wp_insert_post( array(
      'post_type'   => 'sites', // tu custom post type
      'post_title'  => sanitize_text_field( $params['titulo'] ),
      'post_status' => 'publish',
    ) );

    if ( is_wp_error( $post_id ) ) {
      return new WP_REST_Response( array( 'error' => 'No se pudo guardar' ), 500 );
    }

    // Guardamos los campos SCF
    update_field( 'email_contacto', sanitize_email( $params['email'] ), $post_id );
    update_field( 'mensaje', sanitize_textarea_field( $params['mensaje'] ), $post_id );

    return new WP_REST_Response( array(
      'success' => true,
      'post_id' => $post_id,
    ), 200 );
  }
}

new KUDI_SHIFT_REST_API();