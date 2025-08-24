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
class Genix_Tournament extends Widget_Base
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
        return 'tg-tournament';
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
        return __('Tournament', 'genixcore');
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
        return 'genix-icon eicon-post-list';
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

        // Image
        $this->start_controls_section(
            '_section_image',
            [
                'label' => esc_html__('Image', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'team_img',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
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
            'main_title',
            [
                'label' => esc_html__('Team Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('FOXTIE MAX', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Online Status', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Online', 'genixcore'),
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

        $this->add_control(
            'prize_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Prize', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
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
            'prize_amount',
            [
                'label' => esc_html__('Prize Money', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('$75000', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->end_controls_section();

        // Time
        $this->start_controls_section(
            '_section_time',
            [
                'label' => esc_html__('Time', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'time_title',
            [
                'label' => esc_html__('Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Time', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'time_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-clock',
                ]
            );
        } else {
            $this->add_control(
                'time_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-clock',
                        'library' => 'solid',
                    ],
                ]
            );
        }

        $this->add_control(
            'time_set',
            [
                'label' => esc_html__('Time Setup', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('10h : 15m', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->end_controls_section();

        // Live Button
        $this->start_controls_section(
            '_section_live_button',
            [
                'label' => esc_html__('Live Button', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Live Now', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );
        $this->add_control(
            'button_url',
            [
                'label' => esc_html__('Button URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('#', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'button_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-play',
                ]
            );
        } else {
            $this->add_control(
                'button_selected_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-play-circle',
                        'library' => 'solid',
                    ],
                ]
            );
        }

        $this->end_controls_section();

        // tg_btn_button_group
        $this->start_controls_section(
            'tg_btn_button_group',
            [
                'label' => esc_html__('Item Link', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_btn_link_type',
            [
                'label' => esc_html__('Item Link Type', 'genixcore'),
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
                'label' => esc_html__('Link', 'genixcore'),
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
                'label' => esc_html__('Select Link Page', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => genix_get_all_pages(),
                'condition' => [
                    'tg_btn_link_type' => '2',
                ]
            ]
        );

        $this->end_controls_section();

        // Style TAB
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_duration',
            [
                'label' => esc_html__('Animation Delay', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'genixcore'),
                    '.2s' => esc_html__('.2s', 'genixcore'),
                    '.4s' => esc_html__('.4s', 'genixcore'),
                    '.6s' => esc_html__('.6s', 'genixcore'),
                    '.8s' => esc_html__('.8s', 'genixcore'),
                    '1s' => esc_html__('1s', 'genixcore'),
                ],
                'default' => '.2s',
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
        } else {
            if (!empty($settings['tg_btn_link']['url'])) {
                $this->add_link_attributes('tg-button-arg', $settings['tg_btn_link']);
            }
        } ?>

        <div class="tournament__list-item wow fadeInUp" data-wow-delay="<?php echo esc_attr($settings['item_duration']) ?>">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" preserveAspectRatio="none" viewBox="0 0 1116.562 163.37">
                <path class="background-path" d="M708,1784l28-27s4.11-5.76,18-6,702-1,702-1a37.989,37.989,0,0,1,16,9c7.47,7.08,37,33,37,33s9.02,9.47,9,18,0,42,0,42-0.19,9.43-11,19-32,30-32,30-5.53,11.76-21,12-985,0-985,0a42.511,42.511,0,0,1-26-13c-11.433-12.14-34-32-34-32s-6.29-5.01-7-17,0-43,0-43-1-5.42,12-18,34-32,34-32,10.4-8.28,19-8,76,0,76,0a44.661,44.661,0,0,1,21,11c9.268,8.95,22,22,22,22Z" transform="translate(-401.563 -1749.875)" />
            </svg>
            <div class="tournament__list-content">
                <?php if (!empty($settings['team_img']['url'])) : ?>
                    <div class="tournament__list-thumb">
                        <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>>
                            <img src="<?php echo esc_url($settings['team_img']['url']); ?>" alt="<?php echo esc_attr__('Team Image', 'genixcore') ?>">
                        </a>
                    </div>
                <?php endif; ?>
                <div class="tournament__list-name">
                    <h5 class="team-name">
                        <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>>
                            <?php echo genix_kses($settings['main_title']); ?>
                        </a>
                    </h5>
                    <span class="status"><?php echo genix_kses($settings['sub_title']); ?></span>
                </div>
                <div class="tournament__list-prize">
                    <h6 class="title"><?php echo genix_kses($settings['prize_title']); ?></h6>
                    <?php if (!empty($settings['prize_icon']) || !empty($settings['prize_selected_icon']['value'])) : ?>
                        <?php genix_render_icon($settings, 'prize_icon', 'prize_selected_icon'); ?>
                    <?php endif; ?>
                    <span><?php echo genix_kses($settings['prize_amount']); ?></span>
                </div>
                <div class="tournament__list-time">
                    <h6 class="title"><?php echo genix_kses($settings['time_title']); ?></h6>
                    <?php if (!empty($settings['time_icon']) || !empty($settings['time_selected_icon']['value'])) : ?>
                        <?php genix_render_icon($settings, 'time_icon', 'time_selected_icon'); ?>
                    <?php endif; ?>
                    <span><?php echo genix_kses($settings['time_set']); ?></span>
                </div>
                <?php if (!empty($settings['button_url'])) : ?>
                    <div class="tournament__list-live">
                        <a href="<?php echo esc_url($settings['button_url']) ?>" target="_blank">
                            <?php echo genix_kses($settings['button_text']); ?>
                            <?php if (!empty($settings['button_icon']) || !empty($settings['button_selected_icon']['value'])) : ?>
                                <?php genix_render_icon($settings, 'button_icon', 'button_selected_icon'); ?>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<?php
    }
}

$widgets_manager->register(new Genix_Tournament());
