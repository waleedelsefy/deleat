<?php
/**
 * Directories settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/
$theme_version 	  = wp_get_theme();
$listing_view     = array('left' => esc_html__('Left','taskbot'));
if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
  $listing_view['top']  = esc_html__('Top','taskbot');
}
Redux::setSection( $opt_name, array(
        'title'             => esc_html__( 'Search settings', 'taskbot' ),
        'id'                => 'search-settings',
        'desc'       	      => '',
        'icon' 			        => 'el el-search',
        'subsection'        => false,
            'fields'           => array(
                array(
                  'id'        => 'seller_listing_type',
                  'type'      => 'select',
                  'title'     => esc_html__('Owner filter position', 'taskbot'),
                  'desc'      => esc_html__('Select Owner filter position', 'taskbot'),
                  'options'   => $listing_view,
                  'default'   => 'left',
                ),
				array(
					'id'        => 'projects_listing_view',
					'type'      => 'select',
					'title'     => esc_html__('Projects filter position', 'taskbot'),
					'desc'      => esc_html__('Select projects filter position', 'taskbot'),
					'options'   => $listing_view,
					'default'   => 'left',
				),
				array(
					'id'        => 'task_listing_view',
					'type'      => 'select',
					'title'     => esc_html__('Task filter position', 'taskbot'),
					'desc'      => esc_html__('Select task filter position', 'taskbot'),
					'options'   => $listing_view,
					'default'   => 'left',
				),
              
        )
	)
);
Redux::setSection( $opt_name, array(
    'title'             	=> esc_html__( 'Business search settings', 'taskbot' ),
    'id'                	=> 'task_search_settings',
    'desc'       	      	=> '',
    'subsection'        	=> true,
    'icon'			        => 'el el-search',	
    'fields'            	=>  array(
								
								array(
									'id'        => 'hide_task_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Business search settings', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the task search location filter in the Business search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_task_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show price in Business search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the price filter in the Business search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_task_filter_categories',
									'type'      => 'switch',
									'title'     => esc_html__('Show categories in task search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the categories filter in the task search page', 'taskbot'),
									'default'   => true,
								),
			)
	));

Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Project search settings', 'taskbot' ),
	'id'                	=> 'project_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',	
	'fields'            	=>  array(
								
								array(
									'id'        => 'hide_project_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show project type in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project type filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project search location filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show project skills in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project skills filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show project expertise level in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project expertise level filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show project languages in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the project languages filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show price in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the price filter in the project search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_project_filter_categories',
									'type'      => 'switch',
									'title'     => esc_html__('Show categories in project search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the categories filter in the project search page', 'taskbot'),
									'default'   => true,
								),
			)
	));

Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Owner search settings', 'taskbot' ),
	'id'                	=> 'seller_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',	
	'fields'            	=>  array(
								
								array(
									'id'        => 'hide_seller_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show owner type in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the owner type filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the owner search location filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show owner skills in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the owner skills filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show owner english level in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the owner english level filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show owner languages in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the owner languages filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show hourly rate in owner search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the hourly rate filter in the owner search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_seller_without_avatar',
									'type'      => 'select',
									'title'     => esc_html__('Hide owners', 'taskbot'),
									'desc'      => esc_html__('Hide owners without profile picture', 'taskbot'),
									'options'   => array(
										'yes'	=> esc_html__('Yes, hide profiles', 'taskbot'),
										'no'	=> esc_html__('No', 'taskbot'),
									),
									'default'   => 'no',
								),
			)
	));
Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Auditor search settings', 'taskbot' ),
	'id'                	=> 'auditor_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',
	'fields'            	=>  array(

								array(
									'id'        => 'hide_auditor_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show Auditor type in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Auditor type filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Auditor search location filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show Auditor skills in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Auditor skills filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show Auditor english level in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Auditor english level filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show Auditor languages in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Auditor languages filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show hourly rate in Auditor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the hourly rate filter in the Auditor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_auditor_without_avatar',
									'type'      => 'select',
									'title'     => esc_html__('Hide Auditors', 'taskbot'),
									'desc'      => esc_html__('Hide Auditors without profile picture', 'taskbot'),
									'options'   => array(
										'yes'	=> esc_html__('Yes, hide profiles', 'taskbot'),
										'no'	=> esc_html__('No', 'taskbot'),
									),
									'default'   => 'no',
								),
			)
	));
Redux::setSection( $opt_name, array(
	'title'             	=> esc_html__( 'Investor search settings', 'taskbot' ),
	'id'                	=> 'buyer_search_settings',
	'desc'       	      	=> '',
	'subsection'        	=> true,
	'icon'			        => 'el el-search',
	'fields'            	=>  array(

								array(
									'id'        => 'hide_buyer_filter_type',
									'type'      => 'switch',
									'title'     => esc_html__('Show Investor type in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Investor type filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_filter_location',
									'type'      => 'switch',
									'title'     => esc_html__('Show location in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Investor search location filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_filter_skills',
									'type'      => 'switch',
									'title'     => esc_html__('Show Investor skills in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Investor skills filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_filter_level',
									'type'      => 'switch',
									'title'     => esc_html__('Show Investor english level in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Investor english level filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_filter_language',
									'type'      => 'switch',
									'title'     => esc_html__('Show Investor languages in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the Investor languages filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_filter_price',
									'type'      => 'switch',
									'title'     => esc_html__('Show hourly rate in Investor search', 'taskbot'),
									'subtitle'  => esc_html__('Make it off to hide the hourly rate filter in the Investor search page', 'taskbot'),
									'default'   => true,
								),
								array(
									'id'        => 'hide_buyer_without_avatar',
									'type'      => 'select',
									'title'     => esc_html__('Hide Investors', 'taskbot'),
									'desc'      => esc_html__('Hide Investor without profile picture', 'taskbot'),
									'options'   => array(
										'yes'	=> esc_html__('Yes, hide profiles', 'taskbot'),
										'no'	=> esc_html__('No', 'taskbot'),
									),
									'default'   => 'no',
								),
			)
	));