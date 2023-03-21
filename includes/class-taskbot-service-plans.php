<?php

/**
 *
 * Class 'Taskbot_Service_Plans' defines task plans
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package     Taskbot
 * @subpackage  Taskbot/includes
 * @author      Amentotech <info@amentotech.com>
 * @link        https://codecanyon.net/user/amentotech/portfolio
 * @version     1.0
 * @since       1.0
*/

if (!class_exists('Taskbot_Service_Plans')){

    class Taskbot_Service_Plans{

        private static $instance = null;

        public function __construct(){

        }

        /**
         * Returns the *Singleton* instance of this class.
         *
         * @return
         * @throws error
         * @author Waleed Elsefy <waleedelsefy@gmail.com>
         */
        public static function getInstance(){

            if (self::$instance==null){
                self::$instance = new Taskbot_Service_Plans();
            }
            return self::$instance;
        }

        /**
         * @ Default task plans
         * @return
        */
        public static function service_plans(){


            $taskbot_service_plans = array(
                'basic' => array(
                        'description'=> array(
                        'id'            => 'description',
                        'label'         => esc_html__('Description', 'taskbot'),
                        'type'          => 'textarea',
                        'default_value' => '',
                        'class'         =>'description',
                        'placeholder'   => esc_html__('Description', 'taskbot'),
                        'title'         => esc_html__('Please enter description', 'taskbot'),
                       
                    ),
                    'price'=> array(
                        'id'            => 'price',
                        'label'         => esc_html__('Price', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'placeholder'   => esc_html__('Price', 'taskbot'),
                        'title'         => esc_html__('Please enter price', 'taskbot'),
                        ),
                           'acqui_perc'    => array(
                            'id' => 'acqui_perc',
                            'label' => esc_html__('Acquisition Percentage', 'taskbot'),
                            'type' => 'number',
                            'min' => 0,
                            'max' => 100,
                            'default_value' => '',
                            'class' =>'acqui_perc',
                            'placeholder' => esc_html__('Acquisition Percentage', 'taskbot'),
                            'title' => esc_html__('Please enter Acquisition Percentage', 'taskbot'),
                            'required' => false,
                        ),


                    'reported'=> array(
                        'id'            => 'reported',
                        'label'         => esc_html__('Reported Sales in last 12 months', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'reported',
                        'placeholder'   => esc_html__('EGP 4 - 5 million', 'taskbot'),
                        'title'         => esc_html__('Please enter Reported Sales in last 12 months', 'taskbot'),
                       

                    ),
                    'rate'=> array(
                        'id'            => 'rate',
                        'label'         => esc_html__('Run Rate Sales', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'rate',
                        'placeholder'   => esc_html__('EGP 4.2 million', 'taskbot'),
                        'title'         => esc_html__('Please enter Run Rate Sales', 'taskbot'),
                       

                    ),
                    'margin'=> array(
                        'id'            => 'margin',
                        'label'         => esc_html__('Run EBITDA Margin', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 0,
                        'default_value' => '',
                        'class'         =>'margin',
                        'placeholder'   => esc_html__('20 - 30 %', 'taskbot'),
                        'title'         => esc_html__('Please enter EBITDA Margin>', 'taskbot'),
                       

                    ),
                    'established>'=> array(
                        'id'            => 'established',
                        'label'         => esc_html__('Established', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 99,
                        'default_value' => '',
                        'class'         =>'established',
                        'placeholder'   => esc_html__('5-10 year(s)', 'taskbot'),
                        'title'         => esc_html__('Please enter established', 'taskbot'),
                       

                    ),
                    'emply'=> array(
                        'id'            => 'emply',
                        'label'         => esc_html__('Employees', 'taskbot'),
                        'type'          => 'number',
                        'min'           => 0,
                        'max'           => 150,
                        'default_value' => '',
                        'class'         =>'emply',
                        'placeholder'   => esc_html__('10 - 50', 'taskbot'),
                        'title'         => esc_html__('Please enter Employees', 'taskbot'),
                        'required'      => false,

                    ),


                ),

            );

            return apply_filters('taskbot_service_plans', $taskbot_service_plans);
        }

    }
}