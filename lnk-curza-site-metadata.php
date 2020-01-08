<?php

/**
 * Plugin Name: LNK-CURZA Site Metadata
 * Plugin URI: https://github.com/linkerx
 * Description: Expone Metadata de subsitios
 * Version: 0.1
 * Author: Diego Martinez Diaz
 * Author URI: https://github.com/linkerx
 * License: GPLv3
 */

function curza_sites_register_route(){

    $route = 'curza/v1';

    register_rest_route( $route, '/sites', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'curza_get_site',
    ));

    register_rest_route( $route, '/sites/(?P<name>[a-zA-Z0-9-]+)', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'curza_get_site',
    ));
  }
  add_action( 'rest_api_init', 'curza_sites_register_route');

  /**
 * Subsitio CURZA
 *
 * @param WP_REST_Request $request Id del sitio
 * @return WP_REST_Response $sites Datos del sitio
 */
function curza_get_site(WP_REST_Request $request){

    if(isset($request['name'])){
      $path = '/'.$request['name'].'/';
    } else {
      $path = '/';
    }
    $sites_args = array(
      'path' => $path // los posts tb solo publicos?
    );

    $sites = get_sites($sites_args);
    if(count($sites) != 1){
      return new WP_REST_Response('no existe el área', 404 );
    }
    $site = $sites[0];
  
    switch_to_blog($site->blog_id);
    $site->frontpage = get_option('page_on_front');
    $site->tipo_pagina = get_option('curza_tipo_pagina','otro');
    $site->id_departamento = get_option('curza_id_departamento',0);
    $site->barra_izq = get_option('curza_barra_izq_abierta',0);
    $site->barra_der = get_option('curza_barra_der_abierta',0);
  
    if($site->frontpage != 0){
      $site->page = get_post($site->frontpage);
    }
  
    $site->blog_name = get_bloginfo('name');
    $site->blog_description = get_bloginfo('description');
    $site->wpurl = get_bloginfo('wpurl');
    restore_current_blog();
  
    return new WP_REST_Response($site, 200 );
  }