<?php
function register_sites_post_type()
{
  $labels = array(
    'name' => _x('Sitios', 'Post Type General Name', 'kudi-shift'),
    'singular_name' => _x('Sitio', 'Post Type Singular Name', 'kudi-shift'),
    'menu_name' => __('Sitios', 'kudi-shift'),
    'name_admin_bar' => __('Sitios', 'kudi-shift'),
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
    'menu_icon' => 'dashicons-carrot',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'rewrite' => $rewrite,
    'capabilities' => array(
      'edit_post' => 'kudi_edit_site',
      'edit_posts' => 'kudi_edit_sites',
      'edit_others_posts' => 'kudi_edit_other_sites',
      'publish_posts' => 'kudi_publish_sites',
      'read_post' => 'kudi_read_site',
      'read_private_posts' => 'kudi_read_private_sites',
      'delete_post' => 'kudi_delete_site'
    ),
    'map_meta_cap'  => true,
    'show_in_rest' => true
  );

  register_post_type('sites', $args);
}
add_action('init', 'register_sites_post_type', 0);