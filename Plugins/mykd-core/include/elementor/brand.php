<?php

namespace GenixCore\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Mykd Core
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Genix_Brand extends Widget_Base
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
        return 'brand';
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
        return __('Brand', 'genixcore');
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
        return 'genix-icon eicon-logo';
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
                'label_block' => 'true',
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'genixcore'),
                    'layout-2' => esc_html__('Layout 2', 'genixcore'),
                ],
                'default' => 'layout-1',
            ]
        );

        $this->end_controls_section();

        // Brand
        $this->start_controls_section(
            'tg_brand_section',
            [
                'label' => esc_html__('Brand Item', 'genixcore'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tg_brand_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => esc_html__('Image', 'genixcore'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'tg_brand_url',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => esc_html__('URL', 'genixcore'),
                'default' => esc_html__('#', 'genixcore'),
                'placeholder' => esc_html__('Type url here', 'genixcore'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'tg_brand_slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => esc_html__('Brand Item', 'genixcore'),
                'default' => [
                    [
                        'tg_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tg_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tg_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'tg_brand_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();


        // STYLE TAB
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
?>

        <?php if ($settings['tg_design_style'] == 'layout-2') : ?>

            <script>
                jQuery(document).ready(function($) {

                    /*=============================================
                        =    		Brand Active		      =
                    =============================================*/
                    $('.brand-active').slick({
                        dots: false,
                        infinite: true,
                        speed: 500,
                        autoplay: true,
                        arrows: false,
                        slidesToShow: 6,
                        slidesToScroll: 2,
                        responsive: [{
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: 5,
                                    slidesToScroll: 1,
                                    infinite: true,
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 767,
                                settings: {
                                    slidesToShow: 4,
                                    slidesToScroll: 1,
                                    arrows: false,
                                }
                            },
                            {
                                breakpoint: 575,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    arrows: false,
                                }
                            },
                        ]
                    });

                    /*=============================================
                        =           Brand effect         =
                    =============================================*/
                    var democol = $('.brand-active .col');
                    democol.on({
                        mouseenter: function() {
                            $(this).siblings().stop().fadeTo(300, 0.3);
                        },
                        mouseleave: function() {
                            $(this).siblings().stop().fadeTo(300, 1);
                        }
                    });

                });
            </script>

            <div class="row brand-active">
                <?php foreach ($settings['tg_brand_slides'] as $item) :
                    if (!empty($item['tg_brand_image']['url'])) {
                        $tg_brand_image_url = !empty($item['tg_brand_image']['id']) ? wp_get_attachment_image_url($item['tg_brand_image']['id'], $settings['thumbnail_size']) : $item['tg_brand_image']['url'];
                        $tg_brand_image_alt = get_post_meta($item["tg_brand_image"]["id"], "_wp_attachment_image_alt", true);
                    }
                ?>
                    <div class="col">
                        <div class="brand__item">
                            <?php if (!empty($item['tg_brand_url'])) : ?>
                                <a href="<?php echo esc_url($item['tg_brand_url']); ?>" class="brand__link"><img src="<?php echo esc_url($tg_brand_image_url); ?>" alt="<?php echo esc_attr($tg_brand_image_alt); ?>"></a>
                            <?php else : ?>
                                <span class="brand__link"><img src="<?php echo esc_url($tg_brand_image_url); ?>" alt="<?php echo esc_attr($tg_brand_image_alt); ?>"></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>

            <script>
                jQuery(document).ready(function($) {

                    /*=============================================
                        =           Brand effect         =
                    =============================================*/
                    var democol = $('.slider__brand-list li');
                    democol.on({
                        mouseenter: function() {
                            $(this).siblings().stop().fadeTo(300, 0.3);
                        },
                        mouseleave: function() {
                            $(this).siblings().stop().fadeTo(300, 1);
                        }
                    });

                });
            </script>

            <div class="slider__brand-wrap">
                <div class="container custom-container">
                    <ul class="slider__brand-list list-wrap">
                        <?php foreach ($settings['tg_brand_slides'] as $item) :
                            if (!empty($item['tg_brand_image']['url'])) {
                                $tg_brand_image_url = !empty($item['tg_brand_image']['id']) ? wp_get_attachment_image_url($item['tg_brand_image']['id'], $settings['thumbnail_size']) : $item['tg_brand_image']['url'];
                                $tg_brand_image_alt = get_post_meta($item["tg_brand_image"]["id"], "_wp_attachment_image_alt", true);
                            }
                        ?>
                            <li>
                                <?php if (!empty($item['tg_brand_url'])) : ?>
                                    <a href="<?php echo esc_url($item['tg_brand_url']); ?>"><img src="<?php echo esc_url($tg_brand_image_url); ?>" alt="<?php echo esc_attr($tg_brand_image_alt); ?>"></a>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($tg_brand_image_url); ?>" alt="<?php echo esc_attr($tg_brand_image_alt); ?>">
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        <?php endif; ?>

<?php
    }
}

$widgets_manager->register(new Genix_Brand());
