<?php
/**
 * /**
 * Plugin Name: Xlab Session 
 * Plugin URI: https://kodecamps.com 
 * Description:Add video/image to website
 * Author: kodecamps
 * Author URI: hhttps://kodecamps.com
 * Version: 1.0
 * Text Domain: kodecamps
 * Domain Path: /languages/
 *
 * Copyright: (c) 2011-2015 Hungnam. (info@hungnamecommerce.com)
 *
 *
 * @package   woocommerce-media-pro
 * @author    Hungnam
 * @category  Media pro
 * @copyright Copyright (c) 2014, Hungnam, Inc.

 * Created by Magenest
 * User: Luu Thanh Thuy
 * Date: 05/04/2016
 * Time: 13:44
 */
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'KODECAMPS_VERSION', '1.0.0' );
define( 'KODECAMPS__MINIMUM_WP_VERSION', '5.0' );
define( 'KODECAMPS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'KODECAMPS_DELETE_LIMIT', 10000 );
if (! defined ('KODECAMPS_URL'))
	define ('KODECAMPS_URL', plugins_url ( 'xlabsession', '' ) );

//register_activation_hook( __FILE__, array( 'Akismet', 'plugin_activation' ) );
//register_deactivation_hook( __FILE__, array( 'Akismet', 'plugin_deactivation' ) );

require_once( KODECAMPS__PLUGIN_DIR . 'class.kodcamps.php' );

add_action( 'init', array( 'Kodecamps', 'init' ) );
