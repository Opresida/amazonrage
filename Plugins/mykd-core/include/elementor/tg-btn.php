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
class TG_Btn extends Widget_Base
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
        return 'tg-btn';
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
        return __('Mykd Button', 'genixcore');
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
        return 'genix-icon eicon-button';
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
                    'layout-3' => esc_html__('Layout 3', 'genixcore'),
                    'layout-4' => esc_html__('Video Button', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // tg_button_group
        $this->start_controls_section(
            'tg_button_group',
            [
                'label' => esc_html__('Button', 'genixcore'),
                'condition' => [
                    'tg_design_style!' => 'layout-4'
                ]
            ]
        );

        $this->add_control(
            'tg_button_show',
            [
                'label' => esc_html__('Show Button', 'genixcore'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'genixcore'),
                'label_off' => esc_html__('Hide', 'genixcore'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tg_btn_text',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Button Text', 'genixcore'),
                'title' => esc_html__('Enter button text', 'genixcore'),
                'label_block' => true,
                'condition' => [
                    'tg_button_show' => 'yes'
                ],
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
                'condition' => [
                    'tg_button_show' => 'yes'
                ],
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
                    'tg_button_show' => 'yes'
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
                    'tg_button_show' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'tg_align',
            [
                'label' => esc_html__('Alignment', 'genixcore'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'genixcore'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genixcore'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'genixcore'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'tg_design_style!' => 'layout-2'
                ]
            ]
        );

        $this->add_responsive_control(
            'tg_align2',
            [
                'label' => esc_html__('Alignment', 'genixcore'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'genixcore'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'genixcore'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'genixcore'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .tg-button-alignment' => 'justify-content: {{VALUE}};'
                ],
                'condition' => [
                    'tg_design_style' => 'layout-2'
                ]
            ]
        );

        $this->end_controls_section();

        // _tg_video
        $this->start_controls_section(
            '_tg_video_section',
            [
                'label' => esc_html__('Video Button', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-4'
                ]
            ]
        );

        $this->add_control(
            'video_btn_text',
            [
                'label' => esc_html__('Button Text', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('How It Work', 'genixcore'),
                'title' => esc_html__('Enter button text', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__('Video URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('https://www.youtube.com/watch?v=ssrNcwxALS4', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // TAB STYLE
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'genixcore'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'tg_design_style!' => 'layout-4'
                ]
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label' => esc_html__('Button Padding', 'genixcore'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .genix-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            '_tab_style_button_box'
        );
        $this->start_controls_tab(
            '_tab_button_default',
            [
                'label' => esc_html__('Normal', 'genixcore'),
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Text Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .genix-btn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-3' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Background Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .genix-btn .cls-1' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-3 .svg-icon' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'tg_design_style!' => 'layout-3'
                ]
            ]
        );

        $this->add_control(
            'stroke_color',
            [
                'label' => esc_html__('Stroke Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tg-btn-3 .svg-icon' => 'stroke: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-2 svg path' => 'stroke: {{VALUE}}',
                ],
                'condition' => [
                    'tg_design_style' => ['layout-2', 'layout-3']
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => esc_html__('Hover', 'genixcore'),
            ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label' => esc_html__('Text Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .genix-btn:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-3:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-2:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_hover_color',
            [
                'label' => esc_html__('Background Color', 'genixcore'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .genix-btn:hover .cls-1' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-3:hover .svg-icon' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} .tg-btn-2:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

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
                    '{{WRAPPER}} .genix-btn' => 'text-transform: {{VALUE}};',
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
        $settings = $this->get_settings_for_display();

        $randID = wp_rand(); ?>


        <?php if ($settings['tg_design_style'] == 'layout-2') :
            // Link
            if ('2' == $settings['tg_btn_link_type']) {
                $this->add_render_attribute('tg-button-arg', 'href', get_permalink($settings['tg_btn_page_link']));
                $this->add_render_attribute('tg-button-arg', 'target', '_self');
                $this->add_render_attribute('tg-button-arg', 'rel', 'nofollow');
                $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-3 tg-svg' . $randID);
            } else {
                if (!empty($settings['tg_btn_link']['url'])) {
                    $this->add_link_attributes('tg-button-arg', $settings['tg_btn_link']);
                    $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-3 tg-svg' . $randID);
                }
            }
        ?>

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

            <?php if (!empty($settings['tg_button_show'])) : ?>
                <div class="d-flex tg-button-alignment">
                    <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>>
                        <div class="svg-icon" id="btn-svg<?php echo esc_attr($randID); ?>" data-svg-icon="<?php echo get_template_directory_uri(); ?>/assets/img/icons/shape.svg"></div>
                        <span><?php echo $settings['tg_btn_text']; ?></span>
                    </a>
                </div>
            <?php endif; ?>


        <?php elseif ($settings['tg_design_style'] == 'layout-3') :
            // Link
            if ('2' == $settings['tg_btn_link_type']) {
                $this->add_render_attribute('tg-button-arg', 'href', get_permalink($settings['tg_btn_page_link']));
                $this->add_render_attribute('tg-button-arg', 'target', '_self');
                $this->add_render_attribute('tg-button-arg', 'rel', 'nofollow');
                $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-2');
            } else {
                if (!empty($settings['tg_btn_link']['url'])) {
                    $this->add_link_attributes('tg-button-arg', $settings['tg_btn_link']);
                    $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-2');
                }
            }
        ?>

            <?php if (!empty($settings['tg_btn_text'])) : ?>
                <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>>
                    <?php echo $settings['tg_btn_text']; ?>
                    <svg preserveAspectRatio="none" viewBox="0 0 167 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M166 1H1V52H166V1Z" stroke-width="2" />
                        <path d="M166 22L161 27L166 33" stroke-width="2" />
                        <path d="M166 14L154 28L166 40" stroke-width="2" />
                        <path d="M8 1V21" stroke-width="2" />
                        <path d="M159 1V22" stroke-width="2" />
                        <path d="M159 33V52" stroke-width="2" />
                        <path d="M8 34V52" stroke-width="2" />
                        <path d="M1 22L8 27L1 33" stroke-width="2" />
                        <path d="M1 14L15 28L1 40" stroke-width="2" />
                    </svg>
                </a>
            <?php endif; ?>


        <?php elseif ($settings['tg_design_style'] == 'layout-4') : ?>

            <div class="about__content-btns d-flex">
                <a href="<?php echo esc_url($settings['video_url']) ?>" class="popup-video"><i class="fas fa-play"></i><span class="text"><?php echo esc_html($settings['video_btn_text']) ?></span></a>
            </div>


        <?php else :
            // Link
            if ('2' == $settings['tg_btn_link_type']) {
                $this->add_render_attribute('tg-button-arg', 'href', get_permalink($settings['tg_btn_page_link']));
                $this->add_render_attribute('tg-button-arg', 'target', '_self');
                $this->add_render_attribute('tg-button-arg', 'rel', 'nofollow');
                $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-1 genix-btn');
            } else {
                if (!empty($settings['tg_btn_link']['url'])) {
                    $this->add_link_attributes('tg-button-arg', $settings['tg_btn_link']);
                    $this->add_render_attribute('tg-button-arg', 'class', 'tg-btn-1 genix-btn');
                }
            }
        ?>

            <?php if (!empty($settings['tg_button_show'])) : ?>
                <a <?php echo $this->get_render_attribute_string('tg-button-arg'); ?>>
                    <span><?php echo $settings['tg_btn_text']; ?></span>
                    <svg preserveAspectRatio="none" viewBox="0 0 197 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="cls-1" fill-rule="evenodd" clip-rule="evenodd" d="M30.976 0.755987L0.75499 30.977L29.717 58.677H165.717L195.938 30.977L165.717 0.755987H30.976Z" stroke="white" stroke-width="1.5" />
                        <path class="cls-2" fill-rule="evenodd" clip-rule="evenodd" d="M166.712 2.01899L196.933 30.98L166.712 58.68L188.118 29.719L166.712 2.01899Z" fill="white" />
                        <path class="cls-2" fill-rule="evenodd" clip-rule="evenodd" d="M30.235 2.01899L0.0139923 30.977L30.235 58.677L8.82899 29.719L30.235 2.01899Z" fill="white" />
                    </svg>
                </a>
            <?php endif; ?>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new TG_Btn());
