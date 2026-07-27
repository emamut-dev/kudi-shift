<?php
class KUDI_SHIFT_REST_API {

  public function __construct() {
    add_action( 'rest_api_init', array( $this, 'register_routes' ) );
  }

  public function register_routes() {
    register_rest_route( 'kudi-shift/v1', '/journals', array(
      'methods'             => 'GET',
      'callback'            => array( $this, 'get_journals' ),
      'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'kudi-shift/v1', '/sitios', array(
      'methods'             => 'GET',
      'callback'            => array( $this, 'get_sitios' ),
      'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'kudi-shift/v1', '/shifts', array(
      'methods'             => 'GET',
      'callback'            => array( $this, 'get_shifts' ),
      'permission_callback' => '__return_true',
    ) );

    register_rest_route( 'kudi-shift/v1', '/shifts', array(
      'methods'             => 'POST',
      'callback'            => array( $this, 'save_shift' ),
      'permission_callback' => '__return_true',
    ) );
  }

  public function get_journals() {
    $args = array(
      'post_type' => 'journals',
      'post_status' => 'publish',
      'numberposts' => -1,
    );

    $journals = get_posts( $args );

    $data = array();

    foreach ( $journals as $journal ) {
      $data[] = array(
        'id' => $journal->ID,
        'name' => $journal->post_title,
        'monitor' => get_field( 'monitora', $journal->ID ),
        'models' => get_field( 'modelos', $journal->ID ),
      );
    }

    return new WP_REST_Response( $data, 200 );
  }

  public function get_shifts() {
    $args = array(
      'post_type' => 'shifts',
      'post_status' => 'publish',
      'numberposts' => -1,
    );

    $shifts = get_posts( $args );

    $data = array();
    foreach ( $shifts as $shift ) {
      $data[] = array(
        'id' => $shift->ID,
        'fecha_turno' => $this->format_date( $shift->post_title ),
        'contenido' => apply_filters( 'post_content', $shift->post_content ),
      );
    }
    return new WP_REST_Response( $data, 200 );
  }

  public function get_sitios() {
    $args = array(
      'post_type' => 'sites',
      'post_status' => 'publish',
      'numberposts' => -1,
    );

    $sitios = get_posts( $args );

    $data = array();
    foreach ( $sitios as $sitio ) {
      $data[] = array(
        'id' => $sitio->ID,
        'name' => $sitio->post_title,
        'thumbnail' => get_the_post_thumbnail_url( $sitio->ID, 'full' ),
      );
    }
    return new WP_REST_Response( $data, 200 );
  }

  public function save_shift( WP_REST_Request $request ) {
    $params = $request->get_json_params();
    if ( empty( $params ) ) {
      $raw_body = $request->get_body();
      $params = json_decode( $raw_body, true );
    }

    if ( ! is_array( $params ) || empty( $params ) ) {
      return new WP_REST_Response( array( 'error' => 'Invalid JSON payload.' ), 400 );
    }

    $journal_date = isset( $params['journal_date'] ) ? $this->date_to_numeric( $params['journal_date'] ) : 0;

    $shift_post = array(
      'post_title' => $journal_date,
      'post_content' => wp_json_encode( $params['contenido'] ),
      'post_status' => 'publish',
      'post_type' => 'shifts',
    );

    $shift_id = wp_insert_post( $shift_post );

    if ( is_wp_error( $shift_id ) ) {
      return new WP_REST_Response( array( 'error' => $shift_id->get_error_message() ), 500 );
    }

    return new WP_REST_Response( array( 'id' => $shift_id ), 201 );
  }

  private function date_to_numeric( $date_string ) {
    foreach ( array( 'Ymd', 'Y-m-d', 'd/m/Y', 'd-m-Y' ) as $format ) {
      $date = DateTime::createFromFormat( $format, $date_string );
      $errors = DateTime::getLastErrors();

      if ( $date && ( $errors === false || ( $errors['warning_count'] === 0 && $errors['error_count'] === 0 ) ) ) {
        return intval( $date->format( 'Ymd' ) );
      }
    }

    $timestamp = strtotime( $date_string );
    if ( $timestamp !== false ) {
      return intval( date( 'Ymd', $timestamp ) );
    }

    return 0;
  }

  private function format_date( $date_string ) {
    foreach ( array( 'Ymd', 'd/m/Y', 'Y-m-d' ) as $format ) {
      $date = DateTime::createFromFormat( $format, $date_string );
      $errors = DateTime::getLastErrors();

      if ( $date && ( $errors === false || ( $errors['warning_count'] === 0 && $errors['error_count'] === 0 ) ) ) {
        return $date->format( 'l d-m-Y' );
      }
    }

    return '';
  }
}

new KUDI_SHIFT_REST_API();