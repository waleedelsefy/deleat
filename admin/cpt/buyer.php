<?php
/**
 * 
 * Class 'Taskbot_Admin_CPT_Buyer' defines the custom post type Buyers
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_Admin_CPT_Buyer {

	/**
	 * Buyers post type
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
		add_action('init', array(&$this, 'init_post_type'));		
	}

	/**
	 * @Init post type
	*/
	public function init_post_type() {
		$this->register_posttype();
	}

	/**
	 *Regirster buyer post type
	*/ 
	public function register_posttype() {
		$labels = array(
			'name'                  => esc_html__( 'Investors', 'taskbot' ),
			'singular_name'         => esc_html__( 'Investor', 'taskbot' ),
			'menu_name'             => esc_html__( 'Investors', 'taskbot' ),
			'name_admin_bar'        => esc_html__( 'Investors', 'taskbot' ),
			'parent_item_colon'     => esc_html__( 'Parent investor:', 'taskbot' ),
			'all_items'             => esc_html__( 'All investors', 'taskbot' ),
			'add_new_item'          => esc_html__( 'Add new investor', 'taskbot' ),
			'add_new'               => esc_html__( 'Add new investor', 'taskbot' ),
			'new_item'              => esc_html__( 'New investor', 'taskbot' ),
			'edit_item'             => esc_html__( 'Edit investor', 'taskbot' ),
			'update_item'           => esc_html__( 'Update investor', 'taskbot' ),
			'view_item'             => esc_html__( 'View investors', 'taskbot' ),
			'view_items'            => esc_html__( 'View investors', 'taskbot' ),
			'search_items'          => esc_html__( 'Search investors', 'taskbot' ),
		);
		
		$args = array(
			'label'                 => esc_html__( 'Investor', 'taskbot' ),
			'description'           => esc_html__( 'All invistor.', 'taskbot' ),
			'labels'                => apply_filters('taskbot_product_taxonomy_duration_labels', $labels),
			'supports'              => array( 'title','editor','author','excerpt','thumbnail' ),
			'taxonomies'            => array( 'product_cat'),
			'public' 				=> true,
			'supports' 				=> array('title','editor','author','excerpt','thumbnail'),
			'show_ui' 				=> true,
			'capability_type' 		=> 'post',
			'map_meta_cap' 			=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> true,
			'hierarchical' 			=> true,
			'menu_position' 		=> 10,
			'rewrite' 				=> array('slug' => 'investor', 'with_front' => true),
			'query_var' 			=> true,
			'has_archive' 			=> true,
			'show_in_menu' 			=> 'edit.php?post_type=sellers',
			'capabilities' 			=> array(
										'create_posts' => true
									),
			'rest_base'             => 'buyer',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		);
		
		register_post_type( apply_filters('taskbot_buyer_post_type_name', 'buyers'), $args );

	}  
}

new Taskbot_Admin_CPT_Buyer();