<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Mykd Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TG_CIRCLE_TEXT extends Widget_Base
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
        return 'tg-circle';
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
        return __('Circle Text', 'genixcore');
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
        return 'genix-icon eicon-dot-circle-o';
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

        // layout Panel
        $this->start_controls_section(
            'genix_layout',
            [
                'label' => esc_html__('Design Layout', 'genixcore'),
            ]
        );

        $this->add_control(
            'tg_design_style',
            [
                'label' => esc_html__('Select Layout', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'genixcore'),
                    'layout-2' => esc_html__('Layout 2', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // _tg_title
        $this->start_controls_section(
            '_tg_title_text',
            [
                'label' => esc_html__('Title', 'genixcore'),
            ]
        );

        if (genix_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'tg_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
                    'condition' => [
                        'tg_design_style' => 'layout-2'
                    ]
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
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'condition' => [
                        'tg_design_style' => 'layout-2'
                    ]
                ]
            );
        }

        $this->add_control(
            'tg_title',
            [
                'label' => esc_html__('Circle Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('super nft Gaming sits', 'genixcore'),
                'placeholder' => esc_html__('Type Text Here', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__('Sub Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Join Us', 'genixcore'),
                'placeholder' => esc_html__('Type Text Here', 'genixcore'),
                'label_block' => true,
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $this->add_control(
            'main_title',
            [
                'label' => esc_html__('Main Title', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('DISCORD', 'genixcore'),
                'placeholder' => esc_html__('Type Text Here', 'genixcore'),
                'label_block' => true,
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $this->add_control(
            'tg_url',
            [
                'label' => esc_html__('URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('https://discord.com/', 'genixcore'),
                'placeholder' => esc_html__('Type URL Here', 'genixcore'),
                'label_block' => true,
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_transform',
            [
                'label' => esc_html__('Text Transform', 'genixcore'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'genixcore'),
                    'uppercase' => esc_html__('UPPERCASE', 'genixcore'),
                    'lowercase' => esc_html__('lowercase', 'genixcore'),
                    'capitalize' => esc_html__('Capitalize', 'genixcore'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
                ],
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
        $settings = $this->get_settings_for_display(); ?>

        <?php if ($settings['tg_design_style'] == 'layout-2') : ?>

            <div class="team__info-discord">
                <div class="about__content-circle">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/circle02.svg" alt="img">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" version="1.1">
                        <path id="textPath" d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
                        <text>
                            <textPath href="#textPath"><?php echo genix_kses($settings['tg_title']); ?></textPath>
                        </text>
                    </svg>
                    <?php if (!empty($settings['tg_icon']) || !empty($settings['tg_selected_icon']['value'])) : ?>
                        <?php genix_render_icon($settings, 'tg_icon', 'tg_selected_icon'); ?>
                    <?php endif; ?>
                </div>
                <div class="team__info-discord-info">
                    <span class="sub"><?php echo genix_kses($settings['sub_title']); ?></span>
                    <h5 class="title"><a href="<?php echo esc_url($settings['tg_url']); ?>" target="_blank"><?php echo genix_kses($settings['main_title']); ?></a></h5>
                </div>
            </div>

        <?php else : ?>

            <div class="about__content-circle">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/circle.svg" alt="img">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 150" version="1.1">
                    <path id="textPath" d="M 0,75 a 75,75 0 1,1 0,1 z"></path>
                    <text>
                        <textPath href="#textPath"><?php echo genix_kses($settings['tg_title']); ?></textPath>
                    </text>
                </svg>
            </div>

        <?php endif; ?>
<?php
    }
}

$widgets_manager->register(new TG_CIRCLE_TEXT());
