<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Repeater;
use \Elementor\Control_Media;
use \Elementor\Utils;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Xolio Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Genix_Pricing extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tg-pricing';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Pricing', 'genixcore');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'genix-icon eicon-price-table';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['genixcore'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['genixcore'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls()
    {

        // Header
        $this->start_controls_section(
            '_section_header',
            [
                'label' => esc_html__('Header', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tg_is_active',
            [
                'label' => esc_html__('Select Pricing Type', 'genixcore'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'genixcore'),
                    'active' => esc_html__('Popular', 'genixcore'),
                ],
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'tg_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-trophy',
                ]
            );
        } else {
            $this->add_control(
                'tg_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-trophy',
                        'library' => 'solid',
                    ],
                ]
            );
        }

        $this->add_control(
            'trophy_price',
            [
                'label' => esc_html__('Trophy Price', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('25000', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->end_controls_section();

        // CountDown Time
        $this->start_controls_section(
            '_section_time',
            [
                'label' => esc_html__('CountDown Time', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tg_countdown_time',
            [
                'label' => esc_html__('Countdown Date', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'description' => 'dateFormat: "Y-m-d" hh:mm:ss',
                'default' => esc_html__('2024/8/29 12:34:56', 'genixcore'),
                'placeholder' => esc_html__('Select Countdown Date', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Title
        $this->start_controls_section(
            '_section_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Sub Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('TOURNAMENT', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'main_title',
            [
                'label' => esc_html__('Package Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('of weekly', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->end_controls_section();

        // Prize Place
        $this->start_controls_section(
            '_section_prize',
            [
                'label' => esc_html__('Prize Place', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'prize_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-trophy',
                ]
            );
        } else {
            $this->add_control(
                'prize_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-trophy',
                        'library' => 'solid',
                    ],
                ]
            );
        }

        $this->add_control(
            'prize_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('3 prize Places', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->end_controls_section();

        // Pricing List
        $this->start_controls_section(
            '_section_price_list',
            [
                'label' => esc_html__('Pricing List', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_img',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'list_name',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('List Name', 'genixcore'),
                'default' => esc_html__('black ninja', 'genixcore'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'list_price',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('List Price', 'genixcore'),
                'default' => esc_html__('$ 75000', 'genixcore'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tg_list_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-bolt',
                ]
            );
        } else {
            $repeater->add_control(
                'tg_list_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-bolt',
                        'library' => 'solid',
                    ],
                ]
            );
        }

        $this->add_control(
            'list_items',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_name' => esc_html__('black ninja', 'genixcore'),
                    ],
                    [
                        'list_name' => esc_html__('Foxtie Max', 'genixcore'),
                    ],
                    [
                        'list_name' => esc_html__('Holam Doxe', 'genixcore'),
                    ],
                ],
                'title_field' => '{{ list_name }}',
            ]
        );

        $this->end_controls_section();

        // tg_btn_button_group
        $this->start_controls_section(
            'tg_btn_button_group',
            [
                'label' => esc_html__('Button', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_btn_link_type',
            [
                'label' => esc_html__('Button Link Type', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => 'Custom Link',
                    '2' => 'Internal Page',
                ],
                'default' => '1',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tg_btn_link',
            [
                'label' => esc_html__('Button link', 'genixcore'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'genixcore'),
                'show_external' => false,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                    'custom_attributes' => '',
                ],
                'condition' => [
                    'tg_btn_link_type' => '1',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'tg_btn_page_link',
            [
                'label' => esc_html__('Select Button Page', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => genix_get_all_pages(),
                'condition' => [
                    'tg_btn_link_type' => '2',
                ]
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {

        $settings = $this->get_settings_for_display();

        // Link
        if ('2' == $settings['tg_btn_link_type']) {
            $this->add_render_attribute('tg-button-arg', 'href', get_permalink($settings['tg_btn_page_link']));
            $this->add_render_attribute('tg-button-arg', 'target', '_self');
            $this->add_render_attribute('tg-button-arg', 'rel', 'nofollow');
            $this->add_render_attribute('tg-button-arg', 'class', 'position-absolute l-0 t-0 w-100 h-100');
        } else {
            if (!empty($settings['tg_btn_link']['url'])) {
                $this->add_link_attributes('tg-button-arg', $settings['tg_btn_link']);
                $this->add_render_attribute('tg-button-arg', 'class', 'position-absolute l-0 t-0 w-100 h-100');
            }
        } ?>

        <script>
            jQuery(document).ready(function($) {

                /*=============================================
                    =    	  Countdown Active  	         =
                =============================================*/
                $('[data-countdown]').each(function() {
                    var $this = $(this),
                        finalDate = $(this).data('countdown');
                    $this.countdown(finalDate, function(event) {
                        $this.html(event.strftime('<div class="time-count day"><span>%D</span>Day</div><div class="time-count hour"><span>%H</span>hour</div><div class="time-count min"><span>%M</span>min</div><div class="time-count sec"><span>%S</span>sec</div>'));
                    });
                });

            });
        </script>

        <div class="tournament__box-wrap <?php echo esc_attr($settings['tg_is_active']) ?>">
            <svg class="main-bg" x="0px" y="0px" preserveAspectRatio="none" viewBox="0 0 357 533" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.00021 63H103C103 63 114.994 62.778 128 50C141.006 37.222 168.042 13.916 176 10C183.958 6.084 193 1.9 213 2C233 2.1 345 1 345 1C347.917 1.66957 350.51 3.33285 352.334 5.70471C354.159 8.07658 355.101 11.0093 355 14C355.093 25.1 356 515 356 515C356 515 357.368 529.61 343 530C328.632 530.39 15.0002 532 15.0002 532C15.0002 532 0.937211 535.85 1.00021 522C1.06321 508.15 2.00021 63 2.00021 63Z" fill="#19222B" stroke="#4C4C4C" stroke-width="0.25" />
            </svg>
            <svg class="price-bg" viewBox="0 0 166 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00792892 55V11C0.00792892 11 -0.729072 0.988 12.0079 1C24.7449 1.012 160.008 0 160.008 0C160.008 0 172.491 1.863 161.008 10C148.995 18.512 115.008 48 115.008 48C115.008 48 110.021 55.238 90.0079 55C69.9949 54.762 0.00792892 55 0.00792892 55Z" fill="currentcolor" />
            </svg>

            <div class="tournament__box-price">
                <?php if (!empty($settings['tg_icon']) || !empty($settings['tg_selected_icon']['value'])) : ?>
                    <?php genix_render_icon($settings, 'tg_icon', 'tg_selected_icon'); ?>
                <?php endif; ?>
                <span><?php echo genix_kses($settings['trophy_price']); ?></span>
            </div>

            <?php if (!empty($settings['tg_countdown_time'])) : ?>
                <div class="tournament__box-countdown">
                    <div class="coming-time" data-countdown="<?php echo esc_attr($settings['tg_countdown_time']); ?>"></div>
                </div>
            <?php endif; ?>

            <div class="tournament__box-caption">
                <?php if (!empty($settings['sub_title'])) : ?>
                    <span class="sub"><?php echo genix_kses($settings['sub_title']); ?></span>
                <?php endif; ?>
                <?php if (!empty($settings['main_title'])) : ?>
                    <h4 class="title"><?php echo genix_kses($settings['main_title']); ?></h4>
                <?php endif; ?>
            </div>

            <div class="tournament__box-prize position-relative">
                <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>></a>
                <?php if (!empty($settings['prize_icon']) || !empty($settings['prize_selected_icon']['value'])) : ?>
                    <?php genix_render_icon($settings, 'prize_icon', 'prize_selected_icon'); ?>
                <?php endif; ?>
                <?php if (!empty($settings['prize_title'])) : ?>
                    <span><?php echo genix_kses($settings['prize_title']); ?></span>
                <?php endif; ?>
            </div>

            <ul class="tournament__box-list list-wrap">
                <?php foreach ($settings['list_items'] as $item) : ?>
                    <li>
                        <div class="tournament__box-list-item">
                            <?php if (!empty($item['list_img']['url'])) : ?>
                                <div class="tournament__player-thumb">
                                    <img src="<?php echo esc_url($item['list_img']['url']); ?>" alt="<?php echo esc_attr__('Images', 'genixcore') ?>">
                                </div>
                            <?php endif; ?>
                            <h6 class="tournament__player-name"><?php echo esc_html($item['list_name']); ?></h6>
                            <span class="tournament__player-price">
                                <?php echo esc_html($item['list_price']); ?>
                                <?php if (!empty($item['tg_list_icon']) || !empty($item['tg_list_selected_icon']['value'])) : ?>
                                    <?php genix_render_icon($item, 'tg_list_icon', 'tg_list_selected_icon'); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

<?php
    }
}

$widgets_manager->register(new Genix_Pricing());
