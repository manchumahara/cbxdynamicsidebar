<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxdynamicsidebar
 * @subpackage Cbxdynamicsidebar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cbxdynamicsidebar
 * @subpackage Cbxdynamicsidebar/public
 * @author     WPBoxr <info@wpboxr.com>
 */
class Cbxdynamicsidebar_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cbxdynamicsidebar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cbxdynamicsidebar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cbxdynamicsidebar-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cbxdynamicsidebar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cbxdynamicsidebar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cbxdynamicsidebar-public.js', array( 'jquery' ), $this->version, false );

	}

	public function cbxdynamicsidebar_shortcode($atts){
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
