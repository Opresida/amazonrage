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
class Genix_Match_List extends Widget_Base
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
        return 'tg-match-list';
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
        return __('Match List', 'genixcore');
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
        return 'genix-icon eicon-toggle';
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

        // Match List
        $this->start_controls_section(
            '_section_match',
            [
                'label' => esc_html__('Match Item', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs(
            '_tab_style_match_box'
        );
        $this->start_controls_tab(
            '_tab_left_team',
            [
                'label' => esc_html__('Left Team', 'genixcore'),
            ]
        );

        $this->add_control(
            'left_img',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'left_sub',
            [
                'label' => esc_html__('Game Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Dota2', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'left_title',
            [
                'label' => esc_html__('Team Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Sky hunter', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'left_link_type',
            [
                'label' => esc_html__('Team Link Type', 'genixcore'),
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
            'left_btn_link',
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
                    'left_link_type' => '1',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'left_page_link',
            [
                'label' => esc_html__('Select Link Page', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => genix_get_all_pages(),
                'condition' => [
                    'left_link_type' => '2',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_right_team',
            [
                'label' => esc_html__('Right Team', 'genixcore'),
            ]
        );

        $this->add_control(
            'right_img',
            [
                'label' => esc_html__('Upload Image', 'genixcore'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'right_sub',
            [
                'label' => esc_html__('Game Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Dota2', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'right_title',
            [
                'label' => esc_html__('Team Name', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('The Tadium', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'right_link_type',
            [
                'label' => esc_html__('Team Link Type', 'genixcore'),
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
            'right_btn_link',
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
                    'right_link_type' => '1',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'right_page_link',
            [
                'label' => esc_html__('Select Link Page', 'genixcore'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => genix_get_all_pages(),
                'condition' => [
                    'right_link_type' => '2',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // Time Section
        $this->start_controls_section(
            '_section_date_time',
            [
                'label' => esc_html__('Date and Time', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'main_time',
            [
                'label' => esc_html__('Match Time', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('08:30', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
            ]
        );

        $this->add_control(
            'main_date',
            [
                'label' => esc_html__('Match Date', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('October 7, 2023, 8:30 pm', 'genixcore'),
                'dynamic' => [
                    'active' => true
                ],
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
            'match_item_delay',
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

        $randID = wp_rand();

        // Left Link
        if ('2' == $settings['left_link_type']) {
            $this->add_render_attribute('left-button-arg', 'href', get_permalink($settings['left_page_link']));
            $this->add_render_attribute('left-button-arg', 'target', '_self');
            $this->add_render_attribute('left-button-arg', 'rel', 'nofollow');
        } else {
            if (!empty($settings['left_btn_link']['url'])) {
                $this->add_link_attributes('left-button-arg', $settings['left_btn_link']);
            }
        }

        // Right Link
        if ('2' == $settings['right_link_type']) {
            $this->add_render_attribute('right-button-arg', 'href', get_permalink($settings['right_page_link']));
            $this->add_render_attribute('right-button-arg', 'target', '_self');
            $this->add_render_attribute('right-button-arg', 'rel', 'nofollow');
        } else {
            if (!empty($settings['right_btn_link']['url'])) {
                $this->add_link_attributes('right-button-arg', $settings['right_btn_link']);
            }
        } ?>

        <script>
            jQuery(document).ready(function($) {

                /*==================================
                        Button Icon Draw
                ====================================*/
                var $svgIconBox = $('.tg-svg<?php echo $randID; ?>');
                $svgIconBox.each(function() {
                    var $this = $(this),
                        $svgIcon = $this.find('.svg-icon'),
                        $id = $svgIcon.attr('id'),
                        $icon = $svgIcon.data('svg-icon');
                    var $vivus = new Vivus($id, {
                        duration: 180,
                        file: $icon
                    });
                    $this.on('mouseenter', function() {
                        $vivus.reset().play();
                    });
                });

            });
        </script>

        <div class="upcoming-match__lists">
            <div class="upcoming-match__item tg-svg<?php echo $randID; ?> wow fadeInUp" data-wow-delay="<?php echo esc_attr($settings['match_item_delay']) ?>">
                <div class="svg-icon" id="svg<?php echo esc_attr($randID); ?>" data-svg-icon="<?php echo get_template_directory_uri(); ?>/assets/img/icons/match.svg"></div>
                <div class="upcoming-match__position">
                    <?php if (!empty($settings['left_img']['url'])) : ?>
                        <div class="upcoming-match__team team-left">
                            <a <?php echo $this->get_render_attribute_string('left-button-arg'); ?>>
                                <img src="<?php echo esc_url($settings['left_img']['url']); ?>" alt="<?php echo esc_attr__('Team Image', 'genixcore') ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="upcoming-match__content">
                        <div class="team--info info-left">
                            <span class="game-name"><?php echo genix_kses($settings['left_sub']); ?></span>
                            <h3 class="name"><a <?php echo $this->get_render_attribute_string('left-button-arg'); ?>><?php echo genix_kses($settings['left_title']); ?></a></h3>
                        </div>
                        <?php if (!empty($settings['main_time'])) : ?>
                            <div class="upcoming-match__time">
                                <h2 class="time"><?php echo genix_kses($settings['main_time']); ?></h2>
                            </div>
                        <?php endif; ?>
                        <div class="team--info info-right">
                            <span class="game-name"><?php echo genix_kses($settings['right_sub']); ?></span>
                            <h3 class="name"><a <?php echo $this->get_render_attribute_string('right-button-arg'); ?>><?php echo genix_kses($settings['right_title']); ?></a></h3>
                        </div>
                    </div>
                    <?php if (!empty($settings['right_img']['url'])) : ?>
                        <div class="upcoming-match__team team-right">
                            <a <?php echo $this->get_render_attribute_string('right-button-arg'); ?>>
                                <img src="<?php echo esc_url($settings['right_img']['url']); ?>" alt="<?php echo esc_attr__('Team Image', 'genixcore') ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($settings['main_date'])) : ?>
                    <div class="upcoming-match__date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="287" height="24" viewBox="0 0 287 24">
                            <path id="bottom-svg1" d="M1104,3760l-20,24H837l-20-24" transform="translate(-817 -3760)" />
                        </svg>
                        <span><?php echo genix_kses($settings['main_date']); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<?php
    }
}

$widgets_manager->register(new Genix_Match_List());
