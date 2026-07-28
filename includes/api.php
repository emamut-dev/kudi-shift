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

  public function get_journal_by_id( $id ) {
    $journal = get_post( $id );

    if ( ! $journal || $journal->post_type !== 'journals' ) {
      return new WP_REST_Response( array( 'error' => 'Journal not found.' ), 404 );
    }

    return new WP_REST_Response( array(
      'id' => $journal->ID,
      'name' => $journal->post_title,
      'monitor' => get_field( 'monitora', $journal->ID ),
      'models' => get_field( 'modelos', $journal->ID ),
    ), 200 );
  }

  public function get_shifts() {
    $args = array(
      'post_type'   => 'shifts',
      'post_status' => 'publish',
      'numberposts' => -1,
      'orderby'     => 'post_title',
      'order'       => 'ASC',
    );

    $shifts = get_posts( $args );

    $data = array();
    foreach ( $shifts as $shift ) {
      $data[] = $this->get_complete_shift($shift);
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

  private function get_complete_shift($shift_object) {
    $contenido = json_decode($shift_object->post_content, true);
    $data_result = array();
    $previous_model = null;
    $last_key = null;
    $total_shift = 0;

    foreach ( $contenido['data'] as $key => $tokens ) {
      $key = explode( '-', $key );
      $model_data = $this->get_model_by_id($key[0]);
      $sitio_data = $this->get_site_by_id($key[1]);

      if ( $previous_model !== $key[0] ) {
        $data_result[] = array(
          'model' => $model_data['name'],
          $sitio_data['name'] => $tokens,
        );
        end( $data_result );
        $last_key = key( $data_result );
      } else {
        $data_result[ $last_key ][ $sitio_data['name'] ] = $tokens;
      }

      $previous_model = $key[0];
      $total_shift += $tokens;
    }

    return array(
      'id' => $shift_object->ID,
      'journal_date' => $this->format_date($shift_object->post_title),
      'journal_date_numeric' => intval($shift_object->post_title),
      'data' => $data_result,
      'total_shift' => $total_shift,
    );
  }

  private function get_model_by_id( $model_id ) {
    $model_data = get_user_by( 'id', $model_id );

    return array(
      'id' => $model_id,
      'name' => $model_data->display_name,
    );
  }

  private function get_site_by_id( $site_id ) {
    $args = array(
      'post_type' => 'sites',
      'post_status' => 'publish',
      'p' => $site_id,
    );

    $sites = get_posts( $args );

    if ( empty( $sites ) ) {
      return null;
    }

    $site = $sites[0];

    return array(
      'id' => $site->ID,
      'name' => $site->post_title,
      'thumbnail' => get_the_post_thumbnail_url( $site->ID, 'full' ),
    );
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
        if ( class_exists( 'IntlDateFormatter' ) ) {
          $formatter = new IntlDateFormatter(
            'es_CO',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            $date->getTimezone()->getName(),
            IntlDateFormatter::GREGORIAN,
            'EEEE dd-MM-yyyy'
          );

          return $formatter->format( $date );
        }

        setlocale( LC_TIME, 'es_CO.UTF-8', 'es_CO', 'es', 'Spanish_Colombia.1252' );
        return strftime( '%A %d-%m-%Y', $date->getTimestamp() );
      }
    }

    return '';
  }
}

new KUDI_SHIFT_REST_API();