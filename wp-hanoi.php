<?php
/**
 * Plugin Name: WP-Hanoi
 * Plugin URI: http://replicantsfactory.com/
 * Author: Efraim Bayarri
 * Author URI: http://replicantsfactory.com/
 * Version: 1.0
 * Description: Projecte localitzacions
 */


if (is_admin()){
	add_action('admin_menu', 'wphanoi_admin_page');
	add_action('admin_init', 'wphanoi_admin_init');
}
add_action( 'plugins_loaded', 'wphanoi_init');

#############################################################################################
/**
 * Funcions per el init del connector
 *
 * @since ricca3.v.2013.13.6
 * @author Efraim Bayarri
 */
#############################################################################################
function wphanoi_init() {
	
}

#############################################################################################
/**
 * Funcions per a la pàgina d'administracio del connector
 *
 * @since ricca3.v.2013.13.6
 * @author Efraim Bayarri
 */
#############################################################################################
function wphanoi_admin_page() {
	add_options_page( 'WP-HANOI options', 'WP-Hanoi', 'manage_options', 'wphanoi-admin-menu', 'wphanoi_plugin_options' );
}