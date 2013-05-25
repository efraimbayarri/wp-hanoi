<?php
/**
 * Plugin Name: WP-Hanoi
 * Plugin URI: http://replicantsfactory.com/
 * Author: Efraim Bayarri
 * Author URI: http://replicantsfactory.com/
 * Version: 1.002106:1119
 * Description: Projecte localitzacions (git://github.com/efraimbayarri/wp-hanoi.git)
 */

require_once(WP_PLUGIN_DIR.'/wp-hanoi/class_translate.php');

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
	load_plugin_textdomain( 'wp-hanoi', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
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

#############################################################################################
/**   */
#############################################################################################
function wphanoi_admin_init(){
	
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_plugin_options(){
	?>
	<div>
	<h2><?php _e('Opcions WP-HANOI','wphanoi');?></h2>
	<?php _e('Opcions de configuració i administracio de WP-HANOI','wp-hanoi'); ?>
	<form action="options.php" method="post">
	<input name="Submit" type="submit" value="<?php _e('Desar canvis','wp-hanoi'); ?>" />
	<?php // settings_fields('ricca3_options')?>
	<?php // do_settings_sections('RICCA3-admin-menu')?>
	<hr>
	<input name="Submit" type="submit" value="<?php _e('Desar canvis','wp-hanoi'); ?>" />
	</form>
	</div>
	<?php 	
}