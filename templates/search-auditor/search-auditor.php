<?php
/*
* Auditor Search
*/
get_header();
global $paged, $current_user,$taskbot_settings;

$hide_filter_type               = !empty($taskbot_settings['hide_auditor_filter_type']) ? $taskbot_settings['hide_auditor_filter_type'] : false;
$hide_filter_location           = !empty($taskbot_settings['hide_auditor_filter_location']) ? $taskbot_settings['hide_auditor_filter_location'] : false;
$hide_filter_skills             = !empty($taskbot_settings['hide_auditor_filter_skills']) ? $taskbot_settings['hide_auditor_filter_skills'] : false;
$hide_filter_level              = !empty($taskbot_settings['hide_auditor_filter_level']) ? $taskbot_settings['hide_auditor_filter_level'] : false;
$hide_filter_languages          = !empty($taskbot_settings['hide_auditor_filter_language']) ? $taskbot_settings['hide_auditor_filter_language'] : false;
$hide_filter_price              = !empty($taskbot_settings['hide_auditor_filter_price']) ? $taskbot_settings['hide_auditor_filter_price'] : false;
$hide_auditor_without_avatar              = !empty($taskbot_settings['hide_auditor_without_avatar']) ? $taskbot_settings['hide_auditor_without_avatar'] : 'no';


$listing_type       = !empty($taskbot_settings['auditor_listing_type']) ? $taskbot_settings['auditor_listing_type'] : 'left';
$pg_page            = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged           = get_query_var('paged') ? get_query_var('paged') : 1; 
$tax_query_args     = $query_args = $meta_query_args = array();
$per_page           = get_option('posts_per_page');

$tax_queries            = array();

$search_keyword     = !empty($_GET['keyword']) ? esc_html($_GET['keyword']) : '';
$auditor_type        = !empty($_GET['auditor_type']) ? $_GET['auditor_type'] : array();
$english_level      = !empty($_GET['english_level']) ? $_GET['english_level'] : array();
$hourly_rate_start  = !empty( $_GET['min_price'] ) ? intval($_GET['min_price']) : 0;
$hourly_rate_end    = !empty( $_GET['max_price'] ) ? intval($_GET['max_price']) : 0;
$auditor_location    = !empty($_GET['location']) ? esc_html($_GET['location']) : '';
$state              = !empty($_GET['state']) ? esc_html($_GET['state']) : '';
$sorting            = !empty($_GET['sort_by']) ? esc_attr($_GET['sort_by']) : '';
$skills             = !empty($_GET['skills']) ? $_GET['skills'] : array();
$languages          = !empty($_GET['languages']) ? $_GET['languages'] : array();
if (class_exists('WooCommerce')) {
	$countries_obj   	= new WC_Countries();
	$countries   		= $countries_obj->get_allowed_countries('countries');
    if( is_array($countries) && count($countries) === 1 ){
        $country                = array_key_first($countries);
        $auditor_location        = $country;
    }
}
$per_page           = !empty($per_page) ? $per_page : 10;

/* Auditor type */
if ( is_array($auditor_type) && !empty($auditor_type) ) {
    $tax_query_args[] = array(
        'taxonomy' => 'tb_auditor_type',
        'field'    => 'slug',
        'terms'    => $auditor_type,
        'operator' => 'IN',
    );
}

//skills
if ( !empty($skills[0]) && is_array($skills) ) {   
	$query_relation = array('relation' => 'OR',);
	$type_args  	= array();
	foreach( $skills as $key => $type ){
		$type_args[] = array(
			'taxonomy' => 'skills',
			'field'    => 'slug',
			'terms'    => esc_attr($type),
		);
	}

	$tax_query_args[] = array_merge($query_relation, $type_args);   
}

//Languages
if ( !empty($languages[0]) && is_array($languages) ) {   
	$query_relation = array('relation' => 'OR',);
	$lang_args  	= array();

	foreach( $languages as $key => $lang ){
		$lang_args[] = array(
				'taxonomy' => 'languages',
				'field'    => 'slug',
				'terms'    => esc_attr($lang),
			);
	}

	$tax_query_args[] = array_merge($query_relation, $lang_args);   
}

/* English Level */
if ( is_array($english_level) && !empty($english_level) ) {
    $tax_query_args[] = array(
        'taxonomy' => 'tb_english_level',
        'field'    => 'slug',
        'terms'    => $english_level,
        'operator' => 'IN',
    );
}

/* Location */
if ( !empty($auditor_location) ) {
    $meta_query_args[] = array(
        'key'       => 'country',
        'value'     => $auditor_location,
        'compare'   => '=',
    );
    if( !empty($state) ){
        $countries_obj  = new WC_Countries();
        $countries      = $countries_obj->get_allowed_countries('countries');
        $states_list    = $countries_obj->get_states( $auditor_location );
        if( !empty($states_list[$state]) ){
            $meta_query_args[] = array(
                'key'       => 'state',
                'value'     => $state,
                'compare'   => '=',
            );
        }
    }
}

/* Hourly Rate */
if ( !empty($hourly_rate_start) && !empty($hourly_rate_end) ) {
    $meta_query_args[] = array(
        'key'         => 'tb_hourly_rate',
        'value'       => array($hourly_rate_start, $hourly_rate_end),
        'compare'     => 'BETWEEN',
        'type'        => 'NUMERIC'
    );
}

$meta_query_args[] = array(
    'key'       => '_is_verified',
    'value'     => 'yes',
    'compare'   => '=',
);

if(!empty($hide_auditor_without_avatar) && $hide_auditor_without_avatar === 'yes'){
    $meta_query_args[] = array(
        'key'       => 'is_avatar',
        'value'     => 1,
        'compare'   => '=',
    );
}

$query_args = array(
    'posts_per_page'        => $per_page,
    'paged'                 => $paged,
    'post_type'             => 'auditors',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1
);

// if keyword field is set in search then append its args in $query_args
if (!empty($search_keyword)){

    $filtered_args['keyword'] = array(
        's' => $search_keyword,
    );

    $query_args = array_merge($query_args,$filtered_args['keyword']);
}

//Meta Query
if (!empty($meta_query_args)) {
    $query_relation           = array('relation' => 'AND',);
    $meta_query_args          = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

/* Taxonomy Query */
if (!empty($tax_query_args)) {
    $query_relation           = array('relation' => 'AND',);
    $tax_query_args           = array_merge($query_relation, $tax_query_args);
    $query_args['tax_query']  = $tax_query_args;
}


if (!empty($sorting)) {
    $filtered_args = array();
    // filter latest product
    if ($sorting == 'date_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'date',
            'order' 	=> 'DESC',
        );
    } elseif ($sorting == 'price_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> 'tb_hourly_rate',
            'order' 	=> 'desc',
        );
    } elseif ($sorting == 'price_asc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> 'tb_hourly_rate',
            'order' 	=> 'asc',
        );
    } elseif ($sorting == 'views_desc') {
        $filtered_args['sort_by'] = array(
            'orderby' 	=> 'meta_value_num',
            'meta_key' 	=> 'taskbot_profile_views',
            'order' 	=> 'desc',
        );
    }
	
    $query_args = array_merge($query_args, $filtered_args['sort_by']);
}

$auditor_data = new WP_Query(apply_filters('taskbot_freelancer_search_filter', $query_args));
$total_posts = $auditor_data->found_posts;

$page_object_id     = get_queried_object_id();
$current_page_url   = get_permalink( $page_object_id );
if( !empty($listing_type) && $listing_type === 'top' ){
    $theme_version 	                = wp_get_theme();
    $grid_arg                       = array();
    $grid_arg['sorting']            = $sorting;
    $grid_arg['per_page']           = $per_page;
    $grid_arg['auditor_type']        = $auditor_type;
    $grid_arg['auditor_data']        = $auditor_data;
    $grid_arg['search_keyword']     = $search_keyword;
    $grid_arg['total_posts']        = $total_posts;
    $grid_arg['page_object_id']     = $page_object_id;
    $grid_arg['current_page_url']   = $current_page_url;
    $grid_arg['hourly_rate_start']  = $hourly_rate_start;
    $grid_arg['hourly_rate_end']    = $hourly_rate_end;
    $grid_arg['auditor_location']    = $auditor_location;
    $grid_arg['english_level']      = $english_level;
    if(!empty($theme_version->get( 'TextDomain' )) && ( $theme_version->get( 'TextDomain' ) === 'taskup' || $theme_version->get( 'TextDomain' ) === 'taskup-child' )){
        get_template_part( 'template-parts/find', 'auditors', $grid_arg);
    }    
} else {
?>
<main class="tb-main overflow-hidden tb-main-bg">
    <section class="tb-searchresult-section">
        <div class="container">
            <div class="tb-freelancersearch">
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="tk-sort">
                            <h3><?php echo sprintf(esc_html__('%s search result(s)','taskbot'), $total_posts) ?></h3>
                            <?php do_action('taskbot_project_price_sortby_filter_theme', $sorting); ?>
                            <div class="tk-filtermenu">
                                <a href="javascript:();" class="tk-filtericon"><i class="icon-sliders"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xxl-3 tk-mt0">
                        <form id="tb_sort_form" class="tk-searchlist">
                            <input type="hidden" name="sort_by" id="tb_sort_by_filter" value="<?php echo esc_attr($sorting); ?>">
                            <aside class="tb-sidebar">
                                <div class="tk-aside-holder">
                                    <div class="tb-sidebartitle" data-bs-toggle="collapse" data-bs-target="#search" role="button" aria-expanded="true">
                                        <h5><?php esc_html_e('Narrow your search', 'taskbot'); ?></h5>
                                    </div>
                                    <div class="tb-sidebarcontent collapse show" id="search">
                                        <?php do_action('taskbot_keyword_search',$search_keyword); ?>
                                    </div>
                                </div>
                                <?php 
									if( !empty($hide_filter_type) ){ do_action('taskbot_render_auditor_type_filter_html',$auditor_type); }
									if( !empty($hide_filter_level) ){ do_action('taskbot_render_english_level_filter_html',$english_level);}
                                    if( !empty($hide_filter_location) ){ do_action('taskbot_location_search_field', $auditor_location);}
                                    if( !empty($hide_filter_skills) ){ do_action('taskbot_skills_filter_theme', $skills);}
                                    if( !empty($hide_filter_languages) ){ do_action('taskbot_languages_filter_theme', $languages); }
                                    if( !empty($hide_filter_price) ){ do_action('taskbot_render_price_range_filter_html', esc_html__('Funding required','taskbot'), $hourly_rate_start, $hourly_rate_end);}
                                    do_action('taskbot_extend_freelancer_search_filter');
                                    do_action('taskbot_search_clear_button_theme', esc_html__('Search now','taskbot'), $current_page_url); 
                                ?>
                            </aside>
                        </form>
                    </div>
                    <div class="col-lg-8 col-xxl-9">
                        <?php if ($auditor_data->have_posts()) {
                            while ($auditor_data->have_posts()) {
                                $auditor_data->the_post();
                                $auditor_id        = get_the_ID();
                                $auditor_name      = taskbot_get_username($auditor_id);
                                $tb_post_meta     = get_post_meta($auditor_id, 'tb_post_meta', true);
                                $auditor_tagline   = !empty($tb_post_meta['tagline']) ? $tb_post_meta['tagline'] : '';
                                $app_task_base      		    = taskbot_application_access('task');
                                $skills_base                    = 'project';
                                if( !empty($app_task_base) ){
                                    $skills_base    = 'service';
                                }
                                ?>
                                <div class="tb-bestservice">
                                    <div class="tb-bestservice__content tb-bestservicedetail">
                                        <div class="tb-bestservicedetail__user">
                                            <div class="tk-price-holder">
                                                <div class="tb-asideprostatus">
                                                    <?php do_action('taskbot_profile_image', $auditor_id,'',array('width' => 300, 'height' => 300));?>
                                                    <div class="tb-bestservicedetail__title">
                                                        <?php if( !empty($auditor_name) ){?>
                                                            <h6>
                                                                <a href="<?php echo esc_url( get_permalink()); ?>"><?php echo esc_html($auditor_name); ?></a>
                                                                <?php do_action( 'taskbot_verification_tag_html', $auditor_id ); ?>
                                                            </h6>
                                                        <?php } ?>
                                                        <?php if( !empty($auditor_tagline) ){?>
                                                            <h5><?php echo esc_html($auditor_tagline); ?></h5>
                                                        <?php } ?>
                                                        <ul class="tb-rateviews">
                                                            <?php do_action('taskbot_get_freelancer_rating_cuont', $auditor_id); ?>
                                                            <?php do_action('taskbot_get_freelancer_views', $auditor_id); ?>
                                                            <?php do_action('taskbot_save_freelancer_html', $current_user->ID, $auditor_id, '_saved_auditors', '', 'auditors'); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php do_action('taskbot_user_hourly_starting_rate', $auditor_id); ?>
                                            </div>
                                            <div class="tk-tags-holder">
                                                <?php the_excerpt(); ?>
                                                <?php do_action( 'taskbot_term_tags', $auditor_id,'skills','',15,$skills_base );?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                            }
                        } else {
                            do_action( 'taskbot_empty_listing', esc_html__('Oops!! Record not found', 'taskbot') );
                        }
                        ?>
                        <?php if($total_posts > $per_page){?>
                            <?php taskbot_paginate($auditor_data); ?>
                        <?php }?>
                    </div>
                    <?php wp_reset_postdata();?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php }
get_footer();
