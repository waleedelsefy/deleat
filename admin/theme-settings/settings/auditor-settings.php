<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * auditor settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/admin/Theme_Settings/Settings
 * @author      Amentotech <info@amentotech.com>
 * @link        http://amentotech.com/
 * @version     1.0
 * @since       1.0
*/

$taskbot_auditors = array(
	array(
		'id'        => 'hide_languages',
		'type'      => 'select',
		'title'     => esc_html__('Hide english level', 'taskbot'),
		'desc'      => esc_html__('Hide english level from seller settings and profile detail page', 'taskbot'),
		'options'   => array(
			'yes'         => esc_html__('Yes', 'taskbot'),
			'no'         => esc_html__('No', 'taskbot')
		),
		'default'   => 'no',
	),
);


Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Auditor settings ', 'taskbot' ),
	'id'               => 'auditor_settings',
	'desc'       	   => '',
	'subsection'       => false,
	'icon'			   => 'el el-braille',	
	'fields'           => $taskbot_auditors
	)
);