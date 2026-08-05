<?php
function register_sites_post_type()
{
  $labels = array(
    'name' => _x('Sitios', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Sitio', 'Post Type Singular Name', 'kudi-shift'),
    'menu_name' => __('Sitios', 'kudi-shift'),
    'name_admin_bar' => __('Sitio', 'kudi-shift'),
    'archives' => __('Archivo de sitios', 'kudi-shift'),
    'attributes' => __('Atributos del sitio', 'kudi-shift'),
    'parent_item_colon' => __('Sitio padre:', 'kudi-shift'),
    'all_items' => __('Todos los sitios', 'kudi-shift'),
    'add_new_item' => __('Añadir nuevo sitio', 'kudi-shift'),
    'add_new' => __('Añadir sitio', 'kudi-shift'),
    'new_item' => __('Nuevo sitio', 'kudi-shift'),
    'edit_item' => __('Editar sitio', 'kudi-shift'),
    'update_item' => __('Actualizar sitio', 'kudi-shift'),
    'view_item' => __('Ver sitio', 'kudi-shift'),
    'view_items' => __('Ver sitios', 'kudi-shift'),
    'search_items' => __('Buscar sitio', 'kudi-shift'),
    'not_found' => __('No se encontró', 'kudi-shift'),
    'not_found_in_trash' => __('No se encontró en la papelera', 'kudi-shift'),
    'featured_image' => __('Imagen destacada', 'kudi-shift'),
    'set_featured_image' => __('Elegir imagen destacada', 'kudi-shift'),
    'remove_featured_image' => __('Remover imagen destacada', 'kudi-shift'),
    'use_featured_image' => __('Usar como imagen destacada', 'kudi-shift'),
    'insert_into_item' => __('Agregar al sitio', 'kudi-shift'),
    'uploaded_to_this_item' => __('Subido a este sitio', 'kudi-shift'),
    'items_list' => __('Lista de sitios', 'kudi-shift'),
    'items_list_navigation' => __('Navegación de lista de sitios', 'kudi-shift'),
    'filter_items_list' => __('Filtrar lista de sitios', 'kudi-shift'),
  );

  $rewrite = array(
    'slug' => 'Ssitios',
    'with_front' => true,
    'pages' => true,
    'feeds' => true,
  );

  $args = array(
    'label' => __('Sitios', 'kudi-shift'),
    'description' => __('Sitios', 'kudi-shift'),
    'labels' => $labels,
    'supports' => array('title', 'thumbnail'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => current_user_can('manage_options'),
    'show_in_menu' => current_user_can('manage_options'),
    'menu_position' => 32,
    'menu_icon' => 'dashicons-video-alt2',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => false,
    'rewrite' => $rewrite,
    'capabilities' => array(
      'edit_post' => 'edit_site',
      'read_post' => 'read_site',
      'delete_post' => 'delete_site',
      'edit_posts' => 'edit_sites',
      'edit_others_posts' => 'edit_others_sites',
      'publish_posts' => 'publish_sites',
      'read_private_posts' => 'read_private_sites',
    ),
    'show_in_rest' => true
  );

  register_post_type('sites', $args);
}
add_action('init', 'register_sites_post_type', 0);

function register_journals_post_type()
{
  $labels = array(
    'name' => _x('Jornadas', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Jornadas', 'Post Type Singular Name', 'kudi-shift'),
    'menu_name' => __('Jornadas', 'kudi-shift'),
    'name_admin_bar' => __('Jornada', 'kudi-shift'),
    'archives' => __('Archivo de jornadas', 'kudi-shift'),
    'attributes' => __('Atributos de la jornada', 'kudi-shift'),
    'parent_item_colon' => __('Jornada padre:', 'kudi-shift'),
    'all_items' => __('Todos las jornadas', 'kudi-shift'),
    'add_new_item' => __('Añadir nueva jornada', 'kudi-shift'),
    'add_new' => __('Añadir jornada', 'kudi-shift'),
    'new_item' => __('Nueva jornada', 'kudi-shift'),
    'edit_item' => __('Editar jornada', 'kudi-shift'),
    'update_item' => __('Actualizar jornada', 'kudi-shift'),
    'view_item' => __('Ver jornada', 'kudi-shift'),
    'view_items' => __('Ver jornadas', 'kudi-shift'),
    'search_items' => __('Buscar jornada', 'kudi-shift'),
    'not_found' => __('No se encontró', 'kudi-shift'),
    'not_found_in_trash' => __('No se encontró en la papelera', 'kudi-shift'),
    'featured_image' => __('Imagen destacada', 'kudi-shift'),
    'set_featured_image' => __('Elegir imagen destacada', 'kudi-shift'),
    'remove_featured_image' => __('Remover imagen destacada', 'kudi-shift'),
    'use_featured_image' => __('Usar como imagen destacada', 'kudi-shift'),
    'insert_into_item' => __('Agregar a la jornada', 'kudi-shift'),
    'uploaded_to_this_item' => __('Subido a esta jornada', 'kudi-shift'),
    'items_list' => __('Lista de jornadas', 'kudi-shift'),
    'items_list_navigation' => __('Navegación de lista de jornadas', 'kudi-shift'),
    'filter_items_list' => __('Filtrar lista de jornadas', 'kudi-shift'),
  );

  $rewrite = array(
    'slug' => 'jornada',
    'with_front' => true,
    'pages' => true,
    'feeds' => true,
  );

  $args = array(
    'label' => __('Jornada', 'kudi-shift'),
    'description' => __('Jornadas', 'kudi-shift'),
    'labels' => $labels,
    'supports' => array('title'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => current_user_can('manage_options'),
    'show_in_menu' => current_user_can('manage_options'),
    'menu_position' => 32,
    'menu_icon' => 'dashicons-clock',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => false,
    'rewrite' => $rewrite,
    'capabilities' => array(
      'edit_post' => 'edit_journal',
      'read_post' => 'read_journal',
      'delete_post' => 'delete_journal',
      'edit_posts' => 'edit_journals',
      'edit_others_posts' => 'edit_others_journals',
      'publish_posts' => 'publish_journals',
      'read_private_posts' => 'read_private_journals',
    ),
    'show_in_rest' => true
  );

  register_post_type('journals', $args);
}
add_action('init', 'register_journals_post_type', 0);

function register_shifts_post_type()
{
  $labels = array(
    'name' => _x('Turnos', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Turno', 'Post Type Singular Name', 'kudi-shift'),
    'menu_name' => __('Turnos', 'kudi-shift'),
    'name_admin_bar' => __('Turno', 'kudi-shift'),
    'archives' => __('Archivo de turnos', 'kudi-shift'),
    'attributes' => __('Atributos del turno', 'kudi-shift'),
    'parent_item_colon' => __('Turno padre:', 'kudi-shift'),
    'all_items' => __('Todos los turnos', 'kudi-shift'),
    'add_new_item' => __('Añadir nuevo turno', 'kudi-shift'),
    'add_new' => __('Añadir turno', 'kudi-shift'),
    'new_item' => __('Nuevo turno', 'kudi-shift'),
    'edit_item' => __('Editar turno', 'kudi-shift'),
    'update_item' => __('Actualizar turno', 'kudi-shift'),
    'view_item' => __('Ver turno', 'kudi-shift'),
    'view_items' => __('Ver turnos', 'kudi-shift'),
    'search_items' => __('Buscar turno', 'kudi-shift'),
    'not_found' => __('No se encontró', 'kudi-shift'),
    'not_found_in_trash' => __('No se encontró en la papelera', 'kudi-shift'),
    'featured_image' => __('Imagen destacada', 'kudi-shift'),
    'set_featured_image' => __('Elegir imagen destacada', 'kudi-shift'),
    'remove_featured_image' => __('Remover imagen destacada', 'kudi-shift'),
    'use_featured_image' => __('Usar como imagen destacada', 'kudi-shift'),
    'insert_into_item' => __('Agregar al turno', 'kudi-shift'),
    'uploaded_to_this_item' => __('Subido a este turno', 'kudi-shift'),
    'items_list' => __('Lista de turnos', 'kudi-shift'),
    'items_list_navigation' => __('Navegación de lista de turnos', 'kudi-shift'),
    'filter_items_list' => __('Filtrar lista de turnos', 'kudi-shift'),
  );

  $rewrite = array(
    'slug' => 'turno',
    'with_front' => true,
    'pages' => true,
    'feeds' => true,
  );

  $args = array(
    'label' => __('turno', 'kudi-shift'),
    'description' => __('turnos', 'kudi-shift'),
    'labels' => $labels,
    'supports' => array('title', 'editor'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 32,
    'menu_icon' => 'dashicons-no',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => false,
    'rewrite' => $rewrite,
    'capabilities' => array(
      'edit_post' => 'edit_shift',
      'read_post' => 'read_shift',
      'delete_post' => 'delete_shift',
      'edit_posts' => 'edit_shifts',
      'edit_others_posts' => 'edit_others_shifts',
      'publish_posts' => 'publish_shifts',
      'read_private_posts' => 'read_private_shifts',
    ),
    'show_in_rest' => true
  );

  register_post_type('shifts', $args);
}
add_action('init', 'register_shifts_post_type', 0);