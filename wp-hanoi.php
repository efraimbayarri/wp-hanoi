<?php
/**
 * Plugin Name: WP-Hanoi
 * Plugin URI: http://replicantsfactory.com/
 * Author: Efraim Bayarri
 * Author URI: http://replicantsfactory.com/
 * Version: 1.00201323061020
 * Description: Projecte localitzacions (git://github.com/efraimbayarri/wp-hanoi.git)
 */

require_once(WP_PLUGIN_DIR.'/wp-hanoi/class_translate.php');
require_once(WP_PLUGIN_DIR.'/wp-hanoi/dump_r.php');

if (is_admin()){
	add_action('admin_menu', 'wphanoi_admin_page');
	add_action('admin_init', 'wphanoi_admin_init');
}
add_action( 'plugins_loaded', 'wphanoi_init');
add_action( 'widgets_init',   'wphanoi_register_widgets' );

add_shortcode( 'wp-hanoi',    'wphanoi_shortcode_init' );
add_shortcode( 'wp-hanoi-ts', 'wphanoi_ts_init' );

// cookie stuf must be done before page loads
if(isset($_POST['wp-hanoi-option']) && $_POST['wp-hanoi-option'] == 'wp-hanoi_lang'){  
	setcookie ('wp-hanoi-cookie', $_POST['wp-hanoi-lang'], time()+(60*60*24*30), "/" );
	$_COOKIE['wp-hanoi-cookie'] = $_POST['wp-hanoi-lang'];
}
setcookie ('wp-hanoi-cookie_ts', microtime(true), time()+(60*60*24*30), "/" );
$_COOKIE['wp-hanoi-cookie_ts'] = microtime(true);

//

#############################################################################################
/**   */
#############################################################################################
function wphanoi_init() {
	$options = get_option('wp-hanoi_options');
	if(!$options)update_option( 'wp-hanoi_options', array( 'lang1' => '', 'desc1' =>'', 'lang2' => '', 'desc2' =>'', 'lang3' => '', 'desc3' =>'', 'lang4' => '', 'desc4' =>'', 'lang5' => '', 'desc5' =>'', 'lang6' => '', 'desc6' =>'' ) );
	
	load_plugin_textdomain( 'wp-hanoi', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_admin_page() {
	add_options_page( 'WP-HANOI options', 'WP-Hanoi', 'manage_options', 'wphanoi-admin-menu', 'wphanoi_plugin_options' );
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_admin_init(){
	register_setting('wp-hanoi_options',  'wp-hanoi_options', 'wphanoi_options_validate');
	add_settings_section('wp-hanoi_main', __('Main options',  'wp-hanoi'),          'wphanoi_section_text',  'WP-HANOI-admin-menu');
	add_settings_field('wp-hanoi_lang1',  __('Language 1',    'wp-hanoi'),          'wphanoi_setting_lang1', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc1',  __('Description language 1', 'wp-hanoi'), 'wphanoi_setting_desc1', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_lang2',  __('Language 2', 'wp-hanoi'),             'wphanoi_setting_lang2', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc2',  __('Description language 2', 'wp-hanoi'), 'wphanoi_setting_desc2', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_lang3',  __('Language 3', 'wp-hanoi'),             'wphanoi_setting_lang3', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc3',  __('Description language 3', 'wp-hanoi'), 'wphanoi_setting_desc3', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_lang4',  __('Language 4', 'wp-hanoi'),             'wphanoi_setting_lang4', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc4',  __('Description language 4', 'wp-hanoi'), 'wphanoi_setting_desc4', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_lang5',  __('Language 5', 'wp-hanoi'),             'wphanoi_setting_lang5', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc5',  __('Description language 5', 'wp-hanoi'), 'wphanoi_setting_desc5', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_lang6',  __('Language 6', 'wp-hanoi'),             'wphanoi_setting_lang6', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
	add_settings_field('wp-hanoi_desc6',  __('Description language 6', 'wp-hanoi'), 'wphanoi_setting_desc6', 'WP-HANOI-admin-menu', 'wp-hanoi_main');
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_section_text(){
	printf('<hr /><p>', NULL);
	printf('%s', __('Language settings.','wp-hanoi'));
	printf('</p><hr />', NULL);
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_setting_lang1(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang1' name='wp-hanoi_options[lang1]' size='5' type='text' value='{$options['lang1']}' /> ";
}
function wphanoi_setting_lang2(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang2' name='wp-hanoi_options[lang2]' size='5' type='text' value='{$options['lang2']}' /> ";
}
function wphanoi_setting_lang3(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang3' name='wp-hanoi_options[lang3]' size='5' type='text' value='{$options['lang3']}' /> ";
}
function wphanoi_setting_lang4(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang4' name='wp-hanoi_options[lang4]' size='5' type='text' value='{$options['lang4']}' /> ";
}
function wphanoi_setting_lang5(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang5' name='wp-hanoi_options[lang5]' size='5' type='text' value='{$options['lang5']}' /> ";
}
function wphanoi_setting_lang6(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_lang6' name='wp-hanoi_options[lang6]' size='5' type='text' value='{$options['lang6']}' /> ";
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_setting_desc1(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc1' name='wp-hanoi_options[desc1]' size='15' type='text' value='{$options['desc1']}' /> ";
}
function wphanoi_setting_desc2(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc2' name='wp-hanoi_options[desc2]' size='15' type='text' value='{$options['desc2']}' /> ";
}
function wphanoi_setting_desc3(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc3' name='wp-hanoi_options[desc3]' size='15' type='text' value='{$options['desc3']}' /> ";
}
function wphanoi_setting_desc4(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc4' name='wp-hanoi_options[desc4]' size='15' type='text' value='{$options['desc4']}' /> ";
}
function wphanoi_setting_desc5(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc5' name='wp-hanoi_options[desc5]' size='15' type='text' value='{$options['desc5']}' /> ";
}
function wphanoi_setting_desc6(){
	$options = get_option('wp-hanoi_options');
	echo "<input id='wp-hanoi_desc6' name='wp-hanoi_options[desc6]' size='15' type='text' value='{$options['desc6']}' /> ";
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_options_validate($input){
	if(isset($input['lang1']))  $newinput['lang1'] = trim($input['lang1']);
	if(isset($input['lang2']))  $newinput['lang2'] = trim($input['lang2']);
	if(isset($input['lang3']))  $newinput['lang3'] = trim($input['lang3']);
	if(isset($input['lang4']))  $newinput['lang4'] = trim($input['lang4']);
	if(isset($input['lang5']))  $newinput['lang5'] = trim($input['lang5']);
	if(isset($input['lang6']))  $newinput['lang6'] = trim($input['lang6']);
	if(isset($input['desc1']))  $newinput['desc1'] = trim($input['desc1']);
	if(isset($input['desc2']))  $newinput['desc2'] = trim($input['desc2']);
	if(isset($input['desc3']))  $newinput['desc3'] = trim($input['desc3']);
	if(isset($input['desc4']))  $newinput['desc4'] = trim($input['desc4']);
	if(isset($input['desc5']))  $newinput['desc5'] = trim($input['desc5']);
	if(isset($input['desc6']))  $newinput['desc6'] = trim($input['desc6']);

	return $newinput;
}
#############################################################################################
/**   */
#############################################################################################
function wphanoi_plugin_options(){
	?>
	<div>
	<h2><?php _e('WP-HANOI settings','wp-hanoi');?></h2>
	<?php _e('Settings and administration of WP-Hanoi','wp-hanoi'); ?>
	<form action="options.php" method="post">
	<input name="Submit" type="submit" value="<?php _e('Save changes','wp-hanoi'); ?>" />
	<?php  settings_fields('wp-hanoi_options')?>
	<?php  do_settings_sections('WP-HANOI-admin-menu')?>
	<hr>
	<input name="Submit" type="submit" value="<?php _e('Save changes','wp-hanoi'); ?>" />
	</form>
	</div>
	<?php 	
}

#############################################################################################
/**   */
#############################################################################################
function wphanoi_register_widgets() {
	register_widget( 'WphanoiWidget' );
}

#############################################################################################
/**
 * WP-Hanoi Widget Class
  *
 * @since WP-Hanoi v 1.002106
 * @author Efraim Bayarri
 */
#############################################################################################
class WphanoiWidget extends WP_Widget {

	function WphanoiWidget() {
		$widget_ops = array('classname' => 'Wphanoi_widget',
			'description' => __('description for WP-Hanoi Widget', 'wp-hanoi') );
		$control_ops = array('width' => 200, 'height' => 350);
// Instantiate the parent object
		parent::__construct( false, 'WP-Hanoi Widget', $widget_ops, $control_ops );
	}

#############################################################################################
/**   */
#############################################################################################
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		
		printf('<form method="post" action="" target="_self" name="wp-hanoi-widget-form">'.
					'<table><tr>'.
						'<td>%s'.
							'<select name="wp-hanoi-lang">', __('Language: ', 'wp-hanoi'));
		$options = get_option('wp-hanoi_options');
//		
		if(strlen($options['lang1'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang1'],$options['desc1']); 
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang1'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang1'],$options['desc1']);
			printf($option);
		}
		if(strlen($options['lang2'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang2'],$options['desc2']);
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang2'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang2'],$options['desc2']);
			printf($option);
		}
		if(strlen($options['lang3'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang3'],$options['desc3']);
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang3'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang3'],$options['desc3']);
			printf($option);
		}		
		if(strlen($options['lang4'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang4'],$options['desc4']);
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang4'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang4'],$options['desc4']);
			printf($option);
		}
		if(strlen($options['lang5'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang5'],$options['desc5']);
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang5'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang5'],$options['desc5']);
			printf($option);
		}
		if(strlen($options['lang6'])>0){
			$option = sprintf('<option value="%s">%s</option>',$options['lang6'],$options['desc6']);
			if(isset($_COOKIE['wp-hanoi-cookie']) && $_COOKIE['wp-hanoi-cookie'] == $options['lang6'] ) $option = sprintf('<option selected="selected" value="%s">%s</option>',$options['lang6'],$options['desc6']);
			printf($option);
		}
		printf(				'</select>'.
						'</td><td>'.
							'<button type="submit" name="wp-hanoi-option" value="wp-hanoi_lang"> %s </button>'.
						'</td></tr><tr><td colspan="2">%s'.
						'</td>'.
					'</tr></table>'.
				'</form>', __('Change', 'wp-hanoi'), __('warning advise', 'wp-hanoi'));		
		echo $after_widget;
	}

#############################################################################################
/**   */
#############################################################################################
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		echo 'UPDATE';
		return $instance;
	}
	
#############################################################################################
/**   */
#############################################################################################
	function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}else{
			$title = __( 'New title', 'wp-hanoi' );
		}
?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','wp-hanoi' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
<?php 
	}
}

#############################################################################################
/**
 * WP-Hanoi shortcode 
 * shortcode: [wp-hanoi]content[/wp-hanoi]
 *
 * @since WP-Hanoi v 1.002106
 * @author Efraim Bayarri
 */
#############################################################################################
function wphanoi_shortcode_init($atts, $content = null) {

	$local_config = get_locale();
//		take WP installation language for origin language and change it if 'orig=' is set in shortcode call	
	$orig = get_locale();
//		if there is nothing to do -> return
	if($orig == $_COOKIE['wp-hanoi-cookie'] || isset($atts['dest']) && $orig == $atts['dest'])return($content);
//	
	if(isset($atts['orig'])) $orig = $atts['orig'];
//		take WP installation language for destination language. If destination language is defined in cookies throw wp-hanoi Widget, take it.
//			if the shortcode has 'dest=', override all and set destination language to it.
	$dest = get_locale();
	if(isset($_COOKIE['wp-hanoi-cookie']))$dest = $_COOKIE['wp-hanoi-cookie'];
	if(isset($atts['dest']))$dest = $atts['dest'];
//
	$var = new translate($orig,$dest);

	return($var->get($content));
}

#############################################################################################
/**
 * WP-Hanoi timestamp shortcode 
 * shortcode: [wp-hanoi-ts]
 *
 * @since WP-Hanoi v 1.002106
 * @author Efraim Bayarri
 */
#############################################################################################
function wphanoi_ts_init($atts, $content = null) {
	if(isset($_COOKIE['wp-hanoi-cookie_ts'])) return(sprintf('%1.4f', microtime(true)-$_COOKIE['wp-hanoi-cookie_ts']));
}
