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
class TG_ImageBox extends Widget_Base
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
        return 'genix-image';
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
        return __('Image Box', 'genixcore');
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
        return 'genix-icon eicon-image';
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
                    'layout-4' => esc_html__('Layout 4', 'genixcore'),
                    'layout-5' => esc_html__('Layout 5', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // _tg_image
        $this->start_controls_section(
            '_tg_image_section',
            [
                'label' => esc_html__('Image', 'genixcore'),
                'condition' => [
                    'tg_design_style!' => 'layout-4'
                ]
            ]
        );

        $this->add_control(
            'tg_image',
            [
                'label' => esc_html__('Choose Image', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'tg_image2',
            [
                'label' => esc_html__('Choose Image 02', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'tg_design_style!' => ['layout-3', 'layout-5']
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tg_image_size',
                'default' => 'full',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();

        // _tg_repeater
        $this->start_controls_section(
            '_tg_images_repeater',
            [
                'label' => esc_html__('Repeater Image', 'genixcore'),
                'condition' => [
                    'tg_design_style' => 'layout-4'
                ]
            ]
        );

        $repeater = new \Elementor\Repeater();

        if (genix_is_elementor_version('<', '2.6.0')) {
            $repeater->add_control(
                'tg_icon',
                [
                    'show_label' => false,
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'default' => 'fa fa-star',
                ]
            );
        } else {
            $repeater->add_control(
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
                ]
            );
        }

        $repeater->add_control(
            'rep_image',
            [
                'label' => esc_html__('Choose Image', 'genixcore'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'rep_url',
            [
                'label' => esc_html__('Item URL', 'genixcore'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('#', 'genixcore'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'item_lists',
            [
                'label' => esc_html__('Item Lists', 'genixcore'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'rep_image' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Style
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
        $settings = $this->get_settings_for_display();

        if (!empty($settings['tg_image']['url'])) {
            $tg_image_url = !empty($settings['tg_image']['id']) ? wp_get_attachment_image_url($settings['tg_image']['id'], $settings['tg_image_size_size']) : $settings['tg_image']['url'];
            $tg_image_alt = get_post_meta($settings["tg_image"]["id"], "_wp_attachment_image_alt", true);
        }

        if (!empty($settings['tg_image2']['url'])) {
            $tg_image_url2 = !empty($settings['tg_image2']['id']) ? wp_get_attachment_image_url($settings['tg_image2']['id'], $settings['tg_image_size_size']) : $settings['tg_image2']['url'];
            $tg_image_alt2 = get_post_meta($settings["tg_image2"]["id"], "_wp_attachment_image_alt", true);
        } ?>

        <?php if ($settings['tg_design_style']  == 'layout-2') : ?>

            <?php if (!empty($tg_image_url || $tg_image_url2)) : ?>
                <div class="about__three-images">
                    <?php if (!empty($tg_image_url)) : ?>
                        <img src="<?php echo esc_url($tg_image_url); ?>" alt="<?php echo esc_attr($tg_image_alt); ?>" class="left">
                    <?php endif; ?>

                    <?php if (!empty($tg_image_url2)) : ?>
                        <img src="<?php echo esc_url($tg_image_url2); ?>" alt="<?php echo esc_attr($tg_image_alt2); ?>" class="right">
                    <?php endif; ?>
                    <div class="about__dots">
                        <svg width="109" height="35" viewBox="0 0 109 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 0H0V7H9V0Z" fill="currentcolor" />
                            <path d="M24 0H15V7H24V0Z" fill="currentcolor" />
                            <path d="M38 0H29V7H38V0Z" fill="currentcolor" />
                            <path d="M53 0H44V7H53V0Z" fill="currentcolor" />
                            <path d="M67 0H58V7H67V0Z" fill="currentcolor" />
                            <path d="M80 0H71V7H80V0Z" fill="currentcolor" />
                            <path d="M9 14H0V21H9V14Z" fill="currentcolor" />
                            <path d="M24 14H15V21H24V14Z" fill="currentcolor" />
                            <path d="M38 14H29V21H38V14Z" fill="currentcolor" />
                            <path d="M53 14H44V21H53V14Z" fill="currentcolor" />
                            <path d="M67 14H58V21H67V14Z" fill="currentcolor" />
                            <path d="M80 14H71V21H80V14Z" fill="currentcolor" />
                            <path d="M95 14H86V21H95V14Z" fill="currentcolor" />
                            <path d="M109 14H100V21H109V14Z" fill="currentcolor" />
                            <path d="M9 28H0V35H9V28Z" fill="currentcolor" />
                            <path d="M24 28H15V35H24V28Z" fill="currentcolor" />
                            <path d="M38 28H29V35H38V28Z" fill="currentcolor" />
                            <path d="M53 28H44V35H53V28Z" fill="currentcolor" />
                            <path d="M67 28H58V35H67V28Z" fill="currentcolor" />
                            <path d="M80 28H71V35H80V28Z" fill="currentcolor" />
                            <path d="M95 28H86V35H95V28Z" fill="currentcolor" />
                            <path d="M109 28H100V35H109V28Z" fill="currentcolor" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>

        <?php elseif ($settings['tg_design_style']  == 'layout-3') : ?>

            <?php if (!empty($tg_image_url)) : ?>
                <div class="team__details-img">
                    <img src="<?php echo esc_url($tg_image_url); ?>" alt="<?php echo esc_attr($tg_image_alt); ?>">
                    <svg width="145" height="66" viewBox="0 0 145 66" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.95">
                            <path d="M11.94 56.1H0V65.38H11.94V56.1Z" fill="currentcolor" />
                            <path d="M30.81 56.1H18.87V65.38H30.81V56.1Z" fill="currentcolor" />
                            <path d="M49.37 56.1H37.47V65.38H49.37V56.1Z" fill="currentcolor" />
                            <path d="M68.25 56.1H56.34V65.38H68.25V56.1Z" fill="currentcolor" />
                            <path d="M87.81 56.1H75.91V65.38H87.81V56.1Z" fill="currentcolor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M95.12 56.1H107.03V65.3799H95.12V56.1Z" fill="currentcolor" />
                            <path d="M125.94 56.1H114V65.38H125.94V56.1Z" fill="currentcolor" />
                            <path d="M144.5 56.1H132.56V65.38H144.5V56.1Z" fill="currentcolor" />
                            <path d="M11.94 37.1H0V46.38H11.94V37.1Z" fill="currentcolor" />
                            <path d="M30.81 37.1H18.87V46.38H30.81V37.1Z" fill="currentcolor" />
                            <path d="M49.37 37.1H37.47V46.38H49.37V37.1Z" fill="currentcolor" />
                            <path d="M68.25 37.1H56.34V46.38H68.25V37.1Z" fill="currentcolor" />
                            <path d="M87.81 37.1H75.91V46.38H87.81V37.1Z" fill="currentcolor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M95.12 37.1H107.03V46.3799H95.12V37.1Z" fill="currentcolor" />
                            <path d="M125.94 37.1H114V46.38H125.94V37.1Z" fill="currentcolor" />
                            <path d="M144.5 37.1H132.56V46.38H144.5V37.1Z" fill="currentcolor" />
                            <path d="M11.94 18.53H0V27.85H11.94V18.53Z" fill="currentcolor" />
                            <path d="M30.81 18.53H18.87V27.85H30.81V18.53Z" fill="currentcolor" />
                            <path d="M49.37 18.53H37.47V27.85H49.37V18.53Z" fill="currentcolor" />
                            <path d="M68.25 18.53H56.34V27.85H68.25V18.53Z" fill="currentcolor" />
                            <path d="M87.81 18.53H75.91V27.85H87.81V18.53Z" fill="currentcolor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M95.12 18.53H107.03V27.85H95.12V18.53Z" fill="currentcolor" />
                            <path d="M125.94 18.53H114V27.85H125.94V18.53Z" fill="currentcolor" />
                            <path d="M144.5 18.53H132.56V27.85H144.5V18.53Z" fill="currentcolor" />
                            <path d="M11.94 0H0V9.28H11.94V0Z" fill="currentcolor" />
                            <path d="M30.81 0H18.87V9.28H30.81V0Z" fill="currentcolor" />
                            <path d="M49.37 0H37.47V9.28H49.37V0Z" fill="currentcolor" />
                            <path d="M68.25 0H56.34V9.28H68.25V0Z" fill="currentcolor" />
                            <path d="M86.81 0H74.91V9.28H86.81V0Z" fill="currentcolor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M94.12 6.10352e-05H106.03V9.27997H94.12V6.10352e-05Z" fill="currentcolor" />
                        </g>
                    </svg>
                </div>
            <?php endif; ?>

        <?php elseif ($settings['tg_design_style']  == 'layout-4') : ?>

            <div class="services__images">
                <?php foreach ($settings['item_lists'] as $index => $item) :
                    $active = ($index == '0') ? "active" : "";
                ?>
                    <div class="services__images-item <?php echo esc_attr($active) ?>">
                        <?php if (!empty($item['rep_image']['url'])) : ?>
                            <img src="<?php echo esc_attr($item['rep_image']['url']); ?>" alt="<?php echo esc_attr__('Images', 'genixcore') ?>">
                        <?php endif; ?>
                        <?php if (!empty($item['tg_icon']) || !empty($item['tg_selected_icon']['value'])) : ?>
                            <a href="<?php echo esc_url($item['rep_url']) ?>" class="services__link">
                                <?php genix_render_icon($item, 'tg_icon', 'tg_selected_icon'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($settings['tg_design_style']  == 'layout-5') : ?>

            <?php if (!empty($tg_image_url)) : ?>
                <img src="<?php echo esc_url($tg_image_url); ?>" class="tg-parallax" data-scale="1.5" data-orientation="down" alt="<?php echo esc_attr($tg_image_alt); ?>">
            <?php endif; ?>

        <?php else : ?>

            <div class="about__funFact-images">
                <?php if (!empty($tg_image_url2)) : ?>
                    <img src="<?php echo esc_url($tg_image_url2); ?>" alt="<?php echo esc_attr($tg_image_alt2); ?>" class="bg-shape">
                <?php endif; ?>

                <?php if (!empty($tg_image_url)) : ?>
                    <img src="<?php echo esc_url($tg_image_url); ?>" class="main-img" alt="<?php echo esc_attr($tg_image_alt); ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new TG_ImageBox());
