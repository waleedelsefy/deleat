<?php

/**
 * Profile settings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
 */

global $current_user, $taskbot_settings, $userdata, $post;

$reference 		 = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode 			 = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity 	 = intval($current_user->ID);
$id 			 = !empty($args['id']) ? intval($args['id']) : '';
$user_type		 = apply_filters('taskbot_get_user_type', $current_user->ID);
$profile_id      = taskbot_get_linked_profile_id($user_identity, '', $user_type);
$tb_post_meta   = get_post_meta($profile_id, 'tb_post_meta', true);
$tb_post_meta   = !empty($tb_post_meta) ? $tb_post_meta : array();
$country		= get_post_meta($profile_id, 'country', true);
$country		= !empty($country) ? $country : '';
$birthday	    = !empty($tb_post_meta['birthday']) ? $tb_post_meta['birthday'] : '';
$tag_line		= !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
$first_name		= !empty($tb_post_meta['first_name']) ? $tb_post_meta['first_name'] : '';
$last_name		= !empty($tb_post_meta['last_name']) ? $tb_post_meta['last_name'] : '';
$description	= !empty($tb_post_meta['description']) ? $tb_post_meta['description'] : '';
$hide_english_level       = !empty($taskbot_settings['hide_english_level']) ? $taskbot_settings['hide_english_level'] : 'no';
$hide_skills       	  = !empty($taskbot_settings['hide_skills']) ? $taskbot_settings['hide_skills'] : 'no';
$auditor_type_term	= wp_get_object_terms($profile_id, 'tb_auditor_type');
$auditor_type		= !empty($auditor_type_term) ? $auditor_type_term : array();
$first_name			= !empty($first_name) ? $first_name : '';
$last_name			= !empty($last_name) ? $last_name : '';
$countries			= array();
$states					= array();
$state					= get_post_meta($profile_id, 'state', true);
$state					= !empty($state) ? $state : '';
$enable_state			= !empty($taskbot_settings['enable_state']) ? $taskbot_settings['enable_state'] : false;
$state_country_class	= !empty($enable_state) && empty($country) ? 'd-sm-none' : '';
if (class_exists('WooCommerce')) {
    $countries_obj   	= new WC_Countries();
    $countries   		= $countries_obj->get_allowed_countries('countries');
    if( empty($country) && is_array($countries) && count($countries) == 1 ){
        $country                = array_key_first($countries);
        $state_country_class	= '';
    }
    $states			 	= $countries_obj->get_states( $country );
}

$country_class = "form-group";
if(!empty($taskbot_settings['enable_zipcode']) ){
    $country_class = "form-group-half";
}
$auditor_type_data   = taskbot_get_term_dropdown('tb_auditor_type', false, 0, false);

?>
    <div class="tb-dhb-profile-settings">
        <div class="tb-dhb-mainheading">
            <h2><?php esc_html_e('Profile settings', 'taskbot'); ?></h2>
        </div>
        <div class="tb-dhb-box-wrapper">
            <div class="tb-tabtasktitle">
                <h5><?php esc_html_e('Personal details', 'taskbot'); ?></h5>
            </div>
            <form class="tb-themeform tb-profileform" id="tb_save_settings">
                <fieldset>
                    <div class="tb-profileform__holder">
                        <div class="tb-profileform__detail tb-billinginfo">
                            <div class="form-group-half form-group_vertical">
                                <label class="form-group-title"><?php esc_html_e('First name:', 'taskbot'); ?></label>
                                <input type="text" class="form-control" name="first_name" placeholder="<?php esc_attr_e('Enter first name', 'taskbot', $first_name); ?>" autocomplete="off" value="<?php echo esc_attr($first_name); ?>">
                            </div>
                            <div class="form-group-half form-group_vertical">
                                <label class="form-group-title"><?php esc_html_e('Last name:', 'taskbot'); ?></label>
                                <input type="text" class="form-control" name="last_name" placeholder="<?php esc_attr_e('Enter last name', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($last_name); ?>">
                            </div>
                            <div class="form-group-half form-group_vertical">
                                <label class="form-group-title"><?php esc_html_e('birthday:', 'taskbot'); ?></label>
                                <input type="date" class="form-birthday" name="birthday" placeholder="<?php esc_attr_e('28/05/1994', 'taskbot'); ?>" autocomplete="off" value="<?php echo esc_attr($birthday); ?>">
                            </div>
                            <div class="form-group form-group_vertical">
                                <label class="form-group-title"><?php esc_html_e('About you:', 'taskbot'); ?></label>
                                <textarea class="form-control" name="description" placeholder="<?php esc_attr_e('Write more info', 'taskbot'); ?>"><?php echo do_shortcode($description); ?></textarea>
                            </div>
                            <div class="<?php echo esc_attr($country_class);?> form-group_vertical">
                                <label class="form-group-title"><?php esc_html_e('Country', 'taskbot'); ?></label>
                                <span class="tb-select tb-select-country">
								<select id="tb-country" class="tb-country" name="country" data-placeholderinput="<?php esc_attr_e('Search country', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose country', 'taskbot'); ?>">
									<option selected hidden disabled value=""><?php esc_html_e('Country', 'taskbot'); ?></option>
									<?php if (!empty($countries)) {
                                        foreach ($countries as $key => $item) {
                                            $selected = '';

                                            if (!empty($country) && $country === $key) {
                                                $selected = 'selected';
                                            }?>
                                            <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
                                        <?php }
                                    } ?>
								</select>
							</span>
                            </div>
                            <?php if( !empty($enable_state) ){?>
                                <div class="form-group-half form-group_vertical tb-state-parent <?php echo esc_attr($state_country_class);?>">
                                    <label class="form-group-title"><?php esc_html_e('Governorate', 'taskbot'); ?></label>
                                    <span class="tb-select tb-select-country">
									<select class="tb-country-state" name="state" data-placeholderinput="<?php esc_attr_e('Search states', 'taskbot'); ?>" data-placeholder="<?php esc_attr_e('Choose states', 'taskbot'); ?>">
										<option selected hidden disabled value=""><?php esc_html_e('Governorate', 'taskbot'); ?></option>
										<?php if (!empty($states)) {
                                            foreach ($states as $key => $item) {
                                                $selected = '';
                                                if (!empty($state) && $state === $key) {
                                                    $selected = 'selected';
                                                } ?>
                                                <option class="tb-state-option" <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($item); ?></option>
                                            <?php }
                                        } ?>
									</select>
								</span>
                                </div>
                            <?php } ?>
                            <?php do_action('taskbot_add_auditor_profile_fields', $profile_id); ?>

                        </div>
                    </div>
                    <div class="tb-profileform__holder">
                        <div class="tb-dhbbtnarea tb-dhbbtnareav2">
                            <em><?php esc_html_e('Click “Save & Update” to update the latest changes', 'taskbot'); ?></em>
                            <a href="javascript:void(0);" data-id="<?php echo intval($user_identity); ?>" class="tb-btn tb_profile_settings"><?php esc_html_e('Save & Update', 'taskbot'); ?></a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<?php
$scripts	= "
jQuery(document).ready(function($){
    'use strict';
	// Make category drop-down select2 
    jQuery('.tb-select2-languages').select2({
        allowClear: true,
        multiple: true,
    });
    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-languages').select2({
            multiple: true,
            placeholder: scripts_vars.languages_option
        });
    }
    jQuery('.tb-select2-languages').trigger('change');
    jQuery('.tb-select2-skills').select2({
        allowClear: true,
        multiple: true,
    });
    if ( $.isFunction($.fn.select2) ) {
        jQuery('.tb-select2-skills').select2({
            multiple: true,
            placeholder: scripts_vars.skills_option
        });
    }
    jQuery('.tb-select2-skills').trigger('change');

    });";
wp_add_inline_script('taskbot', $scripts, 'after');