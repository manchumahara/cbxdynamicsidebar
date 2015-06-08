<?php
/**
 *
 * @link              http://wpboxr.com
 * @since             1.0.1
 * @package           Cbxdynamicsidebar
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Dynamic Sidebar
 * Plugin URI:        http://wpboxr.com/product/cbx-dynamic-sidebar-for-wordpress
 * Description:       Dynamic sidebar for wordpress using custom post type and shortcode
 * Version:           1.0.0
 * Author:            WPBoxr
 * Author URI:        http://wpboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxdynamicsidebar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbxdynamicsidebar-activator.php
 */
function activate_cbxdynamicsidebar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxdynamicsidebar-activator.php';
	Cbxdynamicsidebar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbxdynamicsidebar-deactivator.php
 */
function deactivate_cbxdynamicsidebar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbxdynamicsidebar-deactivator.php';
	Cbxdynamicsidebar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cbxdynamicsidebar' );
register_deactivation_hook( __FILE__, 'deactivate_cbxdynamicsidebar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cbxdynamicsidebar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbxdynamicsidebar() {

	$plugin = new Cbxdynamicsidebar();
	$plugin->run();

}
run_cbxdynamicsidebar();


if(!function_exists('cbxdynamicsidebar_display')){
	/**
	 * Custom function call
	 *
	 * @param $arr
	 */
	function cbxdynamicsidebar_display($atts){
		$arr = shortcode_atts( array(
			'id'            => 0 ,
			'wclass'        => 'cbxdynamicsidebar_wrapper',
			'wid'           => 'cbxdynamicsidebar_wrapper',
			'float'         => 'auto'

		), $atts );

		extract($arr);

		if(intval($id) < 1) return '';

		$sidebar_custom     = get_post_meta( $id, '_cbxdynamicsidebar', true);
		$active             = intval($sidebar_custom['active']);

		if(!$active) return '';

		if(is_active_sidebar('cbxdynamicsidebar-'.$id)){
			$sidebar_html = '<div style="float:'.$float.';" id="'.$wid.$id.'" class="'.$wclass.' '.$wclass.$id.'" role="complementary">';
			ob_start();
			dynamic_sidebar( 'cbxdynamicsidebar-'.$id );
			$sidebar_html .= ob_get_contents();
			ob_end_clean();
			//echo $sidebar_html;
			$sidebar_html .= '</div>';
			return $sidebar_html;
		}

	}
}

/*
//how to call function from ohter plugin or theme
if(function_exists('cbxdynamicsidebar_display')){
	$config_array = array(
		'id'       => '686',
		'wclass'        => 'cbxdynamicsidebar_wrapper',
		'wid'           => 'cbxdynamicsidebar_wrapper',
		'float'         => 'auto'
	);
	echo cbxdynamicsidebar_display($config_array);
}
*/
