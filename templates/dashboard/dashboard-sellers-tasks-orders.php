<?php
/**
 * Owner order listings
 *
 * @package     Taskbot
 * @subpackage  Taskbot/templates/dashboard
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

global  $current_user;
$ref                = !empty($_GET['ref']) ? esc_html($_GET['ref']) : '';
$mode               = !empty($_GET['mode']) ? esc_html($_GET['mode']) : '';
$user_identity      = !empty($_GET['identity']) ? intval($_GET['identity']) : 0;
$current_page_link  = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, '');
$current_page_link  = !empty($current_page_link) ? $current_page_link : '';
$page_title_key     = !empty($_GET['order_type']) ? esc_html($_GET['order_type']) : esc_html__('All','taskbot');

if (!class_exists('WooCommerce')) {
    return;
}

if (!empty($page_title_key) && $page_title_key == 'hired'){
    $page_title_key   = esc_html__('Ongoing','taskbot');
} elseif (!empty($page_title_key) && $page_title_key == 'any'){
    $page_title_key   = esc_html__('All','taskbot');
}

$page_title     = wp_sprintf('%s %s',$page_title_key,esc_html__('order listings', 'taskbot'));
$show_posts     = get_option('posts_per_page') ? get_option('posts_per_page') : 10;
$pg_page        = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged       = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$task_id        = !empty($_GET['id']) ? intval($_GET['id']) : 0;
$paged          = max($pg_page, $pg_paged);
$order_type     = !empty($_GET['order_type']) ? $_GET['order_type'] : 'any';
$menu_order     = taskbot_list_tasks_order_status_filter();
$order          = 'DESC';
$sorting        = 'ID';
$order_status   = array('wc-completed', 'wc-pending', 'wc-on-hold', 'wc-cancelled', 'wc-refunded', 'wc-processing');
$page_url       = Taskbot_Profile_Menu::taskbot_profile_menu_link($ref, $user_identity, true, $mode);
// basic order query args
$args = array(
    'posts_per_page'    => $show_posts,
    'post_type'         => 'shop_order',
    'orderby'           => $sorting,
    'order'             => $order,
    'post_status'       => $order_status,
    'paged'             => $paged,
    'suppress_filters'  => false
);

// check and get values from search form
$search_keyword  = (isset($_GET['search_keyword'])  && !empty($_GET['search_keyword'])   ? $_GET['search_keyword']   : "");

/* search in product snippet */
// if $search_keyword field is set then prepare query to find and get product/task ids that contains search keyword
if (!empty($search_keyword)){

    $tax_queries  = array();
    $meta_queries = array();
    $product_ids  = array();
    // product_type taxonomy args
    $product_type_tax_args[] = array(
        'taxonomy' => 'product_type',
        'field'    => 'slug',
        'terms'    => 'tasks',
    );

    // append product_type taxonomy args in $tax_queries array
    $tax_queries  = array_merge($tax_queries,$product_type_tax_args);

    // prepared query args
    $search_args  = array(
        'post_type'         => 'product',
        'fields'            => 'ids',
        'post_status'       => 'any',
        's'                 => $search_keyword,
        'tax_query'         => $tax_queries,
    );

    // get product ids
    $product_ids = get_posts( $search_args );

    // if no product ids found against search keyword then set $product_ids as -1 in order to make meta query formatted
    if (empty($product_ids)){
        $product_ids  = array(-1);
    }

    $meta_query_args[] = array(
        'key' 		=> 'task_product_id',
        'value' 	=> $product_ids,
        'compare'   => 'IN'
    );
}

/* search in product snippet end */
$meta_query_args[] = array(
    'key' 		=> 'payment_type',
    'value' 	=> 'tasks',
    'compare'   => '='
);
$meta_query_args[] = array(
    'key' 		=> 'seller_id',
    'value' 	=> $user_identity,
    'compare'   => '='
);

if(!empty($order_type) && $order_type!= 'any' ){
    $meta_query_args[]  = array(
        'key' 		=> '_task_status',
        'value' 	=> $order_type,
        'compare'   => '='
    );
}

$query_relation     = array('relation' => 'AND',);
$args['meta_query'] = array_merge($query_relation, $meta_query_args);
$query              = new WP_Query($args);
$count_post         = $query->found_posts;

?>
<div class="tb-dhb-mainheading">
    <h2><?php esc_html_e('All offers','taskbot');?></h2>
    <div class="tb-sortby">
        <div class="tb-actionselect tb-actionselect2">
            <span><?php esc_html_e('Filter by:','taskbot');?></span>
            <div class="tb-select">
                <select id="tb_order_type" name="order_type" class="form-control tk-selectv">
                    <?php foreach($menu_order as $key => $val ){
                        $selected   = '';

                        if( !empty($order_type) && $order_type == $key ){
                            $selected   = 'selected';
                        }
                        ?>
                        <option data-url="<?php echo esc_url($page_url);?>&order_type=<?php echo esc_attr($key);?>" value="<?php echo esc_attr($key);?>" <?php echo esc_attr($selected);?>>
                            <?php echo esc_html($val);?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="tb-dhbtabs tb-tasktabs">
    <div class="tab-content tab-taskcontent">
        <div class="tab-pane fade active show">
            <div class="tb-tabtasktitle">
                <h5 class="selected-filter"><?php echo esc_html($page_title);?></h5>
                <form class="tb-themeform" action="<?php echo esc_url( $current_page_link ); ?>">
                    <input type="hidden" name="ref" value="<?php echo esc_attr($ref); ?>">
                    <input type="hidden" name="identity" value="<?php echo esc_attr($user_identity); ?>">
                    <fieldset>
                        <div class="tb-themeform__wrap ">
                            <div class="form-group wo-inputicon">
                                <i class="icon-search"></i>
                                <input type="text" name="search_keyword" class="form-control"
                                    value="<?php echo esc_attr($search_keyword) ?>"
                                    placeholder="<?php esc_attr_e('Search Business here','taskbot');?>">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php if (class_exists('WooCommerce')) {?>
                <?php if( $query->have_posts() ){?>
                    <div class="tb-tasklist">
                        <?php while ($query->have_posts()) : $query->the_post();
                            global $post;
                            $order_id   = $post->ID;
                            $task_id    = get_post_meta( $order_id, 'task_product_id', true);
                            $task_id    = !empty($task_id) ? $task_id : 0;
                            $task_title = !empty($task_id) ? get_the_title( $task_id ) : '';

                            $seller_id      = get_post_meta( $order_id, 'seller_id', true);
                            $seller_id      = !empty($seller_id) ? intval($seller_id) : 0;

                            $order 		    = wc_get_order($order_id);
                            $order_price    = get_post_meta( $order_id, 'seller_shares', true);
                            $order_price    = !empty($order_price) ? ($order_price) : 0;

                            $buyer_id      = get_post_meta( $order_id, 'buyer_id', true);
                            $buyer_id      = !empty($buyer_id) ? intval($buyer_id) : 0;

                            $product_data   = get_post_meta( $order_id, 'cus_woo_product_data', true);
                            $product_data   = !empty($product_data) ? $product_data : array();
                            $order_url      = Taskbot_Profile_Menu::taskbot_profile_menu_link('tasks-orders', $user_identity, true, 'detail',$order_id);
                            ?>
                            <div class="tb-tabfilteritem">
                                <div class="tb-tabbitem__list">
                                    <div class="tb-deatlswithimg">
                                        <div class="tb-icondetails">
                                            <?php do_action( 'taskbot_task_order_status', $order_id );?>

                                            <?php if( !empty($task_id) ){
                                                echo do_action('taskbot_task_categories', $task_id, 'product_cat'); 
                                            }?>

                                            <?php if( !empty($task_title) ){?>
                                                <a href="<?php echo esc_url($order_url);?>">
                                                    <h5><?php echo esc_html($task_title);?></h5>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if( !empty($order_price) ){?>
                                    <div class="tb-itemlinks">
                                        <div class="tb-startingprice">
                                            <i><?php esc_html_e('Total business budget','taskbot');?></i>
                                            <span><?php taskbot_price_format($order_price);?></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php do_action( 'taskbot_task_complete_html', $order_id,'sellers');?>
                                <div class="tb-extras">
                                    <?php do_action( 'taskbot_task_author', $buyer_id, 'buyers' );?>
                                    <?php do_action( 'taskbot_order_date', $order_id );?>
                                    <?php do_action( 'taskbot_delivery_date', $order_id );?>
                                    <?php do_action( 'taskbot_subtasks_count', $product_data );?>
                                    <?php do_action( 'taskbot_price_plan', $order_id );?>
                                </div>
                            </div>
                        <?php endwhile;
                        ?>
                    </div>
                <?php } else {
                    do_action( 'taskbot_empty_listing', esc_html__('No orders found', 'taskbot'));
                } ?>
            <?php } else {              
                do_action( 'taskbot_empty_listing', esc_html__('WooCommerce plugin not installed', 'taskbot'));
            } ?>
        </div>
    </div>
</div>
<?php if( !empty($count_post) && $count_post > $show_posts ):?>
    <?php taskbot_paginate($query); ?>
<?php endif;?>
<?php wp_reset_postdata(); ?>
<?php
$script = "
jQuery(document).on('ready', function(){
    jQuery(document).on('change', '#tb_order_type', function (e) {
        let _this       = jQuery(this);
        let page_url = _this.find(':selected').data('url');
		window.location.replace(page_url);
    });
    jQuery('.tb_view_cancellation').on('click', function(){
        var _this       = jQuery(this);
        var order_id    = _this.data('order_id');
        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: 'POST',
            url: scripts_vars.ajaxurl,
            data: {
                'action'		: 'taskbot_tk_cancelled_view',
                'security'		: scripts_vars.ajax_nonce,
                'order_id'		: order_id,
            },
            dataType: 'json',
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    jQuery('#tb_tk_viewrating').html(response.html);
                    jQuery('#tb_excfreelancerpopup').modal('show');
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });
    });

    jQuery(document).on('click', '.tb_view_rating', function (e) {
        let rating_id		= jQuery(this).data('rating_id');

        jQuery('body').append(loader_html);
        jQuery.ajax({
            type: 'POST',
            url: scripts_vars.ajaxurl,
            data: {
                'action'		: 'taskbot_tk_rating_view',
                'security'		: scripts_vars.ajax_nonce,
                'rating_id'		: rating_id,
            },
            dataType: 'json',
            success: function (response) {
                jQuery('.tb-preloader-section').remove();

                if (response.type === 'success') {
                    jQuery('#tb_tk_viewrating').html(response.html);
                    jQuery('#tb_excfreelancerpopup').modal('show');
                } else {
                    StickyAlert(response.message, response.message_desc, {classList: 'danger', autoclose: 5000});
                }
            }
        });

    });
});
";
wp_add_inline_script( 'taskbot', $script, 'after' );
