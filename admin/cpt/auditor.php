<?php
/**
 *
 * Class 'Taskbot_Admin_CPT_Auditor' defines the cusotm post type
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/cpt
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
 */
class Taskbot_Admin_CPT_Auditor {

    /**
     * Profiles post type
     *
     * @since    1.0.0
     * @access   public
     */
    public function __construct() {
        add_action('init', array(&$this, 'init_post_type'));
        add_action('init', array(&$this, 'taskbot_auditor_type_taxonomy_register'));
        add_filter('manage_auditors_posts_columns', array(&$this, 'auditors_columns_add'));
        add_action('manage_auditors_posts_custom_column', array(&$this, 'auditors_columns'),10, 2);
    }
    /**
     * @Prepare Columns
     * @return {post}
     */
    public function auditors_columns_add($columns) {
        $columns['earning'] 		= esc_html__('Earning','taskbot');
        $columns['commission'] 		= esc_html__('Admin commission','taskbot');
        return $columns;
    }

    /**
     * @Get Columns
     * @return {}
     */
    public function auditors_columns($case) {
        global $post;
        $user_identity		= taskbot_get_linked_profile_id($post->ID,'post');
        $account_blance 	= taskbot_account_details($user_identity,array('wc-completed'),'hired');
        $completed_blance   = taskbot_account_details($user_identity,array('wc-completed'),'completed');
        $total_amount       = $completed_blance+$account_blance;

        $admin_account_blance 	= taskbot_account_details($user_identity,array('wc-completed'),'hired','admin_shares');
        $admin_completed_blance = taskbot_account_details($user_identity,array('wc-completed'),'completed','admin_shares');
        $admin_total_amount     = $admin_completed_blance+$admin_account_blance;

        switch ($case) {
            case 'earning':
                taskbot_price_format($total_amount);
                break;
            case 'commission':
                taskbot_price_format($admin_total_amount);
                break;
        }
    }
    /**
     * @Init post type
     */
    public function init_post_type() {
        $this->register_posttype();
    }

    /**
     *Regirster profiles post type
     */
    public function register_posttype() {
        $labels = array(
            'name'                  => esc_html__( 'Auditors', 'taskbot' ),
            'singular_name'         => esc_html__( 'Auditors','taskbot' ),
            'menu_name'             => esc_html__( 'Auditors', 'taskbot' ),
            'name_admin_bar'        => esc_html__( 'Auditors', 'taskbot' ),
            'all_items'             => esc_html__( 'All Auditors', 'taskbot' ),
            'add_new_item'          => esc_html__( 'Add new auditor', 'taskbot' ),
            'add_new'               => esc_html__( 'Add new auditor', 'taskbot' ),
            'new_item'              => esc_html__( 'New auditor', 'taskbot' ),
            'edit_item'             => esc_html__( 'Edit auditor', 'taskbot' ),
            'update_item'           => esc_html__( 'Update auditor', 'taskbot' ),
            'view_item'             => esc_html__( 'View auditor', 'taskbot' ),
            'view_items'            => esc_html__( 'View auditor', 'taskbot' ),
            'search_items'          => esc_html__( 'Search auditor', 'taskbot' ),
        );

        $args = array(
            'label'                 => esc_html__( 'Auditors', 'taskbot' ),
            'description'           => esc_html__( 'All auditors.', 'taskbot' ),
            'labels'                => apply_filters('taskbot_product_taxonomy_duration_labels', $labels),
            'supports'              => array( 'title','editor','author','excerpt','thumbnail' ),
            'public' 				=> true,
            'supports' 				=> array('title','editor','author','excerpt','thumbnail'),
            'show_ui' 				=> true,
            'capability_type' 		=> 'post',
            'map_meta_cap' 			=> true,
            'publicly_queryable' 	=> true,
            'exclude_from_search' 	=> true,
            'hierarchical' 			=> true,
            'menu_position' 		=> 10,
            'rewrite' 				=> array('slug' => 'auditor', 'with_front' => true),
            'query_var' 			=> true,
            'has_archive' 			=> true,
            'menu_icon'				=> 'dashicons-businessman',
            'capabilities' 			=> array(
                'create_posts' => true
            ),
            'rest_base'             => 'auditor',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        );
        register_post_type( apply_filters('taskbot_profiles_post_type_name', 'auditors'), $args );
    }

    /*
     * Auditor type taxonomy
     */
    public function taskbot_auditor_type_taxonomy_register(){
        $auditor_type_labels = array(
            'name' 				=> esc_html__('Auditor type', 'taskbot'),
            'singular_name' 		=> esc_html__('Auditor type','taskbot'),
            'search_items' 		=> esc_html__('Search auditor type', 'taskbot'),
            'all_items' 			=> esc_html__('All auditor types', 'taskbot'),
            'parent_item' 		=> esc_html__('Parent auditor type', 'taskbot'),
            'parent_item_colon' 	=> esc_html__('Parent auditor type:', 'taskbot'),
            'edit_item' 			=> esc_html__('Edit auditor type', 'taskbot'),
            'update_item' 		=> esc_html__('Update auditor type', 'taskbot'),
            'add_new_item' 		=> esc_html__('Add New auditor type', 'taskbot'),
            'new_item_name' 		=> esc_html__('New auditor type name', 'taskbot'),
            'menu_name' 			=> esc_html__('Auditor type', 'taskbot'),
        );

        $auditor_type_args = array(
            'hierarchical'		=> true,
            'labels' 				=> apply_filters('taskbot_auditor_type_taxonom_labels', $auditor_type_labels),
            'show_ui' 			=> true,
            'show_admin_column' 	=> true,
            'show_in_nav_menus' 	=> true,
            'publicly_queryable'	=> true,
            'query_var' 			=> true,
            'show_in_rest' 		=> true,
            'rewrite' 			=> array('slug' => 'auditor_type'),
        );

        register_taxonomy('tb_auditor_type', array('auditors'), $auditor_type_args);
    }


    public function taskbot_auditor_english_level_taxonomy_register(){
        $english_level_labels = array(
            'name' 				=> esc_html__('English level', 'taskbot'),
            'singular_name' 		=> esc_html__('English level','taskbot'),
            'search_items' 		=> esc_html__('Search English level', 'taskbot'),
            'all_items' 			=> esc_html__('All English levels', 'taskbot'),
            'parent_item' 		=> esc_html__('Parent English level', 'taskbot'),
            'parent_item_colon' 	=> esc_html__('Parent English level:', 'taskbot'),
            'edit_item' 			=> esc_html__('Edit English level', 'taskbot'),
            'update_item' 		=> esc_html__('Update English level', 'taskbot'),
            'add_new_item' 		=> esc_html__('Add New English level', 'taskbot'),
            'new_item_name' 		=> esc_html__('New English level name', 'taskbot'),
            'menu_name' 			=> esc_html__('English level', 'taskbot'),
        );
        $english_level_args = array(
            'hierarchical'		=> true,
            'labels' 				=> apply_filters('taskbot_english_level_taxonom_labels', $english_level_labels),
            'show_ui' 			=> true,
            'show_admin_column' 	=> false,
            'show_in_nav_menus' 	=> false,
            'publicly_queryable'	=> true,
            'query_var' 			=> true,
            'show_in_rest' 		=> true,
            'rewrite' 			=> array('slug' => 'english_level'),
        );

        register_taxonomy('tb_english_level', array('auditors'), $english_level_args);
    }
}

new Taskbot_Admin_CPT_Auditor();