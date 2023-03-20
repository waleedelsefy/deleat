    <?php
    /**
     *  FAQs
     *
     * @package     Taskbot
     * @subpackage  Taskbot/templates/post_services
     * @author      Amentotech <info@amentotech.com>
     * @link        https://codecanyon.net/user/amentotech/portfolio
     * @version     1.0
     * @since       1.0
    */
    $current_page_url   = get_the_permalink();
    if(isset($_GET['postid']) && !empty($_GET['postid'])){
        $post_id = intval($_GET['postid']);
        $current_page_url   = add_query_arg('post', $post_id, $current_page_url);
    }

    $current_page_url   = add_query_arg('step', $step, $current_page_url);

    if ( !class_exists('WooCommerce') ) {
        return;
    }

    $taskbot_plans_values = get_post_meta($post_id, 'taskbot_product_plans', TRUE);
    $taskbot_service_plans = Taskbot_Service_Plans::service_plans();?>
    <div id="service-pricing-wrapper">
        <form id="service-faqs-form" class="tb-themeform" action="<?php echo esc_url($current_page_url);?>" method="post" novalidate enctype="multipart/form-data">
            <fieldset>
                <div class="form-group tb-uploadbar-listholder">
                    <div class="tb-postserviceholder">
                        <div class="tb-postservicetitle">
                            <h4><?php esc_html_e('Common FAQ’s', 'taskbot');?></h4>
                        </div>
                        <ul id="tbslothandle" class="tb-uploadbar-list">
                            <?php
                            // Add the five obligatory questions and answers
                            $obligatory_questions = array(
                                array(
                                    'question' => 'Can you provide some background information about your business and what makes your project unique compared to others in your industry?',
                                    'answer' => '',
                                ),
                                array(
                                    'question' => 'What inspired you to list your project on this particular listing site, and what benefits do you hope to gain from doing so?',
                                    'answer' => '',
                                ),
                                array(
                                    'question' => 'Can you share any success stories or milestones your business has achieved so far, and what you attribute those successes to?',
                                    'answer' => '',
                                ),
                                array(
                                    'question' => 'What motivated you to list your project for sale, and what do you hope to achieve through the sale of your business?',
                                    'answer' => '',
                                ),

                            );
                            foreach ($obligatory_questions as $key => $taskbot_faq) { ?>
                                <li id="taskbot-faq-<?php echo esc_attr($key);?>" class="taskbot-faqlistitem">
                                    <div class="tb-uploadbar-content" data-bs-toggle="collapse" data-bs-target="#faquploadbar<?php echo esc_attr($key);?>" role="list" aria-expanded="false">
                                        <h6><?php echo esc_html($taskbot_faq['question']);?></h6>
                                    </div>
                                    <div id="faquploadbar<?php echo esc_attr($key);?>" class="collapse" data-bs-parent="#tbslothandle">
                                        <div class="tb-uploadcontent">
                                            <div class="tb-profileform__content">
                                                <label class="tb-titleinput"><?php esc_html_e('Question', 'taskbot');?>:</label>
                                                <input type="text" name="faq[<?php echo esc_attr($key);?>][question]"  class="form-control" placeholder="<?php esc_attr_e('Add title', 'taskbot');?>" autocomplete="off" value="<?php echo esc_attr($taskbot_faq['question']);?>" readonly>
                                            </div>
                                            <div class="tb-profileform__content">
                                                <label class="tb-titleinput"><?php esc_html_e('Add faq description', 'taskbot');?>:</label>
                                                <textarea class="form-control" name="faq[<?php echo esc_attr($key);?>][answer]" placeholder="<?php esc_attr_e('Description', 'taskbot');?>"><?php echo esc_html($taskbot_faq['answer']);?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="form-group tb-postserviceformbtn">
                    <div class="tb-savebtn">
                        <span><?php esc_html_e('Click “Save &amp; Update” to submit task', 'taskbot');?></span>
                        <button type="submit" class="tb-btn tb-service-plans"><?php esc_html_e('Submit task', 'taskbot');?></button>
                        <input type="hidden" name="post_id" id="service_id" value="<?php echo (int)$post_id;?>">
                    </div>
                </div>
            </fieldset>


        </form>
        <script type="text/template" id="tmpl-load-service-faq">
            <li id="taskbot-faq-{{data.id}}" class="taskbot-faqlist">
                <div class="tb-uploadbar-content" data-bs-toggle="collapse" data-bs-target="#uploadbar{{data.id}}" role="list" aria-expanded="false">
                    <h6>{{data.question}}</h6>
                </div>
                <div id="uploadbar{{data.id}}" class="collapse" data-bs-parent="#tbslothandle">
                    <div class="tb-uploadcontent">
                        <div class="tb-profileform__content">
                            <label class="tb-titleinput"><?php esc_html_e('Question', 'taskbot');?>:</label>
                            <input type="text" name="faq[{{data.id}}][question]" value="{{data.question}}"  class="form-control" placeholder="<?php esc_attr_e('Enter question here', 'taskbot');?>" autocomplete="off">
                        </div>
                        <div class="tb-profileform__content">
                            <label class="tb-titleinput"><?php esc_html_e('Add faq description', 'taskbot');?>:</label>
                            <textarea class="form-control" name="faq[{{data.id}}][answer]" placeholder="<?php esc_attr_e('Enter description', 'taskbot');?>">{{data.answer}}</textarea>
                        </div>
                        <div class="tb-profileform__content">
                            <label class="tb-titleinput"></label>
                            <div class="tb-dhbbtnarea">
                                <a href="javascript:void(0);" class="tb-btn tb-btnvthree taskbot-faq-delete" data-faq_key="{{data.id}}"><?php esc_html_e('Delete', 'taskbot');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </script>
    </div>