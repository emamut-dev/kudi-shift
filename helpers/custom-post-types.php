<?php
function register_sites_post_type()
{
  $labels = array(
    'name' => _x('Sitios', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Sitios', 'Post Type Singular Name', 'kudi-shift'),
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
    'label' => __('Sitio', 'kudi-shift'),
    'description' => __('Sitios', 'kudi-shift'),
    'labels' => $labels,
    'supports' => array('title', 'thumbnail'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 32,
    'menu_icon' => 'dashicons-video-alt2',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'rewrite' => $rewrite,
    'capability_type' => 'post',
    'show_in_rest' => true
  );

  register_post_type('sites', $args);
}
add_action('init', 'register_sites_post_type', 0);

function register_shifts_post_type()
{
  $labels = array(
    'name' => _x('Jornadas', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Jornada', 'Post Type Singular Name', 'kudi-shift'),
    'menu_name' => __('Jornadas', 'kudi-shift'),
    'name_admin_bar' => __('Jornadas', 'kudi-shift'),
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
    'label' => __('Jornadas', 'kudi-shift'),
    'description' => __('Jornadas', 'kudi-shift'),
    'labels' => $labels,
    'supports' => array('title'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 32,
    'menu_icon' => 'dashicons-clock',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'rewrite' => $rewrite,
    'capability_type' => 'post',
    'show_in_rest' => true
  );

  register_post_type('shifts', $args);
}
add_action('init', 'register_shifts_post_type', 0);