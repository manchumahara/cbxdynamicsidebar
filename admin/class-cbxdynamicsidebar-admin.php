<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wpboxr.com
 * @since      1.0.0
 *
 * @package    Cbxdynamicsidebar
 * @subpackage Cbxdynamicsidebar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cbxdynamicsidebar
 * @subpackage Cbxdynamicsidebar/admin
 * @author     WPBoxr <info@wpboxr.com>
 */
class Cbxdynamicsidebar_Admin {

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

	public $loader;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function admin_init(){

		//$plugin_admin = new Cbxdynamicsidebar_Admin( $this->get_plugin_name(), $this->get_version() );

		//var_dump($this->loader);

		add_filter( 'manage_cbxsidebar_posts_columns', array($this, 'cbxsidebar_columns'), 10, 1);
		add_action('manage_cbxsidebar_posts_custom_column', array($this, 'cbxsidebar_column'), 10, 2);

		//manage_{$post_type}_posts_columns
		$this->loader->add_filter( 'manage_cbxsidebar_posts_columns', $this, 'cbxsidebar_columns', 10);
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cbxdynamicsidebar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cbxdynamicsidebar-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Register Custom Post Type
	public  function create_sidebar() {

		$labels = array(
			'name'                => _x( 'Sidebars', 'Post Type General Name', $this->plugin_name ),
			'singular_name'       => _x( 'Sidebar', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'           => __( 'CBX Sidebars', $this->plugin_name ),
			'parent_item_colon'   => __( 'Parent Sidebar:', $this->plugin_name ),
			'all_items'           => __( 'All Sidebars', $this->plugin_name ),
			'view_item'           => __( 'View Sidebar', $this->plugin_name ),
			'add_new_item'        => __( 'Add New Sidebar', $this->plugin_name ),
			'add_new'             => __( 'Add New', $this->plugin_name ),
			'edit_item'           => __( 'Edit Sidebar', $this->plugin_name ),
			'update_item'         => __( 'Update Sidebar', $this->plugin_name ),
			'search_items'        => __( 'Search Sidebar', $this->plugin_name ),
			'not_found'           => __( 'Not found', $this->plugin_name ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->plugin_name ),
		);
		$args = array(
			'label'               => __( 'cbxsidebar', $this->plugin_name ),
			'description'         => __( 'Dynamic Sidebars', $this->plugin_name ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			//'menu_position'       => 5,
			'menu_icon'           => 'dashicons-list-view',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
		);
		register_post_type( 'cbxsidebar', $args );

	}

	/**
	 * Register all custom dynamic sidebars
	 */
	public function  cbxdynamicsidebar_register_sidebars(){
		//get all post types(aka cbxdynamicsidebar type posts )



		$query_arg = array(
			'post_type' => 'cbxsidebar',
			'post_status' => 'publish',
			'posts_per_page' => -1

		);
		$the_query = new WP_Query( $query_arg );

		/*echo '<pre>';
		print_r($the_query);
		echo '</pre>';*/


		while ( $the_query->have_posts() ) : $the_query->the_post();
			global $post;
			$id                 = $post->ID;

			//var_dump($id);
			$post_title         = $post->post_title;

			$sidebar_custom     = get_post_meta( $id, '_cbxdynamicsidebar', true);

			/*echo '<pre>';
			print_r($sidebar_custom);
			echo '</pre>';*/
			//exit();

			if(is_array($sidebar_custom) && sizeof($sidebar_custom) == 0) continue;

			//$sidebar_custom     = $sidebar_custom[0];
			$active             = intval($sidebar_custom['active']);

			if(!$active) continue;

			$description        = html_entity_decode($sidebar_custom['description']);
			$before_widget      = html_entity_decode($sidebar_custom['before_widget']);
			$after_widget       = html_entity_decode($sidebar_custom['after_widget']);
			$before_title       = html_entity_decode($sidebar_custom['before_title']);
			$after_title        = html_entity_decode($sidebar_custom['after_title']);

			register_sidebar( array(
				'name'          => $post_title,
				'id'            => 'cbxdynamicsidebar-'.$id,
				'description'   => $description,
				'before_widget' => $before_widget,
				'after_widget'  => $after_widget,
				'before_title'  => $before_title,
				'after_title'   => $after_title
			) );

		endwhile;
		// Reset Post Data
		wp_reset_postdata();
	}



	public function sidebar_action_row($actions, $post){

		if ($post->post_type =="cbxsidebar"){
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['view'] );
		}
		return $actions;

	}

	 function cbxsidebar_column( $column_name, $post_id ) {
		if ($column_name == 'shortcode') {
			echo '[cbxdynamicsidebar id="'.$post_id.'"]';
		}
	 }

	 public function cbxsidebar_columns($columns ){


		unset($columns['date']);
		$columns['shortcode'] = __('Shortcode', $this->plugin_name);
		return $columns;
	}

	public function add_meta_boxes(){

		//photo meta box
		add_meta_box(
			'cbxdynamicsidebarmetabox', __('Sidebar Definitions', $this->plugin_name), array($this, 'cbxdynamicsidebarmetabox_display'), 'cbxsidebar', 'normal','high'
		);
	}

	public function cbxdynamicsidebarmetabox_display($post){

		$fieldValues = get_post_meta($post->ID, '_cbxdynamicsidebar', true);



		wp_nonce_field( 'cbxdynamicsidebarmetabox', 'cbxdynamicsidebarmetabox[nonce]' );
		//<input type="hidden" id="name_of_nonce_field" name="name_of_nonce_field" value="a62a76f53d">

		echo '<h2>'.__('Shortcode Usages:', $this->plugin_name).'</h2>';
		echo '<code>[cbxdynamicsidebar id="'.$post->ID.'" float="auto" wid="" wclass="" /]</code>';

		echo '<div id="cbxdynamicsidebarmetabox_wrapper">';

		
			$active             = isset($fieldValues['active']) ? intval($fieldValues['active']): 1;
			$description        = isset($fieldValues['description']) ? html_entity_decode($fieldValues['description']): __('Yet another Dynamic Sidebar', $this->plugin_name);
			$class              = isset($fieldValues['class']) ? html_entity_decode($fieldValues['class']): 'cbxdynamicsidebar';
			$before_widget      = isset($fieldValues['before_widget'])? html_entity_decode($fieldValues['before_widget']): '<div id="%1$s" class="widget widget-cbxdynamicsidebar %2$s">';
			$after_widget       = isset($fieldValues['after_widget'])? html_entity_decode($fieldValues['after_widget']): '</div>';
			$before_title       = isset($fieldValues['before_title'])? html_entity_decode($fieldValues['before_title']): '<h2 class="widget-title widget-title-cbxdynamicsidebar">';
			$after_title        = isset($fieldValues['after_title'])? html_entity_decode($fieldValues['after_title']): '</h2>';

			//var_dump($active);
			?>

			
			<table class="form-table"><tbody>
				<tr valign="top">


					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_class"><?php echo __('Sidebar Enabe/Disable', $this->plugin_name) ?></label></th>
					<td>
						<legend class="screen-reader-text"><span>input type="radio"</span></legend>
						<label title='g:i a'>
							<input type="radio" name="cbxdynamicsidebarmetabox[active]" value="0" <?php checked( $active, '0', TRUE ); ?>  />
							<span><?php esc_attr_e( 'No',  $this->plugin_name ); ?></span>
						</label><br>
						<label title='g:i a'>
							<input type="radio" name="cbxdynamicsidebarmetabox[active]" value="1" <?php checked( $active, '1', TRUE ); ?> />
							<span><?php esc_attr_e( 'Yes',  $this->plugin_name ); ?></span>
						</label>

					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_description"><?php echo __('Description', $this->plugin_name) ?></label></th>
					<td>
						<textarea id="cbxdynamicsidebarmetabox_fields_description" class="regular-text" name="cbxdynamicsidebarmetabox[description]" placeholder="<?php echo $description; ?>"><?php echo htmlentities($description); ?></textarea>

					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_class"><?php echo __('CSS Class', $this->plugin_name) ?></label></th>
					<td>
						<input id="cbxdynamicsidebarmetabox_fields_class" class="regular-text" type="text"  name="cbxdynamicsidebarmetabox[class]" placeholder="cbxdynamicsidebar" value="<?php echo htmlentities($class); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_before_widget"><?php echo __('Before Widget Html Wrapping', $this->plugin_name) ?></label></th>
					<td>
						<input id="cbxdynamicsidebarmetabox_fields_before_widget" class="regular-text" type="text"  name="cbxdynamicsidebarmetabox[before_widget]" placeholder="<?php echo htmlentities($before_widget); ?>" value="<?php echo htmlentities($before_widget); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_after_widget"><?php echo __('After Widget Html Wrapping', $this->plugin_name) ?></label></th>
					<td>
						<input id="cbxdynamicsidebarmetabox_fields_after_widget" class="regular-text" type="text"  name="cbxdynamicsidebarmetabox[after_widget]" placeholder="<?php echo htmlentities($after_widget); ?>" value="<?php echo htmlentities($after_widget); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_before_title"><?php echo __('Before Title Html Wrapping', $this->plugin_name) ?></label></th>
					<td>
						<input id="cbxdynamicsidebarmetabox_fields_before_title" class="regular-text" type="text"  name="cbxdynamicsidebarmetabox[before_title]" placeholder="<?php echo htmlentities($before_title); ?>" value="<?php echo htmlentities($before_title); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cbxdynamicsidebarmetabox_fields_after_title"><?php echo __('After Title Html Wrapping', $this->plugin_name) ?></label></th>
					<td>
						<input id="cbxdynamicsidebarmetabox_fields_after_title" class="regular-text" type="text"  name="cbxdynamicsidebarmetabox[after_title]" placeholder="<?php echo htmlentities($after_title); ?>" value="<?php echo htmlentities($after_title); ?>" />
					</td>
				</tr>
				
			</tbody></table>
			
			<?php

		echo '</div>';


	}//end display metabox

	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * @param		int		$post_id	The ID of the post being save
	 * @param		bool				Whether or not the user has the ability to save this post.
	 */
	public function save_post($post_id, $post) {

		$post_type = 'cbxsidebar';

		// If this isn't a 'book' post, don't update it.
		if ( $post_type != $post->post_type ) {
			return;
		}



		if(!empty($_POST['cbxdynamicsidebarmetabox'])) {

			$postData = $_POST['cbxdynamicsidebarmetabox'];


			$saveableData  = array();



			//if(!empty($postData['bdnewsphotobox'])) {
			if ($this->user_can_save($post_id, 'cbxdynamicsidebarmetabox', $postData['nonce'])) {

				$saveableData['active'] 	            = intval($postData['active']);
				$saveableData['description'] 	        = esc_attr($postData['description']);
				$saveableData['class'] 		            = esc_attr($postData['class']);
				$saveableData['before_widget'] 		    = esc_attr($postData['before_widget']);
				$saveableData['after_widget'] 		    = esc_attr($postData['after_widget']);
				$saveableData['before_title'] 		    = esc_attr($postData['before_title']);
				$saveableData['after_title'] 		    = esc_attr($postData['after_title']);

				update_post_meta($post_id, '_cbxdynamicsidebar', $saveableData);
			}
		}
	}
	/**
	 * Determines whether or not the current user has the ability to save meta data associated with this post.
	 *
	 * @param		int		$post_id	The ID of the post being save
	 * @param		bool				Whether or not the user has the ability to save this post.
	 */
	function user_can_save($post_id, $action, $nonce) {

		$is_autosave    = wp_is_post_autosave($post_id);
		$is_revision    = wp_is_post_revision($post_id);
		$is_valid_nonce = ( isset($nonce) && wp_verify_nonce($nonce, $action) );

		// Return true if the user is able to save; otherwise, false.
		return !( $is_autosave || $is_revision ) && $is_valid_nonce;

	}// end user_can_save

}
