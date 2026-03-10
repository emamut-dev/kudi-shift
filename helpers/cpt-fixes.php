<?php
add_action('admin_head', function() {
  global $post_type;
  if ($post_type === 'shifts') { // Cambia 'turno' por el slug de tu CPT
    echo '<style>
      #titlediv { display: none !important; }
    </style>';
  }
});

// Modificando shifts para eliminar la columna de título, ya que no es relevante para este CPT
add_filter( 'manage_shifts_posts_columns', function( $columns ) {
  unset( $columns['title'] );
  return $columns;
} );

add_filter( 'manage_shifts_posts_columns', function( $columns ) {
  $new_columns = [];
  $new_columns['fecha_turno'] = 'Fecha del Turno';
  $new_columns['jornada']   = 'Jornada';
  $new_columns['thumbnail'] = 'Imagen';
  return $new_columns + $columns;
} );

add_filter( 'manage_edit-shifts_sortable_columns', function( $sortable_columns ) {
  $sortable_columns['fecha_turno'] = 'fecha_turno';
  $sortable_columns['jornada'] = 'jornada';
  return $sortable_columns;
} );

add_action( 'manage_shifts_posts_custom_column', function( $column, $post_id ) {
    if( $column === 'fecha_turno' ) {
      $valor = get_field( 'fecha_turno', $post_id );
      echo $valor ? esc_html( $valor ) : '—';
    }

    if( $column === 'jornada' ) {
      $valor = get_field( 'jornada', $post_id );
      echo $valor->post_title ?? '—';
    }
}, 10, 2 );

// 1. Agregar la columna (y posicionarla antes del título)
add_filter( 'manage_sites_posts_columns', function( $columns ) {
    $new = [];

    foreach ( $columns as $key => $value ) {
        $new[ $key ] = $value;

        // insert thumbnail immediately after the title column
        if ( $key === 'title' ) {
            $new['thumbnail'] = 'Imagen';
        }
    }

    return $new;
} );

// 2. Mostrar el thumbnail
add_action( 'manage_sites_posts_custom_column', function( $column, $post_id ) {
    if ( $column === 'thumbnail' ) {
        $thumb = get_the_post_thumbnail( $post_id, 'full-size' );
        echo $thumb ?: '<span style="color:#aaa;">—</span>';
    }
}, 10, 2 );

// 3. Ajustar el ancho de la columna
add_action( 'admin_head', function() {
    $screen = get_current_screen();
    if ( $screen && $screen->post_type === 'sites' ) {
        echo '<style>
            .column-thumbnail { width: 500px; }
            .column-thumbnail img {
                width: 500px;
                height: 60px;
                object-fit: contain;
                object-position: center left;
                border-radius: 4px;
            }
        </style>';
    }
} );

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