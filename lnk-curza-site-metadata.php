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
  
    // Endpoint: subsitio
    register_rest_route( $route, '/sites/(?P<name>[a-zA-Z0-9-]+)', array(
      'methods' => WP_REST_Server::READABLE,
      'callback' => 'curza_get_site',
    ));
  }
  add_action( 'rest_api_init', 'curza_sites_register_route');